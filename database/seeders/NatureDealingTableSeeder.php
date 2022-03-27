<?php

namespace Database\Seeders;

use App\Models\NatureDealing;
use Illuminate\Database\Seeder;

class NatureDealingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $natureDealings = [
            [
                'code' => '2',
                'name_en' => 'supplies',
                'name_ar' => 'التوريدات',
                'discount_type_id' => '1',
            ],
            [
                'code' => '3',
                'name_en' => 'Purchases',
                'name_ar' => 'المشتريات',
                'discount_type_id' => '1',
            ],
            [
                'code' => '22',
                'name_en' => 'Unbound',
                'name_ar' => 'غير مقيد',
                'discount_type_id' => '1',
            ],
            [
                'code' => '4',
                'name_en' => 'Services',
                'name_ar' => 'الخدمات',
                'discount_type_id' => '1',
            ],
            [
                'code' => '10',
                'name_en' => 'professional fees',
                'name_ar' => 'اتعاب مهنية',
                'discount_type_id' => '1',
            ],
            [
                'code' => '21',
                'name_en' => 'employment',
                'name_ar' => 'تشغيل',
                'discount_type_id' => '1',
            ],
            [
                'code' => '1',
                'name_en' => 'Contracting',
                'name_ar' => 'المقاولات',
                'discount_type_id' => '2',
            ],
            [
                'code' => '5',
                'name_en' => 'Amounts paid by motor transport cooperative societies to their members',
                'name_ar' => 'المبالغ التي تدفعها الجمعيات التعاونية للنقل بالسيارات لأعضائها ',
                'discount_type_id' => '1',
            ],
            [
                'code' => '6',
                'name_en' => 'Agency with commission and brokerage',
                'name_ar' => 'الوكالة بالعمولة و السمسرة',
                'discount_type_id' => '1',
            ],
            [
                'code' => '7',
                'name_en' => 'Additional discounts, grants and incentives granted by tobacco and cement companies',
                'name_ar' => 'الخصومات و المنح و الحوافز الإستثنائية الإضافية التي تمنحها شركات الدخان و الأسمنت',
                'discount_type_id' => '1',
            ],
            [
                'code' => '8',
                'name_en' => 'All discounts, grants and commissions granted by petroleum and telecommunications companies and other companies addressed by the discount system',
                'name_ar' => 'جميع الخصومات و المنح و العمولات التي تمنحها شركات البترول و الإتصالات و غيرها من الشركات المخاطبة بنظام الخصم',
                'discount_type_id' => '1',
            ],
            [
                'code' => '9',
                'name_en' => 'Export subsidy support granted by the Export Development Fund',
                'name_ar' => 'مساندة دعم الصادرات التي يمنحها صندوق تنمية الصادرات',
                'discount_type_id' => '1',
            ],
            [
                'code' => '11',
                'name_en' => 'collect licenses',
                'name_ar' => 'تحصيل تراخيص',
                'discount_type_id' => '1',
            ],
            [
                'code' => '13',
                'name_en' => 'collect massacres',
                'name_ar' => 'تحصيل مجازر',
                'discount_type_id' => '1',
            ],
            [
                'code' => '14',
                'name_en' => 'Traffic collection',
                'name_ar' => 'تحصيل المرور',
                'discount_type_id' => '1',
            ],
            [
                'code' => '15',
                'name_en' => 'Courts Collection - Primary',
                'name_ar' => 'تحصيل محاكم - إبتدائي',
                'discount_type_id' => '1',
            ],
            [
                'code' => '16',
                'name_en' => 'Courts Collection - Appeals',
                'name_ar' => 'تحصيل محاكم - إستئناف',
                'discount_type_id' => '1',
            ],
            [
                'code' => '17',
                'name_en' => 'Courts Collection - Real Estate Month',
                'name_ar' => 'تحصيل محاكم - شهر عقاري',
                'discount_type_id' => '1',
            ],
            [
                'code' => '18',
                'name_en' => 'Courts Collection - Cassation',
                'name_ar' => 'تحصيل محاكم - نقض',
                'discount_type_id' => '1',
            ],
            [
                'code' => '19',
                'name_en' => 'Hospitals collecting doctors',
                'name_ar' => 'تحصيل المستشفيات من الأطباء',
                'discount_type_id' => '1',
            ],

       
        ];


        foreach ($natureDealings as $natureDealing) {
            NatureDealing::create([
                'code' => $natureDealing['code'],
                'name_ar' => $natureDealing['name_ar'],
                'name_en' => $natureDealing['name_en'],
                'discount_type_id' => $natureDealing['discount_type_id'],
            ]);
        }
    }

}
