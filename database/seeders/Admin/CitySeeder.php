<?php

namespace Database\Seeders\Admin;

use App\Models\City;
use App\Models\State;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Lagos' => [
                'Ikeja',
                'Lekki',
                'Ajah',
                'Surulere',
                'Yaba',
                'Ikorodu',
                'Epe',
                'Victoria Island',
                'Ikoyi',
            ],
            'Rivers' => [
                'Port Harcourt',
                'Obio-Akpor',
                'Bonny',
                'Okrika',
                'Eleme',
            ],
            'FCT' => [
                'Abuja',
                'Gwagwalada',
                'Kubwa',
                'Kuje',
                'Nyanya',
                'Wuse',
                'Maitama',
            ],
            'Kano' => [
                'Kano Municipal',
                'Fagge',
                'Gwale',
                'Dala',
                'Tarauni',
            ],
            'Oyo' => [
                'Ibadan',
                'Ogbomosho',
                'Oyo Town',
                'Iseyin',
            ],
            'Delta' => [
                'Asaba',
                'Warri',
                'Sapele',
                'Ughelli',
            ],
            'Anambra' => [
                'Awka',
                'Onitsha',
                'Nnewi',
            ],
            'Edo' => [
                'Benin City',
                'Auchi',
                'Ekpoma',
            ],
        ];

        foreach ($data as $stateName => $cities) {
            $state = State::where('name', $stateName)->first();

            if (!$state)
                continue;

            foreach ($cities as $city) {
                City::create([
                    'state_id' => $state->id,
                    'name' => $city,
                    'is_active' => true,
                ]);
            }
        }
    }
}