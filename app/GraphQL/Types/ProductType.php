<?php

namespace App\GraphQL\Types;

use App\Models\Product;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ProductType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Product',
        'description' => 'A product',
        'model' => Product::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The ID of the product',
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The name of the product',
            ],
            'description' => [
                'type' => Type::string(),
                'description' => 'The description of the product',
            ],
            'price' => [
                'type' => Type::nonNull(Type::float()),
                'description' => 'The price of the product',
            ],
            'quantity' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The quantity of the product',
            ],
            'created_at' => [
                'type' => Type::string(),
                'description' => 'The creation date of the product',
            ],
            'updated_at' => [
                'type' => Type::string(),
                'description' => 'The update date of the product',
            ],
        ];
    }
}