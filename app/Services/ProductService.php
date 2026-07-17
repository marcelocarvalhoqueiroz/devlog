<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;


class ProductService {
    public function create(array $data): Product {
        $uuid = (string) Str::uuid();
        $product = Product::create([
            ...$data,
            'uuid' => $uuid,
        ]);

        return $product;
    }

    public function update(array $data, string $id): Product {
        $product = Product::where('uuid', $id)->firstOrFail();
        $product->update($data);
        return $product;
    }

    public function findByUuid(string $id): Product{
        $product = Product::where('uuid', $id)->firstOrFail();

        return $product;
    }

    /**
     * @return Collection<int, Product>
    */
    public function getProducts(): Collection {
        $products = Product::get();

        return $products;
    }

    public function delete(string $id): void{
        $product = Product::where('uuid', $id)->firstOrFail();
        $product->delete();
    }
}