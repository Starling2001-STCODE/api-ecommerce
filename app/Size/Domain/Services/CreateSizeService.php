<?php

namespace App\Size\Domain\Services;

use App\Size\Adapters\Repositories\SizeRepository;
use App\Size\Domain\Contracts\SizeRepositoryPort;
use App\Size\Domain\Entities\Size;

class CreateSizeService 
{
    private SizeRepositoryPort $sizeRepository;
    public function __construct(SizeRepository $sizeRepository)
    {
        $this->sizeRepository = $sizeRepository;
    }
    public function execute(array $data): Size
    {
        $size = new Size($data);
        return $this->sizeRepository->create($size);
    }
}