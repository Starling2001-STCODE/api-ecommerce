<?php

namespace App\Cart\Domain\Contracts;
use App\Cart\Domain\Entities\Cart;
use \Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CartRepositoryPort
{
        public function create(Cart $cart): Cart;
        public function getAll(int $perPage): LengthAwarePaginator;
        public function findById(string $id): Cart;
        public function findByUserId(string $user_id): Cart;
        public function findBySessionId(string $session_id): Cart;
        public function update(string $id, array $data): Cart;
}
