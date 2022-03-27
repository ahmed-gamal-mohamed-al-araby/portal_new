<?php

namespace App\Http\Controllers\Cheque;

use App\Http\Controllers\Controller;
use App\Models\AccountStatement;
use App\Models\ApprovalCycle;
use App\Models\ApprovalTimeline;
use App\Models\ChequeItemRequest;
use App\Models\ChequeRequest;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequest;
use App\Models\Supplier;
use App\Traits\ApprovalCycleTrait;
use Illuminate\Http\Request;
use DB;
use NumberFormatter;
class ChequeController extends Controller
{
    use ApprovalCycleTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $cheques = ChequeRequest::where("requester_id", auth()->user()->id)->where("sent",0)->paginate(5);

        return view('dashboard-views.cheque.index' , compact("cheques"));
    }


    public function chequeRequestData(Request $request)
    {
         return $chequeRequest = ChequeRequest::with("supplier",'purchaseOrder')->find($request->cheque_request);
    }


    public  function getDataSupplier(Request $request)
    {
        return $supplier = Supplier::with("supplierCheque")->where("id",$request->supplier_id)->first();
    }

    public  function chequeValue(Request $request)
    {


    //    $f = new NumberFormatter("ar", NumberFormatter::SPELLOUT);
        // $fdecimal = new NumberFormatter("en", NumberFormatter::DECIMAL_ALWAYS_SHOWN);
        // $value =  $fdecimal->format($request->cheque_value);
         // strpos($value , "٫");
    //      $input = $f->format($request->cheque_value);
    //      return $value = strpos($input , "فاصل");
    //      return  $input = str_replace( $value , "" , $input);
    //     $fdecimal = new NumberFormatter("en", NumberFormatter::DECIMAL_ALWAYS_SHOWN);
    //     $value = strpos($fdecimal->format($request->cheque_value) , ".");
    //    return $output =  substr($fdecimal->format($request->cheque_value),$value+1) . " / 100 قرشا";

        $f = new NumberFormatter("ar", NumberFormatter::SPELLOUT);
        $fdecimal = new NumberFormatter("en", NumberFormatter::DECIMAL_ALWAYS_SHOWN);
        if(strpos($f->format($request->cheque_value) , "فاصل") != "") {
            $var = substr($f->format($request->cheque_value)  , 0 , strpos($f->format($request->cheque_value) , "فاصل"));
            $var .=  "و " . str_replace( "." , "" , strstr($fdecimal->format($request->cheque_value) , ".")). " / 100 قرشا";
        } else {
          $var =  $f->format($request->cheque_value);
        }
        return $var;
    }

    public function getBalance(Request $request)
    {
        $AccountStatement = AccountStatement::where("supplier_id",$request->supplier_id)->get();
        $sum=0;

         foreach ($AccountStatement as $key => $value) {
             $sum +=  $value->debit - $value->credit ;
         }
        return $sum;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $suppliers = Supplier::all();
        $purchaseOrders = [];
        // $purchaseOrdersID = PurchaseOrder::where("sent", 1)->pluck("id");
        $approvalTimelines = ApprovalTimeline::where("table_name", "purchase_orders")->groupby("record_id")->join('approval_cycle_approval_steps', 'approval_timelines.approval_cycle_approval_step_id', 'approval_cycle_approval_steps.id')
            ->select("approval_timelines.id", "approval_timelines.table_name", "approval_timelines.record_id", "approval_timelines.approval_cycle_approval_step_id", "approval_timelines.approval_status", "approval_timelines.user_id", "approval_timelines.created_at")
            ->where('approval_cycle_approval_steps.next_id', null)->where('approval_status', 'A')->pluck("record_id");
        if ($approvalTimelines->count() > 0) {
            $purchaseOrders = PurchaseOrder::whereIn("id",$approvalTimelines)->get();
        }
        return view('dashboard-views.cheque.create' , compact("suppliers" , "purchaseOrders"));
    }


    public function getOperationName(Request $request)
    {
         $purchaseOrder = PurchaseOrder::with(["supplier", "itemOrders"])->where("sent", 1)->where("id", $request->po_id)->first();

        foreach ($purchaseOrder->itemOrders as $itemOrder) {
             $data[] = $itemOrder->ItemRequest()->pluck('purchase_request_id')->first();
        }

        $project = PurchaseRequest::groupBy("project_id")->distinct()->with("project", "itemRequests")->whereIn('id', $data)
            ->get();

        $sector = PurchaseRequest::groupBy("sector_id")->distinct()->with("sector", "itemRequests")->whereIn('id', $data)
        ->get();

        $data['project'] = $project[0]->project;
        $data['sector'] = $sector[0]->sector;

        return $data;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newRow = ChequeRequest::withTrashed()->count();
        $cheque_number =  date('Y') . '-' . str_pad(++$newRow, 4, '0', STR_PAD_LEFT);
        DB::beginTransaction();
        $cheque = ChequeRequest::create([
            "cheque_number" => $cheque_number,
            "type_ord_okay" => $request->type_ord_okay,
            "date" => $request->date,
            "due_date" => $request->due_date,
            "supplier_id" => $request->supplier_id,
            "cheque_value" => $request->cheque_value,
            "value_letter" => $request->value_letter,
            "total_balance" => $request->total_balance,
            "total_debit" => $request->total_debit,
            "order_number" => $request->order_number,
            "operation_name" => $request->operation_name,
            "invoice_number" => $request->invoice_number,
            "balance" => $request->balance[0],
            "requester_id" => auth()->id()
        ]);

        foreach($request->debit as $key => $debit) {
            ChequeItemRequest::create([
                "cheque_id" => $cheque->id,
                "debit" => $request->debit[$key],
                "statement" => $request->statement[$key],
                "notes" => $request->notes[$key],
            ]);
        }


        DB::commit();

        return redirect()->route("cheques.index");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cheque = ChequeRequest::find($id);
        $value=0;

        $approvalTimeline = ApprovalTimeline::where("table_name" , "cheque_requests")->where("record_id",$id)->first();
        $cycleName = $approvalTimeline->approvalCycleApprovalStep->approvalCycle;
        $created_at = $approvalTimeline->created_at;

         $timelines = $this->getApprovalCycleTimelines($approvalTimeline->table_name, $approvalTimeline->record_id);
        return view('dashboard-views.cheque.show' , compact("cheque","value"  ,  "created_at" ,"cycleName" , "timelines"));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $suppliers = Supplier::all();

        $cheque = ChequeRequest::find($id);
        return view('dashboard-views.cheque.edit' , compact("cheque" , "suppliers"));

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
        DB::beginTransaction();
        $cheque = ChequeRequest::where("id",$id)->first();
        $cheque->update([
            "type_ord_okay" => $request->type_ord_okay,
            "date" => $request->date,
            "due_date" => $request->due_date,
            "supplier_id" => $request->supplier_id,
            "cheque_value" => $request->cheque_value,
            "value_letter" => $request->value_letter,
            "total_balance" => $request->total_balance,
            "total_debit" => $request->total_debit,
            "order_number" => $request->order_number,
            "operation_name" => $request->operation_name,
            "invoice_number" => $request->invoice_number,
            "balance" => $request->balance[0],
            "requester_id" => auth()->id()
        ]);
        ChequeItemRequest::where("cheque_id",$id)->forceDelete();

        foreach($request->debit as $key => $debit) {
            ChequeItemRequest::create([
                "cheque_id" => $cheque->id,
                "debit" => $debit,
                "statement" => $request->statement[$key],
                "notes" => $request->notes[$key],
            ]);
        }


        DB::commit();

        return redirect()->route("cheques.index");
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

     // Send Purchase request that saved only and now will send for approvals cycles
     public function sendForApproveSavedPR(Request $request)
     {
         $chequeRequest = ChequeRequest::findorFail($request->chequeRequest_id);
         $chequeRequest->update([
             'sent' => '1'
         ]);

         $creatorUser = $chequeRequest->requester;

         $approvalCycleApprovalStep = ApprovalCycle::where('code', "cheque_request")->first()->approvalCycleApprovalStep()->where('previous_id', NULL)->first();

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
         // Set first approval cycle timeline
         ApprovalTimeline::create([
             'table_name' => 'cheque_requests',
             'record_id' => $chequeRequest->id,
             'approval_cycle_approval_step_id' => $approvalCycleApprovalStep->id,
             'user_id' => $approvalUser->id,
         ]);

         return json_encode([
             'status' => true,
             'code' => 'PR_sent',
         ]);
     }

}
