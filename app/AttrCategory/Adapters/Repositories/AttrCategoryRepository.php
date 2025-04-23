<?php

namespace App\AttrCategory\Adapters\Repositories;
use App\core\Repositories\BaseRepository;
use App\AttrCategory\Domain\Contracts\AttrCategoryRepositoryPort;
use App\Models\AttrCategory as AttrCategoryModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\AttrCategory\Domain\Entities\AttrCategory;
use App\Models\Attribute;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class AttrCategoryRepository extends BaseRepository implements AttrCategoryRepositoryPort
{
    protected array $defaultWith = ['category', 'attribute'];

    public function __construct()
    {
       parent::__construct(AttrCategoryModel::class);
    }
    public function getAll(int $perPage, array $filters = ['name'], array $sorts = ['name'], string $defaultSort = 'updated_at', array $with = []): LengthAwarePaginator
    {
        return parent::getAll($perPage, $filters, $sorts, $defaultSort, $with);
    }
    public function create(AttrCategory $attrCategory): AttrCategory
    {
        $attrCategoryModel = AttrCategoryModel::create([
            'category_id' => $attrCategory->category_id,
            'attribute_id' => $attrCategory->attribute_id,
            'required' => $attrCategory->required,
        ]);
        return new AttrCategory($attrCategoryModel->toArray());
    }
    public function update(string $id, array $data): AttrCategory
    {
        $attrCategoryModel = AttrCategoryModel::findOrFail($id);
        $attrCategoryModel->update($data);
        $attrCategoryModel->load(['category']);
        $attrCategoryModel->load(['attribute']);
        return new AttrCategory($attrCategoryModel->toArray());
    }
    public function findById(string $id): AttrCategory
    {
        $attrCategoryModel = AttrCategoryModel::with($this->defaultWith)->findOrFail($id);
        return new AttrCategory($attrCategoryModel->toArray());
    }
    public function catReqAttr(string $categoryId): bool
    {
        return Cache::remember("category_requires_variants:$categoryId", 3600, function () use ($categoryId) {
            $catReqAttr = AttrCategoryModel::where('category_id', $categoryId)->get();
    
            return $catReqAttr->isNotEmpty() &&
                   $catReqAttr->contains(fn($attr) => (bool) $attr->required);
        });
    }
    public function getRequiredAttributesByCategory(string $categoryId): Collection
    {
        return Attribute::whereHas('categories', function ($query) use ($categoryId) {
            $query->where('category_id', $categoryId)
                ->where('required', true);
        })->with('values')->get();
    }
}
