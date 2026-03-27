<?php

namespace Database\Seeders\Vender;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();
        $user->name = 'Test User';
        $user->email = 'vendor@gmail.com';
        $user->password = bcrypt('password');
        $user->role = UserRole::VENDOR->value;
        $user->save();
    }
}
