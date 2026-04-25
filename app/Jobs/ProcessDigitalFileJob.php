<?php

namespace App\Jobs;

use App\Enums\ProductFilesStatus;
use App\Events\DigitalProductFileUploadComplete;
use App\Models\Admin;
use App\Models\User;
use App\Repositories\Contracts\Admin\ProductRepositoryInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProcessDigitalFileJob implements ShouldQueue
{
    use Queueable;

    public $timeout = 600;
    public $tries = 3;
    public $backoff = [10, 30, 60];

    public function __construct(
        public int $fileId,
        public int $productId,
        public string $safeFileName,
        public User|Admin $user,
    ) {}

    public function handle(): void
    {
        $productRepo = app(ProductRepositoryInterface::class);

        $file = $productRepo->findDigitalFile($this->fileId, $this->productId);

        if (!$file || $file->status === ProductFilesStatus::COMPLETED) {
            return;
        }

        try {
            Log::info("Processing file ID: {$this->fileId}");

            $localPath = $file->path;

            if (!file_exists($localPath)) {
                throw new \Exception("File not found locally: {$localPath}");
            }

            $wasabiPath = "digital-products/{$file->product_id}/{$this->safeFileName}";

            /** STREAM UPLOAD (important improvement) */
            Storage::disk('wasabi')->writeStream(
                $wasabiPath,
                fopen($localPath, 'rb')
            );

            unlink($localPath);

            $file->update([
                'status' => ProductFilesStatus::COMPLETED,
                'path' => $wasabiPath,
                'size' => Storage::disk('wasabi')->size($wasabiPath),
            ]);

            $file = $file->fresh('product');

            event(new DigitalProductFileUploadComplete($file, $this->user));
        } catch (\Throwable $e) {
            $file?->update([
                'status' => ProductFilesStatus::FAILED,
            ]);

            logger()->error($e->getMessage());
        }
    }
}
