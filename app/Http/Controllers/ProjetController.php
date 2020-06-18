<?php

namespace App\Http\Controllers;

use PDF;
use App\Plan;
use App\Outil;
use App\Joined;
use App\Projet;
use App\Remarque;
use Carbon\Carbon;
use App\PlanProjet;
use App\NiveauProjet;
use PayPal\Rest\ApiContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Srmklive\PayPal\Services\ExpressCheckout;
use Srmklive\PayPal\Services\AdaptivePayments;
use Illuminate\Support\Facades\Auth;
use App\User;

class ProjetController extends Controller
{
    protected $queryName = "projets";
    public function avalider()
    {
        return Plan::SelecvByName("kh");
    }
    public function save(Request $request)
    {
        //dd($request->all());
        try
        {
            return DB::transaction(function () use($request) {
                $errors = null;
                $name = Projet::makeCode();
                $item  = new Projet();
                $array = [
                         'user', 'longeur', 'largeur',
                       ];
                // presence_mitoyen
                if (isset($request->id)) {
                    $item = Projet::find($id);
                    NiveauProjet::where('projet_id', $request->id)->delete();
                    NiveauProjet::where('projet_id', $request->id)->forceDelete();
                    $name = $item->name;
                }
                if(empty($request->acces_voirie) || $request->acces_voirie == 0)
                {
                    $item->acces_voirie = 0;
                }
                else
                {
                    $item->acces_voirie = $request->acces_voirie;
                }
                if(empty($request->electricite) || $request->electricite == 0)
                {
                    $item->electricite = 0;
                }
                else
                    $item->electricite             = $request->electricite;
                
                if(empty($request->courant_faible) || $request->courant_faible == 0)
                {
                    $item->courant_faible = 0;
                }
                else
                    $item->courant_faible             = $request->courant_faible;

                if(empty($request->assainissement) || $request->assainissement == 0)
                {
                    $item->assainissement = 0;
                }
                else 
                  $item->assainissement             = $request->assainissement;

                
                  if(empty($request->eaux_pluviable) || $request->eaux_pluviable == 0)
                  {
                      $item->eaux_pluvial = 0;
                  }
                  else 
                    $item->eaux_pluvial      = $request->eaux_pluviable;
                
                if(empty($request->bornes_visible) || $request->bornes_visible == 0)
                {
                    $item->bornes_visible = 0;
                }
                else 
                    $item->bornes_visible      = $request->bornes_visible;

                if(empty($request->necessite_bornage) || $request->necessite_bornage == 0)
                {
                    $item->necessite_bornage = 0;
                }
                else 
                  $item->necessite_bornage      = $request->necessite_bornage;
                if(isset($request->adresse_terrain))
                {
                    $item->adresse_terrain = $request->adresse_terrain;
                }

                $errors = Outil::validation($request, $array);

                $user_connected = Auth::user()->id;

                $User = User::find($user_connected);

                if(isset($User))
                {
                    if($User->is_client== 1)
                    {
                        if(empty($request->tab_niveau))
                        {
                            $errors = "Veuillez remplir les niveaux dans le formulaire";
                            throw new \Exception($errors);
                        }

                    }
                }
                else if(empty($request->description))
                {
                    $errors = "Veuillez compléter la description ";
                    throw new \Exception($errors);
                }
                else
                {
                    $item->text_projet = $request->description;
                }

                $superficie                    = $request->longeur * $request->largeur;
                $item->name                    = $name;
                $item->user_id                 = $request->user;
                $item->superficie              = $superficie;
                $item->longeur                 = $request->longeur;
                $item->largeur                 = $request->largeur;
              
              //  $item->presence_mitoyen        = $request->presence_mitoyen;
                $item->geometre                = $request->geometre;
                $item->adresse_terrain         = $request->adresse_terrain;
                $item->sdb                     = $request->sdb;

                $n = 0;
                $array_level = array();
              
                if(isset($request->tab_niveau) && $request->tab_niveau != null)
                {
                    $data = json_decode($request->tab_niveau, true);
                    foreach ($data as  $key) {
                      
                        $n = $n + 1;
                        $niveau = new NiveauProjet();
                        if (empty($key['piece'])) {
                           $errors = "Veuillez renseigner le nombre de pieces de ce niveau ligne n°". $n;
                        }
                        if (empty($key['chambre'])) {
                            $errors = "Veuillez renseigner le nombre de chambre de ce niveau ligne n°". $n;
                          }
                         if (empty($key['salon'])) {
                            $errors = "Veuillez renseigner le nombre de salon de ce niveau ligne n°". $n;
                         }
                         if (empty($key['bureau'])) {
                            $errors = "Veuillez renseigner le nombre de bureau de ce niveau ligne n°". $n;
                         }
                         if (empty($key['cuisine'])) {
                            $errors = "Veuillez renseigner le nombre de cuisine de ce niveau ligne n°". $n;
                         }
                         if (empty($key['toillette'])) {
                            $errors = "Veuillez renseigner le nombre de toillette de ce niveau ligne n°". $n;
                         }
                         if (empty($key['niveau'])) {
                            $errors = "Veuillez renseigner le name du niveau ligne n°". $n;
                         }
                         if (isset($errors))
                         {
                             throw new \Exception($errors);
                         }
                        $all_piece = $key['chambre'] + $key['salon'] + $key['bureau'] + $key['cuisine'] + $key['toillette'] + $key['sdb'];
                        if ($all_piece != (int)$key['piece'])
                        {
                            $errors = "Erreur de décompte sur le nombre de pièces ligne n°{$n}";
                        }
                       
                        $niveau->niveau_name        = $key['niveau'];
                        $niveau->piece              = $key['piece'];
                        $niveau->chambre            = $key['chambre'];
                       
                        $niveau->salon              = $key['salon'];
                        $niveau->bureau             = $key['bureau'];
                        $niveau->cuisine            = $key['cuisine'];
                        $niveau->toillette          = $key['toillette'];
                        $niveau->sdb               = $key['sdb'];
                      
                      

                       
                        array_push($array_level, $niveau);

                    }
                }

                if (!isset($errors))
                {
                    $item->active = false;
                    $item->etat = 0;
                    //dd($array_level);
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
                    $errors = "Veuillez définir le plan à lier à ce projet";
                }
                if(empty($request->projet))
                {
                    $errors = "Données manquantes pour cette opération, veuillez contacter le service technique";
                }
                if(isset($request->projet))
                {
                    $count = PlanProjet::where('projet_id', $request->projet)->count();
                    if($count == 3)
                    {
                        throw new \Exception("Impossible d'effectuer cette action, le nombre maximal de demandes de modifications  de plan est atteint");
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
                      $errors = "Ce projet est déjà lier à ce plan";
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
                    $errors = "Impossible de supprimer car ces données n'existent pas dans la base de données";
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
                                    $niveaux = $item->niveau_projets;
                                    if(count($niveaux) == 0)
                                    {
                                        $niveaux = null;
                                    }
                                    //dd($client);
                    $created_at = Carbon::parse($item->created_at)->format('d/m/Y');
                    $pdf = PDF::loadView('pdf.contrat', ['projet' => $item, 'created_at' => $created_at, 'client' => $client, 'niveaux' => $niveaux]);
                    return $pdf->setPaper( 'orientation')->stream();
                }
                else
                {
                    $errors = "Impossible de trouver ces données pour un contrat";
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
    public function activeFichier($id)
    {
       try
       {
        $item = Joined::find($id);
        $errors = null;
        $data = 0;
        if(isset($item))
        {
           $plan = Plan::find($item->plan_id);
           $joined = Joined::where('plan_id', $plan->id)->where('active', 1)->get()->first();
           if($joined!=null)
           {

               $joined->active = 0;
               $joined->save();
           }
           $item->active = 1;
           $item->save();
           $data = 1;
        }
        else
          {
            $errors = "Impossible d'effectuer cette opération, données introuvable";
             throw new \Exception($errors);
          }
          if(!isset($errors))
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
    public function payment()
    {
          $config = [
             "id"  => "AcftOJdjG7Oa5OHrLQfzrMB8Bl2u27xdTMzbygvJX9B59200UAGQ05yGjwzn23z0Wy9EanSHZRLDtp6w",
             "secrete" => "ENDRItY4jUMH9BBjH6IMxiLWHBk-GO9t7sCe7X4b9Es5Cuz2mqe995WJc7vuNj-IuJA-PkWa6c4gCSxo"
         ];
        $apiContext = new ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                $config['id'],
                $config['secrete']
            )
        );
        $payment = new \PayPal\Api\Payment();
        $payment->create($apiContext);

        $payment->getApprovalLink();
            dd($payment);
        // $provider = new ExpressCheckout;      // To use express checkout.
        // $provider = new AdaptivePayments;
        // $provider = PayPal::setProvider('express_checkout');      // To use express checkout(used by default).
        // $provider = PayPal::setProvider('adaptive_payments');

        // $apiContext = new \Paypal\Rest\ApiContext(
        //     new \PayPal\Auth\OAuthTokenCredential(
        //         $config['id'],
        //         $config['secrete']     // ClientSecret
        //     )
        // );
        // $provider->setApiCredentials($config);
        // $payment = new \Paypal\Rest\Payment($apiContext);
        // dd($payment);

    }

}
