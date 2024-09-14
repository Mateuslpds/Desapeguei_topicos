<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;
use App\Models\Objeto;

class ObjetoQuery extends Query
{
    protected $attributes = [
        'name' => 'objetos',
    ];

    public function type(): Type
    {
        return Type::listOf(\GraphQL::type('Objeto'));
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return Objeto::all();
    }
}
