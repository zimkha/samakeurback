<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Plan;
use App\Outil;
class PlanController extends Controller
{
    protected $queryName = "plans";
    public function save(Request $request)
    {
        try {
           return DB::transaction(function () use($request) {
                $errors = null;
                $item = new Plan();
                $code = Plan::makeCode();
                if (isset($request->id)) {
                    $item = Plan::find($request->id);
                    $code = $item->code;
                } 
               
                $item->code = $code; 
                if (empty($request->superficie)) {
                   $errors = "Veuillez preciser la superficie pour ce plan";
                }
                if (empty($request->longeur)) {
                    # code...
                    $errors = "Veuillez preciser la longeur";

                }
                if (empty($request->largeur)) {
                    # code...
                    $errors = "Veuillez preciser la largeur";
                }
                if (empty($request->data)) {
                   $errors = "Veuillez preciser au moins le RDC pour ce plan";
                }
                if (isset($errors))
                {
                    throw new \Exception($errors);
                }
            
                $data       = json_decode($request->data, true);
                $tableau    = array(); 
                foreach ($data as $datum) {
                    $niveau = new NiveauPlan();
                    if (empty($datum['piece']))
                    {
                        $errors = "Veuillez renseigner au moins le nombre de pièces pour ce niveau";
                    } 
                    $niveau->piece          = $datum['piece'];
                    $niveau->chambre        = $datum['chambre'];
                    $niveau->salon          = $datum['salon'];
                    $niveau->cuisine        = $datum['cuisine'];
                    $niveau->garage         = $datum['garage'];
                    $niveau->toillette      = $datum['toillette'];   
                    array_push($tableau, $niveau);   
                }
                if (!isset($errors)) {
                    $item->save();
                    foreach($tableau as $var)
                    {
                        $var->plan_id = $item->id;
                        $var->save();
                    }
                    if (isset($request->projet)) {
                        $plan_projet              = new PlanProjet();
                        $plan_projet->plan_id     = $item->id;
                        $plan_projet->projet_id   = $request->id;
                        $plan_projet->etat_active = false;
                        $plan_projet->etat        = 0;
                        $plan_projet->save();
                    }
                    return Outil::redirectgraphql($this->queryName, "id:{$item->id}", Outil::$queries[$this->queryName]);

                }
                throw new \Exception($errors);

           });
        } catch (\Exception $e) {
            return Outil::getResponseError($e);

        }
    }
    public function delete($id)
    {
        try
        {
            return DB::transaction(function () use($id) {
                $errors = null;
                $data   = 0;
                $item   = Plan::find($id);
                if (isset($item)) {
                     $items = PlanProjet::where('plan_id', $id)->get();
                     if (count($items) > 0) {
                         $errors = "Impossible de supprimer un plan lié à des projets";
                     }
                     else
                       {
                           NiveauPlan::where('plan_id', $id)->delete();
                           NiveauPlan::where('plan_id', $id)->forceDelete();
                           $item->delete();
                           $item->forceDelete();
                           $data = 1;
                       }
                } else
                    $errors = "Impossible de supprimer le plan, donnée introuvable";
                    if (isset($errors))
                    {
                        throw new \Exception($errors);
                    }
                    else
                    {
                        $retour = array(
                            'data'          => $data,
                        );
                    }
                    return response()->json($retour);
            });
        }
        catch(\Exception $e)
        {
            return response()->json(array(
                'errors'          => config('app.debug') ? $e->getMessage() : Outil::getMsgError(),
                'errors_debug'    => [$e->getMessage()],
            ));
        }
    }
    
}
