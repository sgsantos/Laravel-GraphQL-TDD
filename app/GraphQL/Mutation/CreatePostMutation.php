<?php

namespace App\GraphQL\Mutation;

use Folklore\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL;
use App\Post;

class CreatePostMutation extends Mutation
{
    protected $attributes = [
        'name' => 'CreatePostMutation',
        'description' => 'Create a post'
    ];

    public function type()
    {
        return GraphQL::type('PostType');
    }

    public function args()
    {
        return [
            'user_id' => [
                'type' => Type::nonNull(Type::string()),
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

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        $post = new Post();
        $post->fill($args);
        $post->save();
        return $post;
    }
}
