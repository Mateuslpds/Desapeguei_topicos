<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class UserType extends GraphQLType
{
    protected $attributes = [
        'name' => 'User',
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The ID of the user',
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The name of the user',
            ],
            'email' => [
                'type' => Type::string(),
                'description' => 'The email of the user',
            ],
            'cpf' => [
                'type' => Type::string(),
                'description' => 'The cpf of the user',
            ],
            'phone' => [
                'type' => Type::string(),
                'description' => 'The phone of the user',
            ],
            'password' => [
                'type' => Type::string(),
                'description' => 'The password of the user',
            ],
        ];
    }
}
