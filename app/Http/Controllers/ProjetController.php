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
use App\Position;
use App\NiveauProjet;
use PayPal\Rest\ApiContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Srmklive\PayPal\Services\ExpressCheckout;
use Srmklive\PayPal\Services\AdaptivePayments;
use Illuminate\Support\Facades\Auth;
use App\User;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

class ProjetController extends Controller
{
    protected $queryName = "projets";
    public function avalider()
    {
        $attribt = "chambre";
        return Projet::nb_attribut(4,$attribt );

    }
    public function save(Request $request)
    {
        // dd($request->all());

        try
        {
            return DB::transaction(function () use($request) {
                $errors = null;
                $name = Projet::makeCode();
                $auth_user = Auth::user()->id;
                $item  = new Projet();
                $array = [
                         'user', 'longeur', 'largeur',
                       ];
                // presence_mitoyen
                if (isset($request->id)) {
                    $item = Projet::find($request->id);
                    NiveauProjet::where('projet_id', $request->id)->delete();
                    NiveauProjet::where('projet_id', $request->id)->forceDelete();
                    Position::where('projet_id', $request->id)->delete();
                    Position::where('projet_id', $request->id)->forceDelete();
                    $name = $item->name;
                    $auth_user = $item->id_user;
                }
             //   $item->id_user = $auth_user;
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

                $item->garage = $request->garage;

                $errors = Outil::validation($request, $array);

                $user_connected = Auth::user()->id;

                $User = User::find($user_connected);

                if(isset($User))
                {
                    if($User->is_client== 1)
                    {
                        if(empty($request->tab_projet))
                        {
                            $errors = "Veuillez remplir les niveaux dans le formulaire";
                            throw new \Exception($errors);
                        }

                    }
                }
               if(isset($request->description))
               {
                    $item->text_projet = $request->description;
               }
                $superficie                    = $request->longeur * $request->largeur;
                $item->name                    = $name;
                $item->user_id                 = (int)$request->user;
                $item->superficie              = $superficie;
                $item->longeur                 = $request->longeur;
                $item->largeur                 = $request->largeur;

              //  $item->presence_mitoyen        = $request->presence_mitoyen;
                $item->geometre                = $request->geometre;
                $item->adresse_terrain         = $request->adresse_terrain;
                $item->sdb                     = $request->sdb;

                $n = 0;
                $array_level = array();

                //  dd($request->hasFile('fichier'), $request->all());
                if (!isset($errors) && $request->hasFile('fichier') )
                {
                    $fichier = $_FILES['fichier']['name'];
                    $fichier_tmp = $_FILES['fichier']['tmp_name'];
                    $k = rand(100, 9999);
                    $ext = explode('.',$fichier);
                    $rename = config('view.uploads')['projets']."/projets_".$k.".".end($ext);
                    move_uploaded_file($fichier_tmp,$rename);
                    //$path = $request->fichier->storeAs('uploads/plans', $rename);
                    $item->fichier = $rename;

                }
                // dd($item->fichier);

                $tab_position = array();
                
                if(isset($request->positions) && $request->positions!= null)
                {
                    $positions = $request->positions;
                    //dd($positions);
                    foreach($positions as $position)
                    {
                        $pt_ref = new Position();
                        $pt_ref->position = $position['ref'];
                        $pt_ref->nom_position = $position['position'];
                        array_push($tab_position , $pt_ref);
                    }
                }
                if(isset($request->tab_projet) && $request->tab_projet != null)
                {
                    $data = json_decode($request->tab_projet, true);
                    foreach ($data as  $key) {

                        $n = $n + 1;
                        $niveau = new NiveauProjet();
                        // if (empty($key['piece'])) {
                        //    $errors = "Veuillez renseigner le nombre de pieces de ce niveau ligne n°". $n;
                        // }
                        if (!isset($key['chambre'])) {
                            $errors = "Veuillez renseigner le nombre de chambre de ce niveau ligne n°". $n;
                          }
                         if (!isset($key['salon'])) {
                            $errors = "Veuillez renseigner le nombre de salon de ce niveau ligne n°". $n;
                         }
                         if (!isset($key['bureau'])) {
                            $errors = "Veuillez renseigner le nombre de bureau de ce niveau ligne n°". $n;
                         }
                         if (!isset($key['cuisine'])) {
                            $errors = "Veuillez renseigner le nombre de cuisine de ce niveau ligne n°". $n;
                         }
                         if (!isset($key['toillette'])) {
                            $errors = "Veuillez renseigner le nombre de toillette de ce niveau ligne n°". $n;
                         }

                         if (isset($errors))
                         {
                             throw new \Exception($errors);
                         }
                        // $all_piece = $key['chambre'] + $key['salon'] + $key['bureau'] + $key['cuisine'] + $key['toillette'] + $key['sdb'];
                        // if ($all_piece != (int)$key['piece'])
                        // {
                        //     $errors = "Erreur de décompte sur le nombre de pièces ligne n°{$n}";
                        // }


                        $niveau->niveau_name        = "R +". $n;
                        // $niveau->piece              = $key['piece'];
                        $niveau->chambre            = $key['chambre'];

                        $niveau->salon              = $key['salon'];
                        $niveau->bureau             = $key['bureau'];
                        $niveau->cuisine            = $key['cuisine'];
                        $niveau->toillette          = $key['toillette'];
                        $niveau->sdb                = $key['sdb'];
                        array_push($array_level, $niveau);

                    }
                }


                //dd($item);

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
                    if(count( $tab_position) > 0)
                    {
                        foreach( $tab_position as $pos)
                        {
                            $pos->projet_id = $item->id;
                            $pos->save();
                        }
                    }
                    if(isset($item->id) && !isset($request->id))
                    {
                        $user = User::find($item->user_id);
                        $tableau = [
                            'title' => "Message de confirmation",
                            'body'  => "Votre demande de création de projet a été bien prise en charge. Veuillez vous connecter sur votre espace personnelle pour procéder au paiment"
                        ];
                        \Mail::to("zimkhandiaye@gmail.com")->send(new \App\Mail\SendMessageConfirm($tableau));
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
    public function activeProjet(Request $request)
    {
        try
        {
            $errors = null;
            $data = null;

            if(isset($request->projet))
            {
                if(empty($request->montant))
                {
                    $errors = "Veuillez definir le montant";
                    throw new \Exception($errors);

                }
                if(isset($request->montant) && $request->montant <= 0)
                {
                    $errors = "Veuillez renseigner un montant valide";
                    throw new \Exception($errors);


                }
                $id = (int)$request->projet;
                $item = Projet::find($id);

                if(isset($item))
                {
                    $item->montant = $request->montant;
                    $item->active = true;
                    $item->etat = 1;
                    $item->save();
                    $data = 1;

                }
                else
                {
                    $errors = "Erreur veuillez contacter le service technique";
                    throw new \Exception($errors);

                }
            }
            else
            {
                $errors = "Données manquantes";
                throw new \Exception($errors);
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
                    $pdf        = PDF::loadView('pdf.contrat', ['projet' => $item, 'created_at' => $created_at, 'client' => $client, 'niveaux' => $niveaux]);
                    return $pdf->setPaper('orientation')->stream();
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
    public function paypalSuccess()
    {

        // $config = [
        //     "id"  => "AYfR2ytBTo3K31b0hV7lIC3ioXz6cTuZusjKQE5XUVtyZ8E1FXikRuNQBVZfKpnqCE7Q-Jjza2y1F24c",
        //     "secrete" => "EJFiXlkNOhlt3uokThwW8VOAe4S7DE_GaeEuEXZcx2hWYYx1RbNHSINVLpBok3QIft8Csf1V8vk2tt2_"
        // ];
        $config = [
            "id"  => "AQr5DXEvYR5O3cYNLkrQAMlhHifUUtuW1UmOg3O9U8Zjy7G83IqtAKTRkF3c7UjTw6fSnD5MFvv-tmeb",
            "secrete" => "ENtF1eT4k760AvOoIh-jUqGFxbIMD-L0PdTrlCo0sG2zNhlTWfnBSPQNwdPRcYxsNPoI9_4zSxWjA8tG"
        ];
       $apiContext = new ApiContext(
           new \PayPal\Auth\OAuthTokenCredential(
               $config['id'],
               $config['secrete']
           )
       );
        $data = 0;
        $errors = null;

        $payment = Payment::get($_GET['paymentId'], $apiContext);
        $execute =( new \PayPal\Api\PaymentExecution())
                    ->setPayerId($_GET['PayerID'])
                    ->setTransactions($payment->getTransactions());
                   try {
                    $payment->execute($execute, $apiContext);

                    $id = $payment->getId();
                    $projet = Projet::find($payment->getTransactions()[0]->getCustom());

                    if(isset($id) && isset($projet))
                    {
                        $projet->etat = 2;
                        $projet->save();
                        return $projet;

                    }
                    else
                      return "erreur de paiement";
                   }
                   catch(\PayPal\Exception\PayPalConnectionException $e)
                      {
                        // var_dump(json_decode($e->getData()));
                        return response()->json(array(
                            'errors'          => config('app.debug') ? $e->getData() : Outil::getMsgError(),
                            'errors_debug'    => [$e->getData()],
                        ));
                   }
    }
    public function payment($id)
    {
        $errors = null;
        try{
            // $config = [
            //     "id"  => "AYfR2ytBTo3K31b0hV7lIC3ioXz6cTuZusjKQE5XUVtyZ8E1FXikRuNQBVZfKpnqCE7Q-Jjza2y1F24c",
            //     "secrete" => "EJFiXlkNOhlt3uokThwW8VOAe4S7DE_GaeEuEXZcx2hWYYx1RbNHSINVLpBok3QIft8Csf1V8vk2tt2_"
            // ];

            $config = [
                "id"  => "AQr5DXEvYR5O3cYNLkrQAMlhHifUUtuW1UmOg3O9U8Zjy7G83IqtAKTRkF3c7UjTw6fSnD5MFvv-tmeb",
                "secrete" => "ENtF1eT4k760AvOoIh-jUqGFxbIMD-L0PdTrlCo0sG2zNhlTWfnBSPQNwdPRcYxsNPoI9_4zSxWjA8tG"
            ];
           $apiContext = new ApiContext(
               new \PayPal\Auth\OAuthTokenCredential(
                   $config['id'],
                   $config['secrete']
               )
           );

                $projet = Projet::find($id);
                if(!isset($projet))
                {
                    $errors = "Impossible de trouver ce projet pour le payment";
                    throw new \Exception($errors);

                }

                $list = new \PayPal\Api\ItemList();
                $item_payment =  array();
                $item = (new \PayPal\Api\Item())
                ->setName($projet->name)
                ->setPrice($projet->montant)
                ->setQuantity(1)
                ->setCurrency('EUR')
                ;

                $list->addItem($item);
                $details =  (new \PayPal\Api\Details())
                      ->setSubTotal($projet->montant);

                $amount = (new \PayPal\Api\Amount())
                  ->setTotal($projet->montant)
                  ->setCurrency("EUR")
                  ->setDetails($details);

                  $transactions = (new \PayPal\Api\Transaction())
                      ->setItemList($list)
                      ->setDescription("Payment des frais pour le projet")
                      ->setInvoiceNumber(uniqid())
                      ->setAmount($amount)
                      ->setCustom($projet->id);
                   //    dd($transactions);
                   $payment = new \PayPal\Api\Payment();
                   //$payment->setIntent('sale');
                   $payment->setIntent('authorize');
                   $redirectUrls = (new  \PayPal\Api\RedirectUrls())
                   ->setReturnUrl(route('payment-execute'))
                   ->setCancelUrl('http://www.samakeur/profil/mon-profil.html');
                   $payment->setRedirectUrls($redirectUrls);

           //      On definie le payeur
                   $payment->setPayer((new \PayPal\Api\Payer())
                        ->setPaymentMethod('paypal'));
                      $payment->setTransactions([$transactions]);



                      try{

                       $response    = $payment->create($apiContext);
                       $redirectUrl = $response->links[1]->href;
                       return $redirectUrl;

                      }
                      catch(\PayPal\Exception\PayPalConnectionException $e)
                      {
                        return response()->json(array(
                            'errors'          => config('app.debug') ? $e->getData() : Outil::getMsgError(),
                            'errors_debug'    => [$e->getData()],
                        ));
                      }
        }catch(\Exception $e)
        {
            return response()->json(array(
                'errors'          => config('app.debug') ? $e->getMessage() : Outil::getMsgError(),
                'errors_debug'    => [$e->getMessage()],
            ));
        }


    }


    public function makeMontant(Request $request)
    {
        try
        {
            return DB::transaction(function() use($request)
            {
                $errors = null;
                if(empty($request->projet))
                {
                    $errors = "Données manquantes l'ID du projet";
                }
                if(empty($request->montant))
                {
                    $errors = "Données manquantes le montant du projet ";
                }
                $item = Projet::find($request->projet);
                //dd($request->projet);
                if(!isset($item))
                {
                    $errors = "Un payment avec ces identifients n'existe pas dans la base de donnée";
                }
                if($item->active == 0)
                {
                    $errors = "Veuillez valider le projet avent de mettre un prix";
                }
                if(empty($errors))
                {
                    $item->montant = $request->montant;
                    $item->save();
                 return Outil::redirectgraphql($this->queryName, "id:{$item->id}", Outil::$queries[$this->queryName]);

                }
                throw new Exception($errors);
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
    public function payeProjet($id)
    {
       try
       {
            $errors = null;
            $data = 0;
            if(isset($id))
            {
                $item = Projet::find($id);
                if(isset($item))
                {
                    $item->etat = 2;
                    $item->save();
                    $data = 1;
                }
                else
                {
                    $errors = "Projet introuvable";
                }

            }
            else
            {
                $errors = "Données manquantes";
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

    public function getResult()
    {
        try{
                $errors = null;
                $tab_resultat = array();
                $one = Projet::all()->count();
                // $one = count($one);
                $prime = Projet::where('etat', 0)->count();
                $two = Projet::where('etat', 1)->count();
                $three =  Projet::where('etat', 2)->count();

                array_push($tab_resultat, [
                    "total"=> $one,
                    "en_attente"=> $prime,
                    "encours"=> $two,
                    "finalise"=> $three
                ]);

                return $tab_resultat;
        }catch(\Exception $e)
        {
            return response()->json(array(
                'errors'          => config('app.debug') ? $e->getMessage() : Outil::getMsgError(),
                'errors_debug'    => [$e->getMessage()],
            ));
        }
    }

}

