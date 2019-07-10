<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Back\CreateItemRequest;
use App\Http\Requests\Back\EditItemRequest;
use App\Models\Item;
use Auth, DB, File, Image;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('Back.Items.index', compact('items'));
    }

    public function Trashed()
    {
        $items = Item::onlyTrashed()->get();
        return view('Back.Items.trashed', compact('items'));
    }

    public function create()
    {
        return view('Back.Items.create');
    }

    public function store(CreateItemRequest $request)
    {
        $itemData = $request->all();

        if(Item::createItem($itemData))
        {
            if (request()->ajax()) {
                return response()->json(['requestStatus' => true, 'message' => __('Data Added Successfully')]);
            } else {
                request()->session()->flash('status','success');
                request()->session()->flash('message',__('Data Added Successfully'));
            }
        }
        else
        {
            if(request()->ajax()) {
                return response()->json(['requestStatus' => false,'message' => __('Internal Server Error 500')]);
            } else {
                request()->session()->flash('status','danger');
                request()->session()->flash('message',__('Internal Server Error 500'));
            }

            return back()->withInputs();
        }
        return redirect()->route('items.index');
    }

    public function ChangeItemstatus(Request $request)
    {
        // Request ajax from index;
        $itemData = $request->all();
        $currentItem = Item::find($request->id);
        
        if (!$updateItemStatus = Item::updateItemStatus($itemData, $currentItem))
            return response()->json(['requestStatus' => false, 'message' => trans('Server Internal Error 500')]);

        return response()->json(['requestStatus' => true, 'message' => trans('Data Updated Successfully')]);
    }

    public function edit($id)
    {
        $item = Item::find($id);
        return view('Back.Items.edit', compact('item'));
    }

    public function update(EditItemRequest $request, $id)
    {
        $itemData = $request->all();
        $currentItem = Item::find($id);
        
        if (Item::updateItem($itemData, $currentItem) ) {

            if (request()->ajax()) {
                return response()->json(['requestStatus' => true, 'message' => __('Data Updated Successfully')]);
            }else{
            	request()->session()->flash('status','success');
                request()->session()->flash('message',__('Data Updated Successfully'));
            }
        }else{
            if (request()->ajax()) {
                return response()->json(['requestStatus' => false, 'message' => __('Server Internal Error 500')]);
            }else{
                request()->session()->flash('status','danger');
                request()->session()->flash('message',__('Server Internal Error 500'));
            }
        }

        return redirect()->route('items.edit', ['id' => $currentItem->id]);
    }

    public function DeleteItem(Request $request)
    {
        $item = Item::find($request->id);

        if(!$item) return response()->json(['deleteStatus' => false, 'error' => 'Sorry, item is not exists !!']);

        try
        {            
            $item->delete();
            
            return response()->json(['deleteStatus' => true, 'message' => 'item Deleted Successfully']);
        }
        catch (Exception $e){ return response()->json(['deleteStatus' => false,'error' => 'Server Internal Error 500']); }

        return redirect()->route('items.index');
    }

    public function RestoreItem(Request $request)
    {
        $restore = DB::table('items')->where('id', $request->id)->where('deleted_at', '!=', null)->update(['deleted_at' => null]);
        
        $response['requestStatus']  = ($restore) ? true : false;
        $response['message']        = ($restore) ? 'Item Restored Successfully' : 'Server Internal Error 500';

        return response()->json($response);
    }

    public function RemoveItem(Request $request)
    {
        $remove = DB::table('items')->where('id', $request->id)->where('deleted_at', '!=', null);

        if ($remove->image) File::delete('uploaded/items/'.$remove->image);

        $remove->delete();
        
        $response['requestStatus']  = ($remove) ? true : false;
        $response['message']        = ($remove) ? 'Item Removed Successfully' : 'Server Internal Error 500';

        return response()->json($response);
    }
}
