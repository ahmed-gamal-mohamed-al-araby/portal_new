<?php

namespace App\Http\Controllers\PaymentInvoice;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\BusinessNature;
use App\Models\ChequeRequest;
use App\Models\Item;
use App\Models\NatureDealing;
use App\Models\PaymentInvoice;
use App\Models\Project;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\User;
use Illuminate\Http\Request;

class PaymentInvoiceController extends Controller
{


    public function show($id)
    {
        $payment = PaymentInvoice::where('id', $id)->first();
        // return $payment;

        return view('dashboard-views.payment.show', compact("payment"));
    }

    public function index()
    {
        $paymentInvoices = PaymentInvoice::orderBy("id", "DESC")->paginate(5);
        $pageType = "index";
        return view('dashboard-views.payment.index', compact("paymentInvoices" , "pageType"));
    }

    public function create()
    {
        $suppliers = Supplier::all();

        $items = Item::all();
        $projects = Project::all();
        $banks = Bank::all();
        $purchaseOrders = PurchaseOrder::all();
        $chequeRequests = ChequeRequest::all();
        return view('dashboard-views.payment.create', compact("items", "chequeRequests" , "projects", "purchaseOrders" ,"suppliers" ,  "banks"));
    }
    public function getPaymentBankData(Request $request)
    {
        return $bank = Bank::find($request->bank_id);
    }

    public function getPaymentBankBusinessData(Request $request)
    {
        $data = [];
        $data["businessNatures"] = BusinessNature::where("item_id", $request->item_id)->get();
        $data["projects"] = Project::where("item_id", $request->item_id)->get();
        return $data;
    }


    public function store(Request $request)
    {

        $fileName = null;
        $originalName = null;

        if ($request->myfile) {
            $fileName = time() . '.' . $request->myfile->extension();
            $originalName = $request->myfile->getClientOriginalName();
            $request->myfile->move(public_path('uploads'), $fileName);
        }

        PaymentInvoice::create([
            "item_id" => $request->item_id,
            "project_id" => $request->project_id,
            "supplier_id" => $request->nat_tax_number,
            "po_number" => $request->supply_order_number,
            "invoice_number" => $request->invoice_number,
            "notes" => $request->notes,
            "payment_method" => $request->payment_method,
            "date_payment" => $request->date_payment,
            "bank_id" => $request->bank_id,
            "cheque_number" => $request->cheque_number,
            "value" => $request->cheque_value,
            "exchange_rate" => $request->exchange_rate,
            "recipient_name_in" => $request->recipient_name_in,
            "date_delivery_in" => $request->delivery_date_in,
            "recipient_name_out" => $request->recipient_name_out,
            "date_delivery_out" => $request->delivery_date_out,
            "file_name" => $fileName,
            "original_name" => $originalName,

            "user_id" => \Auth::user()->id
        ]);

        return redirect()->route("paymentInvoice.index");
    }

    public function edit(Request $request, $id)
    {
        $items = Item::all();
        $projects = Project::all();
        $banks = Bank::all();
        $suppliers = Supplier::all();

        $paymentInvoice = PaymentInvoice::with(['project', "supplier", "bank"])->find($id);
        if (!$paymentInvoice)
            return redirect()->route("paymentInvoice.index")->with(['error' => "Not Found This paymentInvoice"]);
        return view("dashboard-views.payment.edit", compact("paymentInvoice", "items", "projects", "suppliers" , "banks"));
    }

    public function update(Request $request, $id)
    {
        $paymentInvoice = PaymentInvoice::find($id);
        if (!$paymentInvoice)
            return redirect()->route("paymentInvoice.index")->with(['error' => "Not Found This paymentInvoice"]);


        $fileName = null;
        $originalName = null;



        PaymentInvoice::where("id", $id)->update([
            "item_id" => $request->item_id,
            "project_id" => $request->project_id,
            "supplier_id" => $request->nat_tax_number,
            "po_number" => $request->supply_order_number,
            "invoice_number" => $request->invoice_number,
            "notes" => $request->notes,
            "payment_method" => $request->payment_method,
            "date_payment" => $request->date_payment,
            "bank_id" => $request->bank_id,
            "cheque_number" => $request->cheque_number,
            "value" => $request->cheque_value,
            "exchange_rate" => $request->exchange_rate,
            "recipient_name_in" => $request->recipient_name_in,
            "date_delivery_in" => $request->delivery_date_in,
            "recipient_name_out" => $request->recipient_name_out,
            "date_delivery_out" => $request->delivery_date_out,
            "user_id" => $paymentInvoice->user_id
        ]);

        if ($request->myfile) {

            $x = PaymentInvoice::where("id", $id)->first();
            unlink(public_path('uploads/' . $x->file_name));
            $fileName = time() . '.' . $request->myfile->extension();
            $originalName = $request->myfile->getClientOriginalName();
            $request->myfile->move(public_path('uploads'), $fileName);

            PaymentInvoice::where("id", $id)->update([
                "file_name" => $fileName,
                "original_name" => $originalName,
            ]);
        }

        return redirect()->route("paymentInvoice.index")->with(['success' => "paymentInvoice Updated Successfully"]);
    }

    public function approvePayment($id)
    {

        // return $id;

        $payment = PaymentInvoice::where('id', $id)->update([
            "approved" => "1",
        ]);

        return redirect()->route("paymentInvoice.index")->with(['success' => "paymentInvoice Updated Successfully"]);
    }

    public function delete(Request $request, $id)
    {
        $payment = PaymentInvoice::find($id);
        if (!$payment)
            return redirect()->route("paymentInvoice.index")->with(['error' => "Not Found This Payment"]);
        $payment->delete();
        return redirect()->route("paymentInvoice.index")->with(['success' => "Payment Deleted Successfully"]);
    }

}
