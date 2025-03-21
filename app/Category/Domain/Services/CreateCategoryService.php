<?php

namespace App\Category\Domain\Services;
use App\Category\Domain\Contracts\CategoryRepositoryPort;
use App\Category\Domain\Entities\Category;

class CreateCategoryService
{
    /**
     * Create a new class instance.
     */
    private CategoryRepositoryPort $categoryRepository;
    public function __construct(CategoryRepositoryPort $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    public function execute(array $data): Category
    {
        $category = new Category($data);
        return $this->categoryRepository->create($category);
    }
}
