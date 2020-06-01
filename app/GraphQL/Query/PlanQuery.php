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
            'fichier'                 => [ 'type' => Type::string(), 'description' => ''],
            'unite_mesure_id'        => ['type' => Type::id()],
            'superficie'             => ['type' => Type::int()],
            'longeur'                => ['type' => Type::int()],
            'largeur'                => ['type' => Type::int()],
            'fichier'                => ['type' => Type::string()],
            'piscine'                => ['type' => Type::int()],
            'nb_pieces'                => ['type' => Type::int()],
            'nb_chambre'                => ['type' => Type::int()],
            'nb_toillette'                => ['type' => Type::int()],
            'nb_salon'                => ['type' => Type::int()],
            'nb_cuisine'                => ['type' => Type::int()],
            'nb_etage'                => ['type' => Type::int()],
            
          
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
       if (isset($args['nb_pieces'])) {
          $query = $query->whereIn('id');
       }
       $query = $query->get();
       return $query->map(function (Plan $item)
       {
           return 
           [
            'id'                     => $item->id,
            'fichier'                => $item->fichier,
            'unite_mesure_id'        => $item->unite_mesure_id,
            'code'                   => $item->code,
            'superficie'             => $item->superficie,
            'longeur'                => $item->longeur,
            'largeur'                => $item->largeur,
            'piscine'                => $item->piscine,
            'fichier'                => $item->fichier,
            'niveau_plans'           => $item->niveau_plans,
            'plan_projets'            => $item->plan_projets,
            'created_at'             => $item->created_at,
        ];
      });
    }
}
