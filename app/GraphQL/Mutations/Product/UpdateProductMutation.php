<?php

namespace App\GraphQL\Mutations\Product;

use App\Models\Product;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;

class UpdateProductMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updateProduct',
    ];

    public function type(): Type
    {
        return GraphQL::type('Product');
    }

    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The ID of the product',
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The name of the product',
            ],
            'description' => [
                'type' => Type::string(),
                'description' => 'The description of the product',
            ],
            'price' => [
                'type' => Type::float(),
                'description' => 'The price of the product',
            ],
            'quantity' => [
                'type' => Type::int(),
                'description' => 'The quantity of the product',
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $product = Product::findOrFail($args['id']);

        if (isset($args['name'])) {
            $product->name = $args['name'];
        }

        if (isset($args['description'])) {
            $product->description = $args['description'];
        }

        if (isset($args['price'])) {
            $product->price = $args['price'];
        }

        if (isset($args['quantity'])) {
            $product->quantity = $args['quantity'];
        }

        $product->save();

        return $product;
    }
}