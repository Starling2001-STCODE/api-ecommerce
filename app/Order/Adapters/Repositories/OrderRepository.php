<?php

namespace App\Order\Adapters\Repositories;

use App\Models\Order as OrderModel;
use App\Core\Repositories\BaseRepository;
use App\Order\Domain\Contracts\OrderRepositoryPort;
use App\Order\Domain\Entities\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class OrderRepository extends BaseRepository implements OrderRepositoryPort
{
    public function __construct()
    {
        parent::__construct(OrderModel::class);
    }
    public function getAll(int $perPage, array $filters = ['name'], array $sorts = ['name'], string $defaultSort = 'updated_at', array $with = []): LengthAwarePaginator
    {
        return parent::getAll($perPage, $filters, $sorts, $defaultSort, $with);
    }
    public function create(Order $order): Order
    {
        $nextOrderNumber = str_pad(OrderModel::count() + 1, 6, '0', STR_PAD_LEFT);
        $model = OrderModel::create([
            'id' => $order->id,
            'display_order_id' => 'ORD-' . $nextOrderNumber,
            'user_id' => $order->user_id,
            'status' => $order->status,
            'session_id' => $order->session_id,
            'checkout_url' => $order->checkout_url,
            'expires_at' => $order->expires_at,
            'total' => $order->total,
        ]);

        $model->load('items');

        return new Order($model->toArray());
    }

    public function findById(string $id): Order
    {
        $model = OrderModel::with('items')->findOrFail($id);
        return new Order($model->toArray());
    }

    public function findBySessionId(string $sessionId): Order
    {
        $model = OrderModel::with('items')->where('session_id', $sessionId)->firstOrFail();
        return new Order($model->toArray());
    }

    public function findByStripeSessionId(string $sessionId): Order
    {
        $model = OrderModel::with('items')->where('stripe_session_id', $sessionId)->firstOrFail();
        return new Order($model->toArray());
    }

    public function findByUserId(string $userId): array
    {
        $models = OrderModel::with('items')->where('user_id', $userId)->get();
        return $models->map(fn($m) => new Order($m->toArray()))->toArray();
    }


    public function update(string $id, array $data): Order
    {
        $model = OrderModel::findOrFail($id);
        $model->update($data);
        $model->load('items');

        return new Order($model->toArray());
    }

    public function delete(string $id): void
    {
        $model = OrderModel::findOrFail($id);
        $model->delete();
    }
}
