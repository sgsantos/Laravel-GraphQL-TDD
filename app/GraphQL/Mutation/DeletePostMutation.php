<?php

namespace App\GraphQL\Mutation;

use Folklore\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL;
use App\Post;

class DeletePostMutation extends Mutation
{
    protected $attributes = [
        'name' => 'DeletePostMutation',
        'description' => 'Delete a post given the id'
    ];

    public function type()
    {
        return GraphQL::type('PostType');
    }

    public function args()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => "Identifier of the post to be deleted"
            ]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        if( $post = Post::findOrFail($args['id']) ) {
            $post->delete();
            return $post;
        }

        return null;
    }
}
