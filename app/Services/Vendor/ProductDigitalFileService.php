<?php
namespace App\Services\Vendor;

use App\Enums\ProductFilesStatus;
use App\Enums\ProductType;
use App\Jobs\ProcessDigitalFileJob;
use App\Models\Admin;
use App\Models\ProductFile;
use App\Models\User;
use App\Repositories\Contracts\Admin\ProductRepositoryInterface;
use App\Services\Contracts\Admin\ProductDigitalFileServiceInterface;
use App\Services\BaseService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class ProductDigitalFileService extends BaseService implements ProductDigitalFileServiceInterface
{
    private array $allowedMimeTypes = [
        /** Documents */
        'application/pdf',
        'application/zip',
        'application/x-zip-compressed',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',  // docx
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',  // xlsx
        'text/plain',
        /** Audio */
        'audio/mpeg',  // mp3
        'audio/wav',
        'audio/ogg',
        'audio/mp4',
        /** Video */
        'video/mp4',
        'video/webm',
        'video/quicktime',
        /** Images */
        'image/jpeg',
        'image/jpg',
        'image/png',
        'image/gif',
        'image/webp',
    ];

    public function __construct(
        protected ProductRepositoryInterface $productRepo,
    ) {}

    // public function handleChunkUpload(int $productId, ProductType|string $type, array $data): array
    // {
    //     $product = $this->getProduct($productId, $type);

    //     $file = $data['file'];
    //     $uuid = $data['dzuuid'];
    //     $chunkIndex = (int) $data['dzchunkindex'];
    //     $totalChunks = (int) $data['dztotalchunkcount'];
    //     $fileName = $file->getClientOriginalName();

    //     $lockKey = "upload_merge_{$uuid}";

    //     // handle cases where chunk datas are already processed
    //     // if (cache()->has($lockKey)) {
    //     //     return [
    //     //         'status' => 'already_processed'
    //     //     ];
    //     // }

    //     $chunkFolder = storage_path("app/private/chunks/{$uuid}");

    //     if (!file_exists($chunkFolder)) {
    //         mkdir($chunkFolder, 0777, true);
    //     }

    //     $chunkPath = "{$chunkFolder}/{$chunkIndex}";

    //     file_put_contents($chunkPath, file_get_contents($file->getRealPath()));

    //     // count received chunks
    //     $receivedChunks = count(glob($chunkFolder . '/*'));

    //     if ($receivedChunks == $totalChunks && cache()->add($lockKey, true, 300)) {
    //         return $this->mergeChunks($uuid, $file, $fileName, $totalChunks, $product->id);
    //     }

    //     return ['status' => 'chunk_uploaded'];
    // }

    public function handleChunkUpload(int $productId, User|Admin $user, ProductType|string $type, array $data): array
    {
        $product = $this->productRepo->getProduct($productId, $type);

        $uploadedFile = $data['file'];
        $uploadUuid = $data['dzuuid'];
        $chunkIndex = (int) $data['dzchunkindex'];
        $totalChunks = (int) $data['dztotalchunkcount'];
        $originalFileName = $uploadedFile->getClientOriginalName();

        $lockKey = "upload_merge_{$uploadUuid}_{$productId}";
        $chunkDirectory = storage_path("app/private/chunks/{$uploadUuid}");
        $chunkPath = "{$chunkDirectory}/{$chunkIndex}";
        $maxFileSize = 500 * 1024 * 1024;  // 500MB

        /** Prevent duplicate merge processing */
        if (cache()->has($lockKey)) {
            return [
                'status' => 'already_processed',
            ];
        }

        /** Ensure chunk directory exists */
        if (!file_exists($chunkDirectory)) {
            mkdir($chunkDirectory, 0777, true);
        }

        $totalFileSize = (int) $data['dztotalfilesize'];

        if ($totalFileSize > $maxFileSize) {
            throw new \Exception('File size cannot exceed 500MB.');
        }

        /** Save current chunk */
        file_put_contents(
            $chunkPath,
            file_get_contents($uploadedFile->getRealPath())
        );

        /** Count uploaded chunks */
        $receivedChunks = count(glob($chunkDirectory . '/*'));

        /**
         * Trigger merge only when:
         * - all chunks are uploaded
         * - merge has not already started
         */
        if (
            $receivedChunks === $totalChunks &&
            cache()->add($lockKey, true, now()->addMinutes(5))
        ) {
            return $this->mergeChunks(
                uuid: $uploadUuid,
                file: $uploadedFile,
                user: $user,
                totalChunks: $totalChunks,
                productId: $product->id
            );
        }

        return [
            'status' => 'chunk_uploaded',
        ];
    }

    // private function mergeChunks($uuid, $file, $fileName, $totalChunks, $productId): array
    // {
    //     $tempPath = storage_path("app/private/chunks/{$uuid}");
    //     $finalPath = storage_path('app/private/uploads');

    //     // Ensure directory exists
    //     if (!file_exists($finalPath)) {
    //         mkdir($finalPath, 0777, true);
    //     }

    //     // Safe filename
    //     $safeFileName = Str::uuid() . '.' . $file->getClientOriginalExtension();

    //     $finalPath = $finalPath . '/' . $safeFileName;

    //     Log::info('Final path: ' . $finalPath);

    //     $out = fopen($finalPath, 'wb');

    //     for ($i = 0; $i < $totalChunks; $i++) {
    //         $chunkFile = "{$tempPath}/{$i}";
    //         $in = fopen($chunkFile, 'rb');
    //         stream_copy_to_stream($in, $out);
    //         fclose($in);
    //         unlink($chunkFile);
    //     }

    //     fclose($out);
    //     rmdir($tempPath);

    //     // store data in db
    //     Log::info('Uploading to digital file to db');

    //     $file = $this->productRepo->createDigitalFile([
    //         'product_id' => $productId,
    //         'filename' => $safeFileName,
    //         'status' => ProductFilesStatus::PROCESSING,
    //         'extension' => $file->getClientOriginalExtension(),
    //         'path' => null,
    //         'size' => null,
    //     ]);

    //     // dispatch a job to handle file upload
    //     Log::info('Dispatching digital file.');
    //     $admin = Auth::guard('admin')->user();
    //     ProcessDigitalFileJob::dispatch($file->id, $finalPath, $admin);

    //     // return array
    //     return [
    //         'status' => ProductFilesStatus::PROCESSING->value,
    //         // 'path' => $finalPath
    //     ];
    // }

    public function getDigitalFile(int $productId, int $fileId, ProductType|string $type = ProductType::PHYSICAL): ProductFile
    {
        return $this->productRepo->findDigitalFile($fileId, $productId);
    }

    public function deleteDigitalFile(int $productId, int $fileId): bool
    {
        $file = $this->productRepo->findDigitalFile($fileId, $productId);

        if (!$file) {
            return false;
        }

        // delete from storage
        $this->removeFileFromStorage($file);
        return $file->delete();
    }

    public function removeFileFromStorage(ProductFile $file): void
    {
        if ($file->path) {
            if ($file->status === ProductFilesStatus::COMPLETED) {
                // delete from Wasabi
                if (Storage::disk('wasabi')->exists($file->path)) {
                    Storage::disk('wasabi')->delete($file->path);
                }
            } else {
                // delete local file if exists
                $this->safeUnlink($file->path);
            }
        }
    }

    private function mergeChunks($uuid, $file, $user, $totalChunks, $productId): array
    {
        $tempPath = storage_path("app/private/chunks/{$uuid}");
        $finalPath = storage_path('app/private/uploads');

        if (!file_exists($finalPath)) {
            mkdir($finalPath, 0777, true);
        }

        $safeFileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $localFilePath = $finalPath . '/' . $safeFileName;

        Log::info('Merging file: ' . $localFilePath);

        $out = fopen($localFilePath, 'wb');

        for ($i = 0; $i < $totalChunks; $i++) {
            $chunkFile = "{$tempPath}/{$i}";

            if (!file_exists($chunkFile)) {
                throw new RuntimeException("Missing chunk: {$chunkFile}");
            }

            $in = fopen($chunkFile, 'rb');

            if (!$in) {
                throw new RuntimeException("Cannot open chunk: {$chunkFile}");
            }

            stream_copy_to_stream($in, $out);
            fclose($in);

            unlink($chunkFile);
        }

        fclose($out);

        // cleanup folder safely
        if (is_dir($tempPath) && count(glob($tempPath . '/*')) === 0) {
            rmdir($tempPath);
        }

        // validation (safe cleanup on failure)
        try {
            $this->validateFile($localFilePath);
        } catch (\Throwable $e) {
            $this->safeUnlink($localFilePath);
            throw $e;
        }

        $size = filesize($localFilePath);

        $digitalFile = $this->productRepo->createDigitalFile([
            'product_id' => $productId,
            'filename' => $file->getClientOriginalName(),
            'status' => ProductFilesStatus::PROCESSING,
            'extension' => $file->getClientOriginalExtension(),
            'path' => $localFilePath,
            'size' => $size,
        ]);

        Log::info('Dispatching job for file: ' . $digitalFile->id);

        ProcessDigitalFileJob::dispatch($digitalFile->id, $productId, $safeFileName, $user);

        return [
            'status' => ProductFilesStatus::PROCESSING->value,
            'digitalFile' => $digitalFile,
        ];
    }

    private function validateFile(string $finalPath): void
    {
        if (!file_exists($finalPath)) {
            throw new RuntimeException("File not found: {$finalPath}");
        }

        $maxFileSizeBytes = 500 * 1024 * 1024;  // 500MB

        if (filesize($finalPath) > $maxFileSizeBytes) {
            $this->safeUnlink($finalPath);
            throw new RuntimeException('File size limit reached (500MB)');
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);

        if (!$finfo) {
            throw new RuntimeException('Unable to open file info');
        }

        $mimeType = finfo_file($finfo, $finalPath);

        finfo_close($finfo);

        if (!$mimeType) {
            $this->safeUnlink($finalPath);
            throw new RuntimeException('Could not detect file type');
        }

        if (!in_array($mimeType, $this->allowedMimeTypes, true)) {
            $this->safeUnlink($finalPath);
            throw new RuntimeException("File type not allowed: {$mimeType}");
        }
    }

    private function safeUnlink(string $path): void
    {
        if (file_exists($path)) {
            @unlink($path);
        }
    }

    // public function deleteDigitalFile(int $productId, int $fileId): bool
    // {
    //     $file = $this->productRepo->findDigitalFile($fileId, $productId);

    //     if (!$file) {
    //         return false;
    //     }

    //     // Log::info($file->toArray());

    //     $file->update([
    //         'status' => ProductFilesStatus::DELETING,
    //     ]);

    //     DeleteDigitalFileJob::dispatch($file->id, $productId);

    //     return true;
    // }
}
