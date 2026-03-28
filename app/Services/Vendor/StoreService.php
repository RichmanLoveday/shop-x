<?php

namespace App\Services\Vendor;

use App\Models\Store;
use App\Models\User;
use App\Repositories\Contracts\Vendor\StoreRepositoryInterface;
use App\Services\Contracts\Vendor\StoreServiceInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Exception;

class StoreService implements StoreServiceInterface
{
    public function __construct(
        protected StoreRepositoryInterface $storeRepo
    ) {}

    public function addStoreDetails(User $vendor, array $data): Store
    {
        // check if vendor is authenticated
        if (!$vendor) {
            throw new Exception('Vendor must be authenticated');
        }

        // extract data to be uploaded
        $storeDatas = [
            'name' => $data['name'],
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'address' => $data['address'] ?? null,
            'short_desc' => $data['short_desc'],
            'long_desc' => $data['long_desc'] ?? null
        ];

        // update or create new record
        $store = $this->storeRepo->updateCreate($vendor->id, $storeDatas);

        // dd($store->toArray());

        // Handle logo
        if (!empty($data['logo']) && $data['logo'] instanceof UploadedFile) {
            $payload['logo'] = $this->uploadStoreLogo($store, $data['logo'], $vendor);
        }

        // // Handle banner
        if (!empty($data['banner']) && $data['banner'] instanceof UploadedFile) {
            $payload['banner'] = $this->uploadStoreBanner($store, $data['banner'], $vendor);
        }

        // dd($payload);
        // // Update once if needed
        if (isset($payload['logo']) || isset($payload['banner'])) {
            // dd($vendor->id);
            $this->storeRepo->update($store, $payload);
        }

        return $store->fresh();
    }

    public function uploadStoreBanner(Store $store, UploadedFile $document): string
    {
        if ($store->user_id !== Auth::guard('web')->user()->id) {
            throw new Exception('Unauthorized: You can only upload documents to your own store.');
        }

        try {
            // remove old document
            $store->clearMediaCollection('banner');

            // upload new document
            $media = $store
                ->addMedia($document)
                ->usingFileName(uniqid() . '.' . $document->getClientOriginalExtension())
                ->toMediaCollection('banner');

            return $media->getUrl();
        } catch (\Exception $e) {
            throw new Exception('Failed to upload banner document');
        }
    }

    public function uploadStoreLogo(Store $store, UploadedFile $document): string
    {
        if ($store->user_id !== Auth::guard('web')->user()->id) {
            throw new Exception('Unauthorized: You can only upload documents to your own store.');
        }

        try {
            // remove old document
            $store->clearMediaCollection('logo');

            // upload new document
            $media = $store
                ->addMedia($document)
                ->usingFileName(uniqid() . '.' . $document->getClientOriginalExtension())
                ->toMediaCollection('logo');

            // dd($media->getUrl());
            return $media->getUrl();
        } catch (\Exception $e) {
            throw new Exception('Failed to upload logo document');
        }
    }

    public function getStoreData(int $vendorId): ?Store
    {
        return $this->storeRepo->getStore($vendorId);
    }
}
