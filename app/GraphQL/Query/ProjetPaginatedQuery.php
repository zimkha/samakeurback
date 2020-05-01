<?php

namespace App\GraphQL\Query;

use App\Outil;
use App\Projet;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Support\Arr;


class ProjetPaginatedQuery extends Query
{
    protected $attributes = [
        'name' => 'projetspaginated'
    ];

    public function type(): Type
    {
        return GraphQL::type('projetpaginated');
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
          
            'created_at'             => ['type'  => Type::string()],
            'created_at_fr'          => ['type'  => Type::string()],
            'updated_at'             => ['type'  => Type::string()],
            'updated_at_fr'          => ['type'  => Type::string()],
            'deleted_at'             => ['type'  => Type::string()],
            'page'                => ['type' => Type::int()],
            'count'               => ['type' => Type::int()]

           
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
      
       $count = Arr::get($args, 'count', 10);
       $page  = Arr::get($args, 'page', 1);

       return $query->orderBy('created_at', 'desc')->paginate($count, ['*'], 'page', $page);
    }
}
