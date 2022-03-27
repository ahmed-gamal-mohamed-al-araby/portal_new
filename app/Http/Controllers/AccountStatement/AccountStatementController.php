<?php

namespace App\Http\Controllers\AccountStatement;

use App\Models\AccountStatement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Supplier;

class AccountStatementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return view('dashboard-views.accountStatement.index', compact("suppliers"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Models\AccountStatement  $accountStatement
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // return $request->supplier_id;""
        if (!$request->from_date && !$request->to_date) {
            $sum=0;
            $total=0;
            $total_debit=0;
            $total_credit=0;
            $accountStatements=AccountStatement::where("supplier_id",$request->supplier_id)->get();

        }
        elseif ($request->from_date && !$request->to_date) {
            $test=AccountStatement::where("supplier_id",$request->supplier_id)->where("date_search","<=",$request->from_date)->get();
            $sum=0;
            $total=0;
            $total_debit=0;
            $total_credit=0;
     
             foreach ($test as $key => $value) {
                 $sum= $sum+ $value->debit-$value->credit ;
             }
             $accountStatements=AccountStatement::where("supplier_id",$request->supplier_id)->where("date_search",">=",$request->from_date)->get();
       
        } 
        elseif (!$request->from_date && $request->to_date) {
            $sum=0;
            $total=0;
            $total_debit=0;
            $total_credit=0;
     
            
             $accountStatements=AccountStatement::where("supplier_id",$request->supplier_id)->where("date_search","<=",$request->to_date)->get();
       
        } 
        else {
            $test=AccountStatement::where("supplier_id",$request->supplier_id)->where("date_search","<=",$request->from_date)->get();
            $sum=0;
            $total=0;
            $total_debit=0;
            $total_credit=0;
     
             foreach ($test as $key => $value) {
                 $sum= $sum+ $value->debit-$value->credit ;
             }
             $accountStatements=AccountStatement::where("supplier_id",$request->supplier_id)->where("date_search",">=",$request->from_date)->where("date_search","<=",$request->to_date)->get();
       
        }
            return view('dashboard-views.accountStatement.table_report_supplier', compact("total_debit","total_credit","accountStatements","sum","total"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AccountStatement  $accountStatement
     * @return \Illuminate\Http\Response
     */
    public function edit(AccountStatement $accountStatement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AccountStatement  $accountStatement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AccountStatement $accountStatement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AccountStatement  $accountStatement
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccountStatement $accountStatement)
    {
        //
    }
}
