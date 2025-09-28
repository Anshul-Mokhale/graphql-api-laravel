<?php

declare(strict_types=1);

return [
    'route' => [
        // The prefix for routes; do NOT use a leading slash!
        // We'll handle prefixes per schema instead
        'prefix' => 'graphql',

        // The controller/method to use in GraphQL request.
        'controller' => Rebing\GraphQL\GraphQLController::class . '@query',

        // Any middleware for the graphql route group
        'middleware' => [],

        // Additional route group attributes
        'group_attributes' => [],
    ],

    // The name of the default schema
    'default_schema' => 'user',

    'batching' => [
        'enable' => true,
    ],

    'schemas' => [
        'user' => [
            'query' => [
                'user' => App\GraphQL\Queries\User\UserQuery::class,
                'users' => App\GraphQL\Queries\User\UsersQuery::class,
            ],
            'mutation' => [
                'createUser' => App\GraphQL\Mutations\User\CreateUserMutation::class,
                'updateUser' => App\GraphQL\Mutations\User\UpdateUserMutation::class,
                'deleteUser' => App\GraphQL\Mutations\User\DeleteUserMutation::class,
            ],
            'types' => [
                'User' => App\GraphQL\Types\UserType::class,
            ],
            'middleware' => [],
            'method' => ['GET', 'POST'],
            'execution_middleware' => null,

            // Custom route configuration for user schema
            'route' => [
                'prefix' => 'graphql/user',
                'middleware' => [],
                'group_attributes' => [],
            ],
        ],

        'product' => [
            'query' => [
                'product' => App\GraphQL\Queries\Product\ProductQuery::class,
                'products' => App\GraphQL\Queries\Product\ProductsQuery::class,
            ],
            'mutation' => [
                'createProduct' => App\GraphQL\Mutations\Product\CreateProductMutation::class,
                'updateProduct' => App\GraphQL\Mutations\Product\UpdateProductMutation::class,
                'deleteProduct' => App\GraphQL\Mutations\Product\DeleteProductMutation::class,
            ],
            'types' => [
                'Product' => App\GraphQL\Types\ProductType::class,
            ],
            'middleware' => [],
            'method' => ['GET', 'POST'],
            'execution_middleware' => null,

            // Custom route configuration for product schema
            'route' => [
                'prefix' => 'graphql/product',
                'middleware' => [],
                'group_attributes' => [],
            ],
        ],
    ],

    'types' => [
        // Global types can be defined here if needed
    ],

    // 'error_formatter' => [Rebing\GraphQL\GraphQL::class, 'formatError'],
    'error_formatter' => [App\GraphQL\ErrorFormatter::class, 'formatError'],


    'errors_handler' => [Rebing\GraphQL\GraphQL::class, 'handleErrors'],

    'security' => [
        'query_max_complexity' => null,
        'query_max_depth' => null,
        'disable_introspection' => false,
    ],

    'pagination_type' => Rebing\GraphQL\Support\PaginationType::class,

    'simple_pagination_type' => Rebing\GraphQL\Support\SimplePaginationType::class,

    'cursor_pagination_type' => Rebing\GraphQL\Support\CursorPaginationType::class,

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