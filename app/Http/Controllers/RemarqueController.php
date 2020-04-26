<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Outil;

class RemarqueController extends Controller
{
    protected $queryName = "remarques";
    public function save(Request $request)
    {
       try
       {
        return DB::transaction(function () use($request) {
           $errors = null;
           $item = new Remarque();
           if(isset($request->id))
           {
               $item = Remarque::find($request->id);
           }
           if(empty($request->projet))
           {
               $errors = "Une remarque concerne un projet client";
           }
           if(empty($request->type_remarque))
           {
            $errors = "Veuillez renseigner le type de remarque";
           }
           if (isset($request->demande_text)) {
            $errors = "Veuillez renseigner vos remarques";
           }
           if (!isset($errors)) {
               $item->type_remarque_id = $request->type_remarque;
               $item->demande_text      = $request->demande_text;
               $item->projet_id         = $request->projet;
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
    public function delete($id)
    {
        try{
            return DB::transaction(function () use($id) {
                $errors = null;
                $data = 0;
                if (isset($id)) {
                    $item = Remarque::find($id);
                     if (isset($item)){
                         $item->delete();
                         $item->forceDelete();
                         $data = 1;
                     }
                     else 
                        $errors = "Impossible de supprimer, la donnée est introuvable";
                }
                else
                    $errors = "Données manquante";
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
        }catch(\Exception $e)
        {
            return response()->json(array(
                'errors'          => config('app.debug') ? $e->getMessage() : Outil::getMsgError(),
                'errors_debug'    => [$e->getMessage()],
            ));
        }
    }
}
