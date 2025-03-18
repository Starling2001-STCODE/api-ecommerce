<?php

// namespace app\Size\Domain\Services\CreateSizeService;

// use app\Size\Adapters\Repositories\SizeRepository;
// use app\Size\Domain\Contracts\SizeRepositoryPort;
// use App\Size\Domain\Entities\Size;

// class CreateSizeService 
// {
//     private SizeRepositoryPort $sizeRepository;
//     public function __construct(SizeRepository $sizeRepository)
//     {
//         $this->sizeRepository = $sizeRepository;
//     }
//     public function execute(array $data): Size
//     {
//         $size = new Size($data);
//         return $this->sizeRepository->create($size);
//     }
// } 