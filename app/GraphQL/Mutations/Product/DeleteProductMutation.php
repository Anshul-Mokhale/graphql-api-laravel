<?php

namespace App\GraphQL\Mutations\Product;

use App\Models\Product;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class DeleteProductMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deleteProduct',
    ];

    public function type(): Type
    {
        return Type::boolean();
    }

    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The ID of the product',
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $product = Product::findOrFail($args['id']);
        return $product->delete();
    }
}