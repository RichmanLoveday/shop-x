<?php

namespace App\Repositories\Contracts\Admin;

use App\Models\Setting;

interface SettingsRepositoryInterface
{
    public function update(array $data): void;
}