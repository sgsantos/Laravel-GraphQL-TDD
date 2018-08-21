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
        'description' => 'Show a post given the id'
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
                'description' => "Identifier of the post to which you want to access"
            ]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        return Post::find($args['id']);
    }
}
