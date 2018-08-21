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
        'description' => 'Actualiza un post dado el id y los parámetros a modificar'
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
                'description' => 'Identificador del Post'
            ],
            'user_id' => [
                'type' => Type::int(),
                'description' => 'Identificador del usuario que escribió el post'
            ],
            'title' => [
                'type' => Type::string(),
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
