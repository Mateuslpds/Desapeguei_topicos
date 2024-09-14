<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\Objeto;

class CreateObjetoMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createObjeto',
    ];

    public function type(): Type
    {
        return \GraphQL::type('Objeto');
    }

    public function args(): array
    {
        return [
            'nome' => ['type' => Type::nonNull(Type::string())],
            'descricao' => ['type' => Type::string()],
            'imagem' => ['type' => Type::string()],
            'cep' => ['type' => Type::string()],
            'tipo_id' => ['type' => Type::nonNull(Type::int())],
            'user_id' => ['type' => Type::nonNull(Type::int())],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return Objeto::create($args);
    }
}
