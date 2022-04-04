<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemOrder extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded;
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    // public function po()
    // {
    //     return $this->belongsTo("App\Models\PurchaseOrder","purchase_order_id");
    // }
    public function user()
    {
        return $this->belongsTo("App\Models\User" , "action_comment_id");
    }

    public function po()
    {
        return $this->belongsTo("App\Models\PurchaseOrder", "purchase_order_id" , "id" );
    }

    public function ItemRequest()
    {
        return $this->belongsTo(ItemRequest::class);
    }
}
