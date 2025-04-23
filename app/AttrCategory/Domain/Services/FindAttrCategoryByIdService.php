<?php

namespace App\AttrCategory\Domain\Services;
use App\AttrCategory\Domain\Contracts\AttrCategoryRepositoryPort;
use App\AttrCategory\Domain\Entities\AttrCategory;
class FindAttrCategoryByIdService
{
    private AttrCategoryRepositoryPort $attrCategoryRepository;
    public function __construct(AttrCategoryRepositoryPort $attrCategoryRepository)
    {
        $this->attrCategoryRepository = $attrCategoryRepository;
    }
    public function execute(string $id): AttrCategory
    {
        return $this->attrCategoryRepository->findById($id);
    }
}
