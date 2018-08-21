<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as BaseType;
use GraphQL;

class PostType extends BaseType
{
    protected $attributes = [
        'name' => 'PostType',
        'description' => 'Data type for post elements'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Identifier of the post'
            ],
            'user_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Identifier of the user who wrote the post'
            ],
            'title' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Title of the post'
            ],
            'body' => [
                'type' => Type::string(),
                'description' => 'Body of the post'
            ]
        ];
    }
}
