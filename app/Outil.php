<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Outil extends Model
{
    public static function getMsgError()
    {
        return config('env.MSG_ERROR');
    }

    public static function getAPI()
    {
        return config('env.APP_URL');
    }


    public static function getResponseError(\Exception $e)
    {
        return response()->json(array(
            'errors'          => [config('env.APP_ERROR_API') ? $e->getMessage() : config('env.MSG_ERROR')],
            'errors_debug'    => [$e->getMessage()],
            'errors_line'    => [$e->getLine()],
        ));
    }
    public static function getPdf($queryName, $id_critere, $justone = true)
    {
       $data = Outil::getOneItemWithGraphQl($queryName, $id_critere, $justone);

        return PDF::loadView("pdfs.{$queryName}", $data);
    }

    public static $queries = array(
        "plans"                         => "id,fichier,superficie,longeur,largeur,nb_pieces,nb_salon,nb_chambre,nb_cuisine,nb_toillette,nb_etage,niveau_plans{id,niveau,piece,bureau,toillette,chambre,salon,cuisine}",

        "planprojets"                   => "id,plan_id,projet_id,etat_active,message,etat,plan{id}",

        "niveauplans"                   => "id,niveau,piece,bureau,toillette,chambre,salon,cuisine",

        "niveauprojets"                 => "id,niveau,piece,bureau,toillette,chambre,salon,cuisine",

        "projets"                       => "id,superficie,longeur,largeur,nb_pieces,nb_salon,nb_chambre,nb_cuisine,nb_toillette,nb_etage,niveau_projets{id,piece,bureau,toillette,chambre,salon,cuisine},user_id,user{id,name},plan_projets{id,plan_id,plan{id,fichier,superficie,longeur,largeur,nb_pieces,nb_salon,nb_chambre,nb_cuisine,nb_toillette,nb_etage}}",
        
        "typeremarques"                 => "id,name",

        "remarques"                     => "id,type_remarque_id,demande_text,projet_id",

        "users"                         => "id,name,email,active,password,image,nom,prenom,adresse_complet,pays,code_postal,is_client,telephone,roles{id,name,guard_name,permissions{id,name,display_name,guard_name}},last_login,last_login_ip,created_at_fr",

        "roles"                         => "id,name,guard_name,permissions{id,name,display_name,guard_name}",

        "unitemesures"                  => "id,name"

       
    );

    public static function formatdate()
    {
        return "Y-m-d H:i:s";
    }

    public static function redirectgraphql($itemName, $critere, $liste_attributs)
    {
        $path = '{' . $itemName . '(' . $critere . '){' . $liste_attributs . '}}';
        return redirect('graphql?query='.urlencode($path));
    }

    public static function isUnique(array $columnNme, $value, $id, $model)
    {
        if (isset($id))
        {
            $query = app($model)->where('id', '!=', $id);
        }
        else
        {
            $query = app($model);
        }
        for ($i = 0; $i < count($columnNme); $i++)
        {
            $query = $query->where($columnNme[$i], $value[$i]);
        }
        return $query->first() == null;
    }

    public function saveModel(array $request, $model, array $columnNme)
    {
        try {
            DB::transaction(function () use ($request, $model, $columnNme) {
                $newmodel = new app($model);
                if (isset($requets->id)) {
                    $newmodel = app($model)->findOrFail($request->id);
                }
                for ($i = 0; $i < count($columnNme); $i++) {
                    $newmodel->$columnNme[$i] = $request[$i];
                }
                $newmodel->save();
            });
        } catch (\Exception $e) {

        }
    }

    public static function validateDate($date, $format= 'Y-m-d')
    {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    public static function generateCode($n)
    {
        $characters = '0123456789abcdefghijkABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }
    public static function getOneItemWithGraphQl($queryName, $id_critere, $justone = true)
    {
        $guzzleClient = new \GuzzleHttp\Client([
            'defaults' => [
                'exceptions' => true
            ]
        ]);

        $critere = (is_numeric($id_critere)) ? "id:{$id_critere}" : $id_critere;
        $queryAttr = Outil::$queries[$queryName];

        $response = $guzzleClient->get(Outil::getAPI()."/graphql?query={{$queryName}({$critere}){{$queryAttr}}}");
        $data = json_decode($response->getBody(), true);
        //dd($data);
        return ($justone) ? $data['data'][$queryName][0] : $data;
    }

    public static function getItemsWithGraphQl($queryName, $critere)
    {
        $guzzleClient = new \GuzzleHttp\Client([
            'defaults' => [
                'exceptions' => true
            ]
        ]);
        $queryAttr = Outil::$queries[$queryName];


        $response = isset($critere) ? $guzzleClient->get(Outil::getAPI()."/graphql?query={{$queryName}({$critere}){{$queryAttr}}}") : $guzzleClient->get(Outil::getAPI()."/graphql?query={{$queryName}{{$queryAttr}}}");


        $data = json_decode($response->getBody(), true);
        //dd($data);
        return $data;
    }

    public static function getOperateurLikeDB()
    {
        return config('database.default')=="mysql" ? "like" : "ilike";
    }

    public static function validation($request,Array $array)
    {
        $errors = null;
        foreach($array as $item)
        {
            if ($request->$item == null ) {
               $errors = "veuillez renseigner le champs {$item}";
            }
        }
        if ($errors != null) {
            throw new \Exception($errors);
        }
        return $errors;
    }
    public static function validat(Array $array)
    {
        $errors = null;
       foreach ($array as  $value) {
         
           foreach ($value as $key => $item) {
               if (isset($key)) {
                   dd('c pas vide');
               }
               else
                 dd('c vide');
           }
       }
    }

}
