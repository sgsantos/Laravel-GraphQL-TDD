<?php

namespace App\GraphQL\Mutation;

use Folklore\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL;
use App\Post;

class UpdatePostMutation extends Mutation
{
    protected $attributes = [
        'name' => 'UpdatePostMutation',
        'description' => 'Update a post given the id and the parameters to modify'
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
                'description' => 'Identifier of the Post'
            ],
            'user_id' => [
                'type' => Type::int(),
                'description' => 'Identifier of the user who wrote the post'
            ],
            'title' => [
                'type' => Type::string(),
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
        $post = Post::find($args['id']);

        if(!$post)
        {
            return null;
        }


        $user_id = isset($args['user_id'])
            ? array_merge($args, ['user_id' => $args['user_id']])
            : $args;

        $title = isset($args['title'])
            ? array_merge($args, ['title' => $args['title']])
            : $args;

        $body = isset($args['body'])
            ? array_merge($args, ['body' => $args['body']])
            : $args;

        $post->update($user_id, $title, $body);

        return $post;
    }
}
