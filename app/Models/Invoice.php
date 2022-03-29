<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $guarded;

    public function item()
    {
        return $this->belongsTo("App\Models\Item","item_id");
    }

    public function project()
    {
        return $this->belongsTo("App\Models\Project","project_id");
    }

    public function supplier()
    {
        return $this->belongsTo("App\Models\Supplier","supplier_id");
    }

    public function natureDealing()
    {
        return $this->belongsTo("App\Models\NatureDealing","nature_dealing_id");
    }
    public function businessNature()
    {
        return $this->belongsTo("App\Models\BusinessNature","business_nature_id");
    }

    public function PurchaseOrder()
    {
        return $this->belongsTo("App\Models\PurchaseOrder","po_id");
    }
}
