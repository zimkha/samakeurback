<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviseFinance extends Model
{
    
    public function chantier()
    {
        return $this->belongsTo(Chantier::class);
    }
}
