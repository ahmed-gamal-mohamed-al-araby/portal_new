<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Sector;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'username' => 'web.team',
            'name_ar' => 'فريق الويب',
            'name_en' => 'Web Team',
            'email' => 'web.team@eecegypt.com',
            'code' => '0001-000',
            'password' => bcrypt('123456'),
            'sector_id' => Sector::where('name_en', 'Corporate Planning & Development')->first()->id,
            'department_id' => Department::where('name_en', 'Information Technology (IT)')->first()->id,
        ]);

        $user->assignRole("super_admin");

       
        $user = User::create([
            'username' => 'michael.malak',
            'name_ar' => 'مايكل عبدالملاك',
            'name_en' => 'Michael Abd El Malak',
            'email' => 'michael.malak@eecegypt.com',
            'password' => bcrypt('123456'),
             'sector_id' => Sector::where('name_en', 'Purchasing')->first()->id,
            'department_id' => Department::where('name_en', 'Accounting')->first()->id,
        ]);

        $user = User::create([
            'username' => 'george.samir',
            'name_ar' => 'جورج سمير',
            'name_en' => 'George Samir',
            'email' => 'george.samir@eecegypt.com',
            'password' => bcrypt('123456'),
             'sector_id' => Sector::where('name_en', 'Purchasing')->first()->id,
            'department_id' => Department::where('name_en', 'Accounting')->first()->id,
        ]);
        $user = User::create([
            'username' => 'beshoy.aiad',
            'name_ar' => ' بيشوي عياد',
            'name_en' => 'Beshoy Aiad',
            'email' => 'beshoy.aiad@eecegypt.com',
            'password' => bcrypt('123456'),
             'sector_id' => Sector::where('name_en', 'Purchasing')->first()->id,
        ]);
        $user = User::create([
            'username' => 'malak.hanna',
            'name_ar' => ' ملك حنا',
            'name_en' => 'Malak Hanna',
            'email' => 'malak.hanna@eecegypt.com',
            'password' => bcrypt('123456'),
             'sector_id' => Sector::where('name_en', 'Purchasing')->first()->id,
        ]);
        $user = User::create([
            'username' => 'remon.shawky',
            'name_ar' => ' ريمون شوقى',
            'name_en' => 'Remon Shawky',
            'email' => 'remon.shawky@eecegypt.com',
            'password' => bcrypt('123456'),
             'sector_id' => Sector::where('name_en', 'Purchasing')->first()->id,
        ]);
        $user = User::create([
            'username' => 'amir.tharwat',
            'name_ar' => ' امير ثروت',
            'name_en' => 'Amir Tharwat',
            'email' => 'amir.tharwat@eecegypt.com',
            'password' => bcrypt('123456'),
             'sector_id' => Sector::where('name_en', 'Purchasing')->first()->id,
        ]);
        $user = User::create([
            'username' => 'alfred.samir',
            'name_ar' => ' الفريد سمير',
            'name_en' => 'Alfred Samir',
            'email' => 'alfred.samir@eecegypt.com',
            'password' => bcrypt('123456'),
             'sector_id' => Sector::where('name_en', 'Purchasing')->first()->id,
             'department_id' => Department::where('name_en', 'External Purchasing')->first()->id,

        ]);
        $user = User::create([
            'username' => 'banob.samir',
            'name_ar' => ' بانوب سمير',
            'name_en' => 'Banob Samir',
            'email' => 'banob.samir@eecegypt.com',
            'password' => bcrypt('123456'),
             'sector_id' => Sector::where('name_en', 'Purchasing')->first()->id,
             'department_id' => Department::where('name_en', 'External Purchasing')->first()->id,

        ]);
        $user = User::create([
            'username' => 'michael.atta',
            'name_ar' => ' مايكل عطا',
            'name_en' => 'Michael Atta',
            'email' => 'michael.atta@eecegypt.com',
            'password' => bcrypt('123456'),
             'sector_id' => Sector::where('name_en', 'Purchasing')->first()->id,
             'department_id' => Department::where('name_en', 'External Purchasing')->first()->id,

        ]);
        $user = User::create([
            'username' => 'juliana.emad',
            'name_ar' => ' جوليانا عماد',
            'name_en' => 'Juliana emad',
            'email' => 'juliana.emad@eecegypt.com',
            'password' => bcrypt('123456'),
             'sector_id' => Sector::where('name_en', 'Purchasing')->first()->id,
             'department_id' => Department::where('name_en', 'External Purchasing')->first()->id,

        ]);
       
        
        $user = User::create([
            'username' => 'elia.atef',
            'name_ar' => ' ايليا عاطف',
            'name_en' => 'Elia Atef',
            'email' => 'elia.atef@eecegypt.com',
            'password' => bcrypt('123456'),
             'sector_id' => Sector::where('name_en', 'Accounts, Audit & Inventory')->first()->id,
             'department_id' => Department::where('name_en', 'Audit')->first()->id,

        ]);
        $user = User::create([
            'username' => 'peter.makram',
            'name_ar' => ' بيتر مكرم',
            'name_en' => 'Peter Makram',
            'email' => 'peter.makram@eecegypt.com',
            'password' => bcrypt('123456'),
             'sector_id' => Sector::where('name_en', 'Accounts, Audit & Inventory')->first()->id,
             'department_id' => Department::where('name_en', 'Audit')->first()->id,

        ]);
        $user = User::create([
            'username' => 'mohsen.fathy',
            'name_ar' => ' محسن فتحي',
            'name_en' => 'Mohsen fathy',
            'email' => 'mohsen.fathy@eecegypt.com',
            'password' => bcrypt('123456'),
             'sector_id' => Sector::where('name_en', 'Accounts, Audit & Inventory')->first()->id,
             'department_id' => Department::where('name_en', 'Audit')->first()->id,

        ]);
        $user = User::create([
            'username' => 'walid.sadek',
            'name_ar' => ' وليد صادق',
            'name_en' => 'Walid Sadek',
            'email' => 'walid.sadek@eecegypt.com',
            'password' => bcrypt('123456'),
             'sector_id' => Sector::where('name_en', 'Accounts, Audit & Inventory')->first()->id,
             'department_id' => Department::where('name_en', 'Audit')->first()->id,

        ]);
        $user = User::create([
            'username' => 'mohamed.halim',
            'name_ar' => ' محمد عبد الحليم',
            'name_en' => 'Mohamed Abd El halim',
            'email' => 'mohamed.halim@eecegypt.com',
            'password' => bcrypt('123456'),
             'sector_id' => Sector::where('name_en', 'Accounts, Audit & Inventory')->first()->id,
             'department_id' => Department::where('name_en', 'Audit')->first()->id,

        ]);


        $user = User::create([
            'username' => 'hany.helmy',
            'name_ar' => ' هانى حلمى',
            'name_en' => 'Hany Helmy',
            'email' => 'hany.helmy@eecegypt.com',
            'password' => bcrypt('123456'),
             'sector_id' => Sector::where('name_en', 'Accounts, Audit & Inventory')->first()->id,
             'department_id' => Department::where('name_en', 'Cost')->first()->id,

        ]);
        $user = User::create([
            'username' => 'mariam.hussien',
            'name_ar' => ' مريم حسين',
            'name_en' => 'Mariam Hussien',
            'email' => 'mariam.hussien@eecegypt.com',
            'password' => bcrypt('123456'),
             'sector_id' => Sector::where('name_en', 'Accounts, Audit & Inventory')->first()->id,
             'department_id' => Department::where('name_en', 'Cost')->first()->id,

        ]);
        $user = User::create([
            'username' => 'ashraf.mosaad',
            'name_ar' => ' اشرف مسعد',
            'name_en' => 'Ashraf Mosaad',
            'email' => 'ashraf.mosaad@eecegypt.com',
            'password' => bcrypt('123456'),
             'sector_id' => Sector::where('name_en', 'Accounts, Audit & Inventory')->first()->id,
             'department_id' => Department::where('name_en', 'Cost')->first()->id,

        ]);
        $user = User::create([
            'username' => 'youssef.mahmoud',
            'name_ar' => ' يوسف محمود',
            'name_en' => 'Youssef Mahmoud',
            'email' => 'youssef.mahmoud@eecegypt.com',
            'password' => bcrypt('123456'),
            'sector_id' => Sector::where('name_en', 'Construction #2')->first()->id,
            'department_id' => Department::where('name_en', 'Construction Planning & Follow Up')->first()->id,

        ]);
        $user = User::create([
            'username' => 'vivian.fahmy',
            'name_ar' => ' فيفيان فهمي',
            'name_en' => 'Vivian Fahmy',
            'email' => 'vivian.fahmy@eecegypt.com',
            'password' => bcrypt('123456'),
            'sector_id' => Sector::where('name_en', 'Construction #3')->first()->id,
            'department_id' => Department::where('name_en', 'Construction Planning & Follow Up')->first()->id,

        ]);
        $user = User::create([
            'username' => 'george.kheir',
            'name_ar' => ' جورج ابو الخير',
            'name_en' => 'George Abu El Kheir',
            'email' => 'george.kheir@eecegypt.com',
            'password' => bcrypt('123456'),
            'sector_id' => Sector::where('name_en', 'Construction #4')->first()->id,
            'department_id' => Department::where('name_en', 'Construction Planning & Follow Up')->first()->id,

        ]);

        // for ($i = 1; $i <= 100; $i++) {
        //     User::create([
        //         'username' => 'employee' . $i . 'user',
        //         'name_ar' => 'موظف' . $i,
        //         'name_en' => 'Employee' . $i,
        //         'email' => 'employee' . $i . '.fake@eecegypt.com',
        //         'code' => '11' . str_pad($i, 3, '0', STR_PAD_LEFT),
        //         'password' => bcrypt('123456'),
        //     ]);
        // }
    }
}
