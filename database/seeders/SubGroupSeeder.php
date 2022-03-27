<?php

namespace Database\Seeders;

use App\Models\SubGroup;
use Illuminate\Database\Seeder;

class SubGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SubGroup::create([
            'name_ar' => 'أعمال مدنية',
            'name_en' => 'civil works',
            'group_id' => 1,
        ]);

        SubGroup::create([
            'name_ar' => 'أعمال تشطيبات',
            'name_en' => 'Finishing works',
            'group_id' => 1,
        ]);

        SubGroup::create([
            'name_ar' => 'أعمال إنذار ومكافحة حريق',
            'name_en' => 'Alarm and fire fighting works',
            'group_id' => 2,
        ]);

        SubGroup::create([
            'name_ar' => 'أعمال كهرباء',
            'name_en' => 'Electricity works',
            'group_id' => 2,
        ]);

        SubGroup::create([
            'name_ar' => 'أعمال ميكانيكية + صرف',
            'name_en' => 'mechanical work + drainage',
            'group_id' => 2,
        ]);

        SubGroup::create([
            'name_ar' => 'تجهيزات موقع',
            'name_en' => 'Site Equipment',
            'group_id' => 3,
        ]);

        SubGroup::create([
            'name_ar' => 'أخري',
            'name_en' => 'other',
            'group_id' => 3,
        ]);

        SubGroup::create([
            'name_ar' => 'خامات',
            'name_en' => 'ores',
            'group_id' => 7,
        ]);
        SubGroup::create([
            'name_ar' => 'مستهلكات',
            'name_en' => 'consumables',
            'group_id' => 7,
        ]);
        SubGroup::create([
            'name_ar' => 'عده ومعدات',
            'name_en' => 'tools and equipment',
            'group_id' => 7,
        ]);
        SubGroup::create([
            'name_ar' => 'لابتوبات',
            'name_en' => 'laptops',
            'group_id' => 4,
        ]);
        // for ($i = 0; $i < 10; $i++) {
        //     SubGroup::create([
        //         'name_ar' => '__مجموعة' . ($i + 1),
        //         'name_en' => 'SubGroup' . ($i + 1),
        //         'group_id' => ($i % 3) + 7,
        //     ]);
        // }
    }
}
