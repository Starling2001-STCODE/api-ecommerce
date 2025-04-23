<?php

namespace App\AttrCategory\Domain\Services;
use App\AttrCategory\Domain\Contracts\AttrCategoryRepositoryPort;
use App\AttrCategory\Domain\Entities\AttrCategory;


class CreateAttrCategoryService
{
    private AttrCategoryRepositoryPort $attrCategoryRepository;

    public function __construct(AttrCategoryRepositoryPort $attrCategoryRepository)
    {
       $this->attrCategoryRepository = $attrCategoryRepository;
    }
    public function execute(array $data): AttrCategory
    {
        $attrCategory = new AttrCategory($data);
        return $this->attrCategoryRepository->create($attrCategory);
    }
}
