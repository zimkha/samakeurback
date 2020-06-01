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
    public function login(Request $request)
    {
        $email    = $request->login;
        $password = $request->password;

        $client = User::where('email', $email)->first();
        dd($client);
        if (!isset($client))
        {
            return response()->json(array(
                'data' => NULL,
                'errors' => 'Aucun compte associé à cet email',
            ));
        }
        else if (!Hash::check($password,$client->password))
        {
            return  response()->json(array(
                'data' => NULL,
                'errors' => 'login ou mot de passe incorrect',
            ));
        }

        if ($client->activ==false)
        {
            return  response()->json(array(
                'data' => NULL,
                'errors' => 'Votre compte n\'a pas encore été activé<br><br>Un lien d\'activation vous a été envoyé dans votre boite mail',
            ));
        }

        $client = Outil::getOneItemWithGraphQl($this->queryName, $client->id, true);;

        return  response()->json(array(
            'data' => $client,
            'success' => 'Vous etes connecté',

        ));
    }

}
