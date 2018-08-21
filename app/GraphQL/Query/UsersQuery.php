<?php

namespace App\GraphQL\Query;

use Folklore\GraphQL\Support\Query;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL;
use App\User;

class UsersQuery extends Query
{
    protected $attributes = [
        'name' => 'UsersQuery',
        'description' => 'Show all users'
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('UserType'));
    }

    public function args()
    {
        return [
            
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        return User::all();
    }
}
