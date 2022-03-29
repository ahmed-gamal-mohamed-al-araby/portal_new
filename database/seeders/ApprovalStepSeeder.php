<?php

namespace Database\Seeders;

use App\Models\ApprovalStep;
use Illuminate\Database\Seeder;

class ApprovalStepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* depth
            // relation via models
        */

         /* query
            // T: satnds for Table name
            // CONs: stands for conditions
            // CN: stands for Column name
            // CV: stands for Column value
        */

        ApprovalStep::create([
            'name_ar' => 'المدير المباشر',
            'name_en' => 'Direct manager',
            'code' => 'DIR_M',
            'value' => '{"depth":["manager"], "query" : []}',
        ]);

        ApprovalStep::create([
            'name_ar' => 'المنشئ ',
            'name_en' =>  'Merchandising team leader',
            'code' => 'CREATOR',
            'value' => '{"depth":["user"], "query" : []}',
        ]);

        ApprovalStep::create([
            'name_ar' => 'مدير القسم',
            'name_en' => 'Department manager',
            'code' => 'DEP_M',
            'value' => '{"depth":["department", "manager"], "query" : []}',
        ]);

        ApprovalStep::create([
            'name_ar' => 'مدير ادارة المشتريات',
            'name_en' => 'Purchasing Department manager',
            'code' => 'PUR_DEP_M',
            'value' => '{"depth":[],"query":{"T":"departments","CONs":[{"CN":"name_en","CV":"Internal Purchasing"}],"depth":["first()" ,"manager"]}}',
        ]);

        ApprovalStep::create([
            'name_ar' => 'مدير المراجعه',
            'name_en' => 'Audit Manager',
            'code' => 'AUD_M',
            'value' => '{"depth":[],"query":{"T":"departments","CONs":[{"CN":"name_en","CV":"Audit"}],"depth":["first()" ,"manager"]}}',
        ]);

        ApprovalStep::create([
            'name_ar' => ' رئيس قطاع الحسابات والمراجعة والمخازن',
            'name_en' => ' Head of Accounts, Audit & Inventory',
            'code' => 'HEAD_ACC_AUD',
            'value' => '{"depth":[],"query":{"T":"sectors","CONs":[{"CN":"name_en","CV":"Accounts, Audit & Inventory"}],"depth":["first()" ,"head"]}}',
        ]);

        ApprovalStep::create([
            'name_ar' => 'مدير مراقبة التكاليف',
            'name_en' => 'Cost Control Manager',
            'code' => 'COST_M',
            'value' => '{"depth":[],"query":{"T":"departments","CONs":[{"CN":"name_en","CV":"Cost"}],"depth":["first()" ,"manager"]}}',
        ]);

        ApprovalStep::create([
            'name_ar' => 'رئيس القطاع',
            'name_en' => 'Sector head',
            'code' => 'SEC_H',
            'value' => '{"depth":["sector", "head"], "query" : []}',
        ]);

        ApprovalStep::create([
            'name_ar' => 'الرئيس التنفيذي',
            'name_en' => 'Chief Executive Officer (CEO)',
            'code' => 'CEO_H',
            'value' => '{"depth":[],"query":{"T":"sectors","CONs":[{"CN":"name_en","CV":"Chief Executive Officer (CEO)"}],"depth":["first()" ,"head"]}}',
        ]);

        ApprovalStep::create([
            'name_ar' => 'الرئيس التنفيذي للعمليات',
            'name_en' => 'Chief Operating Officer (COO)',
            'code' => 'COO_H',
            'value' => '{"depth":[],"query":{"T":"sectors","CONs":[{"CN":"name_en","CV":"Chief Operating Officer (COO)"}],"depth":["first()" ,"head"]}}',
        ]);

        ApprovalStep::create([
            'name_ar' => 'المدير المالي',
            'name_en' => 'Chief Financial Officer (CFO)',
            'code' => 'CFO_H',
            'value' => '{"depth":[],"query":{"T":"sectors","CONs":[{"CN":"name_en","CV":"Chief Financial Officer (CFO)}],"depth":["first()" ,"head"]}}',
        ]);

        ApprovalStep::create([
            'name_ar' => 'رئيس قطاع التخطيط',
            'name_en' => 'Planning sector head',
            'code' => 'Pln_H',
            'value' => '{"depth":[],"query":{"T":"sectors","CONs":[{"CN":"name_en","CV":"Corporate Planning & Development"}],"depth":["first()" ,"head"]}}',
        ]);

        ApprovalStep::create([
            'name_ar' => 'رئيس قطاع المشتريات',
            'name_en' => 'Purchasing sector head',
            'code' => 'PUR_H',
            'value' => '{"depth":[],"query":{"T":"sectors","CONs":[{"CN":"name_en","CV":"Purchasing"}],"depth":["first()" ,"head"]}}',
        ]);

        ApprovalStep::create([
            'name_ar' => ' تطوير الاعمال',
            'name_en' => 'Business Development',
            'code' => 'B_DEV',
            'value' => '{"depth":[],"query":{"T":"sectors","CONs":[{"CN":"name_en","CV":"Business Development"}],"depth":["first()" ,"head"]}}',
        ]);

        ApprovalStep::create([
            'name_ar' => 'مدير المشروع',
            'name_en' => 'Project manager',
            'code' => 'PRO_M',
            'value' => '{"depth":["project", "manager"], "query" : []}',
        ]);

        ApprovalStep::create([
            'name_ar' => 'رئيس المكتب الفني للبناء - المدني',
            'name_en' => 'Civil Technical Office',
            'code' => 'TEC_OFF_Civil',
            'value' => '{"depth":[],"query":{"T":"departments","CONs":[{"CN":"name_en","CV":"Civil Technical Office"}],"depth":["first()" ,"manager"]}}',
        ]);

        ApprovalStep::create([
            'name_ar' => 'رئيس المكتب الفني للهندسة الكهربائية والميكانيكية',
            'name_en' => 'MEP Technical Office',
            'code' => 'TEC_OFF_MEP',
            'value' => '{"depth":[],"query":{"T":"departments","CONs":[{"CN":"name_en","CV":"MEP Technical Office"}],"depth":["first()" ,"manager"]}}',
        ]);

        // factory

        ApprovalStep::create([
            'name_ar' => '     مسئول تخطيط ومتابعة الخامات',
            'name_en' => 'Plan & MRP Director',
            'code' => 'PLAN_MRP',
            'value' => '{"depth":[],"query":{"T":"users","CONs":[{"CN":"code","CV":"2022-100"}],"depth":["first()"]}}',
        ]);

        ApprovalStep::create([
            'name_ar' => ' مدير تخطيط ومتابعة الخامات',
            'name_en' => 'Plan & MRP Director',
            'code' => 'PLAN_MRP_DIR',
            'value' => '{"depth":[],"query":{"T":"users","CONs":[{"CN":"code","CV":"2022-101"}],"depth":["first()"]}}',

        ]);

        ApprovalStep::create([
            'name_ar' => 'مدير عام المصانع',
            'name_en' => 'administrator',
            'code' => 'ADMI',
            'value' => '{"depth":[],"query":{"T":"users","CONs":[{"CN":"code","CV":"2022-102"}],"depth":["first()"]}}',
        ]);

        ApprovalStep::create([
            'name_ar' => 'نائب رئيس مجلس الاداره ',
            'name_en' => 'Resident Executive Vice President',
            'code' => 'RES_EXE',
            'value' => '{"depth":[],"query":{"T":"users","CONs":[{"CN":"code","CV":"2022-103"}],"depth":["first()"]}}',
        ]);


    }
}
