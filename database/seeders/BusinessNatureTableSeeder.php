<?php

namespace Database\Seeders;

use App\Models\BusinessNature;
use Illuminate\Database\Seeder;

class BusinessNatureTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $businessNatures = [
            [
                'item_id' => '1',
                'name_en' => 'Integrated works',
                'name_ar' => 'اعمال متكامله',                
            ],[
                'item_id' => '1',
                'name_en' => 'Installation of metal structures',
                'name_ar' => 'تركيب منشآت معدنية',                
            ],[
                'item_id' => '1',
                'name_en' => 'Drainage networks + feeding',
                'name_ar' => 'شبكات صرف + تغذية',                
            ],[
                'item_id' => '2',
                'name_en' => 'hospitality',
                'name_ar' => 'ضيـــافة',                
            ],[
                'item_id' => '2',
                'name_en' => 'maintenance',
                'name_ar' => 'صيـــانة',                
            ],[
                'item_id' => '2',
                'name_en' => 'photography',
                'name_ar' => 'تصويــر',                
            ],[
                'item_id' => '2',
                'name_en' => 'Fast mail',
                'name_ar' => 'بريد سريع ',                
            ],[
                'item_id' => '2',
                'name_en' => 'cleanliness',
                'name_ar' => 'نظافـــة',                
            ],[
                'item_id' => '2',
                'name_en' => 'Donations',
                'name_ar' => 'تبرعــات',                
            ],[
                'item_id' => '2',
                'name_en' => 'Tenders',
                'name_ar' => 'مناقصات',                
            ],[
                'item_id' => '2',
                'name_en' => 'Social Services Fund',
                'name_ar' => 'صندوق الخدمات الاجتماعية',                
            ],[
                'item_id' => '2',
                'name_en' => 'Electricity',
                'name_ar' => 'كهربــاء',                
            ],[
                'item_id' => '2',
                'name_en' => 'A stationery and publications',
                'name_ar' => 'أ مكتبية ومطبوعات',                
            ],[
                'item_id' => '2',
                'name_en' => 'gas',
                'name_ar' => 'غـــاز',                
            ],[
                'item_id' => '2',
                'name_en' => 'transitions',
                'name_ar' => 'انتقـالات ',                
            ],[
                'item_id' => '2',
                'name_en' => 'travel abroad',
                'name_ar' => 'سفر للخارج',                
            ],[
                'item_id' => '2',
                'name_en' => 'Car rental to transport workers',
                'name_ar' => 'تأجير سيارات لنقل العاملين',                
            ],[
                'item_id' => '2',
                'name_en' => 'rent',
                'name_ar' => 'ايجــارات',                
            ],[
                'item_id' => '2',
                'name_en' => 'workers uniforms',
                'name_ar' => 'زي عامليـن ',                
            ],[
                'item_id' => '2',
                'name_en' => 'Fees and subscriptions',
                'name_ar' => 'رسوم واشتراكات',                
            ],[
                'item_id' => '2',
                'name_en' => 'Telephones and the Internet',
                'name_ar' => 'تليفونات وانترنت',                
            ],[
                'item_id' => '2',
                'name_en' => 'M . Company amendment contract fee',
                'name_ar' => 'م . ورسوم عقد تعديل الشركة ',                
            ],[
                'item_id' => '2',
                'name_en' => 'perks',
                'name_ar' => 'اكراميــات',                
            ],[
                'item_id' => '2',
                'name_en' => 'professional fees',
                'name_ar' => 'اتعاب مهنيه',                
            ],[
                'item_id' => '2',
                'name_en' => 'Advertising',
                'name_ar' => 'دعاية واعلان',                
            ],[
                'item_id' => '2',
                'name_en' => 'Yellow Pages Guide',
                'name_ar' => 'دليل يلوبيدجز ',                
            ],[
                'item_id' => '2',
                'name_en' => 'treatment',
                'name_ar' => 'عـــلاج',                
            ],[
                'item_id' => '2',
                'name_en' => 'Activities and benefits for employees',
                'name_ar' => 'انشطة ومزايا للعاملين',                
            ],[
                'item_id' => '2',
                'name_en' => 'Newspapers and magazines',
                'name_ar' => 'صحف ومجلات',                
            ],[
                'item_id' => '2',
                'name_en' => 'water',
                'name_ar' => 'ميـــاه',                
            ],[
                'item_id' => '2',
                'name_en' => 'gifts',
                'name_ar' => 'هدايــا',                
            ],[
                'item_id' => '2',
                'name_en' => 'Insurances. social',
                'name_ar' => 'تامينات . اجتماعية ',                
            ],[
                'item_id' => '2',
                'name_en' => 'ISO',
                'name_ar' => 'ايــــزو',                
            ],[
                'item_id' => '2',
                'name_en' => 'training',
                'name_ar' => 'تدريبـات',                
            ],[
                'item_id' => '2',
                'name_en' => 'garden expenses',
                'name_ar' => 'مصروفات حديقة',                
            ],[
                'item_id' => '2',
                'name_en' => 'health insurance',
                'name_ar' => 'تامين صحى  ',                
            ],[
                'item_id' => '2',
                'name_en' => 'm computer',
                'name_ar' => 'م كمبيوتـر',                
            ],[
                'item_id' => '2',
                'name_en' => 'salaries',
                'name_ar' => 'مرتبـــات',                
            ],[
                'item_id' => '2',
                'name_en' => 'workers emergency',
                'name_ar' => 'طوارئ العاملين',                
            ],[
                'item_id' => '2',
                'name_en' => 'M . nutrition',
                'name_ar' => ' م . تغــذية ',                
            ],[
                'item_id' => '2',
                'name_en' => 'cars',
                'name_ar' => 'سيـــارات',                
            ],[
                'item_id' => '2',
                'name_en' => 'Soft Ware',
                'name_ar' => 'برمجة',                
            ],[
                'item_id' => '2',
                'name_en' => 'government stamps',
                'name_ar' => 'دمغات حكومية',                
            ],[
                'item_id' => '2',
                'name_en' => 'Security and guarding',
                'name_ar' => 'أمن و حراسة',                
            ],[
                'item_id' => '2',
                'name_en' => 'Check differences',
                'name_ar' => 'فروق فحص',                
            ],[
                'item_id' => '2',
                'name_en' => 'samples',
                'name_ar' => 'عينات',                
            ],[
                'item_id' => '2',
                'name_en' => 'opposed',
                'name_ar' => 'معارض',                
            ],[
                'item_id' => '2',
                'name_en' => 'compensation',
                'name_ar' => 'تعويضات',                
            ]
        ];

        
        foreach ($businessNatures as $businessNature) {
            BusinessNature::create([
                'name_en' => $businessNature['name_en'],
                'name_ar' => $businessNature['name_ar'],
                'item_id' => $businessNature['item_id'],

            ]);
        }


    }
}
