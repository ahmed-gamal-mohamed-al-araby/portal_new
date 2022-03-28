<?php

use App\Http\Controllers\AccountStatement\AccountStatementController;
use App\Http\Controllers\Approvals\ApprovalCycleController;
use App\Http\Controllers\Bank\BankController;
use App\Http\Controllers\BusinessNature\BusinessNatureController;
use App\Http\Controllers\Cheque\ChequeController;
use App\Http\Controllers\Governorate\GovernorateController;
use App\Http\Controllers\Country\CountryController;
use App\Http\Controllers\Department\DepartmentController;
use App\Http\Controllers\DiscountType\DiscountTypeController;
use App\Http\Controllers\Group\FamilyNameController;
use App\Http\Controllers\Group\GroupController;
use App\Http\Controllers\Group\SubGroupController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InquiryPurchaseRequest\InquiryPurchaseRequestController;
use App\Http\Controllers\Invoice\InvoiceController;
use App\Http\Controllers\Item\ItemController;
use App\Http\Controllers\Job\JobCodeController;
use App\Http\Controllers\Job\JobGradeController;
use App\Http\Controllers\Job\JobNameController;
use App\Http\Controllers\NatureDealing\NatureDealingController;
use App\Http\Controllers\Ore\OreController;
use App\Http\Controllers\Organization\OrganizationChartController;
use App\Http\Controllers\PaymentInvoice\PaymentInvoiceController;
use App\Http\Controllers\Project\ProjectController;
use App\Http\Controllers\PurchaseRequest\PurchaseRequestsController;
use App\Http\Controllers\Sector\SectorController;
use App\Http\Controllers\Project\SiteController;
use App\Http\Controllers\PurchaseOrder\PurchaseOrderController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\Supplier\SupplierController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\UserRole\UserRoleController;
use App\Models\AccountStatement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {

        // Authentication routes
        Auth::routes();

        // Protected routes (Authenticated users only)
        Route::group(
            [
                'middleware' => 'auth'
            ],
            function () {

                // Start Dashboard routes
                Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

                Route::get('/home', function () {
                    return redirect()->route('dashboard');
                })->name('home');

                Route::get('/', function () {
                    return redirect()->route('dashboard');
                });
                // Start Dashboard routes

                Route::get('organization/chart', OrganizationChartController::class)->name('organization.chart.index');

                // Items
                Route::resource('items', ItemController::class)->except('destroy');
                Route::get('/items/delete/{id}', [ItemController::class, 'delete'])->name('items.delete');
                Route::get('/trash_item', [ItemController::class, 'trash_index'])->name('items.trash_index');
                Route::get('/restore_item/{id}', [ItemController::class, 'restore'])->name('items.restore');

                // end Items

                // BusinessNature
                Route::resource('businessNatures', BusinessNatureController::class)->except('destroy');
                Route::get('/businessNatures/delete/{id}', [BusinessNatureController::class, 'delete'])->name('businessNatures.delete');
                Route::get('/trash_businessNature', [BusinessNatureController::class, 'trash_index'])->name('businessNatures.trash_index');
                Route::get('/restore_businessNature/{id}', [BusinessNatureController::class, 'restore'])->name('businessNatures.restore');
                // end BusinessNature


                // discountTypes
                Route::resource('discountTypes', DiscountTypeController::class)->except('destroy');
                Route::get('/discountTypes/delete/{id}', [DiscountTypeController::class, 'delete'])->name('discountTypes.delete');
                Route::get('/trash_discountType', [DiscountTypeController::class, 'trash_index'])->name('discountTypes.trash_index');
                Route::get('/restore_discountType/{id}', [DiscountTypeController::class, 'restore'])->name('discountTypes.restore');
                // end discountTypes

                // Bank
                Route::resource('banks', BankController::class)->except('destroy');
                Route::get('/banks/delete/{id}', [BankController::class, 'delete'])->name('banks.delete');
                Route::get('/trash_bank', [BankController::class, 'trash_index'])->name('banks.trash_index');
                Route::get('/restore_bank/{id}', [BankController::class, 'restore'])->name('banks.restore');
                // end Bank

                // natureDealing
                Route::resource('natureDealing', NatureDealingController::class)->except('destroy');
                Route::get('/natureDealing/delete/{id}', [NatureDealingController::class, 'delete'])->name('natureDealing.delete');
                Route::get('/trash_natureDealing', [NatureDealingController::class, 'trash_index'])->name('natureDealing.trash_index');
                Route::get('/restore_natureDealing/{id}', [NatureDealingController::class, 'restore'])->name('natureDealing.restore');
                // end natureDealing

                // Sector
                Route::group([], function () {
                    Route::get('sector/trash', [SectorController::class, 'trash_index'])->name('sector.trash_index');
                    Route::get('sector/pagination/fetch_data', [SectorController::class, 'fetch_data'])->name('sector.pagination.fetch_data');
                    Route::post('sector/trash', [SectorController::class, 'trash'])->name('sector.trash');
                    Route::post('sector/restore', [SectorController::class, 'restore'])->name('sector.restore');
                    Route::post('sector/permanent-delete', [SectorController::class, 'permanent_delete'])->name('sector.permanent_delete');
                    Route::post('sector/fetch-related-sector', [SectorController::class, 'fetch_related_sector'])->name('sector.fetch_related_sector');
                    Route::resource('sector', SectorController::class)->except('destroy');
                });

                // Department
                Route::group([], function () {
                    Route::get('department/trash', [DepartmentController::class, 'trash_index'])->name('department.trash_index');
                    Route::get('department/pagination/fetch_data', [DepartmentController::class, 'fetch_data'])->name('department.pagination.fetch_data');
                    Route::post('department/trash', [DepartmentController::class, 'trash'])->name('department.trash');
                    Route::post('department/_trash', [DepartmentController::class, '_trash'])->name('department._trash');
                    Route::post('department/restore', [DepartmentController::class, 'restore'])->name('department.restore');
                    Route::post('department/_restore', [DepartmentController::class, '_restore'])->name('department._restore');
                    Route::post('department/permanent-delete', [DepartmentController::class, 'permanent_delete'])->name('department.permanent_delete');
                    Route::post('department/_permanent-delete', [DepartmentController::class, '_permanent_delete'])->name('department._permanent_delete');
                    Route::resource('department', DepartmentController::class)->except('destroy');
                });

                // Project
                Route::group([], function () {
                    Route::get('project/completed', [ProjectController::class, 'completed_index'])->name('project.completed_index');
                    Route::get('project/trash', [ProjectController::class, 'trash_index'])->name('project.trash_index');
                    Route::get('project/pagination/fetch_data', [ProjectController::class, 'fetch_data'])->name('project.pagination.fetch_data');
                    Route::post('project/trash', [ProjectController::class, 'trash'])->name('project.trash');
                    Route::post('project/restore', [ProjectController::class, 'restore'])->name('project.restore');
                    Route::post('project/permanent-delete', [ProjectController::class, 'permanent_delete'])->name('project.permanent_delete');
                    Route::post('project/fetch-related-site', [ProjectController::class, 'fetch_related_site'])->name('project.fetch_related_site');
                    Route::resource('project', ProjectController::class)->except('destroy');
                });

                // Site
                Route::group([], function () {
                    Route::get('site/completed', [SiteController::class, 'completed_index'])->name('site.completed_index');
                    Route::get('site/trash', [SiteController::class, 'trash_index'])->name('site.trash_index');
                    Route::get('site/pagination/fetch_data', [SiteController::class, 'fetch_data'])->name('site.pagination.fetch_data');
                    Route::post('site/trash', [SiteController::class, 'trash'])->name('site.trash');
                    Route::post('site/restore', [SiteController::class, 'restore'])->name('site.restore');
                    Route::post('site/permanent-delete', [SiteController::class, 'permanent_delete'])->name('site.permanent_delete');
                    Route::resource('site', SiteController::class)->except('destroy');
                });

                // Employee
                Route::group([], function () {
                    Route::get('employee/deactive', [UserController::class, 'trash_index'])->name('employee.deactive_index');
                    Route::get('employee/pagination/fetch_data', [UserController::class, 'fetch_data'])->name('employee.pagination.fetch_data');
                    Route::post('employee/deactive', [UserController::class, 'trash'])->name('employee.deactive');
                    Route::get('employee/deactive/trash/{id}', [UserController::class, 'trashpost'])->name('employee.deactive.trash');
                    Route::get('employee/deactive/all/{id}', [UserController::class, 'trashAll'])->name('employee.deactive.all');
                    Route::get('employee/restore/{id}', [UserController::class, 'restore'])->name('employee.restore.employee');
                    Route::post('employee/active', [UserController::class, 'active'])->name('employee.restore');
                    Route::resource('employee', UserController::class)->except('destroy');
                });

                // Job Code
                Route::group([], function () {
                    Route::get('job-code/trash', [JobCodeController::class, 'trash_index'])->name('job_code.trash_index');
                    Route::get('job-code/pagination/fetch_data', [JobCodeController::class, 'fetch_data'])->name('job_code.pagination.fetch_data');
                    Route::post('job-code/trash', [JobCodeController::class, 'trash'])->name('job_code.trash');
                    Route::post('job-code/restore', [JobCodeController::class, 'restore'])->name('job_code.restore');
                    Route::post('job-code/permanent-delete', [JobCodeController::class, 'permanent_delete'])->name('job_code.permanent_delete');
                    Route::post('job-code/fetch-related-job-code', [JobCodeController::class, 'fetch_related_job_code'])->name('job_code.fetch_related_job_code');
                    Route::resource('job-code', JobCodeController::class)->except('destroy');
                });

                // Job Grade
                Route::group([], function () {
                    Route::get('job-grade/trash', [JobGradeController::class, 'trash_index'])->name('job_grade.trash_index');
                    Route::get('job-grade/pagination/fetch_data', [JobGradeController::class, 'fetch_data'])->name('job_grade.pagination.fetch_data');
                    Route::post('job-grade/trash', [JobGradeController::class, 'trash'])->name('job_grade.trash');
                    Route::post('job-grade/restore', [JobGradeController::class, 'restore'])->name('job_grade.restore');
                    Route::post('job-grade/permanent-delete', [JobGradeController::class, 'permanent_delete'])->name('job_grade.permanent_delete');
                    Route::resource('job-grade', JobGradeController::class)->except('destroy');
                });

                // Job Name
                Route::group([], function () {
                    Route::get('job-name/trash', [JobNameController::class, 'trash_index'])->name('job_name.trash_index');
                    Route::get('job-name/pagination/fetch_data', [JobNameController::class, 'fetch_data'])->name('job_name.pagination.fetch_data');
                    Route::post('job-name/trash', [JobNameController::class, 'trash'])->name('job_name.trash');
                    Route::post('job-name/restore', [JobNameController::class, 'restore'])->name('job_name.restore');
                    Route::post('job-name/permanent-delete', [JobNameController::class, 'permanent_delete'])->name('job_name.permanent_delete');
                    Route::resource('job-name', JobNameController::class)->except('destroy');
                });

                // Country
                Route::group([], function () {
                    Route::get('country/trash', [CountryController::class, 'trash_index'])->name('country.trash_index');
                    Route::get('country/pagination/fetch_data', [CountryController::class, 'fetch_data'])->name('country.pagination.fetch_data');
                    Route::post('country/trash', [CountryController::class, 'trash'])->name('country.trash');
                    Route::post('country/restore', [CountryController::class, 'restore'])->name('country.restore');
                    Route::post('country/permanent-delete', [CountryController::class, 'permanent_delete'])->name('country.permanent_delete');
                    Route::post('country/fetch-related-governorate', [CountryController::class, 'fetch_related_governorate'])->name('country.fetch_related_governorate');
                    Route::resource('country', CountryController::class)->except(['show', 'destroy']);
                });

                // Governorate
                Route::group([], function () {
                    Route::get('governorate/trash', [GovernorateController::class, 'trash_index'])->name('governorate.trash_index');
                    Route::get('governorate/pagination/fetch_data', [GovernorateController::class, 'fetch_data'])->name('governorate.pagination.fetch_data');
                    Route::post('governorate/trash', [GovernorateController::class, 'trash'])->name('governorate.trash');
                    Route::post('governorate/restore', [GovernorateController::class, 'restore'])->name('governorate.restore');
                    Route::post('governorate/permanent-delete', [GovernorateController::class, 'permanent_delete'])->name('governorate.permanent_delete');
                    Route::resource('governorate', GovernorateController::class)->except('destroy');
                });

                // -- Start purchase order system -- //
                Route::group(['middleware' => [],], function () {
                    // Group
                    Route::group([], function () {
                        Route::get('group/trash', [GroupController::class, 'trash_index'])->name('group.trash_index');
                        Route::get('group/pagination/fetch_data', [GroupController::class, 'fetch_data'])->name('group.pagination.fetch_data');
                        Route::post('group/trash', [GroupController::class, 'trash'])->name('group.trash');
                        Route::post('group/restore', [GroupController::class, 'restore'])->name('group.restore');
                        Route::post('group/permanent-delete', [GroupController::class, 'permanent_delete'])->name('group.permanent_delete');
                        Route::post('group/fetch-related-sub-group', [GroupController::class, 'fetch_related_sub_group'])->name('group.fetch_related_sub_group');
                        Route::resource('group', GroupController::class)->except('destroy');
                    });

                    // Sub group
                    Route::group([], function () {
                        Route::get('sub-group/trash', [SubGroupController::class, 'trash_index'])->name('sub_group.trash_index');
                        Route::get('sub-group/pagination/fetch_data', [SubGroupController::class, 'fetch_data'])->name('sub_group.pagination.fetch_data');
                        Route::post('sub-group/trash', [SubGroupController::class, 'trash'])->name('sub_group.trash');
                        Route::post('sub-group/restore', [SubGroupController::class, 'restore'])->name('sub_group.restore');
                        Route::post('sub-group/permanent-delete', [SubGroupController::class, 'permanent_delete'])->name('sub_group.permanent_delete');
                        Route::post('sub-group/fetch-related-family-name', [SubGroupController::class, 'fetch_related_family_name'])->name('sub_group.fetch_related_family_name');
                        Route::resource('sub-group', SubGroupController::class)->except('destroy');
                    });

                    // Family name
                    Route::group([], function () {
                        Route::get('family-name/trash', [FamilyNameController::class, 'trash_index'])->name('family_name.trash_index');
                        Route::get('family-name/pagination/fetch_data', [FamilyNameController::class, 'fetch_data'])->name('family_name.pagination.fetch_data');
                        Route::post('family-name/trash', [FamilyNameController::class, 'trash'])->name('family_name.trash');
                        Route::post('family-name/restore', [FamilyNameController::class, 'restore'])->name('family_name.restore');
                        Route::post('family-name/permanent-delete', [FamilyNameController::class, 'permanent_delete'])->name('family_name.permanent_delete');
                        Route::post('family-name/fetch-related-job', [FamilyNameController::class, 'fetch_related_job'])->name('job_code.fetch_related_job');
                        Route::resource('family-name', FamilyNameController::class)->except('destroy');
                    });

                    // Supplier
                    Route::group([], function () {
                        Route::get('supplier/trash', [SupplierController::class, 'trash_index'])->name('supplier.trash_index');
                        Route::get('supplier/pagination/fetch_data', [SupplierController::class, 'fetch_data'])->name('supplier.pagination.fetch_data');
                        Route::post('supplier/permanent-delete', [SupplierController::class, 'permanent_delete'])->name('supplier.permanent_delete');
                        Route::post('supplier/trash', [SupplierController::class, 'trash'])->name('supplier.trash');
                        Route::post('supplier/restore', [SupplierController::class, 'restore'])->name('supplier.restore');
                        Route::post('supplier-search', [SupplierController::class, 'supplier_search'])->name('supplier.supplier_search');
                        Route::get('supplier/search', [SupplierController::class, 'search'])->name('supplier.search');
                        Route::get('supplier/search/fetch', [SupplierController::class, 'search_fetch'])->name('supplier.fetch_data');
                        Route::resource('supplier', SupplierController::class)->except('destroy');
                        // excel
                        Route::post('supplier/importsupplier-delete', [SupplierController::class, 'importsupplier'])->name('importsupplier');
                        Route::post('project/importproject-delete', [ProjectController::class, 'importproject'])->name('importproject');
                        // end excel
                    });

                    // Purchase request
                    Route::group([], function () {
                        Route::post('purchase-request/send-for-approve', [PurchaseRequestsController::class, 'sendForApproveSavedPR'])->name('purchase_request.send_for_approve');
                        Route::get('purchase-request/trash', [PurchaseRequestsController::class, 'trash_index'])->name('purchase_request.trash_index');
                        Route::get('purchase-request/pagination/fetch_data', [PurchaseRequestsController::class, 'fetch_data'])->name('purchase_request.pagination.fetch_data');
                        Route::post('purchase-request/trash', [PurchaseRequestsController::class, 'trash'])->name('purchase_request.trash');
                        Route::post('purchase-request/restore', [PurchaseRequestsController::class, 'restore'])->name('purchase_request.restore');
                        Route::post('purchase-request/permanent-delete', [PurchaseRequestsController::class, 'permanent_delete'])->name('purchase_request.permanent_delete');

                        Route::resource('purchase-request', PurchaseRequestsController::class)->except('destroy');
                    });

                    Route::group([], function () {

                        Route::get('purchase-order/get_data_item', [PurchaseOrderController::class, 'getItemData'])->name('item.getData.order');
                        Route::post('purchase-order/trash', [PurchaseOrderController::class, 'trash'])->name('purchase_order.trash');
                        Route::get('purchase-order/pagination/fetch_data', [PurchaseOrderController::class, 'fetch_data'])->name('purchase_order.pagination.fetch_data');
                        Route::get('purchase-order/trash', [PurchaseOrderController::class, 'trash_index'])->name('purchase_order.trash_index');
                        Route::post('purchase-order/restore', [PurchaseOrderController::class, 'restore'])->name('purchase_order.restore');
                        Route::post('purchase-order/send-for-approve', [PurchaseOrderController::class, 'sendForApproveSavedPR'])->name('purchase_order.send_for_approve');
                        Route::get('purchase-order/get_items', [PurchaseOrderController::class, 'getDataItems'])->name('purchase_order.fetch_related_item');
                        Route::get('purchase-order/supplier', [PurchaseOrderController::class, 'getDataSupplier'])->name('purchase_order.supplier_id');


                        Route::resource('purchase-order', PurchaseOrderController::class)->except('destroy');
                    });
                });
                // -- End purchase order system -- //

                //--Start Inquiry Purchase Request

                Route::resource('inquiry-purchase-request', InquiryPurchaseRequestController::class)->except('destroy');
                // Route::get('inquiry-purchase-request/pagination/fetch_data', [InquiryPurchaseRequestController::class, 'fetch_data'])->name('inquiry.pagination.fetch_data');
                Route::post('inquiry-purchase-request/show/{id}', [InquiryPurchaseRequestController::class, 'storeResponse'])->name('inquiry-purchase-request.storeResponse');
                Route::get('inquire/pagination/fetch_data', [InquiryPurchaseRequestController::class, 'inquire_fetch_data'])->name('inquire.pagination.fetch_data');



                // -- End InquiryPurchaseRequest system -- //
                // -- Start Approvals -- //
                Route::group([], function () {
                    Route::get('approvals/show-all-cycles', [ApprovalCycleController::class, 'showAllCycles'])->name('approvals.show_all_cycles');
                    Route::get('approvals/timeline/show-all-approval-requests-timeline', [ApprovalCycleController::class, 'showAllApprovalRequestsTimeline'])->name('approvals.show_all_approval_requests_timeline');
                    Route::get('approvals/timeline/show-all-acceptable-requests-timeline', [ApprovalCycleController::class, 'showAllAcceptableRequestsTimeline'])->name('approvals.show_all_acceptable_requests_timeline');

                    Route::get('approvals/timeline/show-all-approval-orders-timeline', [ApprovalCycleController::class, 'showAllApprovalOrdersTimeline'])->name('approvals.show_all_approval_orders_timeline');
                    Route::get('approvals/timeline/show-all-acceptable-orders-timeline', [ApprovalCycleController::class, 'showAllAcceptableOrdersTimeline'])->name('approvals.show_all_acceptable_orders_timeline');

                    Route::get('approvals/timeline/{approvalTimeline}', [ApprovalCycleController::class, 'timelineById'])->name('approvals.timeline_by_id');
                    Route::post('approvals/timelineduration', [ApprovalCycleController::class, 'addDuration'])->name('approvals.timeline_add_duration');

                    Route::get('approvals/timeline_order/{approvalTimeline}', [ApprovalCycleController::class, 'timelineOrderById'])->name('approvals.timeline_order_by_id');

                    Route::get('approvals/timeline/{tableName}/{recordId}', [ApprovalCycleController::class, 'timeline'])->name('approvals.timeline');
                    Route::get('approvals/action/approve/{id}', [ApprovalCycleController::class, 'approve'])->name('approvals.action.approve');
                    Route::get('approvals/action/approve/business/{id}', [ApprovalCycleController::class, 'approveBusiness'])->name('approvals.action.approve.business');
                    Route::post('approvals/action/approval', [ApprovalCycleController::class, 'approveComment'])->name('approvals.action.approve.comment');
                    Route::post('approvals/action/revert', [ApprovalCycleController::class, 'revert'])->name('approvals.action.revert');
                    Route::post('approvals/action/reject', [ApprovalCycleController::class, 'reject'])->name('approvals.action.reject');
                    Route::get('approvals/action/showOrder/{id}/{value}/{message}', [ApprovalCycleController::class, 'showOrder'])->name('approvals.action.showOrder');
                    Route::get('approvals/action/showOrderRequest/{id}/{value}/{refuse}', [ApprovalCycleController::class, 'showOrderRequest'])->name('approvals.action.showOrderRequest');
                    Route::get('approvals/action/deleteOrderRequest/{id}/{value}/{refuse}', [ApprovalCycleController::class, 'deleteOrderRequest'])->name('approvals.action.deleteOrderRequest');
                    Route::get('approvals/action/showChequeRequest/{id}/{value}/{refuse}', [ApprovalCycleController::class, 'showChequeRequest'])->name('approvals.action.showChequeRequest');


                    Route::post('approvals/partial', [ApprovalCycleController::class, 'approvePartial'])->name('approve.order.items');
                    Route::post('message/partial', [ApprovalCycleController::class, 'messagePartial'])->name('approve.order.items.message');
                    Route::post('approvals/refuse/partial', [ApprovalCycleController::class, 'refusePartial'])->name('refuse.order.items');


                    Route::get('approvals/pagination/fetch_data', [ApprovalCycleController::class, 'fetch_data'])->name('approval.pagination.fetch_data');
                    Route::get('approvals/pagination/fetch_data/approvels', [ApprovalCycleController::class, 'fetch_data_approvel'])->name('approval.pagination.fetch_data.approvel');
                    Route::get('approvals/pagination/fetch_data_order/approvels', [ApprovalCycleController::class, 'fetch_data_order_approvel'])->name('approval.pagination.fetch_data_orders.approvel');
                    Route::get('approvals/pagination/fetch_data_order', [ApprovalCycleController::class, 'fetch_data_order'])->name('approval.pagination.fetch_data_orders');

                    Route::get('approvals/pagination/fetch_data/accepted', [ApprovalCycleController::class, 'fetch_data_approvel_accepted'])->name('approval.pagination.fetch_data.accepted');
                    Route::get('approvals/pagination/fetch_data_orders/accepted', [ApprovalCycleController::class, 'fetch_data_approvel_accepted_orders'])->name('approval.pagination.fetch_data_orders.accepted');

                    Route::resource('approvals', ApprovalCycleController::class)->only('index', 'show');
                });

                Route::resource('ores', OreController::class);
                Route::post('ores/get_item', [OreController::class, 'OresGetItem'])->name('purchase_order.fetch_related_item_ores');

                // -- End Approvals -- //

                Route::resource('roles', RoleController::class);
                Route::resource('user-roles', UserRoleController::class);

                // // invoices
                // Route::get('invoices/trash', [InvoiceController::class, 'trash_index'])->name('invoices.trash_index');
                // Route::get('invoices/pagination/fetch_data', [InvoiceController::class, 'fetch_data'])->name('invoices.pagination.fetch_data');
                // Route::post('invoices/trash', [InvoiceController::class, 'trash'])->name('invoices.trash');
                // Route::post('invoices/restore', [InvoiceController::class, 'restore'])->name('invoices.restore');
                // Route::post('invoices/permanent-delete', [InvoiceController::class, 'permanent_delete'])->name('invoices.permanent_delete');
                // Route::post('invoices/fetch-related-invoice', [InvoiceController::class, 'fetch_related_invoice'])->name('invoices.fetch_related_invoice');
                // Route::resource('invoices', InvoiceController::class);
                // Route::post('invoices/net_total.fetch', [InvoiceController::class, 'fetch_related_net_total'])->name('net_total.fetch');

                // Invoice
                Route::resource('invoices', InvoiceController::class)->except('destroy');
                Route::get('/invoice_get_data', [InvoiceController::class, 'getInvoiceData'])->name('invoice_get_project_data')->middleware('auth');
                Route::get('/invoice_get_data_supplier', [InvoiceController::class, 'getInvoiceDataSupplier'])->name('invoice_get_supplier')->middleware('auth');
                Route::get('/invoice_get_supplier_name', [InvoiceController::class, 'getInvoiceSupplierName'])->name('invoice_get_supplier_name')->middleware('auth');
                Route::get('/invoice_get_discount_type', [InvoiceController::class, 'getInvoicediscountType'])->name('invoice_get_discount_type')->middleware('auth');
                Route::get('/approve_invoice/{id}', [InvoiceController::class, 'approveInvoice'])->name('approve_invoice')->middleware('auth');
                Route::get('/invoice/delete/{id}', [InvoiceController::class, 'delete'])->name('invoice.delete');
                Route::get('/trash_invoice', [InvoiceController::class, 'trash_index'])->name('invoice.trash_index');
                Route::get('/restore_invoice/{id}', [InvoiceController::class, 'restore'])->name('invoice.restore');


                // PaymentInvoice
                Route::resource('paymentInvoice', PaymentInvoiceController::class)->except('destroy');
                Route::get('/payment_get_bank_data', [PaymentInvoiceController::class, 'getPaymentBankData'])->name('payment_get_bank_data')->middleware('auth');
                Route::get('/invoice_get_project_business_data', [PaymentInvoiceController::class, 'getPaymentBankBusinessData'])->name('invoice_get_project_business_data')->middleware('auth');
                Route::get('/approve_payment/{id}', [PaymentInvoiceController::class, 'approvePayment'])->name('approve_payment')->middleware('auth');
                Route::get('/payment_get_supplier_bank', [PaymentInvoiceController::class, 'getSupplierbank'])->name('payment_get_supplier_bank')->middleware('auth');
                Route::get('/payment/delete/{id}', [PaymentInvoiceController::class, 'delete'])->name('payment.delete');
                Route::get('/trash_payment', [PaymentInvoiceController::class, 'trash_index'])->name('payment.trash_index');
                Route::get('/restore_payment/{id}', [PaymentInvoiceController::class, 'restore'])->name('payment.restore');

               // account statement
               Route::get('/get_supplier_statment', [AccountStatementController::class, 'index'])->name('report_get_supplier_statment')->middleware('auth');
               Route::post('/get_supplier_statment/report', [AccountStatementController::class, 'show'])->name('report_supplier_statment_ajax')->middleware('auth');
                // cheque

                Route::resource('cheques', ChequeController::class)->except('destroy');
                Route::get('cheques/trash', [ChequeController::class, 'trash_index'])->name('cheques.trash');
                Route::post('cheque-request/send-for-approve', [ChequeController::class, 'sendForApproveSavedPR'])->name('cheque_request.send_for_approve');
                Route::get('cheque-request/supplier', [ChequeController::class, 'getDataSupplier'])->name('cheque_request.supplier_id');
                Route::get('cheques/approval/show-all-approval-cheque-timeline', [ApprovalCycleController::class, 'showAllApprovalChequeTimeline'])->name('approvals.show_all_approval_cheque_timeline');

                Route::get('cheques/approval/cheque/{approvalTimeline}', [ApprovalCycleController::class, 'timelineChequeById'])->name('approvals.timeline_cheque_by_id');

                Route::get('cheques/approval/show-all-acceptable-cheque-timeline', [ApprovalCycleController::class, 'showAllAcceptableChequeTimeline'])->name('approvals.show_all_acceptable_cheque_timeline');
                Route::get('cheques/pagination/fetch_all_data_cheque', [ApprovalCycleController::class, 'cheque_fetch_all_data'])->name('cheque.pagination.fetch_all_data');
                Route::get('cheques/pagination/fetch_data_cheque', [ApprovalCycleController::class, 'cheque_fetch_data'])->name('cheque.pagination.fetch_data');
                Route::post('cheques/get-operation-name', [ChequeController::class, 'getOperationName'])->name('cheque_request.getOperationName');
                Route::post('cheques/get-balance', [ChequeController::class, 'getBalance'])->name('cheque_request.getBalance');
                Route::post('cheques/get-cheque-value', [ChequeController::class, 'chequeValue'])->name('cheque_request.chequeValue');

                Route::post('cheques/get-checkRequest', [ChequeController::class, 'chequeRequestData'])->name('payment_get_checkRequest_data');


            }

        );
    }
);
