<?php

namespace App\Http\Controllers;

use App\Plan;
use App\Outil;
use App\Projet;
use App\Remarque;
use App\PlanProjet;
use App\NiveauProjet;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjetController extends Controller
{
    protected $queryName = "projets";
    public function avalider($id)
    {
        return Projet::a_valider($id);
    }
    public function save(Request $request)
    {
        try
        {
            dd($request->all());
            return DB::transaction(function () use($request) {
                $errors = null;
                $name = Projet::makeCode();
                $item  = new Projet();
                $array = [
                         'user', 'description', 'superficie', 'longeur', 'largeur',
                         'acces_voirie', 'electricite', 'courant_faible', 'assainissement', 'eaux_pluviable','bornes_visible',
                        'necessite_bornage','presence_mitoyen','cadatre','geometre'];
                if (isset($request->id)) {
                    $item = Projet::find($id);
                    NiveauProjet::where('projet_id', $request->id)->delete();
                    NiveauProjet::where('projet_id', $request->id)->forceDelete();
                    $name = $item->name;
                }
                if(isset($request->adresse_terrain))
                {
                    $item->adresse_terrain = $request->adresse_terrain;
                }

                $errors = Outil::validation($request, $array);
                //dd($request->superficie,($request->longeur * $request->largeur));
                if ((int)$request->superficie != ($request->longeur * $request->largeur)) {
                    $errors = "le produit du longeur et de la laregeur doit être égale à la superficie total";
                }
               // $user = User::find($request->user);
                $item->name                    = $name;
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
               
                // if (empty($request->data)) // Data represente les niveaux c'est a dire le RDC et les R+n
                // {
                //     $errors = "Veuillez renseigne au moins le RDC";
                //     throw new \Exception($errors);
                // }
                $n = 0;
                $array_level = array();
                if(isset($request->data) && $request->data != null)
                {
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
                }
               
                if (!isset($errors)) 
                {
                    $item->active = false;
                    $item->etat = 0;
                  
                    $item->save();
                    if(count($array_level) > 0)
                    {
                        foreach ($array_level as $level)
                         {
                            $level->projet_id    = $item->id;
                            $level->save();
                        } 
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

   /*
    * Cette function permte de lier un projet a un plan
    * le plan est composé de pdf et de ses infos
    * le fichier du plan est affiché au client
    */
    public function linkPlanToProjet(Request $request)
    {
        try
        {
            return DB::transaction(function()use($request)
            {
                $errors = null;
                $item = new PlanProjet();
                if(isset($request->id))
                {
                    $item = PlanProjet::find($request->id);
                }
                if(empty($request->plan))
                {
                    $errors = "veuillez definir le plan a liee a ce projet";
                }
                if(empty($request->projet))
                {
                    $errors = "données manquante pour cette opération, veuillez contacter le service technique";
                }
                if(isset($request->projet))
                {
                    $count = PlanProjet::where('projet_id', $request->projet)->count();
                    if($count == 3)
                    {
                        throw new \Exception("Impossible d'effectuer cette action, le nombre de soumissions de plan est atteint");
                    }
                }
                if(isset($request->plan))
                {
                    $plan = Plan::find($request->plan);
                    if(!isset($plan) || empty($plan->fichier))
                    {
                        $errors = "Pour ce plan il n'existe plus de fichier de plan";
                    }
                    else
                    $item->fichier   = $plan->fichier;
                  $plan_projet = PlanProjet::where('plan_id', $request->plan)->where('projet_id', $request->projet)->get();
                  if(count($plan_projet)> 0)
                  {
                      $errors = "Ce projet est déja lies a ce plan";
                  }  
                }
                $item->plan_id          = $plan->id;
                $item->projet_id        = $request->projet;
                $item->etat_active      = 0;
                $item->active           = 0; // Par defaut le plan rataché au projet est a false de ce faite c'est au client de la passée a true
                if (!isset($errors))
                {
                    $item->save();
                    return Outil::redirectgraphql($this->queryName, "id:{$item->projet_id}", Outil::$queries[$this->queryName]);
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
   
    public function active_plan(Request $request)
    {
        try
        {
           
            $errors = null;
            $data = 0;
            $item = PlanProjet::find($request->plan_projet);
            if(isset($item))
            {
                $projet = Projet::find($item->projet_id);

                //dd($projet);
                if(isset($projet))
                {
                   
                    $plan_active = PlanProjet::where('active', true)->where('projet_id', $projet->id)->get();
                  
                    if(isset($plan_active) && count($plan_active) > 0)
                    {
                      //  dd("je suis la");
                        foreach($plan_active as $key)
                        {
                           
                            $key->active = 0;
                            $key->save();
                        }
                    }
                
                }
                else
                {
                   $errors = "Impossible d'effectuer cette opération, veuillez contacter le service technique";
                }

            }
            if(!isset($errors))
            {
                if(isset($request->message))
                {
                    $item->message = $request->message;
                }
                $item->active = 1;
                $item->save();
                return Outil::redirectgraphql($this->queryName, "id:{$item->projet_id}", Outil::$queries[$this->queryName]);
            }
            throw new \Exception($errors);
        }
        catch(\Exception $e)
        {
            return response()->json(array(
                'errors'          => config('app.debug') ? $e->getMessage() : Outil::getMsgError(),
                'errors_debug'    => [$e->getMessage()],
            ));  
        }  
    }
    public function activeProjet($id)
    {
        try
        {
            $errors = null;
            $data = null;
            if(isset($id))
            {
                $item = Projet::find($id);
                if(isset($item))
                {
                    $item->active = true;
                    $item->save();
                    $data = 1;
                }
                else
                {
                    $errors = "Erreur veuillez contacter le service technique";
                }
            }
            else
            {
                $errors = "Données manquantes";
            }
            if($errors!=null)
            {
                $retour = array(
                    'data'          => $data,
                );
                return response()->json($retour);
            }
             throw new \Exception($errors);
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
                $item = Projet::find($id);
                if(isset($item))
                {
                    $client = $item->user;
                    $created_at = Carbon::parse($item->created_at)->format('d/m/Y');
                    $pdf = PDF::loadView('pdf.contrat', ['projet' => $item, 'created_at' => $created_at]);
                    return $pdf->setPaper( 'orientation')->stream();
                }
                else
                {
                    $errors = "Impossible de touver ces données pour un contrat";
                }
        }
        catch(\Exception $e)
        {
            return response()->json(array(
                'errors'          => config('app.debug') ? $e->getMessage() : Outil::getMsgError(),
                'errors_debug'    => [$e->getMessage()],
            ));  
        }
    }
    public function payment()
    {
        $config = [
            "id"  => "AcftOJdjG7Oa5OHrLQfzrMB8Bl2u27xdTMzbygvJX9B59200UAGQ05yGjwzn23z0Wy9EanSHZRLDtp6w",
            "secrete" => "ENDRItY4jUMH9BBjH6IMxiLWHBk-GO9t7sCe7X4b9Es5Cuz2mqe995WJc7vuNj-IuJA-PkWa6c4gCSxo"
        ];
        $apiContext = new \Paypal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                $config['id'],
                $config['secrete']     // ClientSecret
            )
        );
        $payment = new \Paypal\Rest\Payment($apiContext);
        dd($payment);

    }
    
}
