<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Outil;
use App\Projet;
class ProjetController extends Controller
{
    public function save(Request $request)
    {
        try
        {
            return DB::transaction(function () use($request) {
                $errors = null;
                $item  = new Projet();
                if (isset($request->id)) {
                    $item = Projet::find($id);
                }
                if (empty($request->user)) {
                    $errors = "Veuilez definir le client pour ce projet";
                }
            });
        }
        catch(\Excepetion $e)
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
                
            });
        }
        catch(\Excepetion $e)
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
        catch(\Excepetion $e)
        {
            return response()->json(array(
                'errors'          => config('app.debug') ? $e->getMessage() : Outil::getMsgError(),
                'errors_debug'    => [$e->getMessage()],
            ));
        }
    }
    public function status($id)
    {
        try
        {
            return DB::transaction(function () use($id) {
                
            });
        }
        catch(\Excepetion $e)
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
        catch(\Excepetion $e)
        {
            return response()->json(array(
                'errors'          => config('app.debug') ? $e->getMessage() : Outil::getMsgError(),
                'errors_debug'    => [$e->getMessage()],
            ));  
        }
    }
    
}
