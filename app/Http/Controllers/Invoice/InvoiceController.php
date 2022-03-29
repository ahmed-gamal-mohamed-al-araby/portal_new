<?php

namespace App\Http\Controllers\Invoice;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AccountStatement;
use App\Models\BusinessNature;
use App\Models\Item;
use App\Models\NatureDealing;
use App\Models\Project;
use App\Models\PurchaseOrder;
use App\Models\Supplier;

class InvoiceController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:invoices', ['only' => ['index']]);
        $this->middleware('permission:add-invoice', ['only' => ['create','store']]);
        $this->middleware('permission:edit-invoice', ['only' => ['edit','update']]);
        $this->middleware('permission:restore-invoice', ['only' => ['restore']]);
    }
    public function index()
    {
        $invoices = Invoice::with(['project', "supplier", "natureDealing"])->orderBy("id", "DESC")->get();
        $pageType = 'index';

        return view('dashboard-views.invoice.index', compact("invoices","pageType"));
    }

    public function show($id)
    {
        $invoice = Invoice::where('id', $id)->first();
        // return $invoice;

        return view('dashboard-views.invoice.show', compact("invoice"));
    }

    public function create()
    {
        $items = Item::all();
        $suppliers = Supplier::all();
        $purchaseOrders = PurchaseOrder::all();

        $projects = Project::all();
        $businessNatures = BusinessNature::where("item_id", 2)->get();
        $natureDealings = NatureDealing::all();
        return view('dashboard-views.invoice.create', compact("purchaseOrders", "items", "projects", "businessNatures", "natureDealings", "suppliers"));
    }

    public function getInvoiceData(Request $request)
    {
        $pro_id = $request->pro_id;
        return $project = Project::with("businessNature")->find($pro_id);
    }

    public function getInvoiceDataSupplier(Request $request)
    {
        $supplier_type = $request->supplier_type;
        return  $supplier = Supplier::where('type', $supplier_type)->get();
    }

    public function getInvoiceSupplierName(Request $request)
    {
        $supplier_id = $request->supplier_id;
        return  $supplier = Supplier::find($supplier_id);
    }

    public function getInvoicediscountType(Request $request)
    {
        $nature_dealing = $request->nature_dealing;
        return  $nature_dealing = NatureDealing::with("discountTypes")->find($nature_dealing);
    }
    public function store(Request $request)
    {

        // return $request->all();
        // $supplier = Supplier::where("nat_tax_number",$request->nat_tax_number)->first();
        if ($request->restrained_type == null) {

            $request->restrained_type = "not_restrained";
        }
        if ($request->expense_type  == null) {
            $request->expense_type = "cashe";
        }

        $invoice = Invoice::create([
            "item_id" => $request->item_id,
            "project_id" => $request->project_id,
            "business_nature_id" => $request->business_nature,
            "covenant_type" => $request->covenant_type,
            "detection_number" => $request->detection_number,
            "supplier_id" => $request->supplier_id,
            "po_id" => $request->purchaseOrder_id,
            "date_invoice" => $request->invoice_date,
            "invoice_number" => $request->invoice_number,
            "specifications" => $request->product,
            "price" => $request->unit_price,
            "amount" => $request->unit_quantity,
            "total" => $request->total,
            "value_tax_rate" => $request->value_tax_rate,
            "value_tax" => $request->value_tax,
            "overall_total" => $request->overall_total,
            "other_discount" => $request->other_discount,
            "total_after_discount" => $request->total_after_discount,
            "restrained_type" => $request->restrained_type,
            "nature_dealing_id" => $request->nature_dealing,
            "expense_type" => $request->expense_type,
            "tax_deduction" => $request->tax_deduction,
            "tax_deduction_value" => $request->tax_deduction_value,
            "net_total" => $request->net_total,
            "business_insurance_rate" => $request->business_insurance_rate,
            "business_insurance_value" => $request->business_insurance_value,
            "net_total_after_business_insurance" => $request->net_total_after_business_insurance,
            "notes" => $request->notes,
            "user_id" => \Auth::user()->id
        ]);

        if ($request->business_insurance_value) {

            // return $request->all();
                 $value=$request->unit_price - $request->business_insurance_value;


            $account = AccountStatement::create([

                "description" => "قيمة الفاتورة",
                "date" => $invoice->created_at,
                "date_search" => $invoice->created_at,
                "debit" => 0,
                "credit" => $value,
                "balance" => "",
                "accountType" => "credit",
                "user_id" => \Auth::user()->id,
                "supplier_id" => $request->supplier_id,
                "invoice_id" => $invoice->id,
            ]);

            $account = AccountStatement::create([

                "description" => "تأمين اعمال",
                "date" => $invoice->created_at,
                "date_search" => $invoice->created_at,
                "debit" => 0,
                "credit" => $request->business_insurance_value,
                "balance" => "",
                "accountType" => "credit",
                "user_id" => \Auth::user()->id,
                "supplier_id" => $request->supplier_id,
                "invoice_id" => $invoice->id,
            ]);
        } else {
            $account = AccountStatement::create([

                "description" => "قيمة الفاتورة",
                "date" => $invoice->created_at,
                "date_search" => $invoice->created_at,
                "debit" => 0,
                "credit" => $request->total,
                "balance" => "",
                "accountType" => "credit",
                "user_id" => \Auth::user()->id,
                "supplier_id" => $request->supplier_id,
                "invoice_id" => $invoice->id,
            ]);
        }

        if ($request->value_tax) {

            $account = AccountStatement::create([

                "description" => "%".$request->value_tax_rate." القيمه المضافه",
                "date" => $invoice->created_at,
                "date_search" => $invoice->created_at,
                "debit" => 0,
                "credit" => $request->value_tax,
                "balance" => "",
                "accountType" => "credit",
                "user_id" => \Auth::user()->id,
                "supplier_id" => $request->supplier_id,
                "invoice_id" => $invoice->id,


            ]);
        }
        if ($request->tax_deduction_value) {

            $account = AccountStatement::create([

                "description" => "%".$request->tax_deduction."ضريبة خصم",
                "date" => $invoice->created_at,
                "date_search" => $invoice->created_at,
                "debit" => $request->tax_deduction_value,
                "credit" => 0,
                "balance" => "",
                "accountType" => "debit",
                "user_id" => \Auth::user()->id,
                "supplier_id" => $request->supplier_id,
                "invoice_id" => $invoice->id,


            ]);
        }
        if ($request->other_discount) {

            $account = AccountStatement::create([

                "description" => "خصومات اخري",
                "date" => $invoice->created_at,
                "date_search" => $invoice->created_at,
                "debit" => $request->other_discount,
                "credit" => 0,
                "balance" => "",
                "accountType" => "debit",
                "user_id" => \Auth::user()->id,
                "supplier_id" => $request->supplier_id,
                "invoice_id" => $invoice->id,

            ]);
        }

        return redirect()->route("invoices.index")->with(['success' => "Invoice Added Successfully"]);
    }

    public function edit(Request $request, $id)
    {
        $items = Item::all();
        $suppliers = Supplier::all();
        $purchaseOrders = PurchaseOrder::all();

        $businessNatures = BusinessNature::where("item_id", 2)->get();
        $natureDealings = NatureDealing::all();
        $invoice = Invoice::with(['project', "supplier", "businessNature", "natureDealing" => function ($q) {
            $q->with("discountTypes");
        }])->find($id);
        if (!$invoice)
            return redirect()->route("invoices.index")->with(['error' => "Not Found This invoice"]);
        $projects = Project::where("item_id", $invoice->item_id)->get();
        return view("dashboard-views.invoice.edit", compact("purchaseOrders", "invoice", "items", "projects", "businessNatures", "natureDealings", "suppliers"));
    }

    public function update(Request $request, $id)
    {

        $invoice = Invoice::find($id);
        if ($request->business_nature_id) {
            $bsiness_id = $request->business_nature_id;
        } else {
            $bsiness_id  = $request->business_nature;
        }
        if (!$invoice)
            return redirect()->route("invoices.index")->with(['error' => "Not Found This invoice"]);

             Invoice::where("id", $id)->update([
            "item_id" => $request->item_id,
            "project_id" => $request->project_id,
            "business_nature_id" => $request->business_nature,
            "covenant_type" => $request->covenant_type,
            "detection_number" => $request->detection_number,
            "supplier_id" => $request->supplier_id,
            "po_id" => $request->purchaseOrder_id,
            "date_invoice" => $request->invoice_date,
            "invoice_number" => $request->invoice_number,
            "specifications" => $request->product,
            "price" => $request->unit_price,
            "amount" => $request->unit_quantity,
            "total" => $request->total,
            "value_tax_rate" => $request->value_tax_rate,
            "value_tax" => $request->value_tax,
            "overall_total" => $request->overall_total,
            "other_discount" => $request->other_discount,
            "total_after_discount" => $request->total_after_discount,
            "restrained_type" => $request->restrained_type,
            "nature_dealing_id" => $request->nature_dealing,
            "expense_type" => $request->expense_type,
            "tax_deduction" => $request->tax_deduction,
            "tax_deduction_value" => $request->tax_deduction_value,
            "net_total" => $request->net_total,
            "business_insurance_rate" => $request->business_insurance_rate,
            "business_insurance_value" => $request->business_insurance_value,
            "net_total_after_business_insurance" => $request->net_total_after_business_insurance,
            "notes" => $request->notes,
            "user_id" => $invoice->user_id
        ]);


       AccountStatement::where("invoice_id",$id)->delete();
        if ($request->business_insurance_value) {

            // return $request->all();
                 $value=$request->unit_price - $request->business_insurance_value;


            $account = AccountStatement::create([

                "description" => "قيمة الفاتورة",
                "date" => $invoice->created_at,
                "date_search" => $invoice->created_at,
                "debit" => 0,
                "credit" => $value,
                "balance" => "",
                "accountType" => "credit",
                "user_id" => \Auth::user()->id,
                "supplier_id" => $request->supplier_id,
                "invoice_id" => $invoice->id,
            ]);

            $account = AccountStatement::create([

                "description" => "تأمين اعمال",
                "date" => $invoice->created_at,
                "date_search" => $invoice->created_at,
                "debit" => 0,
                "credit" => $request->business_insurance_value,
                "balance" => "",
                "accountType" => "credit",
                "user_id" => \Auth::user()->id,
                "supplier_id" => $request->supplier_id,
                "invoice_id" => $invoice->id,
            ]);
        } else {
            $account = AccountStatement::create([

                "description" => "قيمة الفاتورة",
                "date" => $invoice->created_at,
                "date_search" => $invoice->created_at,
                "debit" => 0,
                "credit" => $request->total,
                "balance" => "",
                "accountType" => "credit",
                "user_id" => \Auth::user()->id,
                "supplier_id" => $request->supplier_id,
                "invoice_id" => $invoice->id,
            ]);
        }

        if ($request->value_tax) {

            $account = AccountStatement::create([

                "description" => "%".$request->value_tax_rate." القيمه المضافه",
                "date" => $invoice->created_at,
                "date_search" => $invoice->created_at,
                "debit" => 0,
                "credit" => $request->value_tax,
                "balance" => "",
                "accountType" => "credit",
                "user_id" => \Auth::user()->id,
                "supplier_id" => $request->supplier_id,
                "invoice_id" => $invoice->id,


            ]);
        }
        if ($request->tax_deduction_value) {

            $account = AccountStatement::create([

                "description" => "%".$request->tax_deduction."ضريبة خصم",
                "date" => $invoice->created_at,
                "date_search" => $invoice->created_at,
                "debit" => $request->tax_deduction_value,
                "credit" => 0,
                "balance" => "",
                "accountType" => "debit",
                "user_id" => \Auth::user()->id,
                "supplier_id" => $request->supplier_id,
                "invoice_id" => $invoice->id,


            ]);
        }
        if ($request->other_discount) {

            $account = AccountStatement::create([

                "description" => "خصومات اخري",
                "date" => $invoice->created_at,
                "date_search" => $invoice->created_at,
                "debit" => $request->other_discount,
                "credit" => 0,
                "balance" => "",
                "accountType" => "debit",
                "user_id" => \Auth::user()->id,
                "supplier_id" => $request->supplier_id,
                "invoice_id" => $invoice->id,

            ]);
        }

        return redirect()->route("invoices.index")->with(['success' => "Invoice Updated Successfully"]);
    }

    public function approveInvoice($id)
    {

        // return $id;

        $payment = Invoice::where('id', $id)->update([
            "approved" => "1",
        ]);

        return redirect()->route("invoices.index")->with(['success' => "Invoice Updated Successfully"]);
    }

    public function trash_index()
    {
     
        $invoices = Invoice::onlyTrashed()->get();

        $pageType = 'trashed';
        return view('dashboard-views.invoice.index', compact("invoices","pageType"));

    }

    public function restore($id)
    {
        $invoice = Invoice::withTrashed()->where('id', $id)->firstOrFail();
        $invoice->restore();
        $statment=AccountStatement::where("invoice_id",$id);
        $statment->restore();

        return redirect()->route("invoice.trash_index")->with(['success' => "invoice Restored Successfully"]);
    }

    public function delete(Request $request, $id)
    {
        $invoice = Invoice::find($id);

        $statment=AccountStatement::where("invoice_id",$id);
        if (!$invoice)
            return redirect()->route("invoices.index")->with(['error' => "Not Found This invoice"]);
        $invoice->delete();
        $statment->delete();
        return redirect()->route("invoices.index")->with(['success' => "invoice Deleted Successfully"]);
    }

}
