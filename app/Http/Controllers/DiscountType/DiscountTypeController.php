<?php

namespace App\Http\Controllers\DiscountType;

use App\Models\DiscountType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DiscountTypeController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:discount-types', ['only' => ['index']]);
        $this->middleware('permission:add-discount-type', ['only' => ['create','store']]);
        $this->middleware('permission:edit-discount-type', ['only' => ['edit','update']]);
        $this->middleware('permission:restore-discount-type', ['only' => ['restore']]);
    }

    public function index()
    {
        $discountTypes = DiscountType::all();
        $pageType = 'index';

        return view('dashboard-views.discount_type.index', compact('discountTypes',"pageType"));
    }

    public function trash_index()
    {

        $discountTypes = DiscountType::onlyTrashed()->get();
        $pageType = 'trashed';
        return view('dashboard-views.discount_type.index', compact('discountTypes', "pageType"));
    }

    public function restore($id)
    {
        $discountTypes = DiscountType::withTrashed()->where('id', $id)->firstOrFail();
        $discountTypes->restore();
        return redirect()->route("discountTypes.trash_index")->with(['success' => "DiscountTypes Restored Successfully"]);
    }

    public function show($id)
    {
        $discountTypes = DiscountType::find($id);

        return $discountTypes;
    }
    public function create()
    {
        return view('dashboard-views.discount_type.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_ar' => 'required',
            'code' => 'required|unique:discount_types|numeric',
        ]);
        DiscountType::create([
            "name_en" => $request->name_en,
            "name_ar" => $request->name_ar,
            "code" => $request->code,
        ]);
        return redirect()->route("discountTypes.index")->with(['success' => "discountType Created Successfully"]);
    }

    public function edit(Request $request, $id)
    {
        $discountType = DiscountType::find($id);
        if (!$discountType)
            return redirect()->route("discountTypes.index")->with(['error' => "Not Found This discountType"]);
        return view("dashboard-views.discount_type.edit", compact("discountType"));
    }

    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'name_ar' => 'required',
            'code' => 'required|numeric|unique:discount_types,code,'.$id,
        ]);
        $discountType = DiscountType::find($id);
        if (!$discountType)
            return redirect()->route("discountTypes.index")->with(['error' => "Not Found This discountType"]);
        DiscountType::where("id", $id)->update([
            "name_en" => $request->name_en,
            "name_ar" => $request->name_ar,
            "code" => $request->code,
        ]);
        return redirect()->route("discountTypes.index")->with(['success' => "discountType Updated Successfully"]);
    }

    public function delete(Request $request, $id)
    {
        $project = DiscountType::find($id);
        if (!$project)
            return redirect()->route("discountTypes.index")->with(['error' => "Not Found This discountType"]);
        $project->delete();
        return redirect()->route("discountTypes.index")->with(['success' => "discountType Deleted Successfully"]);
    }
}
