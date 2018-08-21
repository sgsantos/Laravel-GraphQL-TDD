<?php

namespace App\GraphQL\Query;

use App\Post;
use Folklore\GraphQL\Support\Query;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL;
use App\PostType;

class PostsQuery extends Query
{
    protected $attributes = [
        'name' => 'PostsQuery',
        'description' => 'Show all posts'
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('PostType'));
    }

    public function args()
    {
        return [
            
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        return Post::all();
    }
}
