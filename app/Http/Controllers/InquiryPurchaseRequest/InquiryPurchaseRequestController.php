<?php

namespace App\Http\Controllers\InquiryPurchaseRequest;

use App\Http\Controllers\Controller;
use App\Models\InquiryPurchaseRequest;
use App\Models\ItemRequest;
use App\Models\PurchaseRequest;
use Illuminate\Http\Request;
use App\Traits\StoreFileTrait;

class InquiryPurchaseRequestController extends Controller
{
    use StoreFileTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inquiries = InquiryPurchaseRequest::select('purchase_request_id')->distinct()->paginate(env('PAGINATION_LENGTH', 5));


        return view('dashboard-views.inquiry.index', compact('inquiries'));
    }

    public function inquire_fetch_data(Request $request)
    {
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
                    $length = InquiryPurchaseRequest::count();
                }
                if (strlen($searchContent)) {
                    /* Project search */
                    $purchaseRequestID = PurchaseRequest::where(function ($query) use ($searchContent) {
                        return $query->where('request_number', 'like', '%' . $searchContent . '%');
                    })->pluck("id");

                    $inquiries = InquiryPurchaseRequest::where(function ($query) use ($purchaseRequestID) {
                        return $query->whereIn('purchase_request_id', $purchaseRequestID);
                    })->paginate($length);
                } else {
                    $inquiries = InquiryPurchaseRequest::paginate($length);
                }
            }
            return view('dashboard-views.inquiry.pagination_data', compact('inquiries', "pageType"))->render();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return 123456;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InquiryPurchaseRequest  $inquiryPurchaseRequest
     * @return \Illuminate\Http\Response
     */
    public function show($purchase_request_id)
    {

        // $inquiry = InquiryPurchaseRequest::where('id', $id)->first();

        $inquirys = InquiryPurchaseRequest::where('purchase_request_id', $purchase_request_id)->get();
        $value = 0;
        //   $inquirys= InquiryPurchaseRequest::where('purchase_request_id', $inquiry->purchase_request_id)->get();
        return view('dashboard-views.inquiry.show', compact('inquirys', "value"));
    }

    public function storeResponse(Request $request, $id)
    {

        foreach ($request->inquirys as $key => $value) {
            $value = (object)($value);
            // return $value->id;
            $inquiry = InquiryPurchaseRequest::findOrFail($value->id);
            // return $inquiry;
            $aprove_first_date = $inquiry->aprove_first_date;
            if ($inquiry->receive_id == auth()->user()->id) {
                $aprove_first_date = date("Y-m-d H:i:s");
            }
            $aprove_last_date = $inquiry->aprove_last_date;

            if ($inquiry->technical_office == auth()->user()->id) {
                $aprove_last_date = date("Y-m-d H:i:s");
            }
            $old_receive_message = $inquiry->receive_message;
            $old_alternate = $inquiry->alternate;
            $firstApprove = $inquiry->approve;
            $secondApprove = $inquiry->approve_technical_office;
            if (isset($value->first_approval) && $value->first_approval) {
                $firstApprove = $value->first_approval;
            }
            if (isset($value->second_approval) && $value->second_approval) {
                $secondApprove = $value->second_approval;
            }


            $inquiry->update([
                'receive_message' => (isset($value->receive_message) && $value->receive_message)  ? $value->receive_message : $old_receive_message,
                'alternate' =>  (isset($value->alternative_message) && $value->alternative_message) ? $value->alternative_message : $old_alternate,
                'approve' => $firstApprove,
                'approve_technical_office' => $secondApprove,
                'aprove_first_date' => $aprove_first_date,
                'aprove_last_date' => $aprove_last_date,

            ]);
        }

        return redirect()->back();
        // Notification part (In the future)

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InquiryPurchaseRequest  $inquiryPurchaseRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(InquiryPurchaseRequest $inquiryPurchaseRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InquiryPurchaseRequest  $inquiryPurchaseRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InquiryPurchaseRequest $inquiryPurchaseRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InquiryPurchaseRequest  $inquiryPurchaseRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(InquiryPurchaseRequest $inquiryPurchaseRequest)
    {
        //
    }
}
