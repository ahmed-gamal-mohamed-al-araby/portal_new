<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrder extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded;
    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
    public function FileITem()
    {
        return $this->hasMany(FilePurchaseOrder::class);
    }
    public function itemOrders()
    {
        return $this->hasMany(ItemOrder::class);
    }
    
}
