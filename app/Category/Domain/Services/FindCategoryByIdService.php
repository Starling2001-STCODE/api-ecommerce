<?php

namespace App\Category\Domain\Services;
use App\Category\Domain\Contracts\CategoryRepositoryPort;
use App\Category\Domain\Entities\Category;

class FindCategoryByIdService
{
    /**
     * Create a new class instance.
     */
    private CategoryRepositoryPort $categoryRepository;
    public function __construct(CategoryRepositoryPort $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    public function execute(string $id): Category
    {
        return $this->categoryRepository->findById($id);    
    }
}
