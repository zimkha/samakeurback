<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            array("name" => "liste-role", "display_name" => "Voir la liste des profils"),
            array("name" => "creation-role", "display_name" => "Créer un profil"),
            array("name" => "modification-role", "display_name" => "Modification d'un profil"),
            array("name" => "suppression-role", "display_name" => "supprimer un profil"),

            array("name" => "liste-plan", "display_name" => "Voir la liste des plans"),
            array("name" => "creation-plan", "display_name" => "Créer un plan"),
            array("name" => "modification-plan", "display_name" => "Modification d'un plan"),
            array("name" => "suppression-plan", "display_name" => "supprimer un plan"),

            array("name" => "liste-projet", "display_name" => "Voir la liste des projets"),
            array("name" => "creation-projet", "display_name" => "Créer un projets"),
            array("name" => "modification-projet", "display_name" => "Modification d'un projets"),
            array("name" => "suppression-projet", "display_name" => "supprimer un projets"),

            array("name" => "liste-users", "display_name" => "Voir la liste des utilisateur ou client"),
            array("name" => "creation-users", "display_name" => "Créer un utilisateur ou client"),
            array("name" => "modification-users", "display_name" => "Modification d'un utilisateur ou client"),
            array("name" => "suppression-users", "display_name" => "supprimer un utilisateur ou client"),

            array("name" => "creation-fichier", "display_name" => "Créer un fihier joint"),
            array("name" => "modification-fichier", "display_name" => "Modification un fihier joint"),
            array("name" => "suppression-fichier", "display_name" => "supprimer un fihier joint"),
        ];

        foreach ($permissions as $permission)
        {
            $newitem = Permission::where('name', $permission['name'])->first();
            
            if (!isset($newitem))
            {
                Permission::create(['name' => $permission['name'], 'display_name' => $permission['display_name']]);
            }
            else
            {
                $newitem->display_name = $permission['display_name'];
                $newitem->save();
            }
        }
    }
}
