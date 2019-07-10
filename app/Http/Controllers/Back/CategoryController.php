<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Back\CreateCategoryRequest;
use App\Http\Requests\Back\EditCategoryRequest;
use App\Models\Category;
use Auth, DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('Back.Categories.index', compact('categories'));
    }

    public function Trashed()
    {
        $categories = Category::onlyTrashed()->get();
        return view('Back.Categories.trashed', compact('categories'));
    }

    public function create()
    {
        return view('Back.Categories.create');
    }

    public function store(CreateCategoryRequest $request)
    {
        $categoryData = $request->all();

        if(Category::createCategory($categoryData))
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
        return redirect()->route('categories.index');
    }

    public function ChangeCategorystatus(Request $request)
    {
        // Request ajax from index;
        $categoryData = $request->all();
        $currentCategory = Category::find($request->id);
        
        if (!$updateCategoryStatus = Category::updateCategoryStatus($categoryData, $currentCategory))
            return response()->json(['requestStatus' => false, 'message' => trans('Server Internal Error 500')]);

        return response()->json(['requestStatus' => true, 'message' => trans('Data Updated Successfully')]);
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return view('Back.Categories.edit', compact('category'));
    }

    public function update(EditCategoryRequest $request, $id)
    {
        $categoryData = $request->all();
        $currentCategory = Category::find($id);
        
        if (Category::updateCategory($categoryData, $currentCategory) ) {

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

        return redirect()->route('categories.edit', ['id' => $currentCategory->id]);
    }

    public function DeleteCategory(Request $request)
    {
        $category = Category::find($request->id);

        if(!$category) return response()->json(['deleteStatus' => false, 'error' => 'Sorry, Category is not exists !!']);

        try
        {            
            $category->delete();
            
            return response()->json(['deleteStatus' => true, 'message' => 'Category Deleted Successfully']);
        }
        catch (Exception $e){ return response()->json(['deleteStatus' => false,'error' => 'Server Internal Error 500']); }

        return redirect()->route('categories.index');
    }

    public function RestoreCategory(Request $request)
    {
        $restore = DB::table('categories')->where('id', $request->id)->where('deleted_at', '!=', null)->update(['deleted_at' => null]);
        
        $response['requestStatus']  = ($restore) ? true : false;
        $response['message']        = ($restore) ? 'Category Restored Successfully' : 'Server Internal Error 500';

        return response()->json($response);
    }

    public function RemoveCategory(Request $request)
    {
        $remove = DB::table('categories')->where('id', $request->id)->where('deleted_at', '!=', null);

        if ($remove->image) File::delete('uploaded/categories/'.$remove->image);

        $remove->delete();
        
        $response['requestStatus']  = ($remove) ? true : false;
        $response['message']        = ($remove) ? 'Category Removed Successfully' : 'Server Internal Error 500';

        return response()->json($response);
    }
}
