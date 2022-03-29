<?php

namespace App\Http\Controllers\Bank;

use App\Http\Controllers\Controller;

use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:banks', ['only' => ['index']]);
        $this->middleware('permission:add-bank', ['only' => ['create','store']]);
        $this->middleware('permission:edit-bank', ['only' => ['edit','update']]);
        $this->middleware('permission:restore-bank', ['only' => ['restore']]);
    }
    public function index()
    {
        $banks = Bank::all();
        $pageType = 'index';

        return view('dashboard-views.bank.index', compact('banks',"pageType"));
    }

    public function trash_index()
    {

        $banks = Bank::onlyTrashed()->get();
        $pageType = 'trashed';
        return view('dashboard-views.bank.index', compact('banks', "pageType"));
    }

    public function restore($id)
    {
        $bank = Bank::withTrashed()->where('id', $id)->firstOrFail();
        $bank->restore();
        return redirect()->route("banks.trash_index")->with(['success' => "Bank Restored Successfully"]);
    }

    public function show($id)
    {
        $bank = Bank::find($id);

        return $bank;
    }

    public function create()
    {
        return view('dashboard-views.bank.create');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'bank_name' => 'required',
            'currency' => 'required',
            'bank_code' => 'required|unique:banks|numeric',
            'bank_account_number' => 'required|unique:banks',


        ]);

        Bank::create([
            "bank_name" => $request->bank_name,
            "currency" => $request->currency,
            "bank_code" => $request->bank_code,
            "bank_account_number" => $request->bank_account_number,
            "bank_ibn" => $request->bank_ibn,
            "bank_swift" => $request->bank_swift,
        ]);
        return redirect()->route("banks.index")->with(['success' => "bank Created Successfully"]);
    }

    public function edit(Request $request, $id)
    {
        $bank = Bank::find($id);
        if (!$bank)
            return redirect()->route("banks.index")->with(['error' => "Not Found This bank"]);
        return view("dashboard-views.bank.edit", compact("bank"));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'bank_name' => 'required',
            'currency' => 'required',
            'bank_code' => 'required|numeric|unique:banks,bank_code,'.$id,
            'bank_account_number' => 'required|unique:banks,bank_account_number,'.$id,


        ]);

        $bank = Bank::find($id);
        if (!$bank)
            return redirect()->route("banks.index")->with(['error' => "Not Found This bank"]);
        Bank::where("id", $id)->update([
            "bank_name" => $request->bank_name,
            "currency" => $request->currency,
            "bank_code" => $request->bank_code,
            "bank_account_number" => $request->bank_account_number,
            "bank_ibn" => $request->bank_ibn,
            "bank_swift" => $request->bank_swift,

        ]);
        return redirect()->route("banks.index")->with(['success' => "bank Updated Successfully"]);
    }

    public function delete(Request $request, $id)
    {
        $bank = Bank::find($id);
        if (!$bank)
            return redirect()->route("banks.index")->with(['error' => "Not Found This bank"]);
        $bank->delete();
        return redirect()->route("banks.index")->with(['success' => "bank Deleted Successfully"]);
    }
}

