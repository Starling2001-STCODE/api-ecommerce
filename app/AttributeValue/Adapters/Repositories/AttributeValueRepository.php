<?php

namespace App\AttributeValue\Adapters\Repositories;

use App\Core\Repositories\BaseRepository;
use App\AttributeValue\Domain\Contracts\AttributeValueRepositoryPort;
use App\Models\AttributeValue as attributeValueModel;
use App\AttributeValue\Domain\Entities\AttributeValue;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AttributeValueRepository extends BaseRepository implements AttributeValueRepositoryPort
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        parent::__construct(attributeValueModel::class);
    }
    public function getAll(int $perPage, array $filters = ['name'], array $sorts = ['name'], string $defaultSort = 'updated_at', array $with = []): LengthAwarePaginator
    {
        return parent::getAll($perPage, $filters, $sorts, $defaultSort, $with);
    }
    public function create(AttributeValue $attributeValue): AttributeValue
    {
        $attributeValueyModel = attributeValueModel::create([
            'attribute_id' => $attributeValue->attribute_id,
            'value' => $attributeValue->value,
        ]);
        $attributeValueyModel->load(['attribute']);
        return new AttributeValue($attributeValueyModel->toArray());
    }
    public function findById(string $id): AttributeValue
    {
        $attributeValueModel = attributeValueModel::with(['attribute'])->findOrFail($id);
        return new AttributeValue($attributeValueModel->toArray());
    }
    public function update(string $id, array $data): AttributeValue
    {
        $attributeValueModel = attributeValueModel::findOrFail($id);
        $attributeValueModel->update($data);
        $attributeValueModel->load(['attribute']);
        return new AttributeValue($attributeValueModel->toArray());
    }

}
