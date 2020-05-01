<?php

namespace App\GraphQL\Query;

use App\Outil;
use App\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Support\Arr;


class UserPaginatedQuery extends Query
{
    protected $attributes = [
        'name' => 'userspaginated'
    ];

    public function type(): Type
    {
        return GraphQL::type('userpaginated');
    }

    public function args(): array
    {
        return
            [
                'id'                           => ['type' => Type::int()],
                'name'                         => ['type' => Type::string()],
                'email'                        => ['type' => Type::string()],
                'search'                       => ['type' => Type::string()],
                'role_id'                      => ['type' => Type::int()],
                'page'                         => ['type' => Type::int()],
                'count'                        => ['type' => Type::int()],
            ];
    }

    public function resolve($root, $args)
    {
        $query = User::with('roles');

        if(isset($args['id']))
        {
            $query = $query->where('id', $args['id']);
        }
        if (isset($args['role_id']))
        {
            $role_id = $args['role_id'];
            $query = $query->whereHas('roles', function ($query) use ($role_id)
            {
                $query->where('id', $role_id);
            });
        }
        if (isset($args['name']))
        {
            $query = $query->where('name', Outil::getOperateurLikeDB(), '%'.$args['name'].'%');
        }
        if (isset($args['email']))
        {
            $query = $query->where('email', Outil::getOperateurLikeDB(), '%'.$args['email'].'%');
        }
        if (isset($args['search']))
        {
            $query = $query->where('name', Outil::getOperateurLikeDB(),'%'. $args['search'] . '%')
                ->orWhere('email', Outil::getOperateurLikeDB(),'%'. $args['search'] . '%');
        }


        $count = Arr::get($args, 'count', 10);
        $page  = Arr::get($args, 'page', 1);


        return $query->orderBy('id', 'desc')->paginate($count, ['*'], 'page', $page);
    }


}
