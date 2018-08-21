<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as BaseType;
use GraphQL;

class UserType extends BaseType
{
    protected $attributes = [
        'name' => 'UserType',
        'description' => 'Data type for User elements'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'User identifier'
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => "User's name"
            ],
            'email' => [
                'type' => Type::string(),
                'description' => "User's email"
            ],
            'password' => [
                'type' => Type::string(),
                'description' => "User's password"
            ],
            'posts' => [
                'type' => Type::listOf(GraphQL::type('PostType')),
                'description' => "List of user's posts"
            ],
            'updated_at' => [
                'type' => Type::string(),
                'description' => 'Date of user update'
            ]
        ];
    }
}
