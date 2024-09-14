<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\User;

class CreateUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createUser',
    ];

    public function type(): Type
    {
        return \GraphQL::type('User');
    }

    public function args(): array
    {
        return [
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The name of the user',
            ],
            'email' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The email of the user',
            ],
            'cpf' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The cpf of the user',
            ],
            'phone' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The phone of the user',
            ],
            'password' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The password of the user',
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        return User::create([
            'name' => $args['name'],
            'email' => $args['email'],
            'cpf' => $args['cpf'],
            'phone' => $args['phone'],
            'password' => bcrypt($args['password']),
        ]);
    }
}
