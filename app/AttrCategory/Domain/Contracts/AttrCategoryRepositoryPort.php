<?php

namespace App\AttrCategory\Domain\Contracts;
use App\AttrCategory\Domain\Entities\AttrCategory;
use \Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AttrCategoryRepositoryPort
{
    public function create(AttrCategory $attribute): AttrCategory;
    public function getAll(int $perPage): LengthAwarePaginator;
    public function findById(string $id): AttrCategory;
    public function update(string $id, array $data): AttrCategory;
    public function catReqAttr(string $categoryId): bool;

}
