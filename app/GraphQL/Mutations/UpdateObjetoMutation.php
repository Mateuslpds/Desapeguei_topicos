<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Objeto;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class UpdateObjetoMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updateObjeto',
    ];

    public function type(): Type
    {
        return \GraphQL::type('Objeto');
    }

    public function args(): array
    {
        return [
            'id' => ['type' => Type::nonNull(Type::int())],
            'nome' => ['type' => Type::string()],
            'descricao' => ['type' => Type::string()],
            'imagem' => ['type' => Type::string()],
            'cep' => ['type' => Type::string()],
            'tipo_id' => ['type' => Type::int()],
            'user_id' => ['type' => Type::int()],
        ];
    }

    public function resolve($root, array $args)
    {
        $objeto = Objeto::findOrFail($args['id']);
        $objeto->update($args);
        return $objeto;
    }
}
