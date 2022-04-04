<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemRequest extends Model
{
    use HasFactory;
    public $guarded = [];
    public $timestamps = false;

    public function purchaseRequest()
    {
        return $this->belongsTo(PurchaseRequest::class);
    }
    public function user()
    {
        return $this->belongsTo("App\Models\User" , "action_comment_id");
    }

    public function familyName()
    {
        return $this->belongsTo(familyName::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function ItemOrder()
    {
        return $this->hasMany("App\Models\ItemOrder","item_request_id" );
    }

    public function inquiryPurchaseRequest()
    {
        return $this->belongsTo("App\Models\InquiryPurchaseRequest","id");
    }
}
