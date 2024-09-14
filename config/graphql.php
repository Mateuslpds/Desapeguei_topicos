<?php

declare(strict_types = 1);

return [
    'route' => [
        'prefix' => 'graphql',
        'controller' => Rebing\GraphQL\GraphQLController::class . '@query',
        'middleware' => [],
        'group_attributes' => [],
    ],

    'default_schema' => 'default',

    'batching' => [
        'enable' => true,
    ],

    'schemas' => [
        'default' => [
            'query' => [
                'users' => \App\GraphQL\Queries\UserQuery::class,
                'objetos' => \App\GraphQL\Queries\ObjetoQuery::class,
            ],
            'mutation' => [
                'createUser' => \App\GraphQL\Mutations\CreateUserMutation::class,
                'createObjeto' => \App\GraphQL\Mutations\CreateObjetoMutation::class,
                'updateObjeto' => \App\GraphQL\Mutations\UpdateObjetoMutation::class,
                'deleteObjeto' => \App\GraphQL\Mutations\DeleteObjetoMutation::class,
            ],
            'types' => [
                'Objeto' => \App\GraphQL\Types\ObjetoType::class,
            ],

            'middleware' => null,

            'method' => ['GET', 'POST'],

            'execution_middleware' => null,
        ],
    ],

    'types' => [
        'User' => \App\GraphQL\Types\UserType::class,
        //'Objeto' => \App\GraphQL\Types\ObjetoType::class,
    ],

    'error_formatter' => [Rebing\GraphQL\GraphQL::class, 'formatError'],
    'errors_handler' => [Rebing\GraphQL\GraphQL::class, 'handleErrors'],

    'security' => [
        'query_max_complexity' => null,
        'query_max_depth' => null,
        'disable_introspection' => false,
    ],

    'pagination_type' => Rebing\GraphQL\Support\PaginationType::class,
    'simple_pagination_type' => Rebing\GraphQL\Support\SimplePaginationType::class,
    'defaultFieldResolver' => null,
    'headers' => [],
    'json_encoding_options' => 0,

    'apq' => [
        'enable' => env('GRAPHQL_APQ_ENABLE', false),

        'cache_driver' => env('GRAPHQL_APQ_CACHE_DRIVER', config('cache.default')),

        'cache_prefix' => config('cache.prefix') . ':graphql.apq',

        'cache_ttl' => 300,
    ],

    'execution_middleware' => [
        Rebing\GraphQL\Support\ExecutionMiddleware\ValidateOperationParamsMiddleware::class,
        Rebing\GraphQL\Support\ExecutionMiddleware\AutomaticPersistedQueriesMiddleware::class,
        Rebing\GraphQL\Support\ExecutionMiddleware\AddAuthUserContextValueMiddleware::class,
    ],

    'resolver_middleware_append' => null,
];
