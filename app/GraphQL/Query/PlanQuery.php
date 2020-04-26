<?php

namespace App\GraphQL\Query;

use App\Plan;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;


class PlanQuery extends Query
{
    protected $attributes = [
        'name' => 'plans'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Plan'));
    }

    public function args(): array 
    {
        return
        [
            'id'                     => ['type' => Type::id()],
            'superficie'             => ['type' => Type::int()],
            'longeur'                => ['type' => Type::int()],
            'largeur'                => ['type' => Type::int()],
          
            'created_at'             => [ 'type' => Type::string()],
            'created_at_fr'          => [ 'type' => Type::string()],
            'updated_at'             => [ 'type' => Type::string()],
            'updated_at_fr'          => [ 'type' => Type::string()],
            'deleted_at'             => [ 'type' => Type::string()],

           
        ];
        
    }

    public function resolve($root, $args)
    {
       $query = Plan::with('niveau_plans');

       if (isset($args['id']))
       {
          $query = $query->where('id', $args['id']);
       }
       if (isset($args['superficie']))
       {
          $query = $query->where('superficie', $args['superficie']);
       }
       if (isset($args['longeur']))
       {
          $query = $query->where('longeur', $args['longeur']);
       }
       if (isset($args['largeur']))
       {
          $query = $query->where('largeur', $args['largeur']);
       }
       if (isset($args['piscine']))
       {
          $query = $query->where('piscine', $args['piscine']);
       }
       $query = $query->get();
       return $query->map(function (Plan $item)
       {
           return 
           [
            'id'                     => $item->id,
            'superficie'             => $item->superficie,
            'longeur'                => $item->longeur,
            'largeur'                => $item->largeur,
            'piscine'                => $item->piscine,
            'niveaus'                => $item->niveaus,
            'planprojets'            => $item->planprojets,
            'created_at'             => $item->created_at,
        ];
      });
    }
}
