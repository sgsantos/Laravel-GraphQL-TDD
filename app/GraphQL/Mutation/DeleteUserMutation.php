<?php

namespace App\GraphQL\Mutation;

use Folklore\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL;
use App\User;

class DeleteUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'DeleteUserMutation',
        'description' => 'Elimina un usuario dado el id'
    ];

    public function type()
    {
        return GraphQL::type('UserType');
    }

    public function args()
    {
        return [
            'id' => [
                'type' => Type::int(),
                'description' => 'Identificador del usuario que se quiere eliminar'
            ]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        if( $user = User::findOrFail($args['id']) ) {
            $user->delete();
            return $user;
        }

        return null;
    }
}
