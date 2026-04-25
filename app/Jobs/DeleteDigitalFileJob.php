<?php

namespace App\Jobs;

use App\Enums\ProductFilesStatus;
use App\Repositories\Contracts\Admin\ProductRepositoryInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;

class DeleteDigitalFileJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $fileId,
        public int $productId,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $productRepo = app(ProductRepositoryInterface::class);

            $file = $productRepo->findDigitalFile($this->fileId, $this->productId);

            if (!$file) {
                return;
            }

            // check if storage exist, and delete
            if ($file->path) {
                if ($file->status === ProductFilesStatus::COMPLETED) {
                    // delete from Wasabi
                    Storage::disk('wasabi')
                        ->delete($file->path);
                } else {
                    // delete local file if exists
                    if (file_exists($file->path)) {
                        unlink($file->path);
                    }
                }
            }

            $file->delete();
        } catch (\Throwable $e) {
            $file?->update([
                'status' => ProductFilesStatus::COMPLETED,
            ]);

            logger()->error($e->getMessage());
        }
    }
}