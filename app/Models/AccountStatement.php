<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountStatement extends Model
{
    use SoftDeletes;

    protected $guarded;

    public function requester()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function invoice()
    {
        return $this->belongsTo("App\Models\Invoice","invoice_id");
    }

    public function paymentInvoice()
    {
        return $this->belongsTo("App\Models\PaymentInvoice","payment_id");

    }
}
