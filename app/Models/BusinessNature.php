<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessNature extends Model
{
    use SoftDeletes;

    protected $guarded;

    public function item()
    {
        return $this->belongsTo("App\Models\Item","item_id");
    }


    public function invoices()
    {
        return $this->hasMany("App\Models\Invoice", "business_nature_id");
    }

}
