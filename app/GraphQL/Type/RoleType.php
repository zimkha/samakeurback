<?php

namespace App\GraphQL\Type;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;


class RoleType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Role',
        'description' => ''
    ];

    public function fields(): array 
    {
        return
        [
            'id'                    => ['type' => Type::id(), 'description' => ''],
            'name'                  => ['type' => Type::string(), 'description' => ''],
            'guard_name'            => ['type' => Type::string(), 'description' => ''],
            'permissions'           => ['type' => Type::listOf(GraphQL::type('Permission')), 'description' => ''],


            'created_at'            => [ 'type' => Type::string(), 'description' => ''],
            'created_at_fr'         => [ 'type' => Type::string(), 'description' => ''],
            'updated_at'            => [ 'type' => Type::string(), 'description' => ''],
            'updated_at_fr'         => [ 'type' => Type::string(), 'description' => ''],
            'deleted_at'            => [ 'type' => Type::string(), 'description' => ''],
            'deleted_at_fr'         => [ 'type' => Type::string(), 'description' => ''],
        ];
    }
}
