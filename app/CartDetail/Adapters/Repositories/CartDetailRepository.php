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
           'product_id' => $data['product_id']
        ],
        [
            'quantity' => $data['quantity'],
            'price_at_time' => $data['price_at_time'],
            'updated_at' => $data['updated_at'],
        ])->fresh();
        
        return new CartDetail($cartDetail->toArray()); 
    }
}
