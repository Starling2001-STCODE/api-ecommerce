<?php

namespace App\Category\Adapters\Repositories;
use App\Category\Domain\Contracts\CategoryRepositoryPort;
use App\Category\Domain\Entities\Category;
use App\Core\Repositories\BaseRepository;
use App\Models\Category as categoryModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CategoryRepository extends BaseRepository implements CategoryRepositoryPort
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        parent::__construct(CategoryModel::class);
    }

    public function getAll(int $perPage, array $filters = ['name'], array $sorts = ['name'], string $defaultSort = 'updated_at', array $with = ['attributes']): LengthAwarePaginator
    {
        return parent::getAll($perPage, $filters, $sorts, $defaultSort, $with);
    }

    public function create(Category $category): Category
    {
        $categoryModel = CategoryModel::create([
            'name' => $category->name,
        ]);
        return new Category($categoryModel->toArray());
    }
    public function findById(string $id): Category
    {
        $categoryModel = CategoryModel::with('attributes.values')->findOrFail($id);
        return new Category($categoryModel->toArray());
    }
    public function update(string $id, array $data): Category
    {
        $categoryModel = categoryModel::findOrFail($id);
        $categoryModel->update($data);
        return new Category($categoryModel->toArray());
    }
    public function findByName(string $name): Category
    {
        $categoryModel = categoryModel::where('name', $name)->firstOrFail();
        return new Category($categoryModel->toArray());
    }
}
