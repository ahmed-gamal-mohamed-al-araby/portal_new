<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InquiryPurchaseRequest extends Model
{
    use HasFactory, SoftDeletes;

    public $guarded = [];

    public function itemRequest()
    {
        return $this->belongsTo("App\Models\ItemRequest","item_request_id");
    }


    public function purchaseRequest()
    {
        return $this->belongsTo(PurchaseRequest::class);
    }

    public function creator()
    {
        return $this->belongsTo("App\Models\User","send_id");
    }

    public function firstApprovel()
    {
        return $this->belongsTo("App\Models\User","receive_id");
    }
    public function seconedApprovel()
    {
        return $this->belongsTo("App\Models\User","technical_office");
    }
}
