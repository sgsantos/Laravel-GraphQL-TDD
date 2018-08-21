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
        'description' => 'Crea un post'
    ];

    public function type()
    {
        return GraphQL::type('PostType');
    }

    public function args()
    {
        return [
            'user_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Identificador del usuario que escribió el post'
            ],
            'title' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Título del post'
            ],
            'body' => [
                'type' => Type::string(),
                'description' => 'Cuerpo del post'
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
