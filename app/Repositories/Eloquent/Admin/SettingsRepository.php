<?php

namespace App\Repositories\Eloquent\Admin;

use App\Models\Setting;
use App\Repositories\Contracts\Admin\SettingsRepositoryInterface;

class SettingsRepository implements SettingsRepositoryInterface
{
    public function update(array $data): void
    {
        foreach ($data as $key => $value) {
            Setting::query()
                ->updateOrCreate(
                    ['key' => $key],
                    ['value' => $value],
                );
        }
    }
}
