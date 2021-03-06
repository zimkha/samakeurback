<?php

declare(strict_types=1);

return [

    // The prefix for routes
    'prefix' => '/graphql',

    // The routes to make GraphQL request. Either a string that will apply
    // to both query and mutation or an array containing the key 'query' and/or
    // 'mutation' with the according Route
    //
    // Example:
    //
    // Same route for both query and mutation
    //
    // 'routes' => 'path/to/query/{graphql_schema?}',
    //
    // or define each route
    //
    // 'routes' => [
    //     'query' => 'query/{graphql_schema?}',
    //     'mutation' => 'mutation/{graphql_schema?}',
    // ]
    //
    'routes' => '{graphql_schema?}',

    // The controller to use in GraphQL request. Either a string that will apply
    // to both query and mutation or an array containing the key 'query' and/or
    // 'mutation' with the according Controller and method
    //
    // Example:
    //
    // 'controllers' => [
    //     'query' => '\Rebing\GraphQL\GraphQLController@query',
    //     'mutation' => '\Rebing\GraphQL\GraphQLController@mutation'
    // ]
    //
    'controllers' => \Rebing\GraphQL\GraphQLController::class.'@query',

    // Any middleware for the graphql route group
    'middleware' => [],

    // Additional route group attributes
    //
    // Example:
    //
    // 'route_group_attributes' => ['guard' => 'api']
    //
    'route_group_attributes' => [],

    // The name of the default schema used when no argument is provided
    // to GraphQL::schema() or when the route is used without the graphql_schema
    // parameter.
    'default_schema' => 'default',

    // The schemas for query and/or mutation. It expects an array of schemas to provide
    // both the 'query' fields and the 'mutation' fields.
    //
    // You can also provide a middleware that will only apply to the given schema
    //
    // Example:
    //
    //  'schema' => 'default',
    //
    //  'schemas' => [
    //      'default' => [
    //          'query' => [
    //              'users' => 'App\GraphQL\Query\UsersQuery'
    //          ],
    //          'mutation' => [
    //
    //          ]
    //      ],
    //      'user' => [
    //          'query' => [
    //              'profile' => 'App\GraphQL\Query\ProfileQuery'
    //          ],
    //          'mutation' => [
    //
    //          ],
    //          'middleware' => ['auth'],
    //      ],
    //      'user/me' => [
    //          'query' => [
    //              'profile' => 'App\GraphQL\Query\MyProfileQuery'
    //          ],
    //          'mutation' => [
    //
    //          ],
    //          'middleware' => ['auth'],
    //      ],
    //  ]
    //
    'schemas' => [
        'default' => [
            'query' => [
                 \App\GraphQL\Query\TypeRemarqueQuery::class,
                 \App\GraphQL\Query\RemarqueQuery::class,
                 \App\GraphQL\Query\PlanQuery::class,
                 \App\GraphQL\Query\PlanPaginatedQuery::class,
                 \App\GraphQL\Query\ProjetQuery::class,
                 \App\GraphQL\Query\PlanPaginatedQuery::class,
                 \App\GraphQL\Query\ProjetPaginatedQuery::class,
                 \App\GraphQL\Query\RoleQuery::class,
                 \App\GraphQL\Query\NiveauPlanQuery::class,
                 \App\GraphQL\Query\NiveauProjetQuery::class,
                 \App\GraphQL\Query\UserQuery::class,
                 \App\GraphQL\Query\UserPaginatedQuery::class,
                 \App\GraphQL\Query\PermissionQuery::class,
                 \App\GraphQL\Query\PlanProjetQuery::class,
                  \App\GraphQL\Query\UniteMesureQuery::class,
                  \App\GraphQL\Query\JoinedQuery::class,
                  \App\GraphQL\Query\PositionQuery::class,
                  \App\GraphQL\Query\MessageSendQuery::class,
                  \App\GraphQL\Query\MessageSendPaginatedQuery::class,
                  \App\GraphQL\Query\PostQuery::class,
                 
                  \App\GraphQL\Query\ChantierQuery::class,
                  \App\GraphQL\Query\ChantierPaginatedQuery::class,
                  \App\GraphQL\Query\ContratExecutionQuery::class,
                  \App\GraphQL\Query\DeviseEstimeQuery::class,
                  \App\GraphQL\Query\DeviseFinanceQuery::class,
                  \App\GraphQL\Query\PayedQuery::class,
                  \App\GraphQL\Query\PlanningFondQuery::class,
                  \App\GraphQL\Query\PlanningPrevisionnelQuery::class,










            ],
            'mutation' => [
                // 'example_mutation'  => ExampleMutation::class,
            ],
            'middleware' => ['web'],
            'method'     => ['get', 'post'],
        ],
    ],

    // The types available in the application. You can then access it from the
    // facade like this: GraphQL::type('user')
    //
    // Example:
    //
    // 'types' => [
    //     'user' => 'App\GraphQL\Type\UserType'
    // ]
    //
    'types' => [
        
        \App\GraphQL\Type\TypeRemarqueType::class,
        \App\GraphQL\Type\RemarqueType::class,
        \App\GraphQL\Type\NiveauPlanType::class,
        \App\GraphQL\Type\NiveauProjetType::class,
        \App\GraphQL\Type\RoleType::class,
        \App\GraphQL\Type\PermissionType::class,
        \App\GraphQL\Type\PlanType::class,
        \App\GraphQL\Type\PlanPaginatedType::class,
        \App\GraphQL\Type\ProjetType::class,
        \App\GraphQL\Type\ProjetPaginatedType::class,
        \App\GraphQL\Type\Metadata::class,
        \App\GraphQL\Type\UserType::class,
        \App\GraphQL\Type\UserPaginatedType::class,
        \App\GraphQL\Type\PlanProjetType::class,
        \App\GraphQL\Type\UniteMesureType::class,
        \App\GraphQL\Type\JoinedType::class,
        \App\GraphQL\Type\PositionType::class,
        \App\GraphQL\Type\MessageSendType::class,
        \App\GraphQL\Type\MessageSendPaginatedType::class,
        \App\GraphQL\Type\PostType::class,
        \App\GraphQL\Type\ChantierType::class,
        \App\GraphQL\Type\ChantierPaginatedType::class,
        \App\GraphQL\Type\ContratExecutionType::class,
        \App\GraphQL\Type\DeviseEstimeType::class,
        \App\GraphQL\Type\DeviseFinanceType::class,
        \App\GraphQL\Type\PayedType::class,
        \App\GraphQL\Type\PlanningFondType::class,
        \App\GraphQL\Type\PlanningPrevisionnelType::class,


    ],

    // The types will be loaded on demand. Default is to load all types on each request
    // Can increase performance on schemes with many types
    // Presupposes the config type key to match the type class name property
    'lazyload_types' => false,

    // This callable will be passed the Error object for each errors GraphQL catch.
    // The method should return an array representing the error.
    // Typically:
    // [
    //     'message' => '',
    //     'locations' => []
    // ]
    'error_formatter' => ['\Rebing\GraphQL\GraphQL', 'formatError'],

    /*
     * Custom Error Handling
     *
     * Expected handler signature is: function (array $errors, callable $formatter): array
     *
     * The default handler will pass exceptions to laravel Error Handling mechanism
     */
    'errors_handler' => ['\Rebing\GraphQL\GraphQL', 'handleErrors'],

    // You can set the key, which will be used to retrieve the dynamic variables
    'params_key'    => 'variables',

    /*
     * Options to limit the query complexity and depth. See the doc
     * @ https://github.com/webonyx/graphql-php#security
     * for details. Disabled by default.
     */
    'security' => [
        'query_max_complexity'  => null,
        'query_max_depth'       => null,
        'disable_introspection' => false,
    ],

    /*
     * You can define your own pagination type.
     * Reference \Rebing\GraphQL\Support\PaginationType::class
     */
    'pagination_type' => \Rebing\GraphQL\Support\PaginationType::class,

    /*
     * Config for GraphiQL (see (https://github.com/graphql/graphiql).
     */
    'graphiql' => [
        'prefix'     =>  '/graphiql',
        'routes' => '/graphiql/{graphql_schema?}',
        'controller' => \Rebing\GraphQL\GraphQLController::class.'@graphiql',
        'middleware' => [],
        'view'       => 'graphql::graphiql',
        'display'    => env('ENABLE_GRAPHIQL', true),

    ],

    /*
     * Overrides the default field resolver
     * See http://webonyx.github.io/graphql-php/data-fetching/#default-field-resolver
     *
     * Example:
     *
     * ```php
     * 'defaultFieldResolver' => function ($root, $args, $context, $info) {
     * },
     * ```
     * or
     * ```php
     * 'defaultFieldResolver' => [SomeKlass::class, 'someMethod'],
     * ```
     */
    'defaultFieldResolver' => null,

    /*
     * Any headers that will be added to the response returned by the default controller
     */
    'headers' => [],

    /*
     * Any JSON encoding options when returning a response from the default controller
     * See http://php.net/manual/function.json-encode.php for the full list of options
     */
    'json_encoding_options' => 0,
];
