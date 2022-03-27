<?php

namespace App\Http\Controllers\Ore;

use App\Http\Controllers\Controller;
use App\Models\ApprovalTimeline;
use App\Models\ItemOrder;
use App\Models\ItemRequest;
use App\Models\MaterialReceipt;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;
use DB;

class OreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function OresGetItem(Request $request)
    {
        $itemPos = [];
        $data['items'] = PurchaseOrder::with(["itemOrders" => function($q) use($request) {
            return $q->whereIn("purchase_order_id",$request->purchase_order_id);
        }])->get();
        foreach($data['items'] as $item) {
            if(count($item->itemOrders) > 0) {
                foreach ($item->itemOrders as $itemonly) {
                    $itemPos[] = $itemonly->item_request_id;
                }
            }
        }
        return  $itemRequests = ItemRequest::whereIn("id",$itemPos)->with(["unit","ItemOrder"])->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $purchaseOrders=[];

        $purchaseId = PurchaseOrder::where("sent", 1)->pluck("id");
        $approvalTimelines = ApprovalTimeline::where("table_name", "purchase_orders")->groupby("record_id")->join('approval_cycle_approval_steps', 'approval_timelines.approval_cycle_approval_step_id', 'approval_cycle_approval_steps.id')
            ->select("approval_timelines.id", "approval_timelines.table_name", "approval_timelines.record_id", "approval_timelines.approval_cycle_approval_step_id", "approval_timelines.approval_status", "approval_timelines.user_id", "approval_timelines.created_at")
            ->where('approval_cycle_approval_steps.next_id', null)->where('approval_status', 'A')->pluck("record_id");
        if ($approvalTimelines->count() > 0) {
            $purchaseOrders = PurchaseOrder::whereIn("id",$approvalTimelines)->get();
        }

        return view("dashboard-views.ores.create", compact("purchaseOrders"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    //    return $request->all();

        foreach($request->quantity_received as $index => $quantity_received) {

            if($quantity_received != null) {
                $itemOrder =  ItemOrder::where("id",$request->item_order_id[$index])->first();
                if($itemOrder->used_quantity > $quantity_received) {
                    DB::beginTransaction();
                    $itemOrder->update([
                        "used_quantity" => $itemOrder->used_quantity - $quantity_received
                     ]);
                     MaterialReceipt::create([
                        "quantity_received" => $quantity_received,
                        "receipt_number" => $request->receipt_number[$index],
                        "recipient_name" => $request->recipient_name[$index],
                        "recipient_date" => $request->recipient_date[$index],
                        "location" => $request->location[$index],
                        "item_order_id" => $request->item_order_id[$index],
                    ]);
                    DB::commit();
                } else {
                    Toastr()->error(
                        trans('site.quantity_lose'),
                        trans("site.error"),
                        [
                            "closeButton" => true,
                            "progressBar" => true,
                            "positionClass" => app()->getLocale() == 'en' ? "toast-top-right" : "toast-top-left",
                            "timeOut" => "10000",
                            "extendedTimeOut" => "10000",
                        ]
                    );
                  return redirect()->route("ores.create");

                }
            }
        }

            return redirect()->route("ores.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      return  $purchaseOrder = PurchaseOrder::find($id);
        return view("dashboard-views.ores.edit", compact("purchaseOrder"));

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
        //
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
}
