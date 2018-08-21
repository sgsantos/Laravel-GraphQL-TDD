<?php

namespace App\GraphQL\Query;

use Folklore\GraphQL\Support\Query;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL;
use App\Post;

class PostQuery extends Query
{
    protected $attributes = [
        'name' => 'PostQuery',
        'description' => 'Muestra un post dado el id'
    ];

    public function type()
    {
        return GraphQL::type('PostType');
    }

    public function args()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => "Identificador del post al que se quiere acceder"
            ]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        return Post::find($args['id']);
    }
}
