<?php
namespace App\Services\Contracts\Vendor;

use App\Enums\ProductType;
use App\Models\Admin;
use App\Models\ProductFile;
use App\Models\User;

interface ProductDigitalFileServiceInterface
{
    public function handleChunkUpload(int $productId, User|Admin $user, ProductType|string $type, array $data): array;

    public function getDigitalFile(int $productId, int $fileId, ProductType|string $type = ProductType::PHYSICAL): ProductFile;

    public function deleteDigitalFile(int $productId, int $fileId): bool;

    public function removeFileFromStorage(ProductFile $file): void;

}