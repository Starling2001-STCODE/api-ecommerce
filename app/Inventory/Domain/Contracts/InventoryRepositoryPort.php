<?php

namespace App\Inventory\Domain\Contracts;

interface InventoryRepositoryPort
{
    public function getAll(int $perPage, array $filters = [], array $sorts = [], string $defaultSort = 'updated_at', array $with = []);

    public function insertMany(array $data): void;

    public function setMinimumStock(int $minimumStock, string $id): void;

    public function incrementStock(array $data): void;

    public function adjustStock(array $data): void;

    public function decrementStock(array $data): void;
}
