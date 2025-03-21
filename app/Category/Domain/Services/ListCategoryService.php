<?php

namespace App\Category\Domain\Services;
use App\Category\Domain\Contracts\CategoryRepositoryPort;
use App\Category\Domain\Entities\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListCategoryService
{
    /**
     * Create a new class instance.
     */
    private CategoryRepositoryPort $categoryRepository;
    public function __construct(CategoryRepositoryPort $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    public function execute(int $perPage): LengthAwarePaginator
    {
        return $this->categoryRepository->getAll($perPage);    
    }
}
