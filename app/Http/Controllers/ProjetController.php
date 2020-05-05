<?php

namespace App\Http\Controllers;

use App\Outil;
use App\Projet;
use App\Remarque;
use App\PlanProjet;
use App\NiveauProjet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjetController extends Controller
{
    protected $queryName = "projets";
    public function save(Request $request)
    {
        try
        {
            return DB::transaction(function () use($request) {
                $errors = null;
                $item  = new Projet();
                $array = [
                         'user', 'fichier', 'description', 'superficie', 'longeur', 'largeur',
                         'acces_voirie', 'electricite', 'courant_faible', 'assainissement', 'eaux_pluviable','bornes_visible',
                        'necessite_bornage','presence_mitoyen','cadatre','geometre'];
                if (isset($request->id)) {
                    $item = Projet::find($id);
                }

                $errors = Outil::validation($request, $array);
                //dd($request->superficie,($request->longeur * $request->largeur));
                if ((int)$request->superficie != ($request->longeur * $request->largeur)) {
                    $errors = "le produit du longeur et de la laregeur doit être égale à la superficie total";
                }
                $item->user_id                 = $request->user;
                $item->superficie              = $request->superficie;
                $item->longeur                 = $request->longeur;
                $item->largeur                 = $request->largeur;
                $item->text_projet             = $request->description;
                $item->acces_voirie            = $request->acces_voirie;
                $item->electricite             = $request->electricite;
                $item->courant_faible          = $request->courant_faible;
                $item->assainissement          = $request->assainissement;
                $item->eaux_pluvial            = $request->eaux_pluviable;
                $item->bornes_visible          = $request->bornes_visible;
                $item->necessite_bornage       = $request->necessite_bornage;
                $item->presence_mitoyen        = $request->presence_mitoyen;
               
                if (empty($request->data)) // Data represente les niveaux c'est a dire le RDC et les R+n
                {
                    $errors = "Veuillez renseigne au moins le RDC";
                    throw new \Exception($errors);
                }
                $n = 0;
                $array_level = array();
                foreach ($request->data as  $key) {
                    $n = $n + 1;
                    $niveau = new NiveauProjet();
                    if (empty($key['piece'])) {
                       $errors = "Veuillez renseigne le nombre de pieces de ce niveau ligne n°". $n;
                    }
                    if (empty($key['chambre'])) {
                        $errors = "Veuillez renseigne le nombre de chambre de ce niveau ligne n°". $n;
                      }
                     if (empty($key['salon'])) {
                        $errors = "Veuillez renseigne le nombre de salon de ce niveau ligne n°". $n;
                     }
                     if (empty($key['bureau'])) {
                        $errors = "Veuillez renseigne le nombre de bureau de ce niveau ligne n°". $n;
                     }
                     if (empty($key['cuisine'])) {
                        $errors = "Veuillez renseigne le nombre de cuisine de ce niveau ligne n°". $n;
                     }
                     if (empty($key['toillette'])) {
                        $errors = "Veuillez renseigne le nombre de toillette de ce niveau ligne n°". $n;
                     }
                     if (isset($errors)) 
                     {
                         throw new \Exception($errors);
                     }
                    $all_piece = $key['chambre'] + $key['salon'] + $key['bureau'] + $key['cuisine'] + $key['toillette'];
                    if ($all_piece != (int)$key['piece']) 
                    {
                        $errors = "Erreur de decompte sur le nombre de pieces ligne n°{$n}";
                    }
                    $niveau->niveau_name        = $key['niveau_name'];
                    $niveau->piece              = $key['piece'];
                    $niveau->chambre            = $key['chambre'];
                    $niveau->salon              = $key['salon'];
                    $niveau->bureau             = $key['bureau'];
                    $niveau->cuisine            = $key['cuisine'];
                    $niveau->toillette          = $key['toillette'];

                    array_push($array_level, $niveau);
                    
                }
                if (!isset($errors)) 
                {
                    $item->active = false;
                    $item->etat = 0;
                  
                    $item->save();
                  foreach ($array_level as $level) {
                      $level->projet_id    = $item->id;
                      $level->save();
                  } 
                  return Outil::redirectgraphql($this->queryName, "id:{$item->id}", Outil::$queries[$this->queryName]);
                }
                 throw new \Exception($errors);

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
    public function delete($id)
    {
        try
        {
            return DB::transaction(function () use($id) {
                $errors = null;
                $data   = 0;
                if (isset($id))
                 {
                   $item = Projet::find($id);
                   if(isset($item))
                     {
                        $plan_projets = PlanProjet::where('projet_id', $item->id)->get();
                        if (count($plan_projets) > 0) 
                         {
                            $errors = "Impossible de supprimer des données liées au système";
                           
                         } 
                        if (count(Remarque::where('projet_id', $item->id)->get()) > 0)
                         {
                            $errors = "Impossible de supprimer des données liées au système";
                         }
                         if (!isset($errors))
                          {
                              NiveauProjet::where('projet_id', $item->id)->delete();
                              NiveauProjet::where('projet_id', $item->id)->forceDelete();
                              $item->delete();
                              $item->forceDelete();
                              $data = 1;
                            $retour = array(
                                'data'          => $data,
                            );
                            return response()->json($retour);
                          }
                          else
                              throw new \Exception($errors);

                     } 
                   else
                   {
                    $errors = "Impossible de supprimer car ces données n'existe pas dans la base de données";
                    throw new \Exception($errors);
                   }
                 }
                else
                {
                    $errors = "Impossible, données manquantes";
                    throw new \Exception($errors);
                }
                   
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
    public function makeCode()
    {
        try
        {
            return DB::transaction(function ()  {
                
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
   

    public function makeContrat($id)
    {
        try
        {

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
