<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

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
    public function unite_mesure()
    {
        return $this->belongsTo(UniteMesure::class);
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
    public static function nb_attribut($id, $attribut)
    {
        $item = Plan::find($id);
        $nb_attribut = 0;
        if (isset($item)) {
            // le plan Existe 
           $nb =  DB::select(DB::raw("
           select sum(np.$attribut) as nbr from niveau_plans np where np.plan_id = '$id'
        "));
        if ($nb[0]->nbr != null)
           {
            $nb_attribut = $nb[0]->nbr;
           }
        }
        return $nb_attribut;
    }
    public static function getNbAttribut($attribut)
    {
        $tab = DB::select(DB::raw("
        select sum(n.$attribut) as attr , n.plan_id as id from niveau_plans n GROUP By n.plan_id
        "));
        $array = array();
        foreach($tab as $element)
        {
            array_push($array, $element->id)
        }
        return $array;
    }
    
}
