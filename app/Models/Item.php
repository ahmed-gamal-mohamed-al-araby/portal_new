<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;

    protected $guarded;

    public function businessNature()
    {
        return $this->belongsTo("App\Models\BusinessNature","item_id");
    }

    public function project()
    {
        return $this->belongsTo("App\Models\Project","item_id");
    }}
