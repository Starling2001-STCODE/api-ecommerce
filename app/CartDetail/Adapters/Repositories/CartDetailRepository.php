<?php

namespace App\CartDetail\Adapters\Repositories;
use App\CartDetail\Domain\Contracts\CartDetailRepositoryPort;
use App\CartDetail\Domain\Entities\CartDetail;
use App\Models\Cart_detail as cartDetailModel;
use App\Core\Repositories\BaseRepository;
use Illuminate\Http\JsonResponse;
use Symfony\Component\Uid\Ulid;

class CartDetailRepository extends BaseRepository implements CartDetailRepositoryPort
{

    public function __construct()
    {
        parent::__construct(CartDetailModel::class);
    }
    public function updateOrCreate(array $data): CartDetail  
    {
       $cartDetail = cartDetailModel::updateOrCreate
       ([
           'cart_id' => $data['cart_id'],
           'product_id' => $data['product_id'],
            'variant_id' => $data['variant_id'],
        ],
        [
            'quantity' => $data['quantity'],
            'price_at_time' => $data['price_at_time'],
            'updated_at' => $data['updated_at'],
        ])->fresh();
        
        return new CartDetail($cartDetail->toArray()); 
    }
    public function deleteSelectedItems(array $items, string $cartId): void
    {
        foreach ($items as $item) {
            $query = cartDetailModel::where('cart_id', $cartId)
                ->where('product_id', $item['product_id']);

            if (!empty($item['variant_id'])) {
                $query->where('variant_id', $item['variant_id']);
            } else {
                $query->whereNull('variant_id');
            }

            $query->delete();
        }
    }
    public function updateQuantityByProductAndVariant(string $cartId, string $productId, ?string $variantId, int $quantity): void
    {
        $query = cartDetailModel::where('cart_id', $cartId)
            ->where('product_id', $productId);
    
        if ($variantId) {
            $query->where('variant_id', $variantId);
        } else {
            $query->whereNull('variant_id');
        }
    
        $cartDetail = $query->firstOrFail();
        $cartDetail->update(['quantity' => $quantity]);
    }
    
    
    public function deleteByProductAndVariant(string $cartId, string $productId, ?string $variantId): void
    {
        $query = cartDetailModel::where('cart_id', $cartId)
            ->where('product_id', $productId);

        if ($variantId) {
            $query->where('variant_id', $variantId);
        } else {
            $query->whereNull('variant_id');
        }

        $query->delete();
    }
    public function addOrUpdateByProductAndVariant(string $cartId, array $itemData): void
    {
        $query = cartDetailModel::where('cart_id', $cartId)
            ->where('product_id', $itemData['product_id']);
    
        if (!empty($itemData['variant_id'])) {
            $query->where('variant_id', $itemData['variant_id']);
        } else {
            $query->whereNull('variant_id');
        }
    
        $existingItem = $query->first();
    
        if ($existingItem) {
            $existingItem->update([
                'quantity' => $existingItem->quantity + $itemData['quantity'],
                'price_at_time' => $itemData['price_at_time'],
                'updated_at' => now(),
            ]);
        } else {
            cartDetailModel::create([
                'cart_id' => $cartId,
                'product_id' => $itemData['product_id'],
                'variant_id' => $itemData['variant_id'] ?? null,
                'quantity' => $itemData['quantity'],
                'price_at_time' => $itemData['price_at_time'],
            ]);
        }
    }
    
}
