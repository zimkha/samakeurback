<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Contrat;
class ContratController extends Controller
{
    public function save(Request $request)
    {
        try
        {
            return DB::transaction(function() use($request)
            {
                $errors = null;
                $user = Auth::user();
                if(empty($request->projet))
                {
                    $errors = "Veuillez preciser un projet valide";
                }

            });
        }
        catch(\Exception $e)
        {

        }
    }
}
