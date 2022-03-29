<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Traits\ToastrTrait;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    use ToastrTrait;

    function __construct()
    {
        $this->middleware('permission:items', ['only' => ['index']]);
        $this->middleware('permission:add-item', ['only' => ['create','store']]);
        $this->middleware('permission:edit-item', ['only' => ['edit','update']]);
        $this->middleware('permission:restore-item', ['only' => ['restore']]);
    }

    public function index(){
        $items = Item::paginate(5);
        $pageType = 'index';
        return view('dashboard-views.item.index',compact('items',"pageType"));
    }


    public function trash_index()
    {

        $items = Item::onlyTrashed()->paginate(5);
        $pageType = 'trashed';
        return view('dashboard-views.item.index',compact('items',"pageType"));

    }

    public function restore($id)
    {
        $item = Item::withTrashed()->where('id', $id)->firstOrFail();
        $item->restore();
        return redirect()->route("items.trash_index")->with(['success' => "Item Restored Successfully"]);

    }

    public function show($id)
    {
        $item = Item::find($id);

        return $item;
    }

    public function create()
    {
        return view("dashboard-views.item.create");
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_ar' => 'required|unique:items',
        ]);

        Item::create([
            "name_en" => $request->name_en,
            "name_ar" => $request->name_ar,
        ]);

        // Start toastr notification
        $this->getSuccessToastrMessage('added_successfully');
        // End toastr notification

        return redirect()->route("items.index");
    }

    public function edit(Request $request , $id)
    {
       $item = Item::find($id);
       if(!$item)
            return redirect()->route("items.index")->with(['error' => "Not Found This Item"]);
       return view("dashboard-views.item.edit", compact("item"));
    }

    public function update(Request $request , $id)
    {
        $validated = $request->validate([
            'name_ar' => 'required|unique:items,name_ar,'.$id,
        ]);
       $item = Item::find($id);
           if(!$item)
                return redirect()->route("items.index")->with(['error' => "Not Found This Item"]);
       Item::where("id",$id)->update([
            "name_en" => $request->name_en,
            "name_ar" => $request->name_ar,
        ]);
          // Start toastr notification
          $this->getSuccessToastrMessage('updated_successfully');
          // End toastr notification

        return redirect()->route("items.index");
    }

    public function delete(Request $request , $id)
    {
       $item = Item::find($id);
           if(!$item)
                return redirect()->route("items.index")->with(['error' => "Not Found This Item"]);
        $item->delete();
        return redirect()->route("items.index")->with(['success' => "Item Deleted Successfully"]);
    }



}