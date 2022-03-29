<?php

namespace Database\Seeders;

use App\Models\DiscountType;
use Illuminate\Database\Seeder;

class DiscountTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $discountTypes = [
            [
                'code' => '1',
                'name_en' => 'undefined',
                'name_ar' => 'غير محدد',
            ],
            [
                'code' => '2',
                'name_en' => 'returns',
                'name_ar' => 'مردودات',
            ],
            [
                'code' => '3',
                'name_en' => 'commercial response',
                'name_ar' => 'رد تجاري',
            ],
            [
                'code' => '4',
                'name_en' => 'Discount permitted',
                'name_ar' => 'خصم مسموح به',
            ],
            [
                'code' => '5',
                'name_en' => 'advance payments',
                'name_ar' => 'دفعات مقدمة',
            ],
            [
                'code' => '6',
                'name_en' => 'Exemption',
                'name_ar' => 'اعفاء',
            ],
       
        ];


        foreach ($discountTypes as $discountType) {
            DiscountType::create([
                'code' => $discountType['code'],
                'name_en' => $discountType['name_en'],
                'name_ar' => $discountType['name_ar'],
            ]);
        }
    }
}
