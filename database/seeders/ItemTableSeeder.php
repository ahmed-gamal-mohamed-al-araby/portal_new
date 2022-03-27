<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $items = [
            [
                'name_en' => 'operating expenses',
                'name_ar' => 'مصروفات تشغليلية',
            ],
            [
                'name_en' => 'general expenses',
                'name_ar' => 'مصروفات عمومية',
            ],
            [
                'name_en' => 'charges',
                'name_ar' => 'شحنات',
            ],
       
        ];


        foreach ($items as $item) {
            Item::create([
                'name_en' => $item['name_en'],
                'name_ar' => $item['name_ar'],
            ]);
        }
    }
}
