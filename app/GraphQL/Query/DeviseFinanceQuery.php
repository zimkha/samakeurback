<?php

namespace App\GraphQL\Query;

use App\DeviseEstime;
use Carbon\Carbon;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class DeviseFinanceQuery extends Query
{
    protected $attributes = [
        'name' => 'devisefinances'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Devisefinance'));
    }

    public function fields(): array
    {
        return [

            'id'                     => [ 'type' => Type::id()],
            'chantier_id'            => [ 'type' => Type::int()],
            'etat'                   => [ 'type' => Type::int()],
            'fichier'                => [ 'type' => Type::string(),],
            'created_at'             => [ 'type' => Type::string()],
            'created_at_fr'          => [ 'type' => Type::string()],
            'updated_at'             => [ 'type' => Type::string()],
            'updated_at_fr'          => [ 'type' => Type::string()],
                     
        ];
    }
    public function resolve($root, $args)
    {
       $query = DeviseFinance::with('chantier');

      
       if (isset($args['id']))
       {
          $query = $query->where('id', $args['id']);
       }
       if (isset($args['etat']))
       {
          $query = $query->where('etat', $args['etat']);
       }
       if (isset($args['chantier_id']))
       {
          $query = $query->where('chantier_id', $args['chantier_id']);
       }
      
       $query = $query->get();
       return $query->map(function (DeviseFinance $item)
       {
           return 
           [
            'id'                     => $item->id,
            'fichier'                => $item->fichier,
            'etat'                   => $item->etat,
            'chantier_id'            => $item->chantier_id,
            'chantier'               => $item->chantier,
        ];
      });
    }
  
}