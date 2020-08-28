<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Outil;
use App\Chantier;
class ChantierController extends Controller
{
    public function save(Request $request)
    {
        return DB::transaction(function() use($request)
        {
            try {
                $errors = null;
                $item = new Chantier();
                 if(isset($request->id))
                 {
                     $item = Chantier::find($request->id);
                 }
                if(empty($request->user))
                {
                    $errors = "Erreur Server: client introuvable";
                }
                if(empty($request->fichier))
                {
                    $errors = "Veuillez renseigner le fichier du plan (seule les PDFs sont accepte)";
                }
               
                    // Enregistrement des données provenat du client
                    $item->user_id = $request->user;
                    $fichier = $_FILES['fichier']['name'];
                    $fichier_tmp = $_FILES['fichier']['tmp_name'];
                    $ext = explode('.', $fichier);
    
                    if (end($ext) == "pdf" ) 
                    {
                            $count = count(Chantier::all());
                            $rename = config('view.uploads')['piecejointes'] . "/piecejointe_chantier" . ($count + 1) . "." . end($ext);
                            move_uploaded_file($fichier_tmp, $rename);
                            $item->fichier = $rename;
                            $item->save(); 
                        return Outil::redirectgraphql($this->queryName, "id:{$item['id']}", Outils::$queries[$this->queryName]);
                    }
                    else
                    {
                       $errors = "Ce type de fichier n'est pas pris en charge.";
                    }
                    throw new \Exceprion($erros);
            } catch (\Exception $e) 
            {
                return response()->json(array(
                    'errors'          => config('app.debug') ? $e->getMessage() : Outil::getMsgError(),
                    'errors_debug'    => [$e->getMessage()],
                ));
            }
        });
    }

    public function delete($id)
    {
        return DB::transaction(function() use($id)
        {
            try {
                
            } catch (\Exception $e)
             {
                return response()->json(array(
                    'errors'          => config('app.debug') ? $e->getMessage() : Outil::getMsgError(),
                    'errors_debug'    => [$e->getMessage()],
                ));
            }
        });
    }
}
