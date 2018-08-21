<?php

namespace App\GraphQL\Mutation;

use Folklore\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL;
use App\User;

class UpdateUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'UpdateUserMutation',
        'description' => 'Actualiza un usuario dado el id y los parámetros a modificar'
    ];

    public function type()
    {
        return GraphQL::type('UserType');
    }

    public function args()
    {
        return [
            'id' => [
                'type' => Type::int(),
                'description' => 'Identificador del usuario'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'Nombre del usuario'
            ],
            'email' => [
                'type' => Type::string(),
                'description' => 'Email del usuario',
                'rules' => ['email', 'unique:users']
            ],
            'password' => [
                'type' => Type::string(),
                'description' => 'Password del usuario',
                'rules' => ['min:4']
            ]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        $user = User::find($args['id']);

        if(! $user)
        {
            return null;
        }

        // update password user
        $password = isset($args['password'])
            ? array_merge($args, ['password' => $args['password']])
            : $args;

        $name = isset($args['name'])
            ? array_merge($args, ['name' => $args['name']])
            : $args;

        $email = isset($args['email'])
            ? array_merge($args, ['email' => $args['email']])
            : $args;

        $user->update($password, $name, $email);

        return $user;
    }
}
