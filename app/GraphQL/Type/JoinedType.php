<?php

namespace App\GraphQL\Type;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use App\Joined;
use App\NiveauPlan;
class JoinedType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Joined',
    ];

    public function fields(): array
    {
        return [
            'id'                     => ['type' => Type::id()],
            'plan_id'                => ['type' => Type::int()],
            'fichier'                => [ 'type' => Type::string(), 'description' => ''],
            'active'                 => ['type' => Type::boolean()], 
            'description'            => [ 'type' => Type::string()],
            'created_at'             => [ 'type' => Type::string()],
            'created_at_fr'          => [ 'type' => Type::string()],
            'updated_at'             => [ 'type' => Type::string()],
            'updated_at_fr'          => [ 'type' => Type::string()],
            'deleted_at'             => [ 'type' => Type::string()],
            'plan'                   => ['type' => GraphQL::type('Plan')],

            // Resolve 
           

          
           
        ];
    }

  
}