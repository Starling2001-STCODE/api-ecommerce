<?php

namespace App\AttrCategory\Domain\Services;
use App\AttrCategory\Domain\Contracts\AttrCategoryRepositoryPort;
use App\AttrCategory\Domain\Entities\AttrCategory;

class UpdateAttrCategoryService
{
    private AttrCategoryRepositoryPort $attrCategoryRepository;
    public function __construct(AttrCategoryRepositoryPort $attrCategoryRepository)
    {
        $this->attrCategoryRepository = $attrCategoryRepository;
    }
    public function execute(string $id, array $data): AttrCategory
    {
        return $this->attrCategoryRepository->update($id, $data);
    }
}
