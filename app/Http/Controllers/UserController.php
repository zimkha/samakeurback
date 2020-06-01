<?php

namespace App\Http\Controllers;

use App\Pays;
use App\User;
use App\Outil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    private $queryName = "users";

    public function save(Request $request)
    {
        try
        {
            return DB::transaction(function () use ($request)
            {
                $errors=null;
                $user = new User();
                if (!empty($request->id))
                {
                    $user = User::find($request->id);
                }
                else
                {
                    $user->active = false;
                }

               if(empty($request->nom) || empty($request->prenom) || empty($request->telephone) ||  empty($request->email) || empty($request->confirmemail))
               {
                   $errors = "Veuillez remplire tous les champs du formulaire";
               }
               
                    if (empty($request->password) || empty($request->confirmpassword))
                    {
                        $errors = "Veuillez remplir tous les mots de passe";
                    }
                

                if(!empty($request->password) && $request->password!= $request->confirmpassword)
                {
                    $errors = "les deux mots de passe ne correspondent pas";
                }
                if(!empty($request->email) && $request->email!= $request->confirmemail)
                {
                    $errors = "L'email de confirmation n'est pas le même email";
                }

                if (empty($request->id))
                {
                    if(!Outil::isUnique(['email'], [$request->email], $request->id, User::class))
                    {
                        $errors = "Cet email existe déja";
                    }
                }

                  $user->name = $request->nom;
                  $user->nom = $request->nom;
                  $user->prenom = $request->prenom;
                  $user->telephone = $request->telephone;
                  $user->email = $request->email;
                  $user->is_client = true;
                !empty($request->password) ? $user->password = bcrypt($request->password) : '' ;

                $role = Role::find($request->role);
                if (!isset($errors) && $user->save())
                {
                    
                    $user->save();
                    $id = $user->id;
                    return response()->json(array(
                        'data' => $user,
                        'success' => "inscription réussi",
                    ));

                    // return Outil::redirectgraphql($this->queryName, "id:{$id}", Outil::$queries[$this->queryName]);
                }
                return response()->json(['errors' => $errors]);
            });
        }
        catch (\Exception $e)
        {
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

        public function resave(Request $request)
        {
            try
            {
                return DB::transaction(function () use($request){
                    $errors = null;
                    if (empty($request->id)) 
                    {
                        $errors = "veuillez contacter le service technique";
                    }
                    
                    $item = User::find($request->id);
                    if(isset($item))
                    {
                        if(isset($request->nom))
                        {
                            $item->nom = $request->nom;
                        }
                        if(isset($request->prenom))
                        {
                            $item->prenom = $request->prenom;
                        }
                        if(isset($request->code_postal))
                        {
                            $item->code_postal = $request->code_postal;
                        }
                        if(isset($request->telephone))
                        {
                            $item->telephone = $request->telephone;
                        }
                        if(isset($request->pays))
                        {
                            $pays = Pays::find($request->pays);
                            if ($pays) {
                                $item->pays = $pays->nom_fr_fr;
                            }
                        }
                        if(isset($request->adresse_complet))
                        {
                            $item->adresse_complet = $request->adresse_complet;
                        }

                    }
                    if(!isset($errors))
                    {
                        $item->save();
                        return Outil::redirectgraphql($this->queryName, "id:{$item->id}", Outil::$queries[$this->queryName]);

                    }
                    throw new \Exception($errors);
                });
            }catch(\Exception $e)
            {
                return response()->json(['errors' => $e->getMessage()]);
            }
        }
    public function statut(Request $request)
    {
        $errors = null;
        $data = 0;

        try
        {
            // dd($request->all());
            $user = User::find($request->id);
            if ($user != null)
            {
                $user->active = $request->etat;
            }
            else
            {
                $errors = "Cet utilisateur n'existe pas";
            }

            // dd($user->active);
            if (!isset($errors) && $user->save())
            {
                $data = 1;
            }
            else
                throw new \Exception($errors);
        }
        catch (\Exception $e)
        {
            $errors = "Vérifier les données fournies";
        }
        return response('{"data":' . $data . ', "errors": "'. $errors .'" }')->header('Content-Type','application/json');
    }

    public function delete($id)
    {
        try
        {
            return DB::transaction(function () use ($id)
            {
                $errors = null;
                $data = 0;

                if($id)
                {
                    $user = User::with('projets')->find($id);
                    if ($user!=null && $user->is_client == 1)
                    {
                        $dataliason = true;
                        if (count($user->projets)==0)
                        {
                            $user->delete();
                            $user->forceDelete();
                            $data = 1;
                            $dataliason = false;
                        }

                        if ($dataliason)
                        {
                            $data = 0;
                            $errors = "Cet utilisateur à des données à son actif:  ".count($user->projets)." projets";
                        }
                    }
                    else
                    {
                        $data = 0;
                        $errors = "Utilisateur inexistant";
                    }
                }
                else
                {
                    $errors = "Données manquantes";
                }

                if (isset($errors))
                {
                    throw new \Exception('{"data": null, "errors": "'. $errors .'" }');
                }
                return response('{"data":' . $data . ', "errors": "'. $errors .'" }')->header('Content-Type','application/json');
            });
        }
        catch (\Exception $e)
        {
            return response($e->getMessage())->header('Content-Type','application/json');
        }
    }
    public function  testesave(Request $request)
    {

       /* $this->validate($request, [

            'name' => 'required',

            'email' => 'required|email|unique:users,email',

            'password' => 'required|same:confirm-password',

            'roles' => 'required'

        ]);

*/

        $input = $request->all();

        $input['password'] = Hash::make($input['password']);


        $user = User::create($input);
        $user->save();
        $user->assignRole($request->input('roles'));

        return 'ok';
        //  return redirect()->route('users.index')

        //       ->with('success','User created successfully');
    }

    public function update(Request $request, $id)

    {

       try{
            return DB::transaction(function ()use($request, $id){
                $errors = null;
                $input = $request->all();

                if(!empty($input['password'])){

                    $input['password'] = Hash::make($input['password']);

                }else{

                    $input = array_except($input,array('password'));

                }
                if(!Outil::isUnique(['email'], [$request->email], $request->id, User::class))
                {
                    $errors = "Cet email existe déja";
                    return $errors;
                }


                $user = User::find($id);
                if ($user==null)
                    return "Impossible de trouve cette utilsateur avec ces identifiants";

                $user->update($input);

                DB::table('model_has_roles')->where('model_id',$id)->delete();


                $user->assignRole($request->input('roles'));
                return $user;
               // return Outil::redirectgraphql($this->queryName, "id:{$user->id}", Outil::$queries[$this->queryName])
            });
       }catch(\Exception $e)
       {
         return response()->json($e->getMessage())->header('Content-Type', 'application/json');
       }

    }
}
