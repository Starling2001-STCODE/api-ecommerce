<?php
namespace App\CartDetail\Domain\Services;

use App\CartDetail\Domain\Contracts\CartDetailRepositoryPort;

class DeleteSelectedCartItemsService
{
    private CartDetailRepositoryPort $repository;

    public function __construct(CartDetailRepositoryPort $repository)
    {
        $this->repository = $repository;
    }

    public function execute(array $selectedItems, string $cartId): void
    {
        $this->repository->deleteSelectedItems($selectedItems, $cartId);
    }
}
