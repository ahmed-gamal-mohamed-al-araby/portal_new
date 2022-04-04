<?php

namespace App\Http\Controllers\PurchaseRequest;

use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseRequest\CreatePurchaseRequestRequest;
use App\Http\Requests\PurchaseRequest\UpdatePurchaseRequestRequest;
use App\Models\ApprovalCycle;
use App\Models\ApprovalTimeline;
use App\Traits\ApprovalCycleTrait;
use App\Traits\ToastrTrait;
use App\Models\FamilyName;
use App\Models\FilePurchaseRequest;
use App\Models\Group;
use App\Models\ItemRequest;
use App\Models\Project;
use App\Models\PurchaseRequest;
use App\Models\Site;
use App\Models\SubGroup;
use App\Models\Unit;
use App\Models\UserGroup;
use App\Traits\StoreFileTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PurchaseRequestsController extends Controller
{
    use ApprovalCycleTrait;
    use ToastrTrait;
    use StoreFileTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('permission:purchase-requests', ['only' => ['index']]);
        $this->middleware('permission:add-purchase-request', ['only' => ['create','store']]);
        $this->middleware('permission:edit-purchase-request', ['only' => ['edit','update']]);
        $this->middleware('permission:restore-purchase-request', ['only' => ['restore']]);
    }


    public function index()
    {
        $purchaseRequests = PurchaseRequest::where('sent',0)->where("requester_id",\Auth::user()->id)->paginate(env('PAGINATION_LENGTH', 5));

        return view('dashboard-views.purchaseRequest.index', compact('purchaseRequests'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash_index()
    {
        $purchaseRequests = PurchaseRequest::onlyTrashed()->paginate(env('PAGINATION_LENGTH', 5));

        return view('dashboard-views.purchaseRequest.trash', compact('purchaseRequests'));
    }

    /**
     * Return a view of the resource.
     *
     * @return \Illuminate\Support\Facades\View
     */
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
                    $length = PurchaseRequest::count();
                }
                if (strlen($searchContent)) {
                    $purchaseRequests = PurchaseRequest::where('sent',0)->where('request_number', 'like', '%' . $searchContent . '%')->where("requester_id",\Auth::user()->id)->paginate($length);
                } else {
                    $purchaseRequests = PurchaseRequest::where('sent',0)->where("requester_id",\Auth::user()->id)->paginate($length);
                }
            } else if ($pageType == 'trashed') {
                if ($length == -1) {
                    $length = PurchaseRequest::where('sent',0)->where("requester_id",\Auth::user()->id)->onlyTrashed()->count();
                }
                if (strlen($searchContent)) {
                    $purchaseRequests = PurchaseRequest::onlyTrashed()
                        ->where(function ($query) use ($searchContent) {
                            return $query->where('request_number', 'like', '%' . $searchContent . '%')
                            ->where("requester_id",\Auth::user()->id)
                            ->where('sent',0);
                        })->paginate($length);
                } else {
                    $purchaseRequests = PurchaseRequest::where('sent',0)->where("requester_id",\Auth::user()->id)->onlyTrashed()->paginate($length);
                }
            }

            return view('dashboard-views.purchaseRequest.pagination_data', compact('purchaseRequests', 'pageType'))->render();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (count(session()->getOldInput())) {
            // dd(session()->getOldInput()['group_id']);
            $subGroupWithSupplierFamilyNames_id = [];
            $familyNames = FamilyName::whereIn('id', session()->getOldInput()['family_names_id'] ?? [])->get();
            $subGroups = session()->getOldInput()['group_id'] ? (Group::where('id', session()->getOldInput()['group_id'])->first()->subGroups) : [];
            $subGroupIds = [];
            $familyNames = [];
            foreach (session()->getOldInput()['family_names_id'] ?? [] as $key => $familyNameId) {
                if (!$familyNameId) {
                    array_push($subGroupIds, null);
                    array_push($familyNames, []);
                } else {
                    array_push($subGroupIds, FamilyName::where('id', $familyNameId)->first()->subGroup->id);
                    array_push($familyNames, SubGroup::where('id', $subGroupIds[$key])->first()->familyNames);
                }
            }

            session()->put('_old_input.subGroupIds', $subGroupIds);
            session()->put('_old_input.familyNames', $familyNames);
            session()->put('_old_input.subGroups', $subGroups);
        }

        $userData = collect([]);
        $user = auth()->user();
        $userData->put('name_ar', $user->name_ar);
        $userData->put('name_en', $user->name_en);

        $userData->put('project', $user->project()->with('sites')->first() ?? false);

        $userData->put('department',  $user->department ?? false);

        $userData->put('sector', $user->sector);

        // $projects = [];
        // if (!$userData['project'] && !$userData['department']) {
        //     if($userData['sector']) {
        //         $projects = $userData['sector']->projects;
        //     }
        // }
        // dd($userData['project']['sites']);
        // $groups = Group::where('both', '0')->get();
        $units = Unit::all();
        $groupid = UserGroup::where('user_id',auth()->user()->id )->pluck("group_id");
        $groups = Group::whereIn("id",$groupid)->get();
        $projects = Project::where("sector_id",auth()->user()->sector->id)->get();
        return view('dashboard-views.purchaseRequest.create', compact('userData', 'groups', 'units', 'projects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dump($request->all());
        // dd($request->all());

      //  return $request->all();
        $user = auth()->user();
        $newRow = PurchaseRequest::withTrashed()->count();
        if( $request->group_id == 7) {
            $requestnumber =  date('Y') . '-F' . str_pad(++$newRow, 4, '0', STR_PAD_LEFT);
        } else {
            $requestnumber =  date('Y') . '-' . str_pad(++$newRow, 4, '0', STR_PAD_LEFT);
        }


        $newStoredPurchaseRequest = null;
        // Start store files
        DB::beginTransaction();

        if ($request->save) { // save only and not send
            $newStoredPurchaseRequest = PurchaseRequest::withoutEvents(function () use ($requestnumber, $request, $user) {
               // Save PR basic data
                $newPurchaseRequest = PurchaseRequest::create([
                    'request_number' => $requestnumber,
                    'client_name' => $request->client_name,
                    'manufacturing_order_number' => $request->manufacturing_order_number,
                    'requester_id' => $user->id,
                    'department_id' => $request->department_id ?? null,
                    'project_id' => $request->project_id ?? null,
                    'site_id' => $request->site_id ?? null,
                    'sector_id' => $request->sector_id,
                    'group_id' => $request->group_id,

                ]);
                return $newPurchaseRequest;
            });
        } else {
            // Save and send to approve PR basic data
            $newStoredPurchaseRequest = PurchaseRequest::create([
                'request_number' => $requestnumber,
                'client_name' => $request->client_name,
                'manufacturing_order_number' => $request->manufacturing_order_number,


                'requester_id' => $user->id,
                'department_id' => $request->department_id ?? null,
                'project_id' => $request->project_id ?? null,
                'site_id' => $request->site_id ?? null,
                'sector_id' => $request->sector_id,
                'group_id' => $request->group_id,
            ]);
        }

        if ($request->has('file_purchase_request')) {
            foreach ($request->file_purchase_request as $fileReq) {
                $file_purchase = $this->uploadImage('pr' ,$fileReq);
                FilePurchaseRequest::create([
                    "file_name" => $fileReq->getClientOriginalName(),
                    "purchase_request_id" =>  $newStoredPurchaseRequest->id,
                    "file" => $file_purchase
                ]);
            }
        }


      $file = [];
        // // Save PR Items
        foreach ($request->items as $key => $item) {

            if ($request->has('file')) {
                if(isset($request->file[$key]))
                   $file = $this->storeFile($request->file[$key], 'uploaded-files/pr');
                else
                   $file = null;

            } else
                $file = null;


            $newStoredPurchaseRequest->itemRequests()->create([
                'family_name_id' => $request->family_names_id[$key],
                'specification' => $request->specifications[$key],
                'comment' => $request->comments[$key],
                'priority' => $request->priorities[$key],
                'quantity' => $request->quantities[$key],
                'stock_quantity' => $request->stock_quantities[$key],
                'actual_quantity' => $request->actual_quantities[$key],
                'used_quantity' => $request->actual_quantities[$key],
                'unit_id' => $request->units_id[$key],
                "comment_reason" => $request->comment_reason[$key],
                'reserved_quantity' => $request->reserved_quantity[$key],
                'max_date_delivery' => $request->max_date_delivery[$key],
                'start_date_supply' => $request->start_date_supply[$key],
                'factory_specification' => $request->factory_specification[$key],
                "file" => $file
            ]);

        }


        DB::commit();

        // Notification part (In the future)
        // Start toastr notification
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


        // End toastr notification

        return redirect()->route('purchase-request.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PurchaseRequest $purchaseRequest
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseRequest $purchaseRequest)
    {
        return json_decode(collect([
            'PurchaseRequest' => json_decode($purchaseRequest),
        ]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PurchaseRequest $purchaseRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseRequest $purchaseRequest)
    {
        if (count(session()->getOldInput())) {
            // dd(session()->getOldInput());
            $subGroupWithSupplierFamilyNames_id = [];
            $familyNames = FamilyName::whereIn('id', session()->getOldInput()['family_names_id'] ?? [])->get();
            $subGroups = session()->getOldInput()['group_id'] ? (Group::where('id', session()->getOldInput()['group_id'])->first()->subGroups) : [];
            $subGroupIds = [];
            $familyNames = [];
            foreach (session()->getOldInput()['family_names_id'] ?? [] as $key => $familyNameId) {
                if (!$familyNameId) {
                    array_push($subGroupIds, null);
                    array_push($familyNames, []);
                } else {
                    array_push($subGroupIds, FamilyName::where('id', $familyNameId)->first()->subGroup->id);
                    array_push($familyNames, SubGroup::where('id', $subGroupIds[$key])->first()->familyNames);
                }
            }

            session()->put('_old_input.subGroupIds', $subGroupIds);
            session()->put('_old_input.familyNames', $familyNames);
            session()->put('_old_input.subGroups', $subGroups);
        }

        $userData = collect([]);
        $user = auth()->user();
        $userData->put('name_ar', $user->name_ar);
        $userData->put('name_en', $user->name_en);

        $userData->put('project', $user->project()->with('sites')->first() ?? false);

        $userData->put('department',  $user->department ?? false);

        $userData->put('sector', $user->sector);

        // $projects = [];
        // if (!$userData['project'] && !$userData['department'] && $userData['sector']) {
        //     $projects = $userData['sector']->projects;
        // }

        // return PurchaseRequest::with(["ApprovalTimeline" => function($q) {
        //         return $q->with("comment");
        // }])->where("id",$purchaseRequest->id)->first();

        $units = Unit::all();
        $mytime = Carbon::now()->format('d-m-Y');

        $groupid = UserGroup::where('user_id', auth()->user()->id )->pluck("group_id");
        $groups = Group::whereIn("id",$groupid)->get();

        $subGroups = SubGroup::where('group_id', $purchaseRequest->group_id)->get();
        $familyNames = FamilyName::all();
        $projects = Project::where("sector_id",auth()->user()->sector->id)->get();
        $sites = Site::with("project")->get();
        return view('dashboard-views.purchaseRequest.edit', compact(
            'purchaseRequest',
            'groups',
            'userData',
            'mytime',
            'units',
            'user',
            'subGroups',
            'familyNames',
            'projects',
            "sites"
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchaseRequest $purchaseRequest
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, PurchaseRequest $purchaseRequest)
    {

            $purRequest = PurchaseRequest::find($purchaseRequest->id);
        // Start transaction
        // return $request->all();
        $file = "";
        DB::beginTransaction();
        try {
            // Save PR Main Component
            $purchaseRequest->update([
                'department_id' => $request->department_id ?? null,
                'project_id' => $request->project_id ?? null,
                'site_id' => $request->site_id ?? null,
                'sector_id' => $request->sector_id,
                'group_id' => $request->group_id,
                'manufacturing_order_number' => $request->manufacturing_order_number,
                'client_name' => $request->client_name,
            ]);

            // Start update item
            $retrivedItemsRequest = [];
            foreach ($request->items as  $key => $item) {
                array_push($retrivedItemsRequest, $request->ids[$key]);
            }
            $ItemsRequest = ItemRequest::where('purchase_request_id', $purchaseRequest->id)->pluck('id')->toArray();
            $deletedItemRequest = array_diff($ItemsRequest, $retrivedItemsRequest);
            ItemRequest::whereIn('id', $deletedItemRequest)->delete();
            unset($deletedItemRequest, $ItemsRequest, $retrivedItemsRequest);


            $fileItems = FilePurchaseRequest::where("purchase_request_id", $purchaseRequest->id)->get();
            if ($request->has('file_purchase_request')) {
                FilePurchaseRequest::where("purchase_request_id",$purchaseRequest->id)->delete();

                foreach ($request->file_purchase_request as $fileReq) {
                    $file_purchase = $this->uploadImage('pr' ,$fileReq);
                    FilePurchaseRequest::create([
                        "file_name" => $fileReq->getClientOriginalName(),
                        "purchase_request_id" =>  $purchaseRequest->id,
                        "file" => $file_purchase
                    ]);
                }
            } else {
                foreach ($fileItems as $fileItem) {
                    FilePurchaseRequest::where("purchase_request_id", $purchaseRequest->id)->update([
                        "purchase_request_id" =>  $purchaseRequest->id,
                    ]);
                }
            }

            foreach ($request->items as $key => $item) {
                if ($request->has('file')) {
                    if(isset($request->file[$key]))
                        $file = $this->storeFile($request->file[$key], 'uploaded-files/pr');
                    else
                       { $file_exist = ItemRequest::where('id', $request->ids[$key])->first('file');
                        if($file_exist)
                            $file = $file_exist->file;
                        else
                            $file = null;}
                }  else {
                    $file_exist = ItemRequest::where('id', $request->ids[$key])->first('file');
                    if($file_exist)
                        $file = $file_exist->file;
                    else
                        $file = null;
                 }

                    ItemRequest::create([
                        'purchase_request_id' => $purchaseRequest->id,
                        'family_name_id' => $request->family_names_id[$key],
                        'specification' => $request->specifications[$key],
                        'comment' => $request->comments[$key],
                        'priority' => $request->priorities[$key],
                        'quantity' => $request->quantities[$key],
                        'stock_quantity' => $request->stock_quantities[$key],
                        'actual_quantity' => $request->actual_quantities[$key],
                        'used_quantity' => $request->actual_quantities[$key],
                        'unit_id' => $request->units_id[$key],
                        "comment_reason" => $request->comment_reason[$key],
                        'reserved_quantity' => $request->reserved_quantity[$key],
                        'max_date_delivery' => $request->max_date_delivery[$key],
                        'start_date_supply' => $request->start_date_supply[$key],
                        'factory_specification' => $request->factory_specification[$key],
                        "file" => $file
                    ]);

                    ItemRequest::where("id",$request->ids[$key])->delete();


            }
            // End update items

            DB::commit();
            $this->getSuccessToastrMessage('added_successfully');
            // Notification part (In the future)
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
        }
        return redirect()->route('purchase-request.index');
    }


    /**
     * Trash the specified resource from storage.
     *
     * @param  \App\Models\Request $request
     * @return \Illuminate\Http\Response
     */
    public function trash(Request $request)
    {
        $purchaseRequest = PurchaseRequest::findOrFail($request->purchaseRequest_id);

        // Start Check if record can be deleted
        $availableToDelete = true;
        $errorMessage = '';
        $status = null;

        // Start transaction
        DB::beginTransaction();
        try {
            $purchaseRequest->forceDelete();
        } catch (\Illuminate\Database\QueryException $e) { // Handle integrity constraint violation
            $availableToDelete = false;
            if ($e->errorInfo[0] == 23000) {
                // $errorMessage = '';
                $errorMessage = $e->getMessage();
            } else {
                $errorMessage = 'DB error';
            }
        } finally {
            DB::rollBack();
        }

        // End check if record can be deleted
        $purchaseRequest = PurchaseRequest::findOrFail($request->purchaseRequest_id);
        if ($availableToDelete) {
            $status = true;
            $purchaseRequest->delete();
        } else {
            $status = false;
        }

        return json_encode([
            'status' => $status,
            'errorMessage' => $errorMessage,
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Models\Request $request
     * @return \Illuminate\Http\Response
     */

    public function restore(Request $request)
    {
        $purchaseRequest = PurchaseRequest::withTrashed()->where('id', $request->purchaseRequest_id)->firstOrFail();
        $status = null;

        if ($purchaseRequest->trashed()) {
            $purchaseRequest->restore();

            // Notification part (In the future)

            $status = true;
        } else {
            $status = false;
        }
        return json_encode([
            'status' => $status,
            'errorMessage' => 'already founded',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Request $request
     * @return \Illuminate\Http\Response
     */
    public function permanent_delete(Request $request)
    {
        // Start transaction
        DB::beginTransaction();
        try {

            $purchaseRequest = PurchaseRequest::onlyTrashed()->findOrFail($request->purchaseRequest_id);

            $deletedPurchaseRequest = clone $purchaseRequest; // used in notifications

            $purchaseRequest->forceDelete();

            $errorMessage = '';
            $status = null;

            // Notification part (In the future)

            $status = true;

            DB::commit();
        } catch (\Illuminate\Database\QueryException $e) { // Handle integrity constraint violation
            DB::rollBack();

            if ($e->errorInfo[0] == 23000) {
                // $errorMessage = '';
                $errorMessage = $e->getMessage();
            } else {
                $errorMessage = 'DB error';
            }

            $status = false;
        }
        return json_encode([
            'status' => $status,
            'errorMessage' => $errorMessage,
        ]);
    }

      // Send Purchase request that saved only and now will send for approvals cycles
      public function sendForApproveSavedPR(Request $request)
      {

          $purchaseRequest = PurchaseRequest::findorFail($request->purchaseRequest_id);
          $purchaseRequest->update([
              'sent' => '1'
          ]);

          $creatorUser = $purchaseRequest->requester;
          $purchaseRequestGroup = $purchaseRequest->group;

          $approvalCycleApprovalStep = ApprovalCycle::where('code', $purchaseRequestGroup->code)->first()->approvalCycleApprovalStep()->where('previous_id', NULL)->first();

          $stepValue =  json_decode($approvalCycleApprovalStep->approvalStep->value);

          $approvalUser = '';
          if (count($stepValue->depth)) {
              $approvalUser = $creatorUser;
              foreach ($stepValue->depth as $step) {
                  if($approvalUser->{$step}) {
                      $approvalUser = $approvalUser->{$step};
                  }
              }
          } else {
              $approvalUser = $this->getComplexNextUserForApprovals($stepValue->query->T, $stepValue->query->CONs,  $stepValue->query->depth);
          }

          // This cycle depend on group
          $purchaseRequest->group;
          // Set first approval cycle timeline

          if($purchaseRequest->group->code == "IT-01" ||  $purchaseRequest->group->code == "stationary") {

            ApprovalTimeline::create([
                'table_name' => 'purchase_requests',
                'record_id' => $purchaseRequest->id,
                'approval_cycle_approval_step_id' => $approvalCycleApprovalStep->id,
                'user_id' => $approvalUser->id,
            ]);

          } else {

            $approvalTimeline = ApprovalTimeline::create([
                'table_name' => 'purchase_requests',
                'record_id' => $purchaseRequest->id,
                'approval_cycle_approval_step_id' => $approvalCycleApprovalStep->id,
                'user_id' => $approvalUser->id,
            ]);

            /****/

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

          }





          // Notification for creator

          // Notification for nextApprovalUser

          DB::commit();

          /****/

          return json_encode([
              'status' => true,
              'code' => 'PR_sent',
          ]);


      }
}
