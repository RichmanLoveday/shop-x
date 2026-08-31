<?php

namespace Database\Seeders\Admin;

use App\Models\City;
use App\Models\ShippingZone;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShippingZoneSeeder extends Seeder
{
    public function run(): void
    {
        $zones = [
            'Lagos Mainland' => [
                'Ikeja',
                'Yaba',
                'Surulere',
                'Mushin',
                'Maryland',
                'Anthony',
                'Ojota',
                'Gbagada',
                'Ketu',
                'Magodo',
                'Ogba',
                'Agege',
                'Oshodi',
                'Ilupeju',
                'Fadeyi',
                'Palmgrove',
            ],
            'Lagos Island' => [
                'Lagos Island',
                'Victoria Island',
                'Ikoyi',
                'Falomo',
                'Obalende',
            ],
            'Lekki & Ajah' => [
                'Lekki',
                'Ajah',
                'Sangotedo',
                'Osapa',
                'Chevron',
                'Oniru',
            ],
            'Lagos West' => [
                'Alimosho',
                'Egbeda',
                'Akowonjo',
                'Ipaja',
                'Ayobo',
                'Iyana-Ipaja',
                'Abule-Egba',
                'Meiran',
                'Alagbado',
                'Dopemu',
            ],
            'Lagos East' => [
                'Ikorodu',
                'Igbogbo',
                'Imota',
                'Epe',
            ],
            'Lagos Coastal West' => [
                'Badagry',
                'Ojo',
                'Alaba',
                'Festac',
                'Amuwo-Odofin',
                'Satellite Town',
                'Trade Fair',
                'Mile 2',
            ],
            'Port Harcourt Metro' => [
                'Port Harcourt',
                'Rumuola',
                'Rumuokwuta',
                'Rumuomasi',
                'Rumueme',
                'Elekahia',
                'Diobu',
                'Mile 1',
                'Mile 2',
                'Mile 3',
                'Trans Amadi',
            ],
            'Obio-Akpor' => [
                'Rumuodara',
                'Rumuigbo',
                'Rumuokoro',
                'Choba',
                'Alakahia',
                'Eliozu',
                'Woji',
                'Eneka',
                'Oginigba',
            ],
            'Ikwerre' => [
                'Isiokpo',
                'Igwuruta',
                'Aluu',
                'Ubima',
            ],
            'Eleme & Oyigbo' => [
                'Eleme',
                'Onne',
                'Ogale',
                'Oyigbo',
                'Afam',
            ],
            'Bonny Island' => [
                'Bonny',
                'Finima',
            ],
            'Rivers Riverine' => [
                'Degema',
                'Abonnema',
                'Buguma',
                'Okrika',
                'Opobo',
            ],
            'Ahoada & Omoku' => [
                'Ahoada',
                'Omoku',
                'Emohua',
                'Bori',
            ],
            'Abeokuta' => [
                'Abeokuta',
            ],
            'Ota & Sango' => [
                'Ota',
                'Sango',
                'Ifo',
                'Agbado',
                'Ijoko',
                'Atan',
            ],
            'Sagamu & Remo' => [
                'Sagamu',
                'Iperu',
                'Ilisan',
                'Simawa',
                'Ikenne',
            ],
            'Ijebu Zone' => [
                'Ijebu-Ode',
                'Ilaro',
                'Ijebu-Igbo',
                'Oru',
                'Ago-Iwoye',
                'Odogbolu',
            ],
            'Ibadan Metro' => [
                'Ibadan',
            ],
            'Oyo Regional' => [
                'Oyo',
                'Ogbomoso',
                'Iseyin',
                'Igboho',
                'Kisi',
                'Saki',
            ],
            'Oyo South' => [
                'Eruwa',
                'Lanlate',
                'Igangan',
                'Fiditi',
                'Ilora',
            ],
            'Benin City Metro' => [
                'Benin City',
            ],
            'Edo Regional' => [
                'Auchi',
                'Ekpoma',
                'Irrua',
                'Uromi',
                'Igarra',
                'Afuze',
                'Sabongida-Ora',
                'Fugar',
            ],
            'Warri & Effurun' => [
                'Warri',
                'Effurun',
                'Udu',
            ],
            'Asaba Zone' => [
                'Asaba',
                'Ogwashi-Uku',
            ],
            'Delta Regional' => [
                'Sapele',
                'Ughelli',
                'Agbor',
                'Oghara',
                'Ozoro',
                'Koko',
                'Abraka',
            ],
            'Yenagoa Metro' => [
                'Yenagoa',
            ],
            'Bayelsa Riverine' => [
                'Brass',
                'Nembe',
                'Sagbama',
                'Ekeremor',
                'Ogbia',
            ],
            'Uyo Metro' => [
                'Uyo',
            ],
            'Eket & Ibeno' => [
                'Eket',
                'Ibeno',
                'Onna',
            ],
            'Ikot Ekpene Zone' => [
                'Ikot Ekpene',
                'Abak',
            ],
            'Oron Zone' => [
                'Oron',
            ],
            'Calabar Metro' => [
                'Calabar',
            ],
            'Cross River Regional' => [
                'Ikom',
                'Ogoja',
                'Ugep',
                'Obudu',
                'Akamkpa',
            ],
            'Onitsha Metro' => [
                'Onitsha',
                'Nkpor',
                'Obosi',
                'Ogidi',
            ],
            'Awka & Nnewi' => [
                'Awka',
                'Nnewi',
                'Ekwulobia',
                'Ihiala',
                'Agulu',
                'Nanka',
                'Umunze',
            ],
            'Anambra Riverine' => [
                'Otuocha',
                'Atani',
            ],
            'Aba Metro' => [
                'Aba',
                'Osisioma',
                'Ngwa',
                'Obingwa',
            ],
            'Umuahia Zone' => [
                'Umuahia',
                'Ikwuano',
                'Ohafia',
            ],
            'Enugu Metro' => [
                'Enugu',
                'Emene',
                'Abakpa',
                'New Haven',
                '9th Mile',
            ],
            'Nsukka Zone' => [
                'Nsukka',
            ],
            'Enugu Regional' => [
                'Oji River',
                'Agbani',
                'Awgu',
                'Udi',
            ],
            'Owerri Metro' => [
                'Owerri',
            ],
            'Imo Regional' => [
                'Orlu',
                'Okigwe',
                'Mbaise',
                'Oguta',
                'Ideato',
                'Nkwerre',
            ],
            'Abakaliki Metro' => [
                'Abakaliki',
                'Onueke',
                'Nkalagu',
                'Ezza',
            ],
            'Ebonyi Regional' => [
                'Afikpo',
                'Ohaukwu',
                'Ishielu',
                'Izzi',
                'Edda',
            ],
            'Abuja Central' => [
                'Abuja',
                'Wuse',
                'Garki',
                'Maitama',
                'Asokoro',
                'Central Area',
            ],
            'Abuja North' => [
                'Gwarinpa',
                'Life Camp',
                'Jabi',
                'Kado',
                'Kubwa',
                'Dutse',
                'Bwari',
            ],
            'Abuja South' => [
                'Lokogoma',
                'Galadimawa',
                'Apo',
                'Gudu',
                'Durumi',
                'Lugbe',
                'Airport Road',
                'Kuje',
            ],
            'Kaduna Metro' => [
                'Kaduna',
                'Kafanchan',
                'Kachia',
                'Saminaka',
                'Kawo',
                'Sabon Tasha',
            ],
            'Zaria Zone' => [
                'Zaria',
            ],
            'Kano Metro' => [
                'Kano',
                'Fagge',
                'Nassarawa',
                'Tarauni',
                'Dala',
                'Gwale',
                'Kumbotso',
                'Ungogo',
            ],
            'Kano Regional' => [
                'Wudil',
                'Bichi',
                'Gwarzo',
                'Rano',
            ],
            'Katsina Zone' => [
                'Katsina',
                'Funtua',
                'Daura',
                'Dutsin-Ma',
                'Malumfashi',
            ],
            'Sokoto Zone' => [
                'Sokoto',
                'Wamakko',
                'Tambuwal',
                'Dange-Shuni',
                'Gwadabawa',
            ],
            'Jos Metro' => [
                'Jos',
                'Bukuru',
                'Rayfield',
                'Barkin Ladi',
            ],
            'Plateau Regional' => [
                'Pankshin',
                'Shendam',
                'Langtang',
                'Mangu',
            ],
            'Makurdi Metro' => [
                'Makurdi',
            ],
            'Benue Regional' => [
                'Gboko',
                'Otukpo',
                'Katsina-Ala',
                'Adikpo',
                'Aliade',
                'Zaki-Biam',
            ],
            'Lokoja Metro' => [
                'Lokoja',
            ],
            'Kogi Regional' => [
                'Okene',
                'Idah',
                'Anyigba',
                'Kabba',
                'Ajaokuta',
                'Ankpa',
                'Dekina',
            ],
            'Ilorin Metro' => [
                'Ilorin',
            ],
            'Kwara Regional' => [
                'Offa',
                'Jebba',
                'Lafiagi',
                'Patigi',
                'Omu-Aran',
            ],
            'Lafia Metro' => [
                'Lafia',
                'Keffi',
                'Akwanga',
                'Karu',
                'Mararaba',
                'Masaka',
                'New Nyanya',
            ],
            'Niger Metro' => [
                'Minna',
                'Suleja',
                'Bida',
                'Kontagora',
                'Mokwa',
                'Lapai',
            ],
            'Ado-Ekiti Metro' => [
                'Ado-Ekiti',
                'Ikere',
                'Ikole',
                'Ijero',
                'Ilawe',
                'Oye',
            ],
            'Akure Metro' => [
                'Akure',
                'Ondo City',
                'Owo',
                'Ikare',
                'Ore',
                'Akungba',
            ],
            'Osogbo Metro' => [
                'Osogbo',
                'Ile-Ife',
                'Ilesa',
                'Ede',
                'Iwo',
                'Ikirun',
            ],
            'Yola Metro' => [
                'Yola',
                'Jimeta',
                'Mubi',
                'Numan',
            ],
            'Maiduguri Metro' => [
                'Maiduguri',
                'Dikwa',
                'Konduga',
                'Biu',
            ],
            'Bauchi Metro' => [
                'Bauchi',
                'Azare',
                'Misau',
                'Jama’are',
                'Ningi',
            ],
            'Gombe Zone' => [
                'Gombe',
                'Kaltungo',
                'Billiri',
                'Bajoga',
                'Dukku',
                'Nafada',
            ],
            'Jigawa Zone' => [
                'Dutse',
                'Hadejia',
                'Gumel',
                'Birnin Kudu',
                'Kazaure',
                'Ringim',
            ],
            'Kebbi Zone' => [
                'Birnin Kebbi',
                'Argungu',
                'Yauri',
                'Zuru',
                'Jega',
            ],
            'Taraba Zone' => [
                'Jalingo',
                'Wukari',
                'Bali',
                'Gembu',
                'Takum',
                'Serti',
            ],
            'Yobe Zone' => [
                'Damaturu',
                'Potiskum',
                'Gashua',
                'Nguru',
                'Geidam',
            ],
            'Zamfara Zone' => [
                'Gusau',
                'Kaura Namoda',
                'Talata Mafara',
                'Anka',
                'Bungudu',
                'Maru',
            ],
        ];

        foreach ($zones as $zoneName => $cityNames) {
            $zone = ShippingZone::updateOrCreate(
                [
                    'name' => $zoneName,
                ],
                [
                    'is_active' => true,
                ]
            );

            foreach ($cityNames as $cityName) {
                $city = City::where('name', $cityName)->first();

                if (!$city) {
                    $this->command?->warn(
                        "City [{$cityName}] was not found. Skipping."
                    );

                    continue;
                }

                DB::table('shipping_zone_cities')->updateOrInsert(
                    [
                        'shipping_zone_id' => $zone->id,
                        'city_id' => $city->id,
                    ],
                    [
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}