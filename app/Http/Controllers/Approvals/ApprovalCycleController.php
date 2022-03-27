<?php

namespace App\Http\Controllers\Approvals;

use App\Http\Controllers\Controller;
use App\Traits\ApprovalCycleTrait;
use App\Traits\ToastrTrait;
use App\Models\ApprovalCycle;
use App\Models\ApprovalCycleApprovalStep;
use App\Models\ApprovalTimeline;
use App\Models\ApprovalTimelineComment;
use App\Models\ChequeItemRequest;
use App\Models\ChequeRequest;
use App\Models\Department;
use App\Models\FamilyName;
use App\Models\FilePurchaseOrder;
use App\Models\FilePurchaseRequest;
use App\Models\InquiryPurchaseRequest;
use App\Models\ItemOrder;
use App\Models\ItemRequest;
use App\Models\User;
use App\Models\Project;
use App\Models\PurchaseOrder;
use App\Models\Site;
use App\Models\PurchaseRequest;
use App\Models\Sector;
use App\Traits\StoreFileTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;

class ApprovalCycleController extends Controller
{

    use ApprovalCycleTrait, ToastrTrait;
    use StoreFileTrait;

    // Show all Approval cycles

    function __construct()
    {
         $this->middleware('permission:timeline-purchase-request|show-timeline-purchase-request', ['only' => ['showAllApprovalRequestsTimeline']]);
         $this->middleware('permission:acceptable-purchase-request|show-acceptable-purchase-request', ['only' => ['showAllAcceptableRequestsTimeline']]);

         $this->middleware('permission:timeline-purchase-order|show-timeline-purchase-order', ['only' => ['showAllApprovalOrdersTimeline']]);
         $this->middleware('permission:acceptable-purchase-order|show-acceptable-purchase-order', ['only' => ['showAllAcceptableOrdersTimeline']]);

         $this->middleware('permission:timeline-purchase-order|show-timeline-purchase-order|permission:acceptable-purchase-request|show-acceptable-purchase-request|permission:timeline-purchase-request
         |show-timeline-purchase-request|permission:acceptable-purchase-order|show-acceptable-purchase-order', ['only' => ['showOrder']]);
    }


    public function showAllCycles()
    {
        $approvalCycles = ApprovalCycle::all();

        return view('dashboard-views.approval.all', compact('approvalCycles'));
    }

    public function approveBusiness($id)
    {
        // return $request->image_approve;

        $approvalTimeline = ApprovalTimeline::where('id', $id)->firstOrFail();

        $sector = Sector::where("name_en","Business Development")->first();
        $user = User::where("sector_id",$sector->id)->first();
        try {
                DB::beginTransaction();
                $approvalTimeline->update([
                    "business_action" => 3
                ]);
                ApprovalTimeline::create([
                    'table_name' => $approvalTimeline->table_name,
                    'record_id' => $approvalTimeline->record_id,
                    'approval_cycle_approval_step_id' => $approvalTimeline->approval_cycle_approval_step_id,
                    'user_id' => $user->id, // next user in cycle
                    "approval_status" => "P",
                    "business_action" => 1
                ]);
                $this->getSuccess();

            DB::commit();
        } catch (\Illuminate\Database\QueryException $e) {
            dd($e->getMessage());
            DB::rollBack();
            $this->getError();
        }
        return redirect()->route('approvals.index');
    }

    public function refusePartial(Request $request)
    {


         $aritemDelete = [];
          $itemDelete  = count(array_filter($request->reason_refuse , fn($value) => !is_null($value) && $value !== ''));
         $allitemCount = count($request->ids);
        if( $allitemCount <= $itemDelete) {
            Toastr()->error(
                trans('site.cannot_delete_items_delete_order'),
                trans("site.error"),
                [
                    "closeButton" => true,
                    "progressBar" => true,
                    "positionClass" => app()->getLocale() == 'en' ? "toast-top-right" : "toast-top-left",
                    "timeOut" => "10000",
                    "extendedTimeOut" => "10000",
                ]
            );
            return redirect()->route("approvals.show_all_acceptable_orders_timeline");
        } else {
            foreach($request->reason_refuse as $index => $reason_refuse) {
                if($reason_refuse !== null) {
                    $itemOrder = ItemOrder::where("id",$request->ids[$index])->first();
                    $itemRequest =  ItemRequest::where("id",$itemOrder->item_request_id)->first();
                    ItemRequest::where("id",$itemOrder->item_request_id)->update([
                       "used_quantity" => $itemOrder->quantity + $itemRequest->used_quantity
                    ]);
                    ItemOrder::where("id",$request->ids[$index])->update([
                        "comment_item_refuse" => $reason_refuse
                    ]);
                    $itemOrder->delete();
                }
           }
           Toastr()->success(
            trans('site.item_deleted'),
            trans("site.Success"),
            [
                "closeButton" => true,
                "progressBar" => true,
                "positionClass" => app()->getLocale() == 'en' ? "toast-top-right" : "toast-top-left",
                "timeOut" => "10000",
                "extendedTimeOut" => "10000",
            ]
        );
           return redirect()->route("approvals.show_all_acceptable_orders_timeline");
        }

    }

    public function deleteOrderRequest( Request $request ,$id , $value , $refuse)
    {
            DB::beginTransaction();
            $purchaseOrder =  PurchaseOrder::find($id);
            $itemOrders = ItemOrder::where("purchase_order_id",$id)->get();
            foreach($itemOrders as $index => $itemID) {
                $itemOrder = ItemOrder::where("id",$itemID->id)->first();
                $itemRequest =  ItemRequest::where("id",$itemID->item_request_id)->first();
                ItemRequest::where("id",$itemOrder->item_request_id)->update([
                   "used_quantity" => $itemOrder->quantity + $itemRequest->used_quantity
                ]);
                $itemOrder->delete();
           }
            ApprovalTimeline::where("record_id",$purchaseOrder->id)->where('table_name',"purchase_orders")->delete();
           $purchaseOrder->delete();
           DB::commit();
           Toastr()->success(
            trans('site.po_deleted'),
            trans("site.Success"),
            [
                "closeButton" => true,
                "progressBar" => true,
                "positionClass" => app()->getLocale() == 'en' ? "toast-top-right" : "toast-top-left",
                "timeOut" => "10000",
                "extendedTimeOut" => "10000",
            ]
        );
           return redirect()->route("approvals.show_all_acceptable_orders_timeline");
    }

    public function messagePartial(Request $request)
    {

        $purchaseRequest = PurchaseRequest::find($request->purchase_request_id);

        foreach($request->messgae as $index => $messgae) {

            $editItem = ItemRequest::where("id",$request->ids[$index])->first();

            if($editItem->specification == $request->specification[$index]) {
                $specification = null;
            } else {
                $specification = $request->specification[$index];
            }
            if( $purchaseRequest->group_id == 1) {
                $technical_office_id = 24;
                $receive = $purchaseRequest->sector->head_id;
            } elseif( $purchaseRequest->group_id == 2) {
                $technical_office_id = 27;
                $receive = $purchaseRequest->sector->head_id;

            } elseif( $purchaseRequest->group_id == 4) {
                $technical_office_id = 5;
                $receive = 6;
            } elseif( $purchaseRequest->group_id == 7) {
                $technical_office_id = 50;
                $receive = $purchaseRequest->requester_id;
            } else {
                $technical_office_id =  $purchaseRequest->department->manager_id;
                $receive = $purchaseRequest->sector->head_id;
            }
            if($messgae !== null) {
                InquiryPurchaseRequest::create([
                    "item_request_id" => $request->ids[$index],
                    "purchase_request_id" => $request->purchase_request_id,
                    "send_message" => $messgae,
                    "send_id" => auth()->id(),
                    "edit_item" => $specification,
                    "receive_id" => $receive,
                    "technical_office" =>  $technical_office_id
                    ]);
            }

        }

        Toastr()->success(
            trans('site.success'),
            trans("site.Success"),
            [
                "closeButton" => true,
                "progressBar" => true,
                "positionClass" => app()->getLocale() == 'en' ? "toast-top-right" : "toast-top-left",
                "timeOut" => "10000",
                "extendedTimeOut" => "10000",
            ]
        );
           return redirect()->route("approvals.show_all_acceptable_requests_timeline");
    }

    // Show all pending cycle for currnt authenticated user

    public function approvePartial(Request $request)
    {
        // return $request->all();
        $id = $request->purchase_request_id;
        $approvalTimeline = ApprovalTimeline::where('id', $id)->firstOrFail();

        $model = $this->getModelFromClassName($approvalTimeline->table_name);
        $creatorUser = $model::findOrFail($approvalTimeline->record_id)->requester;

        DB::beginTransaction();
        try {
            $approvalTimeline->update([
                'approval_status' => 'A'
            ]);

            $currentApprovalCycleApprovalStep = $approvalTimeline->approvalCycleApprovalStep;
            $nextApprovalCycleApprovalStep = $currentApprovalCycleApprovalStep->next;

            if ($nextApprovalCycleApprovalStep) { // check if there is next approval cycle

                $stepValue =  json_decode($nextApprovalCycleApprovalStep->approvalStep->value);
                $nextApprovalUser = '';

                if (count($stepValue->depth)) {
                    $nextApprovalUser = $creatorUser;
                    foreach ($stepValue->depth as $step) {
                        if ($nextApprovalUser->{$step}) {
                            $nextApprovalUser = $nextApprovalUser->{$step};
                        }
                    }
                } else {
                    $nextApprovalUser = $this->getComplexNextUserForApprovals($stepValue->query->T, $stepValue->query->CONs,  $stepValue->query->depth);
                }

                ApprovalTimeline::create([
                    'table_name' => $approvalTimeline->table_name,
                    'record_id' => $approvalTimeline->record_id,
                    'approval_cycle_approval_step_id' => $nextApprovalCycleApprovalStep->id,
                    'user_id' => $nextApprovalUser->id, // next user in cycle
                ]);
                $this->getSuccess();
            } else {
                $this->getSuccessToastrMessage('DONE');
                // Here update table record id approval_status To Approved
                /*
                    *
                    *
                    *
                */
            }
            DB::commit();
            if ($approvalTimeline->table_name == "purchase_requests") {
                $purchase = PurchaseRequest::where('id', $approvalTimeline->record_id)->firstOrFail();
                $newRow = PurchaseRequest::withTrashed()->count();
                if( $purchase->group_id == 7) {
                    $requestnumber =  date('Y') . '-f' . str_pad(++$newRow, 4, '0', STR_PAD_LEFT);
                } else {
                    $requestnumber =  date('Y') . '-' . str_pad(++$newRow, 4, '0', STR_PAD_LEFT);
                }
                DB::beginTransaction();

                //    $item = ItemRequest::create()

                foreach ($request->reason_refuse as $index => $comment) {
                    if ($comment) {
                        $newStoredPurchaseRequest = PurchaseRequest::withoutEvents(function () use ($requestnumber, $request, $purchase) {
                            $purchse = PurchaseRequest::create([
                                "request_number" => $requestnumber,
                                "requester_id" => $purchase->requester_id,
                                "sector_id" => $purchase->sector_id,
                                "department_id" => $purchase->department_id,
                                "project_id" => $purchase->project_id,
                                "site_id" => $purchase->site_id,
                                "group_id" => $purchase->group_id,
                                "approved" => $purchase->approved,
                                "sent" => 0,
                                "client_name" => $purchase->client_name,
                                "manufacturing_order_number" => $purchase->manufacturing_order_number,
                            ]);
                            return  $purchse;
                        });
                        break;
                    }
                };

                foreach ($request->reason_refuse as $index => $comment) {
                    if ($comment) {

                        $item = ItemRequest::where("id", $request->ids[$index])->first();
                        $item_create = ItemRequest::create([
                            "purchase_request_id" => $newStoredPurchaseRequest->id,
                            "family_name_id" => $item->family_name_id,
                            "specification" => $item->specification,
                            "file" => $item->file,
                            "comment_reason" => $item->comment_reason,
                            "quantity" => $item->quantity,
                            "stock_quantity" => $item->stock_quantity,
                            "actual_quantity" => $item->actual_quantity,
                            "used_quantity" => $item->used_quantity,
                            "reserved_quantity" => $item->reserved_quantity,
                            "start_date_supply" => $item->start_date_supply,
                            "max_date_delivery" => $item->max_date_delivery,
                            "unit_id" => $item->unit_id,
                            "priority" => $item->priority,
                            "comment" => $item->comment,
                            "approved" => 1,
                            "comment_refuse" => $comment,
                        ]);
                        ItemRequest::where("id", $request->ids[$index])->delete();
                    }
                }
            } else {
                $order = PurchaseOrder::where('id', $approvalTimeline->record_id)->firstOrFail();
                $newRow = PurchaseOrder::withTrashed()->count();
                $ordernumber =  date('Y') . '-' . str_pad(++$newRow, 4, '0', STR_PAD_LEFT);
                DB::beginTransaction();

                foreach ($request->reason_refuse as $index => $comment) {
                    if ($comment) {
                        $newStoredPurchaseOrder = PurchaseOrder::withoutEvents(function () use ($ordernumber, $request, $order) {
                            $purchse = PurchaseOrder::create([
                                "order_number" => $ordernumber,
                                "requester_id" => $order->requester_id,
                                "place_delivery" => $order->place_delivery,
                                "payment_terms" => $order->payment_terms,
                                "general_terms" => $order->general_terms,
                                "suppling_duration" => $order->suppling_duration,
                                "total_gross" => $order->total_gross,
                                "taxes" => $order->taxes,
                                "with_holding" => $order->with_holding,
                                "net_total" => $order->net_total,
                                "supplier_id" => $order->supplier_id,
                                "approved" => $order->approved,
                                "sent" => 0,
                            ]);
                            return  $purchse;
                        });
                        break;
                    }
                };

                foreach ($request->reason_refuse as $index => $comment) {
                    if ($comment) {

                        $item = ItemOrder::where("id", $request->ids[$index])->first();
                        $item_create = ItemOrder::create([
                            "purchase_order_id" => $newStoredPurchaseOrder->id,
                            "total" => $item->total,
                            "comment_reason" => $item->comment_reason,
                            "quantity" => $item->quantity,
                            "price" => $item->price,
                            "quantity" => $item->quantity,
                            "unit_id" => $item->unit_id,
                            "item_request_id" => $item->item_request_id,
                            "comment" => $item->comment,
                            "approved" => 1,
                            "comment_refuse" => $comment,
                            "unit_new" => $item->unit_new,
                            "comment_change_reason" => $item->comment_change_reason,
                            "specification" => $item->specification,
                        ]);
                        ItemOrder::where("id", $request->ids[$index])->delete();
                    }
                }
            }



            // Notification for creator

            // Notification for nextApprovalUser

            DB::commit();
        } catch (\Illuminate\Database\QueryException $e) {
            dd($e->getMessage());
            DB::rollBack();
            $this->getError();
        }
        return redirect()->route('approvals.index');
        // pending
        // approved
        // revert
        // reject
    }

    public function index()
    {
        // $ApprovalTimelines = $this->getCurrentUserPendingApprovals();
        // // return $ApprovalTimelines;
        // $purchaseOrder = [];
        // $purchaseRequest = [];
        // $order = [];
        // foreach ($ApprovalTimelines as $key => $ApprovalTimeline) {
        //     $order[] = ApprovalTimeline::where('id', $ApprovalTimeline->id)->firstOrFail();
        // }

        if(\Auth::user()->hasRole("super_admin")) {
            $ApprovalTimelines = ApprovalTimeline::join('approval_cycle_approval_steps', 'approval_cycle_approval_steps.id', '=', 'approval_timelines.approval_cycle_approval_step_id')
            ->join('users', 'users.id', '=', 'approval_timelines.user_id')
            ->join('approval_steps', 'approval_steps.id', '=', 'approval_cycle_approval_steps.approval_step_id')->where("approval_status","P")->
            select('approval_timelines.id', 'approval_cycle_approval_steps.level', "approval_timelines.record_id" ,'users.username', 'approval_timelines.table_name' , 'approval_timelines.business_action', 'approval_timelines.approval_status', 'approval_steps.name_ar', 'approval_steps.name_en')
            ->get();
            // return $ApprovalTimelines;
        } else {
            if(auth()->user()->manager && auth()->user()->delegated_at == 1) {
                  $ApprovalTimelines = DB::table('approval_timelines')
                ->join('approval_cycle_approval_steps', 'approval_cycle_approval_steps.id', '=', 'approval_timelines.approval_cycle_approval_step_id')
                ->join('users', 'users.id', '=', 'approval_timelines.user_id')
                ->join('approval_steps', 'approval_steps.id', '=', 'approval_cycle_approval_steps.approval_step_id')
                ->where('approval_timelines.approval_status', 'P')
                ->where('approval_timelines.user_id', auth()->user()->id)
                ->orWhere("approval_timelines.user_id",auth()->user()->manager->id)
                ->where('approval_timelines.approval_status', 'P')

                ->select('approval_timelines.id', 'approval_cycle_approval_steps.level', "approval_timelines.record_id" , 'approval_timelines.business_action','users.username', 'approval_timelines.table_name', 'approval_timelines.approval_status', 'approval_steps.name_ar', 'approval_steps.name_en')
                ->orderBy('approval_timelines.updated_at')->get();
            } else {
                   $ApprovalTimelines = $this->getCurrentUserPendingApprovals();
            }
            // $ApprovalTimelines = [];
        }

    //  return  $ApprovalTimelines;

        $purchaseOrder = [];
        $purchaseRequest = [];
        $order = [];
        foreach ($ApprovalTimelines as $key => $ApprovalTimeline) {
            $order[] = ApprovalTimeline::where('id', $ApprovalTimeline->id)->first();
        }

        return view('dashboard-views.approval.index', compact('ApprovalTimelines',  'purchaseOrder', "order" , 'purchaseRequest'));
    }

    // Show approval cycle steps name
    public function show($id)

    {
        $approvalCycle = ApprovalCycle::where('id', $id)->firstOrFail();
        $approvalCycleSteps = $this->getApprovalCycleSteps($id);

        $approvalCycle = [
            'name_ar' => $approvalCycle->name_ar,
            'name_en' => $approvalCycle->name_en,
            'steps' => $approvalCycleSteps,
        ];

        // dd($approvalCycle);

        return view('dashboard-views.approval.show', compact('approvalCycle'));
    }

    // Show approval cycle steps name
    public function showOrder($id, $value , $message)

    {
        $factory = 0;
        $approvalTimeline = ApprovalTimeline::find($id);

        $cycleName = $approvalTimeline->approvalCycleApprovalStep->approvalCycle;
         $timelines = DB::table('approval_timelines')->where('table_name', $approvalTimeline->table_name)->where('record_id', $approvalTimeline->record_id)
            ->where("approval_status", "A")
            ->join('users', 'users.id', '=', 'approval_timelines.user_id')
            ->join('approval_cycle_approval_steps', 'approval_cycle_approval_steps.id', '=', 'approval_timelines.approval_cycle_approval_step_id')
            ->join('approval_steps', 'approval_steps.id', '=', 'approval_cycle_approval_steps.approval_step_id')
            ->leftJoin('approval_timeline_comments', 'approval_timeline_comments.approval_timeline_id', '=', 'approval_timelines.id')
            ->select('approval_steps.name_ar as AS_name_ar',  "approval_timelines.action_id" ,"approval_timelines.user_id" ,'approval_steps.name_en  as AS_name_en',  'users.name_ar as U_name_ar', 'users.name_en as U_name_en', 'approval_timelines.approval_status',
            'approval_timeline_comments.comment as comment','approval_timelines.created_at')
            ->selectRaw("MAX(approval_timelines.created_at) AS created_at")
            ->groupBy("approval_timelines.user_id")
                ->orderBy("approval_timelines.created_at")
            ->get();

        $order = ApprovalTimeline::where('id', $id)->firstOrFail();
        $purchaseOrder = PurchaseRequest::where('id', $order->record_id)->firstOrFail();
        if ($purchaseOrder->client_name) {
            $factory = 1;
        }
        //  x=[]
        $files = FilePurchaseRequest::where('purchase_request_id', $purchaseOrder->id)->get();

        $itemsorders = ItemRequest::where('purchase_request_id', $purchaseOrder->id)->where("approved", 1)->get();
        $ApprovalTimeline = $this->getCurrentUserPendingApprovals();
        return view('dashboard-views.approval.show_order', compact('factory', 'files', 'order', 'purchaseOrder',  "timelines", 'itemsorders', 'ApprovalTimeline', "id", "value" , "message"));
    }


    // Show approval cycle steps name
    public function showOrderRequest($id, $value , $refuse)

    {

        // return $id;

        $order = ApprovalTimeline::where('id', $id)->firstOrFail();
        $purchaseOrder = PurchaseOrder::where('id', $order->record_id)->firstOrFail();
        $purchaseOrder->total_gross = filter_var($purchaseOrder->total_gross, FILTER_SANITIZE_NUMBER_INT);
        $timelines = DB::table('approval_timelines')->where('table_name', $order->table_name)->where('record_id', $order->record_id)
        ->where("approval_status", "A")
        ->join('users', 'users.id', '=', 'approval_timelines.user_id')
        ->join('approval_cycle_approval_steps', 'approval_cycle_approval_steps.id', '=', 'approval_timelines.approval_cycle_approval_step_id')
        ->join('approval_steps', 'approval_steps.id', '=', 'approval_cycle_approval_steps.approval_step_id')
        ->leftJoin('approval_timeline_comments', 'approval_timeline_comments.approval_timeline_id', '=', 'approval_timelines.id')
        ->select('approval_steps.name_ar as AS_name_ar', 'approval_steps.name_en  as AS_name_en',  'users.name_ar as U_name_ar', 'users.name_en as U_name_en', 'approval_timelines.approval_status',
        'approval_timeline_comments.comment as comment', "approval_timelines.action_id" , 'approval_timelines.created_at')
        ->selectRaw("MAX(approval_timelines.created_at) AS created_at")
        ->groupBy("approval_timelines.user_id")
            ->orderBy("approval_timelines.created_at")
        ->get();

        $itemsorders = ItemOrder::where('purchase_order_id', $purchaseOrder->id)->where("approved", 1)->get();
        //    return $itemsorders;
        $files = FilePurchaseOrder::where('purchase_order_id', $purchaseOrder->id)->get();
        $request_number = [];
        $departments = [];
        $projects = [];
        foreach ($itemsorders as $key => $itemsorder) {
            $request_number[$key] = $itemsorder->ItemRequest->purchaseRequest;
            // $id_requestNumber[$key] = PurchaseRequest::where('request_number', $request_number[$key])->firstOrFail();


            $projects[$key] = $itemsorder->ItemRequest->purchaseRequest->project;
            $departments[$key] = $itemsorder->ItemRequest->purchaseRequest->department;
        }

        $requestNumbers = array_unique($request_number);
        // $idRequestNumber = array_unique($id_requestNumber);

        // return $requestNumbers;

        $departments = array_unique($departments);
        $projects = array_unique($projects);


        $ApprovalTimeline = $this->getCurrentUserPendingApprovals();
        // return $ApprovalTimeline;
        // return env('APP_URL','');

        return view('dashboard-views.approval.show_order_request', compact('files',  "timelines" ,  "refuse" , 'projects', 'departments', 'requestNumbers', 'order', 'purchaseOrder', 'itemsorders', 'ApprovalTimeline', "id", "value"));
    }

    // show timeline for specific table record approval cycle
    public function timeline($tableName, $recordId)
    {
        $timelines = $this->getApprovalCycleTimelines($tableName, $recordId);
        $cycleName = ApprovalTimeline::where('table_name', $tableName)->where('record_id', $recordId)->firstOrFail()->approvalCycleApprovalStep->approvalCycle;
        $codeOrId = $recordId;
        return view('dashboard-views.approval.timeline', compact('timelines', 'cycleName', 'codeOrId'));
    }

    // show timeline for specific table record approval cycle By id
    public function timelineById(ApprovalTimeline $approvalTimeline)
    {
        $sites = "";
        $cycleName = $approvalTimeline->approvalCycleApprovalStep->approvalCycle;
        $timelines = $this->getApprovalCycleTimelines($approvalTimeline->table_name, $approvalTimeline->record_id);
        $codeOrId = $approvalTimeline->record_id;
        $PurchaseRequest = PurchaseRequest::where("id", $approvalTimeline->record_id)->first();
        $user = User::find($PurchaseRequest->requester_id);
        $created_at = $approvalTimeline->created_at;
        $sector = Sector::where('id', $PurchaseRequest->sector_id)->first();
        $department = Department::where('id', $PurchaseRequest->department_id)->first();
        $project = Project::where('id', $PurchaseRequest->project_id)->first();
        if ($project) {
            $sites = Site::where('project_id', $project->id)->get();
        }
        return view('dashboard-views.approval.timeline', compact('timelines', 'cycleName', 'codeOrId', 'user',  "department", "sector", "project", 'created_at', "sites", "PurchaseRequest"));
    }

    public function addDuration(Request $request)
    {

        //  return $request;

        $approval = ApprovalTimeline::where('id', $request->id_approvalTimeline)->first();
        //  return   $purchaseRequest= PurchaseRequest::where("id", $request->i)->first();


        $purchaseOrder = PurchaseRequest::where("id", $approval->record_id)->update([
            'expected_duration' => str_replace("\n"," # ",$request->duration)
        ]);
        return redirect()->back();
    }


    public function timelineOrderById(ApprovalTimeline $approvalTimeline)
    {
        $sites = "";
        $cycleName = $approvalTimeline->approvalCycleApprovalStep->approvalCycle;
        $timelines = $this->getApprovalCycleTimelines($approvalTimeline->table_name, $approvalTimeline->record_id);
        $codeOrId = $approvalTimeline->record_id;
        $purchaseOrder = PurchaseOrder::with("supplier")->where("id", $approvalTimeline->record_id)->first();
        $itemReqId = ItemOrder::where("purchase_order_id", $purchaseOrder->id)->pluck("item_request_id");
        $purchaseReID = ItemRequest::whereIn("id", $itemReqId)->groupby("purchase_request_id")->distinct()->pluck("purchase_request_id");
        $purchaseRequestID = PurchaseRequest::whereIn("id", $purchaseReID)->pluck("request_number");
        $user = User::find($purchaseOrder->requester_id);
        $created_at = $approvalTimeline->created_at;
        return view('dashboard-views.approval.timeline_order', compact('timelines', 'cycleName', 'codeOrId', 'user', "purchaseRequestID", 'created_at', "purchaseOrder"));
    }


    public function approveComment(  Request $request)
    {
          $id  = $request->approval_id;
        // return $request->image_approve;

        $approvalTimeline = ApprovalTimeline::where('id', $id)->firstOrFail();
        $model = $this->getModelFromClassName($approvalTimeline->table_name);
        $creatorUser = $model::findOrFail($approvalTimeline->record_id)->requester;
        // $purchase = PurchaseRequest::where('id', $approvalTimeline->record_id)->firstOrFail();
        if(auth()->user()->sector->name_en == "Business Development") {
            $approvalTimeline->update([
                'approval_status' => 'A',
                "action_id" => \Auth::user()->id
            ]);
        } else {
            DB::beginTransaction();
        try {
            // $purchase->update([
            //     "approved" => 1
            // ]);
            $approvalTimeline->update([
                'approval_status' => 'A',
                "action_id" => \Auth::user()->id
            ]);

            $currentApprovalCycleApprovalStep = $approvalTimeline->approvalCycleApprovalStep;
            $nextApprovalCycleApprovalStep = $currentApprovalCycleApprovalStep->next;

            if ($nextApprovalCycleApprovalStep) { // check if there is next approval cycle

                $stepValue =  json_decode($nextApprovalCycleApprovalStep->approvalStep->value);
                $nextApprovalUser = '';

                if (count($stepValue->depth)) {
                    $nextApprovalUser = $creatorUser;
                    foreach ($stepValue->depth as $step) {
                        if ($nextApprovalUser->{$step}) {
                            $nextApprovalUser = $nextApprovalUser->{$step};
                        }
                    }
                } else {
                    $nextApprovalUser = $this->getComplexNextUserForApprovals($stepValue->query->T, $stepValue->query->CONs,  $stepValue->query->depth);
                }
            DB::beginTransaction();
                if(isset($request->skip_stage)) {
                    PurchaseRequest::where("id",$approvalTimeline->record_id)->update([
                        "purchase_type" => $request->purchase_type
                    ]);
                }
                if($request->skip_stage == "skip") {
                    ApprovalTimeline::create([
                        'table_name' => $approvalTimeline->table_name,
                        'record_id' => $approvalTimeline->record_id,
                        'approval_cycle_approval_step_id' => $nextApprovalCycleApprovalStep->id,
                        'user_id' => $nextApprovalUser->id, // next user in cycle
                        "approval_status" => "A"
                    ]);
                } else {
                    ApprovalTimeline::create([
                        'table_name' => $approvalTimeline->table_name,
                        'record_id' => $approvalTimeline->record_id,
                        'approval_cycle_approval_step_id' => $nextApprovalCycleApprovalStep->id,
                        'user_id' => $nextApprovalUser->id, // next user in cycle
                    ]);
                }

                ApprovalTimelineComment::create([
                    'comment_approve' => $request->comment,
                    'approval_timeline_id' => $id,
                ]);

                if($approvalTimeline->table_name == "purchase_requests") {
                    PurchaseRequest::where("id",$approvalTimeline->record_id)->update([
                        "exist_comment" => 1
                    ]);
                } else if($approvalTimeline->table_name == "purchase_orders") {
                    PurchaseOrder::where("id",$approvalTimeline->record_id)->update([
                        "exist_comment" => 1
                    ]);
                } else if($approvalTimeline->table_name == "cheque_requests") {
                    chequeRequest::where("id",$approvalTimeline->record_id)->update([
                        "exist_comment" => 1
                    ]);
                }

                DB::commit();
                if ($request->has('image_approve')) {
                    foreach ($request->image_approve as $file) {
                        $file_approve = $this->uploadImage('approve_request' ,$file);
                        ApprovalTimelineComment::create([
                            "name_image_approve" => $file->getClientOriginalName(),
                            'approval_timeline_id' => $id,
                            "image_approve" => $file_approve
                        ]);
                    }
                }
                $this->getSuccess();
            } else {
                $this->getSuccessToastrMessage('DONE');
                // Here update table record id approval_status To Approved
                /*
                    *
                    *
                    *
                */
            }

            // Notification for creator

            // Notification for nextApprovalUser

            DB::commit();
        } catch (\Illuminate\Database\QueryException $e) {
            dd($e->getMessage());
            DB::rollBack();
            $this->getError();
        }
        }
        return redirect()->route('approvals.index');


        // pending
        // approved
        // revert
        // reject
    }
    // Validate that this user is user in timeline -------------------------------------------------------------------------------------

    // Take approve action
    public function approve(  Request $request, $id)
    {
        $approvalTimeline = ApprovalTimeline::where('id', $id)->firstOrFail();
        $model = $this->getModelFromClassName($approvalTimeline->table_name);
        $creatorUser = $model::findOrFail($approvalTimeline->record_id)->requester;
        // $purchase = PurchaseRequest::where('id', $approvalTimeline->record_id)->firstOrFail();
        // return $approvalTimeline->user->sector->name_en;

        if($approvalTimeline->user->sector->name_en == "Business Development" && \Auth::user()->hasRole("super_admin")) {
            $approvalTimeline->update([
                'approval_status' => 'A',
                "action_id" => \Auth::user()->id,
                "business_action" => 2
            ]);
            ApprovalTimelineComment::create([
                'comment' => $request->comment,
                'approval_timeline_id' => $id,
            ]);

            ApprovalTimeline::where("business_action",3)->where("record_id",$approvalTimeline->record_id)->update([
                "business_action" => 0
            ]);


        }
        else if(auth()->user()->sector->name_en == "Business Development") {
            $approvalTimeline->update([
                'approval_status' => 'A',
                "action_id" => \Auth::user()->id,
                "business_action" => 2
            ]);
            ApprovalTimeline::where("business_action",3)->where("record_id",$approvalTimeline->record_id)->update([
                "business_action" => 0
            ]);
        } else {
            DB::beginTransaction();
            try {
                // $purchase->update([
                //     "approved" => 1
                // ]);
                $approvalTimeline->update([
                    'approval_status' => 'A',
                    "action_id" => \Auth::user()->id,
                ]);

                $currentApprovalCycleApprovalStep = $approvalTimeline->approvalCycleApprovalStep;
                $nextApprovalCycleApprovalStep = $currentApprovalCycleApprovalStep->next;

                if ($nextApprovalCycleApprovalStep) { // check if there is next approval cycle

                    $stepValue =  json_decode($nextApprovalCycleApprovalStep->approvalStep->value);
                    $nextApprovalUser = '';

                    if (count($stepValue->depth)) {
                        $nextApprovalUser = $creatorUser;
                        foreach ($stepValue->depth as $step) {
                            if ($nextApprovalUser->{$step}) {
                                $nextApprovalUser = $nextApprovalUser->{$step};
                            }
                        }
                    } else {
                        $nextApprovalUser = $this->getComplexNextUserForApprovals($stepValue->query->T, $stepValue->query->CONs,  $stepValue->query->depth);
                    }

                    ApprovalTimeline::create([
                        'table_name' => $approvalTimeline->table_name,
                        'record_id' => $approvalTimeline->record_id,
                        'approval_cycle_approval_step_id' => $nextApprovalCycleApprovalStep->id,
                        'user_id' => $nextApprovalUser->id, // next user in cycle
                    ]);

                    $this->getSuccess();
                } else {
                    $this->getSuccessToastrMessage('DONE');
                    // Here update table record id approval_status To Approved
                    /*
                        *
                        *
                        *
                    */
                }

                // Notification for creator

                // Notification for nextApprovalUser

                DB::commit();
            } catch (\Illuminate\Database\QueryException $e) {
                dd($e->getMessage());
                DB::rollBack();
                $this->getError();
            }
        }

        return redirect()->route('approvals.index');
        // pending
        // approved
        // revert
        // reject
    }

    // Take revert action
    public function revert(Request $request)
    {

         $id  = $request->approval_id;
        $approveTime = ApprovalTimeline::with("approvalCycleApprovalStep")->where("id", $id)->first();
        DB::beginTransaction();
        if($approveTime->user->sector) {
            if($approveTime->user->sector->name_en == "Business Development" && \Auth::user()->hasRole("super_admin")) {
                $approveTime->update([
                    'approval_status' => 'RV',
                    "action_id" => \Auth::user()->id,
                    "business_action" => 2
                ]);
                ApprovalTimelineComment::create([
                    'comment' => $request->comment,
                    'approval_timeline_id' => $id,
                ]);

                ApprovalTimeline::where("business_action",3)->where("record_id",$approveTime->record_id)->update([
                    "business_action" => 0
                ]);

            }
        }

        else if(auth()->user()->sector->name_en == "Business Development") {

            ApprovalTimeline::with("approvalCycleApprovalStep")->where("id", $id)->update([
                'approval_status' => 'RV',
                "action_id" => \Auth::user()->id
            ]);
            ApprovalTimelineComment::create([
                'comment' => $request->comment,
                'approval_timeline_id' => $id,
            ]);
            ApprovalTimeline::where("business_action",3)->where("record_id",$approveTime->record_id)->update([
                "business_action" => 0
            ]);
        }

            if ($approveTime->table_name == "purchase_requests") {
                if ($approveTime->approvalCycleApprovalStep->previous_id == null) {
                    PurchaseRequest::where('id', $approveTime->record_id)->update([
                        'sent' => 0,
                        "exist_comment" => 1
                    ]);
                }
                ApprovalTimelineComment::create([
                    'comment' => $request->comment,
                    'approval_timeline_id' => $id,
                ]);
        } else if ($approveTime->table_name == "purchase_orders") {

                if ($approveTime->approvalCycleApprovalStep->previous_id == null) {
                    PurchaseOrder::where('id', $approveTime->record_id)->update([
                        'sent' => 0,
                        "exist_comment" => 1

                    ]);
                }
                ApprovalTimelineComment::create([
                    'comment' => $request->comment,
                    'approval_timeline_id' => $id,
                ]);
            } else if ($approveTime->table_name == "cheque_requests") {

                if ($approveTime->approvalCycleApprovalStep->previous_id == null) {
                    ChequeRequest::where('id', $approveTime->record_id)->update([
                        'sent' => 0,
                        "exist_comment" => 1

                    ]);
                }
                ApprovalTimelineComment::create([
                    'comment' => $request->comment,
                    'approval_timeline_id' => $id,
                ]);
            }
             $approvalTimeline = ApprovalTimeline::where('id', $id)->firstOrFail();
            $model = $this->getModelFromClassName($approvalTimeline->table_name);
            $creatorUser = $model::findOrFail($approvalTimeline->record_id)->requester;
            try {

                $currentApprovalCycleApprovalStep = $approvalTimeline->approvalCycleApprovalStep;

                $previousApprovalCycleApprovalStep = $currentApprovalCycleApprovalStep->previous;

                if ($previousApprovalCycleApprovalStep) { // check if there is next approval cycle
                    $stepValue =  json_decode($previousApprovalCycleApprovalStep->approvalStep->value);
                    $previousApprovalUser = '';

                    if (count($stepValue->depth)) {
                        $previousApprovalUser = $creatorUser;
                        foreach ($stepValue->depth as $step) {
                            if ($previousApprovalUser->{$step}) {
                                $previousApprovalUser = $previousApprovalUser->{$step};
                            }
                        }
                    } else {
                        $previousApprovalUser = $this->getComplexNextUserForApprovals($stepValue->query->T, $stepValue->query->CONs,  $stepValue->query->depth);
                    }
                    ApprovalTimeline::create([
                        'table_name' => $approvalTimeline->table_name,
                        'record_id' => $approvalTimeline->record_id,
                        'approval_cycle_approval_step_id' => $previousApprovalCycleApprovalStep->id,
                        'user_id' => $previousApprovalUser->id, // next user in cycle
                    ]);
                    $this->getWarningMessage('reverted_successfully');
                } else {
                    // Revert approval step to creator
                }

                $approvalTimeline->update([
                    'approval_status' => 'RV'
                ]);

                // Notification for creator

                // Notification for previousApprovalUser

                DB::commit();
            } catch (\Illuminate\Database\QueryException $e) {
                dd($e->getMessage());
                DB::rollBack();
                $this->getError();
            }


        return redirect()->route('approvals.index');
    }

    // Take reject action
    public function reject(Request $request)
    {
        $id  = $request->approval_id;
        DB::beginTransaction();
        ApprovalTimelineComment::create([
            'comment' => $request->comment,
            'approval_timeline_id' => $id,
        ]);

        $approvalTimeline = ApprovalTimeline::where('id', $id)->firstOrFail();
        if($approvalTimeline->user->sector) {
            if($approvalTimeline->user->sector->name_en == "Business Development" && \Auth::user()->hasRole("super_admin")) {
                $approvalTimeline->update([
                    'approval_status' => 'RJ',
                    "action_id" => \Auth::user()->id,
                    "business_action" => 2
                ]);
                ApprovalTimelineComment::create([
                    'comment' => $request->comment,
                    'approval_timeline_id' => $id,
                ]);
                ApprovalTimeline::where("business_action",3)->where("record_id",$approvalTimeline->record_id)->update([
                    "business_action" => 0
                ]);
            }
        }


        else if(auth()->user()->sector->name_en == "Business Development") {
            $approvalTimeline->update([
                'approval_status' => 'RJ',
                "action_id" => \Auth::user()->id,
                "business_action" => 2
            ]);
            ApprovalTimelineComment::create([
                'comment' => $request->comment,
                'approval_timeline_id' => $id,
            ]);
            ApprovalTimeline::where("business_action",3)->where("record_id",$approvalTimeline->record_id)->update([
                "business_action" => 0
            ]);
        }
            if($approvalTimeline->table_name == "purchase_requests") {
                PurchaseRequest::where("id",$approvalTimeline->record_id)->update([
                    "exist_comment" => 1
                ]);
            } else if($approvalTimeline->table_name == "purchase_orders") {
                PurchaseOrder::where("id",$approvalTimeline->record_id)->update([
                    "exist_comment" => 1
                ]);
            } else if($approvalTimeline->table_name == "cheque_requests") {
                chequeRequest::where("id",$approvalTimeline->record_id)->update([
                    "exist_comment" => 1
                ]);
            }
            $approvalTimeline->update([
                'approval_status' => 'RJ'
            ]);

    DB::commit();

        $this->getWarningMessage('rejected_successfully');

        // Notification for creator

        // Here update table record id approval_status To Rejcted
        /*
            *
            *
            *
        */
        return redirect()->route('approvals.index');
    }

    public function showAllApprovalRequestsTimeline()
    {

        if (Auth::user()->can('timeline-purchase-request-super')) {
            $purchaseRequestId = PurchaseRequest::pluck("id");
        }
        else {
            $purchaseRequestId = PurchaseRequest::where("sector_id" , auth()->user()->sector->id)->pluck("id");
        }
        $approvalTimelines = ApprovalTimeline::whereIn("record_id",$purchaseRequestId)->where("table_name", "purchase_requests")->groupby("record_id")->distinct()->get();
        // return $approvalTimelines;

        $data = [];
        $projects = [];
        $sites = [];
        $departments = [];

        foreach ($approvalTimelines as $timeline) {

            $exis = PurchaseRequest::where('id', $timeline->record_id)->get();
            if ($exis) {
                $data[] = $exis;
            }
        }
        foreach ($data as $dat) {
            foreach ($dat as $pro) {
                $exis =  Project::where("id", $pro->project_id)->get();
                if ($exis) {
                    $projects[] = $exis;
                }
            }
        }


        foreach ($data as $dat) {
            foreach ($dat as $dept) {
                $exis =  Department::where("id", $dept->department_id)->get();
                if ($exis) {
                    $departments[] = $exis;
                }
            }
        }


        foreach ($data as $site) {
            foreach ($site as $siteget) {
                $exis =  Site::where('id', $siteget->site_id)->get();
                if ($exis) {
                    $sites[] = $exis;
                }
            }
        }
        $accept = 0;

        return view('dashboard-views.timeline.all_time_requests', compact('accept', 'approvalTimelines', 'projects', 'sites', "departments"));
    }

    public function showAllApprovalOrdersTimeline()
    {

        if (Auth::user()->can('timeline-purchase-order-super')) {
            $purchaseRequestId = PurchaseRequest::pluck("id");
        }
        else {
            $purchaseRequestId = PurchaseRequest::where("sector_id" , auth()->user()->sector->id)->pluck("id");
        }
        $itemRequests = ItemRequest::whereIn("purchase_request_id",$purchaseRequestId)->pluck("id");
        $purchaseOrdersId = ItemOrder::whereIn("item_request_id",$itemRequests)->pluck("purchase_order_id");


        $approvalTimelines = ApprovalTimeline::whereIn("record_id", $purchaseOrdersId)->with("itemOrders", "purchaseOrder")->where("table_name", "purchase_orders")->groupby("record_id")->distinct()->get();
        $data = [];
        $projects = [];
        $departments = [];

        $purID = ApprovalTimeline::where("table_name", "purchase_orders")->groupby("record_id")->distinct()->pluck("record_id");
        $purchaseOrders = PurchaseOrder::with(["supplier", "itemOrders"])->where("sent", 1)->whereIn("id", $purID)->get();

        foreach ($purchaseOrders as $index => $purchaseOrder) {
            foreach ($purchaseOrder->itemOrders as $itemOrder) {
                $data[] = $itemOrder->ItemRequest()->pluck('purchase_request_id')->first();
            }
        }
        $departments = PurchaseRequest::groupBy("department_id")->distinct()->with("department", "itemRequests")->whereIn('id', $data)
            ->get();
        $projects = PurchaseRequest::groupBy("project_id")->distinct()->with("project", "itemRequests")->whereIn('id', $data)
            ->get();
        $accept = 0;
        return view('dashboard-views.timeline.all_time_orders', compact('approvalTimelines', "accept" , 'projects',  "departments"));
    }

    public function showAllAcceptableRequestsTimeline()
    {
        if (Auth::user()->can('acceptable-purchase-request-super')) {
            $purchaseRequestsId = PurchaseRequest::pluck("id");
        }
        elseif(Auth::user()->can('internal_purchases')){
            $purchaseRequestsId = PurchaseRequest::where("purchase_type" , "purchase_in")->pluck("id");

        }
        elseif(Auth::user()->can('external_purchases')){
            $purchaseRequestsId = PurchaseRequest::where("purchase_type" , "purchase_out")->pluck("id");

        }


        else {
            $purchaseRequestsId = PurchaseRequest::where("sector_id" , auth()->user()->sector->id)->pluck("id");
        }

        $approvalTimelines = ApprovalTimeline::whereIn("record_id",$purchaseRequestsId)->where("table_name", "purchase_requests")->groupby("record_id")->join('approval_cycle_approval_steps', 'approval_timelines.approval_cycle_approval_step_id', 'approval_cycle_approval_steps.id')
            ->select("approval_timelines.id", "approval_timelines.table_name", "approval_timelines.record_id", "approval_timelines.approval_cycle_approval_step_id", "approval_timelines.approval_status", "approval_timelines.user_id", "approval_timelines.created_at")
            ->where('approval_cycle_approval_steps.next_id', null)->where('approval_status', 'A')->get();

        //  return   $approvalTimelines = ApprovalTimeline::where("table_name", "purchase_requests")->groupby("record_id")->distinct()->where('user_id', '3')->where('approval_status', 'A')->paginate(env('PAGINATION_LENGTH', 5));
        $data = [];
        $projects = [];
        $sites = [];
        $departments = [];
        $items = [];

        $allPurchaseRequest = PurchaseRequest::get();
        // $approvalTimelinesCreate = ApprovalTimeline::where("table_name", "purchase_requests")->where('record_id', '3')->where('approval_status', 'A')->paginate(env('PAGINATION_LENGTH', 5));


        foreach ($approvalTimelines as $timeline) {
            $exis = PurchaseRequest::where('id', $timeline->record_id)->get();
            $item = ItemRequest::where('purchase_request_id', $timeline->record_id)->get();

            if ($exis) {
                $data[] = $exis;
            }
            if ($item) {
                $items[] = $item;
            }
        }

        // return $items;

        // $status="complated";
        // foreach ($items as $x) {
        //     if ($x->actual_quantity !=0) {
        //         $status="in progress";
        //     }
        // }

        foreach ($data as $dat) {
            foreach ($dat as $pro) {
                $exis =  Project::where("id", $pro->project_id)->get();
                if ($exis) {
                    $projects[] = $exis;
                }
            }
        }

        foreach ($data as $dat) {
            foreach ($dat as $dept) {
                $exis =  Department::where("id", $dept->department_id)->get();
                if ($exis) {
                    $departments[] = $exis;
                }
            }
        }

        foreach ($data as $site) {
            foreach ($site as $siteget) {
                $exis =  Site::where('id', $siteget->site_id)->get();
                if ($exis) {
                    $sites[] = $exis;
                }
            }
        }
        $accept = 1;
        // return $items;
        return view('dashboard-views.timeline.acceptable_purchase_requests', compact('allPurchaseRequest', 'accept', 'items', 'approvalTimelines', 'projects', 'sites', 'departments'));
    }


    public function showAllAcceptableOrdersTimeline()
    {
        if (Auth::user()->can('acceptable-purchase-request-super')) {
            $purchaseRequestId = PurchaseRequest::pluck("id");
        }
        else {
            $purchaseRequestId = PurchaseRequest::where("sector_id" , auth()->user()->sector->id)->pluck("id");
        }


        $itemRequests = ItemRequest::whereIn("purchase_request_id",$purchaseRequestId)->pluck("id");
          $purchaseOrdersId = ItemOrder::whereIn("item_request_id",$itemRequests)->pluck("purchase_order_id");
         $approvalTimelines = ApprovalTimeline::whereIn("record_id",$purchaseOrdersId)->where("table_name", "purchase_orders")->groupby("record_id")->join('approval_cycle_approval_steps', 'approval_timelines.approval_cycle_approval_step_id', 'approval_cycle_approval_steps.id')
        ->select("approval_timelines.id", "approval_timelines.table_name", "approval_timelines.record_id", "approval_timelines.approval_cycle_approval_step_id", "approval_timelines.approval_status", "approval_timelines.user_id", "approval_timelines.created_at")
        ->where('approval_cycle_approval_steps.next_id', null)->where('approval_status', 'A')->get();
        $data = [];
        $projects = [];
        $sites = [];
        $departments = [];
        $items = [];

        $purID = ApprovalTimeline::where("table_name", "purchase_orders")->groupby("record_id")->distinct()->pluck("record_id");
        $purchaseOrders = PurchaseOrder::with(["supplier", "itemOrders"])->where("sent", 1)->whereIn("id", $purID)->get();

        foreach ($purchaseOrders as $index => $purchaseOrder) {
            foreach ($purchaseOrder->itemOrders as $item) {
                $exis = ItemRequest::where('id', $item->item_request_id)->get();
                if ($exis) {
                    $data[] = $exis;
                }
            }
        }



        // $allPurchaseRequest = PurchaseRequest::get();
        // $approvalTimelinesCreate = ApprovalTimeline::where("table_name", "purchase_requests")->where('record_id', '3')->where('approval_status', 'A')->paginate(env('PAGINATION_LENGTH', 5));


        foreach ($approvalTimelines as $timeline) {
            $exis = PurchaseOrder::where('id', $timeline->record_id)->get();
            $item = ItemOrder::where('purchase_order_id', $timeline->record_id)->get();

            if ($exis) {
                $data[] = $exis;
            }
            if ($item) {
                $items[] = $item;
            }
        }

        // return $data;
        $idITem = [];
        foreach ($data as $purchaseRequest) {
            foreach ($purchaseRequest as $pur) {
                $idITem[] = $pur->purchase_request_id;
            }
        }

        //   return $idITem;

        $departments = PurchaseRequest::groupBy("department_id")->distinct()->with("department", "itemRequests")->whereIn('id', $idITem)
            ->get();
        $projects = PurchaseRequest::groupBy("project_id")->distinct()->with("project", "itemRequests")->whereIn('id', $idITem)
            ->get();
        $accept = 1;
        return view('dashboard-views.timeline.acceptable_purchase_orders', compact('approvalTimelines',"items","accept" , 'projects', 'departments'));
    }




    function fetch_data(Request $request)
    {
        // dd($request->all());
        /* Request
        [
            page, // page number
            legnth, // items per page
            search_content,
            page_type => ['index', 'trashed']
        ]
        */

        $accept = 0;
        $length = request()->length ?? env('PAGINATION_LENGTH', 5);
        $searchContent = request()->search_content ?? '';
        $pageType = request()->page_type;
        $approvalTimelines = [];
        $data = [];
        $projects = [];
        $projectsID = [];
        $sites = [];
        $purchaseId = [];
        $departments = [];
        if ($request->ajax()) {
            if ($pageType == 'index') {
                if ($length == -1) {
                    $length = ApprovalTimeline::where("table_name", "purchase_requests")->count();
                }
                if (strlen($searchContent)) {
                    /* Project search */
                    $projectsID = Project::where(function ($query) use ($searchContent) {
                        return $query->where('name_ar', 'like', '%' . $searchContent . '%')
                            ->orWhere('name_en', 'like', '%' . $searchContent . '%');
                    })->pluck("id");
                    $purchaseId = PurchaseRequest::whereIn('project_id', $projectsID)->where("sector_id" , auth()->user()->sector->id)->pluck('id');
                    /* End Project search */

                    /* Site search */

                    $siteID = Site::where(function ($query) use ($searchContent) {
                        return $query->where('name_ar', 'like', '%' . $searchContent . '%')
                            ->orWhere('name_en', 'like', '%' . $searchContent . '%');
                    })->pluck("id");
                    $purchasesiteId = PurchaseRequest::whereIn('site_id', $siteID)->where("sector_id" , auth()->user()->sector->id)->pluck('id');

                    /* End Site search */

                    /* Department search */

                    $department_id = Department::where(function ($query) use ($searchContent) {
                        return $query->where('name_ar', 'like', '%' . $searchContent . '%')
                            ->orWhere('name_en', 'like', '%' . $searchContent . '%');
                    })->pluck("id");
                    $purchasedeptId = PurchaseRequest::whereIn('department_id', $department_id)->where("sector_id" , auth()->user()->sector->id)->pluck('id');

                    /* End Department search */
                    $purchaseRequestNumber = PurchaseRequest::where('request_number', 'like', '%' . $searchContent . '%')->where("sector_id" , auth()->user()->sector->id)->pluck('id');
                    // $purchaseRequestId = PurchaseRequest::where("sector_id" , auth()->user()->sector->id)->pluck("id");

                    $approvalTimelines = ApprovalTimeline::where("table_name", "purchase_requests")->where(function ($query) use ($searchContent, $purchaseId, $purchasesiteId, $purchasedeptId, $purchaseRequestNumber) {
                        return $query->where('table_name', 'like', '%' . $searchContent . '%')
                            ->orWhereIn('record_id', $purchaseId)
                            ->orWhereIn('record_id', $purchasesiteId)
                            ->orWhereIn('record_id', $purchasedeptId)
                            ->orWhereIn('record_id', $purchaseRequestNumber);
                    })->groupby("record_id")->distinct()->paginate($length);
                } else {
                        $purchaseRequestId = PurchaseRequest::where("sector_id" , auth()->user()->sector->id)->pluck("id");
                       $approvalTimelines = ApprovalTimeline::whereIn("record_id",$purchaseRequestId)->where("table_name", "purchase_requests")->groupby("record_id")->distinct()->paginate($length);
                }
            }
            foreach ($approvalTimelines as $timeline) {
                $exis = PurchaseRequest::where('id', $timeline->record_id)->get();
                if ($exis) {
                    $data[] = $exis;
                }
            }


            foreach ($data as $dat) {
                foreach ($dat as $pro) {
                    $exis =  Project::where("id", $pro->project_id)->get();
                    if ($exis) {
                        $projects[] = $exis;
                    }
                }
            }
            foreach ($data as $dat) {
                foreach ($dat as $dept) {
                    $exis =  Department::where("id", $dept->department_id)->get();
                    if ($exis) {
                        $departments[] = $exis;
                    }
                }
            }

            foreach ($data as $site) {
                foreach ($site as $siteget) {
                    $exis =  Site::where('id', $siteget->site_id)->get();
                    if ($exis) {
                        $sites[] = $exis;
                    }
                }
            }
            return view('dashboard-views.approval.pagination_data', compact('approvalTimelines',  "accept", 'pageType', 'projects', 'sites', "departments"))->render();
        }
    }

    function fetch_data_approvel(Request $request)
    {
        // dd($request->all());
        /* Request
        [
            page, // page number
            legnth, // items per page
            search_content,
            page_type => ['index', 'trashed']
        ]
        */
        $length = request()->length ?? env('PAGINATION_LENGTH', 5);
        $searchContent = request()->search_content ?? '';
        $pageType = request()->page_type;
        $ApprovalTimelines = [];
        if(\Auth::user()->hasRole("super_admin")) {
            if ($request->ajax()) {
                if ($pageType == 'index') {
                    if ($length == -1) {
                        // $length = ApprovalTimeline::where("table_name", "purchase_requests")->where("user_id", \Auth::user()->id)->count();
                        $length = ApprovalTimeline::count();
                    }
                    if (strlen($searchContent)) {
                        $purchaseRequestId = PurchaseRequest::where("sector_id" , auth()->user()->sector->id)->pluck("id");
                        $ApprovalTimelines =  DB::table('approval_timelines')
                            ->join('approval_cycle_approval_steps', 'approval_cycle_approval_steps.id', '=', 'approval_timelines.approval_cycle_approval_step_id')
                            ->join('users', 'users.id', '=', 'approval_timelines.user_id')
                            ->join('approval_steps', 'approval_steps.id', '=', 'approval_cycle_approval_steps.approval_step_id')
                            ->where('approval_timelines.approval_status', 'P')
                            ->whereIn("record_id",$purchaseRequestId)
                            ->where('approval_timelines.table_name', 'like', '%' . $searchContent . '%')
                            ->select('approval_timelines.id', 'approval_cycle_approval_steps.level', 'users.username', 'approval_timelines.table_name', "approval_timelines.record_id" ,'approval_timelines.approval_status', 'approval_steps.name_ar', 'approval_steps.name_en')
                            ->orderBy('approval_timelines.updated_at')->paginate($length);
                    } else {
                        $purchaseRequestId = PurchaseRequest::where("sector_id" , auth()->user()->sector->id)->pluck("id");

                        $ApprovalTimelines = ApprovalTimeline::where("approval_status","P")->whereIn("record_id",$purchaseRequestId)->paginate($length);
                    }
                }  $order = [];
                foreach ($ApprovalTimelines as $key => $ApprovalTimeline) {
                    $order[] = ApprovalTimeline::where('id', $ApprovalTimeline->id)->firstOrFail();
                }
                return view('dashboard-views.approval.pagination_data_index', compact('ApprovalTimelines', 'pageType' , "order"))->render();
            }
        } else {
            if ($request->ajax()) {
                if ($pageType == 'index') {
                    if ($length == -1) {
                        $length = ApprovalTimeline::where("table_name", "purchase_requests")->where("user_id", \Auth::user()->id)->count();
                    }
                    if (strlen($searchContent)) {
                        $ApprovalTimelines =  DB::table('approval_timelines')
                            ->join('approval_cycle_approval_steps', 'approval_cycle_approval_steps.id', '=', 'approval_timelines.approval_cycle_approval_step_id')
                            ->join('users', 'users.id', '=', 'approval_timelines.user_id')
                            ->join('approval_steps', 'approval_steps.id', '=', 'approval_cycle_approval_steps.approval_step_id')
                            ->where('approval_timelines.user_id', auth()->user()->id)
                            ->where('approval_timelines.approval_status', 'P')
                            ->where('approval_timelines.table_name', 'like', '%' . $searchContent . '%')
                            ->select('approval_timelines.id', 'approval_cycle_approval_steps.level', 'users.username', 'approval_timelines.table_name', 'approval_timelines.approval_status', 'approval_steps.name_ar', 'approval_steps.name_en')
                            ->orderBy('approval_timelines.updated_at')->paginate($length);
                    } else {
                        $ApprovalTimelines = $this->getCurrentUserPendingApprovals($length);
                    }
                }
                $order = [];
                foreach ($ApprovalTimelines as $key => $ApprovalTimeline) {
                    $order[] = ApprovalTimeline::where('id', $ApprovalTimeline->id)->firstOrFail();
                }
                return view('dashboard-views.approval.pagination_data_index', compact('ApprovalTimelines', 'pageType' , "order"))->render();
            }
        }


    }
    // function fetch_data_approvel_accepted(Request $request)
    // {
    //     // dd($request->all());
    //     /* Request
    //     [
    //         page, // page number
    //         legnth, // items per page
    //         search_content,
    //         page_type => ['index', 'trashed']
    //     ]
    //     */
    //     return "Af";
    //     $accept = 1;
    //     $length = request()->length ?? env('PAGINATION_LENGTH', 5);
    //     $searchContent = request()->search_content ?? '';
    //     $pageType = request()->page_type;
    //     $approvalTimelines = [];
    //     $data = [];
    //     $projects = [];
    //     $projectsID = [];
    //     $sites = [];
    //     $purchaseId = [];
    //     $departments = [];
    //     if ($request->ajax()) {
    //         if ($pageType == 'index') {
    //             if ($length == -1) {
    //                 $length = ApprovalTimeline::where("table_name", "purchase_requests")->count();
    //             }
    //             if (strlen($searchContent)) {
    //                 /* Project search */
    //                 $projectsID = Project::where(function ($query) use ($searchContent) {
    //                     return $query->where('name_ar', 'like', '%' . $searchContent . '%')
    //                         ->orWhere('name_en', 'like', '%' . $searchContent . '%');
    //                 })->pluck("id");
    //                 $purchaseId = PurchaseRequest::whereIn('project_id', $projectsID)->where("sector_id" , auth()->user()->sector->id)->pluck('id');
    //                 /* End Project search */

    //                 /* Site search */

    //                 $siteID = Site::where(function ($query) use ($searchContent) {
    //                     return $query->where('name_ar', 'like', '%' . $searchContent . '%')
    //                         ->orWhere('name_en', 'like', '%' . $searchContent . '%');
    //                 })->pluck("id");
    //                 $purchasesiteId = PurchaseRequest::whereIn('site_id', $siteID)->where("sector_id" , auth()->user()->sector->id)->pluck('id');

    //                 /* End Site search */

    //                 /* Department search */

    //                 $department_id = Department::where(function ($query) use ($searchContent) {
    //                     return $query->where('name_ar', 'like', '%' . $searchContent . '%')
    //                         ->orWhere('name_en', 'like', '%' . $searchContent . '%');
    //                 })->pluck("id");
    //                 $purchasedeptId = PurchaseRequest::whereIn('department_id', $department_id)->where("sector_id" , auth()->user()->sector->id)->pluck('id');
    //                 /* End Department search */

    //                 $purchaseRequestNumber = PurchaseRequest::where('request_number', 'like', '%' . $searchContent . '%')->where("sector_id" , auth()->user()->sector->id)->pluck('id');

    //                 $approvalTimelines = ApprovalTimeline::where("table_name", "purchase_requests")->where(function ($query) use ($searchContent, $purchaseId, $purchasesiteId, $purchasedeptId, $purchaseRequestNumber) {
    //                     return $query->where('table_name', 'like', '%' . $searchContent . '%')

    //                         ->orWhereIn('record_id', $purchaseId)
    //                         ->orWhereIn('record_id', $purchasesiteId)
    //                         ->orWhereIn('record_id', $purchasedeptId)
    //                         ->orWhereIn("record_id", $purchaseRequestNumber);
    //                 })->groupby("record_id")->distinct()->where('user_id', '3')
    //                     ->where('approval_status', 'A')->paginate($length);

    //     //                 $approvalTimelines = ApprovalTimeline::orWhereIn('record_id', $purchaseId)
    //     //                     ->orWhereIn('record_id', $purchasesiteId)
    //     //                     ->orWhereIn('record_id', $purchasedeptId)
    //     //                     ->orWhereIn("record_id", $purchaseRequestNumber)
    //     //                     ->where('table_name', 'like', '%' . $searchContent . '%')
    //     //                 ->groupby("record_id")->join('approval_cycle_approval_steps', 'approval_timelines.approval_cycle_approval_step_id', 'approval_cycle_approval_steps.id')
    //     // ->select("approval_timelines.id", "approval_timelines.table_name", "approval_timelines.record_id", "approval_timelines.approval_cycle_approval_step_id", "approval_timelines.approval_status", "approval_timelines.user_id", "approval_timelines.created_at")
    //     // ->where('approval_cycle_approval_steps.next_id', null)->where('approval_status', 'A')->paginate(env('PAGINATION_LENGTH', 5));
    //             } else {
    //                 $purchaseRequestId = PurchaseRequest::where("sector_id" , auth()->user()->sector->id)->pluck("id");
    //                 $approvalTimelines = ApprovalTimeline::whereIn("record_id",$purchaseRequestId)->where("table_name", "purchase_requests")->groupby("record_id")->distinct()->where('user_id', '3')->where('approval_status', 'A')->paginate($length);
    //             }
    //         }


    //         foreach ($approvalTimelines as $timeline) {
    //             $exis = PurchaseRequest::where('id', $timeline->record_id)->get();
    //             if ($exis) {
    //                 $data[] = $exis;
    //             }
    //         }


    //         foreach ($data as $dat) {
    //             foreach ($dat as $pro) {
    //                 $exis =  Project::where("id", $pro->project_id)->get();
    //                 if ($exis) {
    //                     $projects[] = $exis;
    //                 }
    //             }
    //         }
    //         foreach ($data as $dat) {
    //             foreach ($dat as $dept) {
    //                 $exis =  Department::where("id", $dept->department_id)->get();
    //                 if ($exis) {
    //                     $departments[] = $exis;
    //                 }
    //             }
    //         }

    //         foreach ($data as $site) {
    //             foreach ($site as $siteget) {
    //                 $exis =  Site::where('id', $siteget->site_id)->get();
    //                 if ($exis) {
    //                     $sites[] = $exis;
    //                 }
    //             }
    //         }
    //         return view('dashboard-views.approval.pagination_data', compact('approvalTimelines', "accept", 'pageType', 'projects', 'sites', "departments"))->render();
    //     }
    // }



    function fetch_data_approvel_accepted_orders(Request $request)
    {
        // dd($request->all());
        /* Request
        [
            page, // page number
            legnth, // items per page
            search_content,
            page_type => ['index', 'trashed']
        ]
        */
        $length = request()->length ?? env('PAGINATION_LENGTH', 5);
        $searchContent = request()->search_content ?? '';
        $pageType = request()->page_type;
        $approvalTimelines = [];
        $data = [];
        $projects = [];
        $projectsID = [];
        $purchaseId = [];
        $departments = [];
        $purchaseRequestId = PurchaseRequest::where("sector_id" , auth()->user()->sector->id)->pluck("id");
        $itemRequests = ItemRequest::whereIn("purchase_request_id",$purchaseRequestId)->pluck("id");
        $purchaseOrdersSearchid = ItemOrder::whereIn("item_request_id",$itemRequests)->pluck("purchase_order_id");
        if ($request->ajax()) {
            if ($pageType == 'index') {
                if ($length == -1) {
                    $length = ApprovalTimeline::where("table_name", "purchase_orders")->count();
                }
                if (strlen($searchContent)) {
                    /* Project search */
                    $projectsID = Project::where(function ($query) use ($searchContent) {
                        return $query->where('name_ar', 'like', '%' . $searchContent . '%')
                            ->orWhere('name_en', 'like', '%' . $searchContent . '%');
                    })->pluck("id");
                    $purchaseId = PurchaseRequest::whereIn('project_id', $projectsID)->where("sector_id" , auth()->user()->sector->id)->pluck('id');
                    /* End Project search */

                    /* Department search */

                    $department_id = Department::where(function ($query) use ($searchContent) {
                        return $query->where('name_ar', 'like', '%' . $searchContent . '%')
                            ->orWhere('name_en', 'like', '%' . $searchContent . '%');
                    })->pluck("id");

                    $purchasedeptId = PurchaseRequest::whereIn('department_id', $department_id)->where("sector_id" , auth()->user()->sector->id)->pluck('id');
                    /* End Department search */

                    $itemRe = ItemRequest::whereIn("purchase_request_id", $purchasedeptId)->orWhereIn("purchase_request_id", $purchaseId)->pluck("id");

                    $POID = ItemOrder::whereIn("item_request_id", $itemRe)->pluck("purchase_order_id");

                    $purchaseOrderNumber = PurchaseOrder::whereIn("id", $purchaseOrdersSearchid)->where('order_number', 'like', '%' . $searchContent . '%')->pluck('id');

                    $approvalTimelines = ApprovalTimeline::whereIn("record_id",$POID)->orWhereIn('record_id', $purchaseOrderNumber)->where("table_name", "purchase_orders")->groupby("record_id")->join('approval_cycle_approval_steps', 'approval_timelines.approval_cycle_approval_step_id', 'approval_cycle_approval_steps.id')
                    ->select("approval_timelines.id", "approval_timelines.table_name", "approval_timelines.record_id", "approval_timelines.approval_cycle_approval_step_id", "approval_timelines.approval_status", "approval_timelines.user_id", "approval_timelines.created_at")
                    ->where('approval_cycle_approval_steps.next_id', null)->where('approval_status', 'A')->paginate(env('PAGINATION_LENGTH',$length));
                } else {
                    $approvalTimelines = ApprovalTimeline::whereIn("record_id",$purchaseOrdersSearchid)->where("table_name", "purchase_orders")->groupby("record_id")->join('approval_cycle_approval_steps', 'approval_timelines.approval_cycle_approval_step_id', 'approval_cycle_approval_steps.id')
                    ->select("approval_timelines.id", "approval_timelines.table_name", "approval_timelines.record_id", "approval_timelines.approval_cycle_approval_step_id", "approval_timelines.approval_status", "approval_timelines.user_id", "approval_timelines.created_at")
                    ->where('approval_cycle_approval_steps.next_id', null)->where('approval_status', 'A')->paginate(env('PAGINATION_LENGTH',$length));
                }
            }


            $purID = ApprovalTimeline::whereIn("record_id",$purchaseOrdersSearchid)->where("table_name", "purchase_orders")->groupby("record_id")->distinct()->pluck("record_id");
            $purchaseOrders = PurchaseOrder::with(["supplier", "itemOrders"])->where("sent", 1)->whereIn("id", $purID)->get();

            foreach ($purchaseOrders as $index => $purchaseOrder) {
                foreach ($purchaseOrder->itemOrders as $itemOrder) {
                    $data[] = $itemOrder->ItemRequest()->pluck('purchase_request_id')->first();
                }
            }

            $items = [];

            foreach ($approvalTimelines as $timeline) {
                $exis = PurchaseRequest::where('id', $timeline->record_id)->get();
                $item = ItemRequest::where('purchase_request_id', $timeline->record_id)->get();

                if ($exis) {
                    $data[] = $exis;
                }
                if ($item) {
                    $items[] = $item;
                }
            }

            $departments = PurchaseRequest::groupBy("department_id")->distinct()->with("department", "itemRequests")->whereIn('id', $data)
                ->get();
            $projects = PurchaseRequest::groupBy("project_id")->distinct()->with("project", "itemRequests")->whereIn('id', $data)
                ->get();
                $accept = 1;
            return view('dashboard-views.approval.pagination_data_order', compact('approvalTimelines', "items" ,"accept" , 'pageType', 'projects', "departments"))->render();
        }
    }

    function fetch_data_order(Request $request)
    {
        // dd($request->all());
        /* Request
        [
            page, // page number
            legnth, // items per page
            search_content,
            page_type => ['index', 'trashed']
        ]
        */
        $length = request()->length ?? env('PAGINATION_LENGTH', 5);
        $searchContent = request()->search_content ?? '';
        $pageType = request()->page_type;
        $approvalTimelines = [];
        $data = [];
        $projects = [];
        $projectsID = [];
        $purchaseId = [];
        $departments = [];
        $purchaseRequestId = PurchaseRequest::where("sector_id" , auth()->user()->sector->id)->pluck("id");
        $itemRequests = ItemRequest::whereIn("purchase_request_id",$purchaseRequestId)->pluck("id");
        $purchaseOrdersSearchid = ItemOrder::whereIn("item_request_id",$itemRequests)->pluck("purchase_order_id");
        $purchaseRequestNumber = [];
        if ($request->ajax()) {
            if ($pageType == 'index') {
                if ($length == -1) {
                    $length = ApprovalTimeline::where("table_name", "purchase_orders")->count();
                }
                if (strlen($searchContent)) {
                    /* Project search */
                    $projectsID = Project::where(function ($query) use ($searchContent) {
                        return $query->where('name_ar', 'like', '%' . $searchContent . '%')
                            ->orWhere('name_en', 'like', '%' . $searchContent . '%');
                    })->pluck("id");
                    $purchaseId = PurchaseRequest::where("sector_id" , auth()->user()->sector->id)->whereIn('project_id', $projectsID)->pluck('id');
                    /* End Project search */

                    /* Department search */

                    $department_id = Department::where(function ($query) use ($searchContent) {
                        return $query->where('name_ar', 'like', '%' . $searchContent . '%')
                            ->orWhere('name_en', 'like', '%' . $searchContent . '%');
                    })->pluck("id");

                    $purchasedeptId = PurchaseRequest::where("sector_id" , auth()->user()->sector->id)->whereIn('department_id', $department_id)->pluck('id');
                    /* End Department search */

                    $itemRe = ItemRequest::whereIn("purchase_request_id", $purchasedeptId)->orWhereIn("purchase_request_id", $purchaseId)->pluck("id");

                    $POID = ItemOrder::whereIn("item_request_id", $itemRe)->pluck("purchase_order_id");

                    $purchaseOrderNumber = PurchaseOrder::whereIn("id",$purchaseOrdersSearchid)->where('order_number', 'like', '%' . $searchContent . '%')->pluck('id');

                    $approvalTimelines = ApprovalTimeline::whereIn("record_id",$POID)->orWhereIn('record_id', $purchaseOrderNumber)->where("table_name", "purchase_orders")->groupby("record_id")->join('approval_cycle_approval_steps', 'approval_timelines.approval_cycle_approval_step_id', 'approval_cycle_approval_steps.id')
                    ->select("approval_timelines.id", "approval_timelines.table_name", "approval_timelines.record_id", "approval_timelines.approval_cycle_approval_step_id", "approval_timelines.approval_status", "approval_timelines.user_id", "approval_timelines.created_at")
                    ->where('approval_cycle_approval_steps.next_id', null)->where('approval_status', 'A')->paginate(env('PAGINATION_LENGTH',$length));
                } else {
                    $approvalTimelines = ApprovalTimeline::whereIn("record_id",$purchaseOrdersSearchid)->where("table_name", "purchase_orders")->groupby("record_id")->join('approval_cycle_approval_steps', 'approval_timelines.approval_cycle_approval_step_id', 'approval_cycle_approval_steps.id')
                    ->select("approval_timelines.id", "approval_timelines.table_name", "approval_timelines.record_id", "approval_timelines.approval_cycle_approval_step_id", "approval_timelines.approval_status", "approval_timelines.user_id", "approval_timelines.created_at")
                    ->where('approval_cycle_approval_steps.next_id', null)->where('approval_status', 'A')->paginate(env('PAGINATION_LENGTH',$length));
                }
            }


            $purID = ApprovalTimeline::whereIn("record_id",$purchaseOrdersSearchid)->where("table_name", "purchase_orders")->groupby("record_id")->distinct()->pluck("record_id");
            $purchaseOrders = PurchaseOrder::with(["supplier", "itemOrders"])->where("sent", 1)->whereIn("id", $purID)->get();
            foreach ($purchaseOrders as $index => $purchaseOrder) {
                foreach ($purchaseOrder->itemOrders as $itemOrder) {
                    $data[] = $itemOrder->ItemRequest()->pluck('purchase_request_id')->first();
                }
            }

            $items = [];

            foreach ($approvalTimelines as $timeline) {
                $exis = PurchaseRequest::where('id', $timeline->record_id)->get();
                $item = ItemRequest::where('purchase_request_id', $timeline->record_id)->get();

                if ($exis) {
                    $data[] = $exis;
                }
                if ($item) {
                    $items[] = $item;
                }
            }

            $departments = PurchaseRequest::groupBy("department_id")->distinct()->with("department", "itemRequests")->whereIn('id', $data)
                ->get();
            $projects = PurchaseRequest::groupBy("project_id")->distinct()->with("project", "itemRequests")->whereIn('id', $data)
                ->get();
                $accept = 0;

            return view('dashboard-views.approval.pagination_data_order', compact('approvalTimelines', "items" , "accept" ,'pageType', 'projects', "departments"))->render();
        }
    }

    public function showChequeRequest($id)
    {
        $cheque = ApprovalTimeline::where('id', $id)->firstOrFail();

        $cheque = ChequeRequest::where('id', $cheque->record_id)->firstOrFail();
        $value=1;
        return view('dashboard-views.cheque.show' , compact("cheque","value"));
            // return "Show Cheque Request";

        // $order = ApprovalTimeline::where('id', $id)->firstOrFail();
        // $chequeRequest = ChequeRequest::where('id', $order->record_id)->firstOrFail();
        // $timelines = DB::table('approval_timelines')->where('table_name', $order->table_name)->where('record_id', $order->record_id)
        // ->where("approval_status", "A")
        // ->join('users', 'users.id', '=', 'approval_timelines.user_id')
        // ->join('approval_cycle_approval_steps', 'approval_cycle_approval_steps.id', '=', 'approval_timelines.approval_cycle_approval_step_id')
        // ->join('approval_steps', 'approval_steps.id', '=', 'approval_cycle_approval_steps.approval_step_id')
        // ->leftJoin('approval_timeline_comments', 'approval_timeline_comments.approval_timeline_id', '=', 'approval_timelines.id')
        // ->select('approval_steps.name_ar as AS_name_ar', 'approval_steps.name_en  as AS_name_en',  'users.name_ar as U_name_ar', 'users.name_en as U_name_en', 'approval_timelines.approval_status',
        // 'approval_timeline_comments.comment as comment','approval_timelines.created_at')
        // ->selectRaw("MAX(approval_timelines.created_at) AS created_at")
        // ->groupBy("approval_timelines.user_id")
        //     ->orderBy("approval_timelines.created_at")
        // ->get();

        // $chequeItemRequest = ChequeItemRequest::where('cheque_id', $chequeRequest->id)->get();

        // return view('dashboard-views.approval.show_order_request', compact('files',  "timelines" ,  "refuse" , 'projects', 'departments', 'requestNumbers', 'order', 'purchaseOrder', 'itemsorders', 'ApprovalTimeline', "id", "value"));
    }

    public function showAllApprovalChequeTimeline()
    {
        $approvalTimelines = ApprovalTimeline::with("cheque")->where("table_name", "cheque_requests")
        ->groupby("record_id")->distinct()->get();

        $accept = 0;
        return view('dashboard-views.timeline.all_time_cheque', compact('approvalTimelines', "accept"));
    }

    public function timelineChequeById(ApprovalTimeline $approvalTimeline)
    {
        $cycleName = $approvalTimeline->approvalCycleApprovalStep->approvalCycle;
        $timelines = $this->getApprovalCycleTimelines($approvalTimeline->table_name, $approvalTimeline->record_id);
        $codeOrId = $approvalTimeline->record_id;
        $ChequeRequest = ChequeRequest::where("id", $approvalTimeline->record_id)->first();
        $user = User::find($ChequeRequest->requester_id);
        $created_at = $approvalTimeline->created_at;
        $id = $approvalTimeline->record_id;

        return view('dashboard-views.approval.timelineCheque', compact('timelines', "id" , 'cycleName', 'codeOrId', 'user', 'created_at', "ChequeRequest"));
    }

    public function showAllAcceptableChequeTimeline()
    {
        $approvalTimelines = ApprovalTimeline::where("table_name", "cheque_requests")->groupby("record_id")->join('approval_cycle_approval_steps', 'approval_timelines.approval_cycle_approval_step_id', 'approval_cycle_approval_steps.id')
        ->select("approval_timelines.id", "approval_timelines.table_name", "approval_timelines.record_id", "approval_timelines.approval_cycle_approval_step_id", "approval_timelines.approval_status", "approval_timelines.user_id", "approval_timelines.created_at")
        ->where('approval_cycle_approval_steps.next_id', null)->where('approval_status', 'A')->get();

        $accept = 1;
        return view('dashboard-views.timeline.all_time_cheque', compact('approvalTimelines', "accept"));
    }

    public function cheque_fetch_all_data(Request $request)
    {
        $accept = 0;
        $length = request()->length ?? env('PAGINATION_LENGTH', 5);
        $searchContent = request()->search_content ?? '';
        $pageType = request()->page_type;
        $approvalTimelines = [];
        $data = [];
        $chequeRequest = [];
        if ($request->ajax()) {
            if ($pageType == 'index') {
                if ($length == -1) {
                    $length = ApprovalTimeline::where("table_name", "cheque_requests")->count();
                }
                if (strlen($searchContent)) {
                /* End Department search */
                  $chequeRequest = ChequeRequest::where('type_ord_okay', 'like', '%' . $searchContent . '%')->where("sent",1)->pluck('id');

                  $approvalTimelines = ApprovalTimeline::where("table_name", "cheque_requests")->where(function ($query) use ($searchContent, $chequeRequest) {
                    return $query->where('table_name', 'like', '%' . $searchContent . '%')
                        ->orWhereIn('record_id', $chequeRequest);
                    })->groupby("record_id")->distinct()->paginate($length);
                } else {
                    $approvalTimelines = ApprovalTimeline::where("table_name", "cheque_requests")->groupby("record_id")->distinct()->paginate($length);
                }
            }
        }
            return view('dashboard-views.approval.pagination_data_cheque', compact('approvalTimelines',  "accept", 'pageType'))->render();
    }

    public function cheque_fetch_data(Request $request)
    {
        $accept = 0;
        $length = request()->length ?? env('PAGINATION_LENGTH', 5);
        $searchContent = request()->search_content ?? '';
        $pageType = request()->page_type;
        $approvalTimelines = [];
        $data = [];
        $chequeRequest = [];
        if ($request->ajax()) {
            if ($pageType == 'index') {
                if ($length == -1) {
                    $length = ChequeRequest::where("table_name", "cheque_requests")->count();
                }
                if (strlen($searchContent)) {
                  $cheques = ChequeRequest::where('type_ord_okay', 'like', '%' . $searchContent . '%')->where("sent",0)->paginate($length);
                } else {
                    $cheques = ChequeRequest::where("sent",0)->paginate($length);
                }
            }
        }
            return view('dashboard-views.cheque.pagination_data', compact('cheques',  'pageType'))->render();
    }



}
