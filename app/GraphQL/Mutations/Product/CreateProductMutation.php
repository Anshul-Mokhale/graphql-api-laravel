<?php

namespace App\GraphQL\Mutations\Product;

use App\Models\Product;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;

class CreateProductMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createProduct',
    ];

    public function type(): Type
    {
        return GraphQL::type('Product');
    }

    public function args(): array
    {
        return [
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
        ];
    }

    public function resolve($root, $args)
    {
        $product = new Product();
        $product->name = $args['name'];
        $product->description = $args['description'] ?? null;
        $product->price = $args['price'];
        $product->quantity = $args['quantity'];
        $product->save();

        return $product;
    }
}