<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Support\Arr;
use App\Plan;
class PlanPaginatedQuery extends Query
{
    protected $attributes = [
        'name' => 'planspaginated'
    ];

    public function type(): Type
    {

        return GraphQL::type('planpaginated');
    }

    public function args(): array 
    {
        return
        [
            'id'                     => ['type' => Type::id()],
            'fichier'                 => [ 'type' => Type::string(), 'description' => ''],
            'superficie'             => ['type' => Type::int()],
            'longeur'                => ['type' => Type::int()],
            'largeur'                => ['type' => Type::int()],
            'fichier'                => ['type' => Type::string()],
            'piscine'                => ['type' => Type::int()],
            'created_at'             => [ 'type' => Type::string()],
            'created_at_fr'          => [ 'type' => Type::string()],
            'updated_at'             => [ 'type' => Type::string()],
            'updated_at_fr'          => [ 'type' => Type::string()],
            'deleted_at'             => [ 'type' => Type::string()],

            'page'                => ['type' => Type::int()],
            'count'               => ['type' => Type::int()]
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
       
       $count = Arr::get($args, 'count', 10);
       $page  = Arr::get($args, 'page', 1);

       return $query->orderBy('created_at', 'desc')->paginate($count, ['*'], 'page', $page);
       
    }
}
