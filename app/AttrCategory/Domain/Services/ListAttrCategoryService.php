<?php
namespace App\AttrCategory\Domain\Services;
use App\AttrCategory\Domain\Contracts\AttrCategoryRepositoryPort;
use App\AttrCategory\Domain\Entities\AttrCategory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListAttrCategoryService
{
    private AttrCategoryRepositoryPort $attrCategoryRepository;
    public function __construct(AttrCategoryRepositoryPort $attrCategoryRepository)
    {
        $this->attrCategoryRepository = $attrCategoryRepository;
    }
    public function execute(int $perPage): LengthAwarePaginator
    {
        return $this->attrCategoryRepository->getAll($perPage);
    }
}
