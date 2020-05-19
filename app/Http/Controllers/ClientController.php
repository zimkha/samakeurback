<?php

namespace App\Http\Controllers;

use App\User;
use App\Outil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;

class ClientController extends Controller
{
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
    public function connexion(Request $request)
    {
       try
       {
         $errors = null;
         $data = null;
         $user_email = $request->email;
         $password   = $request->password;
         $user = User::where('email', $user_email)->first();
         if(isset($user))
         {
             if(Hash::check($password, $user->password))
             {
                if($user->active == 0 || $user->active == false)
                {
                   $errors = "votre compte n'est pas encore activé";
                   return response()->json([
                       'data' => $data,
                       'errors' => $errors
                   ], 200);
                }
                else
                 {
                   // Si tout se passe bien
                  
                   return response()->json([
                    'data' => $user,
                    'message' => ["connexion réussi"]
                ], 200);
                 }
             }
             else
             {
                return response()->json([
                    'data' => null,
                    'errors' => ["mot de passe incorrect"]
                ], 200);
             } 
         }
         else
         {
            return response()->json([
                'data' => null,
                'errors' => ["email incorrecte"]
            ], 200);
         }
         
       }
       catch(\Exception $e)
       {
        return Outil::getResponseError($e);
       }
    }
   
}
