<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NiveauPlan extends Model
{
    use SoftDeletes;
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
