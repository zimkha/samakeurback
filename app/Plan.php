<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Plan extends Model
{
    use SoftDeletes;

    public function niveau_plans()
    {
        return $this->hasMany(NiveauPlan::class);
    }
    public function plan_projets()
    {
        return $this->hasMany(PlanProjet::class);
    }


    public static function makeCode()
    {
        $last = Plan::all()->last();
        $nume = null;
        $code = "PL";
        if (isset($last)) {
            $nume = $last->id;
        }
        else $nume = 0;
        $nume = $nume + 1;
        
        if ($nume >= 1  && $nume <= 9) 
        {
          $code = $code ."000".$nume;
        }
        if ($nume > 9 && $nume <= 99)
        {
            $code = $code ."00".$nume;
        }
        return $code;

    }
}
