<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Objeto;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class DeleteObjetoMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deleteObjeto',
    ];

    public function type(): Type
    {
        return Type::boolean();
    }

    public function args(): array
    {
        return [
            'id' => ['type' => Type::nonNull(Type::int())],
        ];
    }

    public function resolve($root, array $args)
    {
        $objeto = Objeto::findOrFail($args['id']);
        return $objeto->delete() ? true : false;
    }
}
