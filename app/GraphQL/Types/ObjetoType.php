<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class ObjetoType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Objeto',
        'description' => 'A type representing an Objeto',
        'model' => Objeto::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The ID of the objeto',
            ],
            'nome' => [
                'type' => Type::string(),
                'description' => 'The name of the objeto',
            ],
            'descricao' => [
                'type' => Type::string(),
                'description' => 'The description of the objeto',
            ],
            'imagem' => [
                'type' => Type::string(),
                'description' => 'The image of the objeto',
            ],
            'cep' => [
                'type' => Type::string(),
                'description' => 'The cep of the objeto',
            ],
            'tipo_id' => [
                'type' => Type::int(),
                'description' => 'The tipo_id of the objeto',
            ],
            'user_id' => [
                'type' => Type::int(),
                'description' => 'The user_id of the objeto',
            ],
        ];
    }
}
