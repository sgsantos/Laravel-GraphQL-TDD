<?php

namespace App\GraphQL\Mutation;

use Folklore\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL;
use App\User;

class CreateUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'CreateUserMutation',
        'description' => 'Create a user'
    ];

    public function type()
    {
        return GraphQL::type('UserType');
    }

    public function args()
    {
        return [
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Name of the user'
            ],
            'email' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Email of the user',
                'rules' => ['email', 'unique:users']
            ],
            'password' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Password of the user',
                'rules' => ['min:4']
            ]
        ];
    }

    public function resolve($params, $args)
    {

        $user = new User();
        $user->fill($args);
        $user->save();
        return $user;

    }
}
