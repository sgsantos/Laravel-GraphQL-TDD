<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as BaseType;
use GraphQL;

class UserType extends BaseType
{
    protected $attributes = [
        'name' => 'UserType',
        'description' => 'Tipo de dato para los elementos User'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Identificador del usuario'
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Nombre del usuario'
            ],
            'email' => [
                'type' => Type::string(),
                'description' => 'Email del usuario'
            ],
            'password' => [
                'type' => Type::string(),
                'description' => 'Password del usuario'
            ],
            'posts' => [
                'type' => Type::listOf(GraphQL::type('PostType')),
                'description' => 'Lista de posts del usuario'
            ],
            'updated_at' => [
                'type' => Type::string(),
                'description' => 'Fecha de ctualización del usuario'
            ]
        ];
    }
}
