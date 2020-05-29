<?php

namespace App\GraphQL\Type;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use App\Projet;
use App\Outil;
use Carbon\Carbon;
use App\NiveauProjet;
class ProjetType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Projet',
    ];

    public function fields(): array
    {
        return [
            'id'                     => ['type'  => Type::id()],
            'user_id'                => ['type'  => Type::int()],
            'superficie'             => ['type' => Type::int()],
            'longeur'                => ['type' => Type::int()],
            'largeur'                => ['type' => Type::int()],
            'text_projet'            => ['type'  => Type::string()],
            'fichier'                => ['type'  => Type::string()],
            'active'                 => ['type'  => Type::boolean()],
            'etat'                   => ['type'  => Type::int()],
            'user'                   => ['type' => GraphQL::type('User')],
            'niveau_projets'         => ['type' => Type::listOf(GraphQL::type('Niveauplan')), 'description' => ''],
            'remarques'              => ['type' => Type::listOf(GraphQL::type('Remarque')), 'description' => ''],
            'plan_projets'           => ['type' => Type::listOf(GraphQL::type('Planprojet')), 'description' => ''],
             
            'nb_pieces'              => ['type' => Type::int()],
            'nb_chambre'             => ['type' => Type::int()],
            'nb_toillette'           => ['type' => Type::int()],
            'nb_salon'               => ['type' => Type::int()],
            'nb_cuisine'             => ['type' => Type::int()],
            'nb_etage'               => ['type' => Type::int()],
            'a_valider'              => ['type' => Type::int()],

            'created_at'             => ['type'  => Type::string()],
            'created_at_fr'          => ['type'  => Type::string()],
            'updated_at'             => ['type'  => Type::string()],
            'updated_at_fr'          => ['type'  => Type::string()],
            'deleted_at'             => ['type'  => Type::string()],
           
        ];
    }
    public function resolveAValiderField($root, $args)
    {
        if (!isset($root['id']))
        {
            $projet_id = $root->id;
        
}        else
        {
            $projet_id = $root['id'];
        }
        $response = Projet::a_valider($projet_id);
        if($response == null)
         return 0;

        else
          return $response; 
    }
    public function resolveNbPiecesField($root, $args)
    {
        if (!isset($root['id']))
        {
            $projet_id = $root->id;
        
}        else
        {
            $projet_id = $root['id'];
        }
        $attribut = "piece";
        $nbr =  Projet::nb_attribut($projet_id, $attribut);
        return $nbr;
    }
    public function resolveNbChambreField($root, $args)
    {
         if (!isset($root['id']))
        {
            $projet_id = $root->id;
        }
        else
        {
            $projet_id = $root['id'];
        }
        $attribut = "chambre";
        $nbr =  Projet::nb_attribut($projet_id, $attribut);
        return $nbr; 
    }

    public function resolveNbSalonField($root, $args)
    {
         if (!isset($root['id']))
        {
            $projet_id = $root->id;
        }
        else
        {
            $projet_id = $root['id'];
        }
        $attribut = "salon";
        $nbr =  Projet::nb_attribut($projet_id, $attribut);
        return $nbr; 
    }

    public function resolveNbCuisineField($root, $args)
    {
        if (!isset($root['id']))
        {
            $projet_id = $root->id;
        }
        else
        {
            $projet_id = $root['id'];
        }
        $attribut = "cuisine";
        $nbr =  Projet::nb_attribut($projet_id, $attribut);
        return $nbr; 
    }
    public function resolveNbToilletteField($root, $args)
    {
         if (!isset($root['id']))
        {
            $projet_id = $root->id;
        }
        else
        {
            $projet_id = $root['id'];
        }
        $attribut = "toillette";
        $nbr =  Projet::nb_attribut($projet_id, $attribut);
        return $nbr; 
    }
    public function resolveNbEtageField($root, $args)
    {
        if (!isset($root['id']))
        {
            $projet_id = $root->id;
        }
        else
        {
            $projet_id = $root['id'];
        }
        return  NiveauProjet::where('projet_id', $projet_id)->count();
        
    }
    protected function resolveCreatedAtField($root, $args)
    {
        if (!isset($root['created_at']))
        {
            $date_at = $root->created_at;
        }
        else
        {
            $date_at = is_string($root['created_at']) ? $root['created_at'] : $root['created_at']->format(Outil::formatdate());
        }
        return $date_at;
    }
    protected function resolveUpdatedAtField($root, $args)
    {
        if (!isset($root['updated_at']))
        {
            $date_at = $root->updated_at;
        }
        else
        {
            $date_at = is_string($root['updated_at']) ? $root['updated_at'] : $root['updated_at']->format(Outil::formatdate());
        }
        return $date_at;
    }
    protected function resolveCreatedAtFrField($root, $args)
    {
        if (!isset($root['created_at']))
        {
            $created_at = $root->created_at;
        }
        else
        {
            $created_at = $root['created_at'];
        }
        return Carbon::parse($created_at)->format('d/m/Y ');
    }

}