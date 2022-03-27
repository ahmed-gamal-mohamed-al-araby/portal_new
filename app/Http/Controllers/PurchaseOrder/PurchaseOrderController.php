<?php

namespace App\Http\Controllers\PurchaseOrder;

use App\Http\Controllers\Controller;
use App\Http\Requests\purchaseOrder\CreatePurchaseorderRequest;
use App\Models\ApprovalCycle;
use App\Models\ApprovalTimeline;
use App\Models\Department;
use App\Models\FamilyName;
use App\Models\FamilyNameSupplier;
use App\Models\FilePurchaseOrder;
use App\Models\ItemRequest;
use App\Models\ItemOrder;
use App\Models\Project;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequest;
use App\Models\Supplier;
use App\Traits\ApprovalCycleTrait;
use App\Traits\StoreFileTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB as FacadesDB;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use ApprovalCycleTrait;
    use StoreFileTrait;
    function __construct()
    {
        $this->middleware('permission:purchase-orders', ['only' => ['index']]);
        $this->middleware('permission:add-purchase-order', ['only' => ['create','store']]);
        $this->middleware('permission:edit-purchase-order', ['only' => ['edit','update']]);
        $this->middleware('permission:restore-purchase-order', ['only' => ['restore']]);
    }

    public function index()
    {

     $purchaseOrders = PurchaseOrder::with(["supplier", "itemOrders" => function($q) {
             $q->with("itemRequest",function($p) {
                return  $p->with("purchaseRequest")->get();
            })->get();
       }])->where('sent', 0)->where("requester_id", auth()->id())->paginate(env('PAGINATION_LENGTH', 5));
        $data  = [];
        $departments = [];
        $projects = [];

        foreach ($purchaseOrders as $index => $purchaseOrder) {
            foreach ($purchaseOrder->itemOrders as $itemOrder) {
                $data[] = $itemOrder->ItemRequest()->pluck('purchase_request_id')->first();
            }
        }

        $departments = PurchaseRequest::groupBy("department_id")->distinct()->with("department", "itemRequests")->whereIn('id', $data)
            ->get();
        $projects = PurchaseRequest::groupBy("project_id")->distinct()->with("project", "itemRequests")->whereIn('id', $data)
            ->get();

        return view('dashboard-views.purchaseOrder.index', compact("purchaseOrders", "departments", "projects"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $items = [];
        $purchaseRequests=[];
        $purchaseRequest=[];
        $suppliers = Supplier::all();

        $purchaseId = PurchaseRequest::where("sent", 1)->pluck("id");
        $approvalTimelines = ApprovalTimeline::where("table_name", "purchase_requests")->groupby("record_id")->join('approval_cycle_approval_steps', 'approval_timelines.approval_cycle_approval_step_id', 'approval_cycle_approval_steps.id')
            ->select("approval_timelines.id", "approval_timelines.table_name", "approval_timelines.record_id", "approval_timelines.approval_cycle_approval_step_id", "approval_timelines.approval_status", "approval_timelines.user_id", "approval_timelines.created_at")
            ->where('approval_cycle_approval_steps.next_id', null)->where('approval_status', 'A')->pluck("record_id");
        if ($approvalTimelines->count() > 0) {
            $purchaseRequests = PurchaseRequest::with(["itemRequests" => function($q) {
                $q->where("used_quantity" , ">" , 0);
            }])->whereIn("id",$approvalTimelines)->get();
        }

        foreach($purchaseRequests as $pur) {
            if(count($pur->itemRequests) > 0) {
                $purchaseRequest[] = $pur;
            }
        }
        // return $purchaseRequest;

        // foreach ($items as $item) {
        //     $idFamily[] = $item->familyName->id;
        // }
        // $families = FamilyName::with("items")->whereIn("id",$idFamily)->groupby("id")->distinct()->get();
        return view('dashboard-views.purchaseOrder.create', compact("suppliers", "purchaseRequest"));
    }

    public function getItemData(Request $request)
    {
        $item_id = $request->itemID;
        return $item = ItemRequest::with("unit")->where("id", $item_id)->first();
    }

    public function getDataItems(Request $request)
    {
        $data = [];
        if($request->value == 1) {
            $data['items'] = ItemRequest::with(["ItemOrder" => function($q) use($request) {
                return $q->where("purchase_order_id",$request->purchase_order_id);
            }])->with("unit")->whereIn("purchase_request_id",$request->purchase_request_id)->get();
        } else {
              $data['items'] = ItemRequest::with(["ItemOrder" => function($q) use($request) {
                return $q->where("purchase_order_id",$request->purchase_order_id);
            }])->with("unit")->where("used_quantity",">" , 0)->whereIn("purchase_request_id",$request->purchase_request_id)->get();
        }
        $data['sectors'] = PurchaseRequest::whereIn("id",$request->purchase_request_id)->with("sector")->get();
        $data['projects']  = PurchaseRequest::whereIn("id",$request->purchase_request_id)->with("project")->get();
        return $data;
        // return $item = ItemRequest::with("unit")->where("id", $item_id)->first();
         // return $data['items'] = ItemRequest::with(["ItemOrder" => function($q) use($request) {
        //     return   $q->with(["po" => function($p)  {
        //           $p->where("sent",1);
        //         }]);
        //     }])->with("unit")->whereIn("purchase_request_id",$request->purchase_request_id)->get();

    }

    public  function getDataSupplier(Request $request)
    {
        return $supplier = Supplier::where("id",$request->supplier_id)->first("system");
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $validated = $request->validated();
        // return $request;
        // return $request->all();
        $newRow = PurchaseOrder::withTrashed()->count();
        $ordernumber =  date('Y') . '-' . str_pad(++$newRow, 4, '0', STR_PAD_LEFT);
        DB::beginTransaction();

        if (isset($request->accept)) {
            $purchaseOrder = PurchaseOrder::create([
                "order_number" =>  $ordernumber,
                "place_delivery" => $request->delivery_place,
                "payment_terms" => $request->payment_terms,
                "general_terms" => $request->general_terms,
                "suppling_duration" => $request->suppling_duration,
                "total_gross" => $request->total_gross,
                "taxes" => $request->taxes,
                "with_holding" => $request->withholding,
                "net_total" => $request->net_total,
                "supplier_id" => $request->supplier_id,
                "discount" => $request->discount,
                "total_after_discount" => $request->total_after_discount,
                "currency" => $request->currency,
                "type_discount" => $request->type_discount,
                "approved" => 0,
                "sent" => 0,
                "requester_id" => auth()->id()
            ]);
            foreach ($request->accept as $val) {
                $item = ItemRequest::where("id", $request->item_request_id[$val])->first();
                $qty = $item->used_quantity;

                $item->update([
                    'used_quantity' => $qty - $request->qty[$val],
                ]);

                ItemOrder::create([
                    "purchase_order_id" =>  $purchaseOrder->id,
                    "quantity" => $request->qty[$val],
                    "used_quantity" => $request->qty[$val],
                    "total" => $request->total[$val],
                    "price" => $request->price[$val],
                    "item_request_id" => $request->item_request_id[$val],
                    "unit_id" => $request->unit_id[$val],
                    "unit_new" => $request->unit[$val],
                    // "comment_change_reason" => $request->comment[$val],
                    "specification" => $request->specification[$val],

                ]);

            }
            $file_refused = null;
            if ($request->has('file_refused')) {
                foreach ($request->file_refused as $file) {
                    $file_refused = $this->storeFile($file, 'uploaded-files/po');
                    FilePurchaseOrder::create([
                        "file_name" => $file->getClientOriginalName(),
                        "purchase_order_id" =>  $purchaseOrder->id,
                        "file_refused" => $file_refused
                    ]);
                }
            }

            Toastr()->success(
                trans('site.added_successfully'),
                trans("site.Success"),
                [
                    "closeButton" => true,
                    "progressBar" => true,
                    "positionClass" => app()->getLocale() == 'en' ? "toast-top-right" : "toast-top-left",
                    "timeOut" => "10000",
                    "extendedTimeOut" => "10000",
                ]
            );
        }
        // End toastr notification
        DB::commit();
        return redirect()->route('purchase-order.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $items = [];
        $suppliers = Supplier::all();
        $purchaseId = PurchaseRequest::where("sent", 1)->pluck("id");
        $approvalTimelines = ApprovalTimeline::where("table_name", "purchase_requests")->groupby("record_id")->join('approval_cycle_approval_steps', 'approval_timelines.approval_cycle_approval_step_id', 'approval_cycle_approval_steps.id')
        ->select("approval_timelines.id", "approval_timelines.table_name", "approval_timelines.record_id", "approval_timelines.approval_cycle_approval_step_id", "approval_timelines.approval_status", "approval_timelines.user_id", "approval_timelines.created_at")
        ->where('approval_cycle_approval_steps.next_id', null)->where('approval_status', 'A')->pluck("record_id");
        if ($approvalTimelines->count() > 0) {
            $purchaseRequests = PurchaseRequest::whereIn("id",$approvalTimelines)->get();
        }

        $purchaseOrder = PurchaseOrder::with("supplier", "FileITem")->where("id", $id)->first();
        $items_self = ItemOrder::with("unit","ItemRequest")->where("purchase_order_id", $id)->get();
        $itemRequestID = ItemOrder::where("purchase_order_id", $id)->pluck("item_request_id");
        $purchaseReqId = ItemRequest::whereIn("id",$itemRequestID)->pluck("purchase_request_id")->toArray();
        $purchaseReqId = array_unique($purchaseReqId);

        $purchaseReques = PurchaseRequest::with("project","sector")->whereIn("id",$purchaseReqId)->get();
        return view('dashboard-views.purchaseOrder.edit', compact("suppliers", "purchaseReques" ,"purchaseReqId" , "id" ,"purchaseRequests", "items_self", "purchaseOrder"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //  return $request->all();
        DB::beginTransaction();
        if($request->has("not_checked")) {
            // $arrDif =  array_diff($request->not_checked, $request->accept);
            foreach ($request->not_checked as $item) {
            if(isset($request->item_request_id_two[$item])) {
                $itemOr = ItemOrder::where("item_request_id",$request->item_request_id_two[$item])->where("purchase_order_id",$id)->first();
                $itemRe = ItemRequest::where("id", $request->item_request_id_two[$item])->first();
                ItemRequest::where("id", $request->item_request_id_two[$item])->update([
                    'used_quantity' => $itemOr->quantity,
                ]);
                ItemOrder::where("item_request_id",$request->item_request_id_two[$item])->where("purchase_order_id",$id)->forceDelete();
            }
        }
    } else if($request->has("not_checked_new")) {
            $arrDif =  array_diff($request->not_checked_new, $request->accept);
            foreach ($arrDif as $item) {
            if(isset($request->item_request_id[$item])) {
                $itemOr = ItemOrder::where("item_request_id",$request->item_request_id[$item])->where("purchase_order_id",$id)->first();
                $itemRe = ItemRequest::where("id", $request->item_request_id[$item])->first();
                if($itemRe->used_quantity > 0) {
                    ItemRequest::where("id", $request->item_request_id[$item])->update([
                        'used_quantity' => $itemRe->used_quantity - $itemOr->quantity,
                    ]);
                } else {
                    ItemRequest::where("id", $request->item_request_id[$item])->update([
                        'used_quantity' => $itemRe->used_quantity + $itemOr->quantity,
                    ]);
                }

                ItemOrder::where("item_request_id",$request->item_request_id[$item])->where("purchase_order_id",$id)->forceDelete();
            }
        }
        } else {
            return redirect()->route('purchase-order.edit', $id);

        }
        // return $request->item_id_edit;


         $newRow = PurchaseOrder::withTrashed()->count();
         $ordernumber =  date('Y') . '-' . str_pad(++$newRow, 4, '0', STR_PAD_LEFT);

        if (isset($request->accept)) {
            PurchaseOrder::find($id)->forceDelete();
            $purchaseOrder = PurchaseOrder::create([
                "order_number" =>  $ordernumber,
                "place_delivery" => $request->delivery_place,
                "payment_terms" => $request->payment_terms,
                "general_terms" => $request->general_terms,
                "suppling_duration" => $request->suppling_duration,
                "total_gross" => $request->total_gross,
                "taxes" => $request->taxes,
                "with_holding" => $request->withholding,
                "net_total" => $request->net_total,
                "supplier_id" => $request->supplier_id,
                "discount" => $request->discount,
                "total_after_discount" => $request->total_after_discount,
                "currency" => $request->currency,
                "type_discount" => $request->type_discount,
                "approved" => 0,
                "sent" => 0,
                "requester_id" => auth()->id()
            ]);

            foreach ($request->accept as $val) {
                if(isset($request->item_request_id_two[$val])) {
                    $item = ItemRequest::where("id", $request->item_request_id_two[$val])->first();
                } else {
                    $item = ItemRequest::where("id", $request->item_request_id[$val])->first();
                }
                $qty = $item->actual_quantity;

                    $item->update([
                        'used_quantity' => $qty - $request->qty[$val],
                    ]);

                    if(isset($request->unit_id_new)) {
                        ItemOrder::create([
                            "purchase_order_id" =>  $purchaseOrder->id,
                            "quantity" => $request->qty[$val],
                            "used_quantity" => $request->qty[$val],

                            "total" => $request->total[$val],
                            "price" => $request->price[$val],
                            "item_request_id" => $item->id,
                            "unit_id" => $request->unit_id_new[$val],
                            "unit_new" => $request->unit[$val],
                            // "comment_change_reason" => $request->comment[$val],
                            "specification" => $request->specification[$val],
                        ]);
                    } else {
                        ItemOrder::create([
                            "purchase_order_id" =>  $purchaseOrder->id,
                            "quantity" => $request->qty[$val],
                            "used_quantity" => $request->qty[$val],

                            "total" => $request->total[$val],
                            "price" => $request->price[$val],
                            "item_request_id" => $item->id,
                            "unit_id" => $request->unit_id[$val],
                            "unit_new" => $request->unit[$val],
                            // "comment_change_reason" => $request->comment[$val],
                            "specification" => $request->specification[$val],
                        ]);
                    }



                $file_refused = null;
                $fileItems = FilePurchaseOrder::where("purchase_order_id", $id)->get();
                if ($request->has('file_refused')) {
                    foreach ($fileItems as $fileItem) {
                        $fileItem->delete();
                    }

                    foreach ($request->file_refused as $file) {
                        $file_refused = $this->uploadImage('po' ,$file);
                        FilePurchaseOrder::create([
                            "file_name" => $file->getClientOriginalName(),
                            "purchase_order_id" =>  $purchaseOrder->id,
                            "file_refused" => $file_refused
                        ]);
                    }
                } else {
                    foreach ($fileItems as $fileItem) {
                        FilePurchaseOrder::where("purchase_order_id", $id)->update([
                            "purchase_order_id" =>  $purchaseOrder->id,
                        ]);
                    }
                }
            }

            PurchaseOrder::where("id", $id)->delete();
        }
        DB::commit();
        Toastr()->success(
            trans('site.updated_successfully'),
            trans("site.Success"),
            [
                "closeButton" => true,
                "progressBar" => true,
                "positionClass" => app()->getLocale() == 'en' ? "toast-top-right" : "toast-top-left",
                "timeOut" => "10000",
                "extendedTimeOut" => "10000",
            ]
        );
        // End toastr notification

        return redirect()->route('purchase-order.index');
    }

    public function trash(Request $request)
    {

        $purchaseOrder = PurchaseOrder::with("itemOrders", "supplier")->findOrFail($request->purchase_order_id);
        $errorMessage = '';
        $status = null;
        DB::beginTransaction();
        try {
            $purchaseOrder->delete();
            foreach ($purchaseOrder->itemOrders as $item_order) {
                $item_request = ItemRequest::where('id', $item_order->item_request_id)->first();
                ItemRequest::where('id', $item_order->item_request_id)->update([
                    "used_quantity" => $item_request->used_quantity + $item_order->quantity,
                ]);
                $item_order->delete();
            }
            $status = true;
            DB::commit();
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[0] == 23000) {

                $errorMessage = $e->getMessage();
            } else {
                $errorMessage = 'DB error';
            }
        } finally {
            DB::rollBack();
        }

        return json_encode([
            'status' => $status,
            'errorMessage' => $errorMessage,
        ]);
    }

    public function trash_index()
    {
        $purchaseOrders = PurchaseOrder::with(["supplier", "itemOrders"])->where('sent', 0)->where("requester_id", auth()->id())->onlyTrashed()->paginate(env('PAGINATION_LENGTH', 5));
        $data  = [];
        $departments = [];
        $projects = [];
        foreach ($purchaseOrders as $index => $purchaseOrder) {
            foreach ($purchaseOrder->itemOrders as $itemOrder) {
                $data[] = $itemOrder->ItemRequest()->pluck('purchase_request_id')->first();
            }
        }
        $departments = PurchaseRequest::groupBy("department_id")->distinct()->with("department", "itemRequests")->whereIn('id', $data)
            ->get();
        $projects = PurchaseRequest::groupBy("project_id")->distinct()->with("project", "itemRequests")->whereIn('id', $data)
            ->get();
        return view('dashboard-views.purchaseOrder.trash', compact('purchaseOrders', "projects", "departments"));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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

        $length = request()->length ?? env('PAGINATION_LENGTH', 5);
        $searchContent = request()->search_content ?? '';
        $pageType = request()->page_type;
        $purchaseRequests = [];

        if ($request->ajax()) {
            if ($pageType == 'index') {
                if ($length == -1) {
                    $length = PurchaseOrder::count();
                }
                if (strlen($searchContent)) {
                    // Search By Supplier
                    $supplierId = Supplier::where(function ($query) use ($searchContent) {
                        return $query->where('name_ar', 'like', '%' . $searchContent . '%')
                            ->orWhere('name_en', 'like', '%' . $searchContent . '%');
                    })->pluck("id");

                    // Search By Project
                    $projectID = Project::where(function ($query) use ($searchContent) {
                        return $query->where('name_ar', 'like', '%' . $searchContent . '%')
                            ->orWhere('name_en', 'like', '%' . $searchContent . '%');
                    })->pluck("id");
                    // Search By Department
                    $deptID = Department::where(function ($query) use ($searchContent) {
                        return $query->where('name_ar', 'like', '%' . $searchContent . '%')
                            ->orWhere('name_en', 'like', '%' . $searchContent . '%');
                    })->pluck("id");

                    // continue search bu department and project
                    $purchaseId = PurchaseRequest::whereIn('project_id', $projectID)->orWhereIn('department_id', $deptID)->pluck("id");
                    $itemReq = ItemRequest::whereIn("purchase_request_id", $purchaseId)->pluck("id");
                    $purOrderID = ItemOrder::whereIn("item_request_id", $itemReq)->pluck("purchase_order_id");
                    // End

                    $purchaseOrders = PurchaseOrder::with("supplier", "itemOrders")->where(function ($query) use ($searchContent, $purOrderID, $supplierId) {
                        return $query->Where('order_number', 'like', '%' . $searchContent . '%')
                            ->orWhereIn('supplier_id', $supplierId)
                            ->orWhereIn('id', $purOrderID);
                    })->where('sent', 0)->where("requester_id", auth()->id())->paginate($length);
                } else {
                    $purchaseOrders = PurchaseOrder::where('sent', 0)->where("requester_id", auth()->id())->paginate($length);
                }
            } else if ($pageType == 'trashed') {
                if ($length == -1) {
                    $length = PurchaseOrder::where('sent', 0)->where("requester_id", auth()->id())->onlyTrashed()->count();
                }
                if (strlen($searchContent)) {
                    $supplierId = Supplier::where(function ($query) use ($searchContent) {
                        return $query->where('name_ar', 'like', '%' . $searchContent . '%')
                            ->orWhere('name_en', 'like', '%' . $searchContent . '%');
                    })->pluck("id");

                    $purchaseOrders = PurchaseOrder::where(function ($query) use ($searchContent, $supplierId) {
                        return $query->where('order_number', 'like', '%' . $searchContent . '%')
                            ->where("requester_id", auth()->id())
                            ->where('sent', 0)
                            ->orWhereIn('supplier_id', $supplierId);
                    })->onlyTrashed()->paginate($length);
                } else {
                    $purchaseOrders = PurchaseOrder::where('sent', 0)->where("requester_id", auth()->id())->onlyTrashed()->paginate($length);
                }
            }

            $data  = [];
            $departments = [];
            $projects = [];

            foreach ($purchaseOrders as $index => $purchaseOrder) {
                foreach ($purchaseOrder->itemOrders as $itemOrder) {
                    $data[] = $itemOrder->ItemRequest()->pluck('purchase_request_id')->first();
                }
            }
            $departments = PurchaseRequest::groupBy("department_id")->distinct()->with("department", "itemRequests")->whereIn('id', $data)
                ->get();
            $projects = PurchaseRequest::groupBy("project_id")->distinct()->with("project", "itemRequests")->whereIn('id', $data)
                ->get();

            return view('dashboard-views.purchaseOrder.pagination_data', compact('purchaseOrders', "projects", 'pageType', "departments"))->render();
        }
    }

    public function restore(Request $request)
    {
        $purchaseOrder = PurchaseOrder::withTrashed()->where('id', $request->purchase_order_id)->first();
        $itemsOrders =  ItemOrder::where('purchase_order_id', $request->purchase_order_id)->withTrashed()->get();
        $status = null;
        DB::beginTransaction();


        // Notification part (In the future)

        foreach ($itemsOrders as $itemDel) {
            $itemActual = ItemRequest::where("id", $itemDel->item_request_id)->first();
            if ($itemDel->quantity < $itemActual->quantity) {
                ItemRequest::where("id", $itemDel->item_request_id)->update([
                    "used_quantity" => $itemActual->used_quantity - $itemDel->quantity
                ]);
                $purchaseOrder->restore();
                $itemDel->restore();
            }
        }

        if ($purchaseOrder->trashed()) {
            $status = false;
        } else {
            $status = true;
        }

        DB::commit();

        return json_encode([
            'status' => $status,
            'errorMessage' => trans("site.All_Items_Alerady_Used"),
        ]);
    }

    public function sendForApproveSavedPR(Request $request)
    {
        $purchaseOrder = PurchaseOrder::findorFail($request->purchase_order_id);
        $purchaseOrder->update([
            'sent' => '1'
        ]);

        $creatorUser = $purchaseOrder->requester;

        $approvalCycleApprovalStep = ApprovalCycle::where('code', "PO")->first()->approvalCycleApprovalStep()->where('previous_id', NULL)->first();

        $stepValue =  json_decode($approvalCycleApprovalStep->approvalStep->value);

        $approvalUser = '';
        if (count($stepValue->depth)) {
            $approvalUser = $creatorUser;
            foreach ($stepValue->depth as $step) {
                if ($approvalUser->{$step}) {
                    $approvalUser = $approvalUser->{$step};
                }
            }
        } else {
            $approvalUser = $this->getComplexNextUserForApprovals($stepValue->query->T, $stepValue->query->CONs,  $stepValue->query->depth);
        }

        // Set first approval cycle timeline
        ApprovalTimeline::create([
            'table_name' => 'purchase_orders',
            'record_id' => $purchaseOrder->id,
            'approval_cycle_approval_step_id' => $approvalCycleApprovalStep->id,
            'user_id' => $approvalUser->id,
        ]);

        return json_encode([
            'status' => true,
            'code' => 'PR_sent',
        ]);
    }
}
