<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApprovalTimeline extends Model
{
    use HasFactory, SoftDeletes;
    public $guarded = [];

    // Return users (table) record that take approvalTimeline action
    public function user()
    {
        return $this->belongsTo(User::class);
    }



    // Return approvalCycleApprovalStep (Joining table) record with its related record in approval_cycles (table) and related record in approval_steps (table)
    public function approvalCycleApprovalStep()
    {
        return $this->belongsTo(ApprovalCycleApprovalStep::class)->with('approvalCycle')->with('approvalStep');
    }

    public function itemOrders()
    {
        return $this->hasMany("App\Models\itemOrder","purchase_order_id" , "record_id");
    }

    public function purchaseOrder()
    {
        return $this->belongsTo("App\Models\PurchaseOrder","record_id" , "id");
    }

    public function cheque()
    {
        return $this->belongsTo("App\Models\ChequeRequest","record_id" , "id");
    }

    public function purchaseRequest()
    {
        return $this->belongsTo("App\Models\PurchaseRequest", "record_id" , "id");
    }

    public function chequeRequest()
    {
        return $this->belongsTo("App\Models\ChequeRequest", "record_id" , "id");
    }



    // public function itemOrders()
    // {
    //     return $this->hasManyThrough("App\Models\itemOrder" , "App\Models\ApprovalTimeline" , "record_id" "purchase_order_id" );
    // }


    public function comment()
    {
        return $this->hasMany("App\Models\ApprovalTimelineComment", "approval_timeline_id" , "id");
    }
}
