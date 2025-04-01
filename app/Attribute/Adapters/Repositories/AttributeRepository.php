<?php

namespace App\Attribute\Adapters\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Attribute\Domain\Contracts\AttributeRepositoryPort;
use App\Models\Attribute as attributeModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Attribute\Domain\Entities\Attributes;


class AttributeRepository extends BaseRepository implements AttributeRepositoryPort
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        parent::__construct( attributeModel::class);
    }
    public function getAll(int $perPage, array $filters = ['name'], array $sorts = ['name'], string $defaultSort = 'updated_at', array $with = []): LengthAwarePaginator
    {
        return parent::getAll($perPage, $filters, $sorts, $defaultSort, $with);
    }
    public function create(Attributes $attributes): Attributes
    {
        $attributeModel = attributeModel::create([
            'name' => $attributes->name,
        ]);
        return new Attributes($attributeModel->toArray());
    }
    public function findById(string $id): Attributes
    {
        $attributeModel = attributeModel::findOrFail($id);
        return new Attributes($attributeModel->toArray());
    }
    public function update(string $id, array $data): Attributes
    {
        $attributeModel = attributeModel::findOrFail($id);
        $attributeModel->update($data);
        return new Attributes($attributeModel->toArray());
    }
    public function findByName(string $name): Attributes
    {
        $attributeModel = attributeModel::where('name', $name)->firstOrFail();
        return new Attributes($attributeModel->toArray());
    }

}
