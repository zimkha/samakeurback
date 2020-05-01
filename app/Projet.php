<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Projet extends Model
{
    use SoftDeletes;

    public function user()
    {
         return $this->belongsTo(User::class);
    }
    public function niveau_projets()
    {
        return $this->hasMany(NiveauProjet::class);
    }
    public function remarques()
    {
         return $this->hasMany(Remarque::class);
    }
    public function plan_projets()
    {
        return $this->hasMany(PlanProjet::class);
    }
}
