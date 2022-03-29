<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NatureDealing extends Model
{
    use SoftDeletes;

    protected $guarded;

    public function discountTypes()
    {
        return $this->belongsTo("App\Models\DiscountType","discount_type_id");
    }
    
}
