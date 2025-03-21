<?php

namespace App\Category\Domain\Services;
use App\Category\Domain\Contracts\CategoryRepositoryPort;
use App\Category\Domain\Entities\Category;
use Illuminate\Support\Arr;

class UpdateCategoryService
{
    /**
     * Create a new class instance.
     */
    private CategoryRepositoryPort $categoryRepository;
    public function __construct(CategoryRepositoryPort $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    public function execute(string $id, Array $data): Category
    {
        return $this->categoryRepository->update($id, $data);    
    }
}
