<?php

namespace App\Http\Controllers\BusinessNature;

use App\Http\Controllers\Controller;
use App\Models\BusinessNature;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Traits\ToastrTrait;

class BusinessNatureController extends Controller
{
    use ToastrTrait;
    function __construct()
    {
        $this->middleware('permission:business-natures', ['only' => ['index']]);
        $this->middleware('permission:add-business-nature', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-business-nature', ['only' => ['edit', 'update']]);
        $this->middleware('permission:restore-business-nature', ['only' => ['restore']]);
    }
    public function index()
    {

        $businessNatures = BusinessNature::all();
        $pageType = 'index';

        return view('dashboard-views.business_nature.index', compact('businessNatures',"pageType"));
    }

    public function trash_index()
    {

        $businessNatures = BusinessNature::onlyTrashed()->get();
        $pageType = 'trashed';
        return view('dashboard-views.business_nature.index', compact('businessNatures', "pageType"));
    }

    public function restore($id)
    {
        $businessNature = BusinessNature::withTrashed()->where('id', $id)->firstOrFail();
        $businessNature->restore();
        return redirect()->route("businessNatures.trash_index")->with(['success' => "BusinessNature Restored Successfully"]);
    }

    public function show($id)
    {
        $businessNature = BusinessNature::find($id);

        return $businessNature;
    }


    public function create()
    {
        $items = Item::all();
        return view('dashboard-views.business_nature.create', compact('items'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'name_ar' => 'required|unique:business_natures',
        ]);

        BusinessNature::create([
            "name_en" => $request->name_en,
            "name_ar" => $request->name_ar,
            "item_id" => $request->item_id,

        ]);
        // Start toastr notification
        $this->getSuccessToastrMessage('added_successfully');
        // End toastr notification
        return redirect()->route("businessNatures.index");
    }

    public function edit(Request $request, $id)
    {
        $businessNature = BusinessNature::find($id);
        $items = Item::all();

        if (!$businessNature)
            return redirect()->route("businessNatures.index")->with(['error' => "Not Found This businessNature"]);
        return view("dashboard-views.business_nature.edit", compact("businessNature", "items"));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name_ar' => 'required|unique:business_natures,name_ar,' . $id,
        ]);

        $businessNature = BusinessNature::find($id);
        if (!$businessNature)
            return redirect()->route("businessNatures.index")->with(['error' => "Not Found This businessNature"]);
        BusinessNature::where("id", $id)->update([
            "name_en" => $request->name_en,
            "name_ar" => $request->name_ar,
            "item_id" => $request->item_id,

        ]);

        // Start toastr notification
        $this->getSuccessToastrMessage('added_successfully');
        // End toastr notification

        return redirect()->route("businessNatures.index");
    }

    public function delete(Request $request, $id)
    {
        $businessNature = BusinessNature::find($id);
        if (!$businessNature)
            return redirect()->route("businessNatures.index")->with(['error' => "Not Found This businessNature"]);
        $businessNature->delete();
        return redirect()->route("businessNatures.index")->with(['success' => "businessNature Deleted Successfully"]);
    }
}
