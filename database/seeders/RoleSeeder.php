<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            "my_actions",
            "approval_courses",
            "inquiry_edit",
            'add-bank',
            'edit-bank',
            'delete-bank',
            'restore-bank',
            'banks',

            'add-item',
            'edit-item',
            'delete-item',
            'restore-item',
            'items',

            'add-business-nature',
            'edit-business-nature',
            'delete-business-nature',
            'restore-business-nature',
            'business-natures',

            'add-nature-dealing',
            'edit-nature-dealing',
            'delete-nature-dealing',
            'restore-nature-dealing',
            'nature-dealings',

            'add-discount-type',
            'edit-discount-type',
            'delete-discount-type',
            'restore-discount-type',
            'discount-types',

            'add-invoice',
            'edit-invoice',
            'show-invoice',
            'delete-invoice',
            'restore-invoice',
            'invoices',

            'add-payment',
            'edit-payment',
            'show-payment',
            'delete-payment',
            'restore-payment',
            'payments',

            'add-sector',
            'edit-sector',
            'show-sector',
            'delete-sector',
            'restore-sector',
            'sectors',

            'add-department',
            'edit-department',
            'show-department',
            'delete-department',
            'restore-department',
            'departments',

            'add-project',
            'edit-project',
            'show-project',
            'delete-project',
            'restore-project',
            "complete-project",
            'projects',

            'add-site',
            'edit-site',
            'show-site',
            'delete-site',
            'restore-site',
            'sites',

            'add-job-code',
            'edit-job-code',
            'show-job-code',
            'delete-job-code',
            'restore-job-code',
            'job-codes',

            'add-job-grade',
            'edit-job-grade',
            'show-job-grade',
            'delete-job-grade',
            'restore-job-grade',
            'job-grades',

            'add-job-name',
            'edit-job-name',
            'show-job-name',
            'delete-job-name',
            'restore-job-name',
            'job-names',

            'add-country',
            'edit-country',
            'show-country',
            'delete-country',
            'restore-country',
            'countries',

            'add-governorate',
            'edit-governorate',
            'show-governorate',
            'delete-governorate',
            'restore-governorate',
            'governorates',

            'add-group',
            'edit-group',
            'show-group',
            'delete-group',
            'restore-group',
            'groups',

            'add-sub-group',
            'edit-sub-group',
            'show-sub-group',
            'delete-sub-group',
            'restore-sub-group',
            'sub-groups',

            'add-family-name',
            'edit-family-name',
            'show-family-name',
            'delete-family-name',
            'restore-family-name',
            'family-names',

            'add-supplier',
            'show-supplier',
            'delete-supplier',
            'edit-supplier',
            'suppliers',
            'supplier-search',
            'restore-supplier',

            'add-employee',
            'show-employee',
            'delete-employee',
            'edit-employee',
            'restore-employee',
            'employees',

            'add-purchase-request',
            'show-purchase-request',
            'delete-purchase-request',
            'edit-purchase-request',
            'restore-purchase-request',
            'purchase-requests',

            'show-timeline-purchase-request',
            'timeline-purchase-request',
            'show-acceptable-purchase-request',
            'acceptable-purchase-request',
            'add-expected-tiem',
            'add-inquire',

            'add-purchase-order',
            'edit-purchase-order',
            'purchase-orders',
            'show-purchase-order',
            'restore-purchase-order',
            'delete-purchase-order',

            'add-cheque',
            'edit-cheque',
            'show-cheque',
            'delete-cheque',
            'restore-cheque',
            'send-cheque',
            'cheques',


            'timeline-purchase-order',
            'show-acceptable-purchase-order',
            'acceptable-purchase-order',

            'timeline-cheque-request',
            'show-acceptable-cheque-request',
            'acceptable-cheque-request',

            "account_statement",
            "roles-page",
            "user-roles-page",

        ];
        $super_admin = Role::create(['name' => "super_admin"]);
        $super_admin->syncPermissions($permissions);

        $permissionPurchaseAccount = [
            'show-supplier',
            'suppliers',
            'supplier-search',

            'add-employee',
            'show-employee',
            'delete-employee',
            'edit-employee',
            'restore-employee',
            'employees',

            'add-purchase-request',
            'show-purchase-request',
            'delete-purchase-request',
            'restore-purchase-request',
            'purchase-requests',

            'show-acceptable-purchase-request',
            'acceptable-purchase-request',

            'add-purchase-order',
            'purchase-orders',
            'show-purchase-order',
            'restore-purchase-order',
            'delete-purchase-order',

            'timeline-purchase-order',
            'show-acceptable-purchase-order',
            'acceptable-purchase-order',
        ];

        $rolePurchaseAccount = Role::create(['name' => "purchase_accountant"]);
        $rolePurchaseAccount->syncPermissions($permissionPurchaseAccount);

        $purchaseDirectory  = [
            'add-supplier',
            'show-supplier',
            'suppliers',
            'supplier-search',

            'add-purchase-request',
            'show-purchase-request',
            'delete-purchase-request',
            'edit-purchase-request',
            'restore-purchase-request',
            'purchase-requests',

            'show-timeline-purchase-request',
            'timeline-purchase-request',
            'show-acceptable-purchase-request',
            'acceptable-purchase-request',

            'add-purchase-order',
            'edit-purchase-order',
            'purchase-orders',
            'show-purchase-order',
            'restore-purchase-order',
            'delete-purchase-order',

            'timeline-purchase-order',
            'show-acceptable-purchase-order',
            'acceptable-purchase-order',

        ];

        $rolePurchaseDirectory = Role::create(['name' => "purchase_directory"]);
        $rolePurchaseDirectory->syncPermissions($purchaseDirectory);

        $permissionPurDirectorDept = [
            'add-supplier',
            'show-supplier',
            'delete-supplier',
            'edit-supplier',
            'suppliers',
            'supplier-search',
            'restore-supplier',

            'add-purchase-request',
            'show-purchase-request',
            'delete-purchase-request',
            'edit-purchase-request',
            'restore-purchase-request',
            'purchase-requests',

            'show-timeline-purchase-request',
            'timeline-purchase-request',
            'show-acceptable-purchase-request',
            'acceptable-purchase-request',
            'add-expected-tiem',
            'add-inquire',

            'add-purchase-order',
            'edit-purchase-order',
            'purchase-orders',
            'show-purchase-order',
            'restore-purchase-order',
            'delete-purchase-order',

            'timeline-purchase-order',
            'show-acceptable-purchase-order',
            'acceptable-purchase-order',

            'timeline-cheque-request',
            'show-acceptable-cheque-request',
            'acceptable-cheque-request',

        ];

        $rolePurDirectorDept = Role::create(['name' => "pur_directory_dept"]);
        $rolePurDirectorDept->syncPermissions($permissionPurDirectorDept);

        $permissionPurHeadSector = [
            'add-supplier',
            'show-supplier',
            'delete-supplier',
            'edit-supplier',
            'suppliers',
            'supplier-search',
            'restore-supplier',

            'add-purchase-request',
            'show-purchase-request',
            'delete-purchase-request',
            'edit-purchase-request',
            'restore-purchase-request',
            'purchase-requests',

            'show-timeline-purchase-request',
            'timeline-purchase-request',
            'show-acceptable-purchase-request',
            'acceptable-purchase-request',
            'add-expected-tiem',
            'add-inquire',

            'timeline-cheque-request',
            'show-acceptable-cheque-request',
            'acceptable-cheque-request',

        ];

        $rolePurHeadSector = Role::create(['name' => "pur_head_sector"]);
        $rolePurHeadSector->syncPermissions($permissionPurHeadSector);

    }
}
