<?php
namespace App\GraphQL\Query;

use App\Outil;
use App\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;


class UserQuery extends Query
{
    protected $attributes = [
        'name' => 'users',
        'description' => ''
    ];

    public function type():Type
    {
        // result of query with pagination laravel
        return Type::listOf(GraphQL::type('User'));
    }

    // arguments to filter query
    public function args(): array 
    {
        return
            [
                'id'                    => ['type' => Type::int()],
                'role_id'               => ['type' => Type::int()],
                'active'                => ['type' => Type::boolean()],
                'name'                  => ['type' => Type::string()],
                'email'                 => ['type' => Type::string()],
            ];
    }

    public function resolve($root, $args)
    {
        $query = User::with('roles')->where('is_client', '!=', false);
        if(isset($args['id']))
        {
            $query = $query->where('id', $args['id']);
        }
        if(isset($args['active']))
        {
            $query = $query->where('active', $args['active']);
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

        $query = $query->get();

        return $query->map(function (User $item)
        {
            return
                [
                    'id'                  => $item->id,
                    'name'                => $item->name,
                    'email'               => $item->email,
                    'image'               => $item->image,
                    'password'            => $item->password,
                    'last_login'          => $item->last_login,
                    'last_login_ip'       => $item->last_login_ip,
                    'created_at'          => $item->created_at->format(Outil::formatdate()),
                    'updated_at'          => $item->updated_at->format(Outil::formatdate()),
                    'deleted_at'          => empty($item->deleted_at) ? $item->deleted_at : $item->deleted_at->format(Outil::formatdate()),

                    'roles'               => $item->roles,

                   
                ];
        });
    }
}
