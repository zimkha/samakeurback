<?php

namespace App\GraphQL\Query;

use App\Outil;
use App\Projet;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;


class ProjetQuery extends Query
{
    protected $attributes = [
        'name' => 'projets'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Projet'));
    }

    public function args(): array 
    {
        return
        [
            'id'                     => ['type'  => Type::id()],
            'user_id'                => ['type'  => Type::int()],
            'text_projet'            => ['type'  => Type::string()],
            'fichier'                => ['type'  => Type::string()],
            'active'                 => ['type'  => Type::boolean()],
            'etat'                   => ['type'  => Type::int()],
            'superficie'             => ['type' => Type::int()],
            'longeur'                => ['type' => Type::int()],
            'largeur'                => ['type' => Type::int()],
          
            'created_at'             => ['type'  => Type::string()],
            'created_at_fr'          => ['type'  => Type::string()],
            'updated_at'             => ['type'  => Type::string()],
            'updated_at_fr'          => ['type'  => Type::string()],
            'deleted_at'             => ['type'  => Type::string()],

           
        ];
        
    }

    public function resolve($root, $args)
    {
       $query = Projet::with('niveau_projets');

       if (isset($args['id']))
       {
          $query = $query->where('id', $args['id']);
       }
       if (isset($args['user_id']))
       {
          $query = $query->where('user_id', $args['user_id']);
       }
       if (isset($args['active']))
       {
          $query = $query->where('active', $args['active']);
       }
       if (isset($args['etat']))
       {
          $query = $query->where('etat', $args['etat']);
       }
      
       $query = $query->get();
       return $query->map(function (Projet $item)
       {
           return 
           [
            'id'                     => $item->id,
            'user_id'                => $item->user_id,
            'superficie'             => $item->superficie,
            'longeur'                => $item->longeur,
            'largeur'                => $item->largeur,
            'user'                   => $item->user,
            'active'                 => $item->active,
            'text_projet'            => $item->text_projet,
            'fichier'                => $item->fichier,
            'etat'                   => $item->etat,
            'niveau_projets'         => $item->niveau_projets,
            'planprojets'            => $item->planprojets,
            'created_at'             => $item->created_at,
        ];
      });
    }
}
