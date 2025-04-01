<?php

namespace App\Product\Adapters\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Product\Domain\Contracts\ProductRepositoryPort;
use App\Models\Product as ProductModel;
use App\Product\Domain\Entities\Product;
use App\Product\Sorts\CategoryNameSort;
use App\Product\Sorts\SizeNameSort;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class ProductRepository extends BaseRepository implements ProductRepositoryPort
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        parent::__construct(ProductModel::class);
    }
    public function getAll(int $perPage, array $filters = [], array $sorts = [], string $defaultSort = 'updated_at', array $with = ['category', 'size']): LengthAwarePaginator
    {
        $sorts = [
            AllowedSort::field('name'),
            AllowedSort::field('cost_price'),
            AllowedSort::field('sale_price'),
            AllowedSort::field('rating_average'),
            AllowedSort::field('created_at'),
            AllowedSort::custom('category_name', new CategoryNameSort),
            AllowedSort::custom('size_name', new SizeNameSort),
        ];
        $filters = [
            AllowedFilter::scope('name'),
            AllowedFilter::scope('category_name'),
            AllowedFilter::scope('size_name'),
            AllowedFilter::exact('brand'),
            AllowedFilter::exact('status'),
            AllowedFilter::exact('featured'),
        ];
        return  parent::getAll($perPage, $filters, $sorts, $defaultSort, $with);
    }
    public function create(Product $product): Product
    {
        $productModel = ProductModel::create([
            'name' => $product->name,
            'description' => $product->description,
            'cost_price' => $product->cost_price,
            'sale_price' => $product->sale_price,
            'sku' => $product->sku,
            'brand' => $product->brand,
            'weight' => $product->weight,
            'dimensions' => $product->dimensions,
            'status' => $product->status,
            'featured' => $product->featured,
            'rating_average' => $product->rating_average,
            'tags' => $product->tags,
            'user_id' => $product->user_id,
            'category_id' => $product->category_id,
            'size_id' => $product->size_id,
            'img' => $product->img,
        ]);
        $productModel->load(['category', 'size']);
        return new Product($productModel->toArray());
    }
    public function findById(string $id): Product
    {
        $productModel = ProductModel::with(['category', 'size'])->findOrFail($id);
        return new Product($productModel->toArray());
    }
    public function update(string $id, array $data): Product
    {
        $productModel = ProductModel::findOrFail($id);
        $productModel->update($data);
        $productModel->load(['category', 'size']);
        return new Product($productModel->toArray());
    }
    public function findManyByIds(array $ids): object
    {
        return ProductModel::select('id', 'cost_price', 'sale_price')
            ->whereIn('id', $ids)
            ->get();
    }

}
