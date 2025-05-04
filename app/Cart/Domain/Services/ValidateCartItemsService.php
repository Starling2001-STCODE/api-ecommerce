<?php

namespace App\Cart\Domain\Services;

use App\Product\Domain\Contracts\ProductRepositoryPort;
use App\Cart\Domain\Exceptions\InvalidCartItemException;
use App\Cart\Domain\Exceptions\ProductNotFoundException;
use App\Cart\Domain\Exceptions\ProductVariantNotFoundException;
use App\Cart\Domain\Exceptions\OutOfStockException;
use Illuminate\Support\Facades\Log;

class ValidateCartItemsService
{
    private ProductRepositoryPort $productRepository;

    public function __construct(ProductRepositoryPort $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute(array $cartItems): array
    {
        $validatedItems = [];

        foreach ($cartItems as $item) {
            $validatedItems[] = $this->validateAndSanitizeItem($item);
        }

        return $validatedItems;
    }

    private function validateAndSanitizeItem(array $item): array
    {
        $productId = $item['product_id'] ?? null;
        $variantId = $item['variant_id'] ?? null;

        if (!$productId) {
            throw new InvalidCartItemException("Item inválido: falta el product_id.");
        }

        try {
            $product = $this->productRepository->findById($productId);
        } catch (\Exception $e) {
            throw new ProductNotFoundException($productId);
        }

        return $variantId
            ? $this->validateAndSanitizeVariantItem($product, $item)
            : $this->validateAndSanitizeSimpleProductItem($product, $item);
    }

    private function validateAndSanitizeVariantItem($product, array $item): array
    {
        $variantId = $item['variant_id'];
        $quantity = $item['quantity'] ?? 1;

        $variant = collect($product->variants)->firstWhere('id', $variantId);

        if (!$variant) {
            throw new ProductVariantNotFoundException($variantId);
        }

        // Validar atributos
        $this->validateAttributes(
            $variant['attribute_values'] ?? [],
            $item['attributes'] ?? [],
            $item['id'] ?? $variantId
        );

        // Validar stock
        $availableStock = $variant['quantity'] ?? 0;

        if ($availableStock < $quantity) {
            throw new OutOfStockException($variantId, $quantity, $availableStock);
        }

        // Validar precio
        if (!isset($variant['sale_price'])) {
            throw new InvalidCartItemException("Falta el precio de la variante {$variantId}");
        }

        // Generar nombre y buscar imagen principal
        $attributeNames = collect($variant['attribute_values'] ?? [])
            ->pluck('attribute_value_name')
            ->implode(', ');

        $image = $variant['images'][0]['url']
            ?? $variant['attribute_value_images'][0]['url']
            ?? $product->preview_image
            ?? null;

        // Asignar datos actualizados
        $item['price_at_time'] = (float) $variant['sale_price'];
        $item['stock_at_time'] = (int) $availableStock;
        $item['name'] = $product->name . (!empty($attributeNames) ? " - {$attributeNames}" : '');
        $item['image'] = $image;

        return $item;
    }

    private function validateAndSanitizeSimpleProductItem($product, array $item): array
    {
        $quantity = $item['quantity'] ?? 1;
        $inventory = $product->inventory;
    
         if (!$inventory || ($inventory->quantity ?? 0) < $quantity) {
            throw new OutOfStockException(
                $item['id'] ?? $product->id,
                $quantity,
                $inventory->quantity ?? 0
            );
        }

        if (!isset($product->sale_price)) {
            throw new InvalidCartItemException("Falta el precio del producto {$product->id}");
        }

        $item['price_at_time'] = (float) $product->sale_price;
        $item['stock_at_time'] = (int) $inventory->quantity;
        $item['name'] = $product->name;
        $item['image'] = $product->preview_image ?? null;

        return $item;
    }

    private function validateAttributes(array $expectedAttributes, array $incomingAttributes, string $itemId): void
    {
        $expected = collect($expectedAttributes)->pluck('attribute_value_id')->sort()->values();
        $incoming = collect($incomingAttributes)->pluck('attribute_value_id')->sort()->values();

        if ($expected->diff($incoming)->isNotEmpty() || $incoming->diff($expected)->isNotEmpty()) {
            throw new InvalidCartItemException(
                "Los atributos enviados no coinciden con la variante real para el item {$itemId}."
            );
        }
    }
}
