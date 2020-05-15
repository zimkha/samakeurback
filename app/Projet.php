<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

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
     public static function nb_attribut($id, $attribut)
    {
        $item = Projet::find($id);
        $nb_attribut = 0;
        if (isset($item)) {
            // le plan Existe 
           $nb =  DB::select(DB::raw("
           select sum(np.$attribut) as nbr from niveau_projets np where np.projet_id = '$id'
        "));
        if ($nb[0]->nbr != null)
           {
            $nb_attribut = $nb[0]->nbr;
           }
        }
        return $nb_attribut;
    }
    
}
