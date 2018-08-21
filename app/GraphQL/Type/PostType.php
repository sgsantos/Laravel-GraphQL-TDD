<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as BaseType;
use GraphQL;

class PostType extends BaseType
{
    protected $attributes = [
        'name' => 'PostType',
        'description' => 'Tipo de dato para los elementos Post'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Identificador del Post'
            ],
            'user_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Identificador del usuario que escribió el Post'
            ],
            'title' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Título del Post'
            ],
            'body' => [
                'type' => Type::string(),
                'description' => 'Cuerpo del Post'
            ]
        ];
    }
}
