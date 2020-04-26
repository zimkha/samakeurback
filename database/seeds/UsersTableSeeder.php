<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = array();
        array_push($users,array("name" => "root" , "email" => "root@samakeur.sn" , "image" =>  ('assets/images/upload.jpg') , "password" => "root"));
        array_push($users,array("name" => "moustapha" , "email" => "moustapha@gmail.com" , "image" =>  ('assets/images/upload.jpg') , "password" => "guindy"));
        array_push($users,array("name" => "thiame" , "email" => "thiame11@gmail.com" , "image" =>  ('assets/images/upload.jpg') , "password" => "passer"));
        

        foreach ($users as $user)
        {
            $newuser = User::withTrashed()->where('email', $user['email'])->first();
            if (!$newuser)
            {
                $newuser = new User();
                $newuser->active = 1;
                $newuser->password = bcrypt($user['password']);
            }
            $newuser->name = $user['name'];
            $newuser->email = $user['email'];
            $newuser->image = $user['image'];
            $newuser->save();
        }


        $users = User::all();
        foreach ($users as $user)
        {
            if ($user->name == "moustapha" || $user->name == "thiame" )
            {
                $user->syncRoles('super-admin');
            }
        }

    }
}
