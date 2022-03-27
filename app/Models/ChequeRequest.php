<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChequeRequest extends Model
{
    use HasFactory;
    protected $guarded;
    use SoftDeletes;

    public function ChequeItemRequest () {
        return $this->hasMany("App\Models\ChequeItemRequest", "cheque_id");
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'order_number');
    }

}
