<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Back\CreateTableRequest;
use App\Http\Requests\Back\EditTableRequest;
use App\Models\Table;
use Auth, DB;

class TableController extends Controller
{
    public function index()
    {
        $tables = Table::all();
        return view('Back.Tables.index', compact('tables'));
    }

    public function Trashed()
    {
        $tables = Table::onlyTrashed()->get();
        return view('Back.Tables.trashed', compact('tables'));
    }

    public function create()
    {
        return view('Back.Tables.create');
    }

    public function store(CreateTableRequest $request)
    {
        $tableData = $request->all();

        if(Table::createTable($tableData))
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
        return redirect()->route('tables.index');
    }

    public function ChangeTablestatus(Request $request)
    {
        // Request ajax from index;
        $tableData = $request->all();
        $currentTable = Table::find($request->id);
        
        if (!$updateTableStatus = Table::updateTableStatus($tableData, $currentTable))
            return response()->json(['requestStatus' => false, 'message' => trans('Server Internal Error 500')]);

        return response()->json(['requestStatus' => true, 'message' => trans('Data Updated Successfully')]);
    }

    public function edit($id)
    {
        $table = Table::find($id);
        return view('Back.Tables.edit', compact('table'));
    }

    public function update(EditTableRequest $request, $id)
    {
        $tableData = $request->all();
        $currentTable = Table::find($id);
        
        if (Table::updateTable($tableData, $currentTable) ) {

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

        return redirect()->route('tables.edit', ['id' => $currentTable->id]);
    }

    public function DeleteTable(Request $request)
    {
        $table = Table::find($request->id);

        if(!$table) return response()->json(['deleteStatus' => false, 'error' => 'Sorry, Table is not exists !!']);

        try
        {            
            $table->delete();
            
            return response()->json(['deleteStatus' => true, 'message' => 'Table Deleted Successfully']);
        }
        catch (Exception $e){ return response()->json(['deleteStatus' => false,'error' => 'Server Internal Error 500']); }

        return redirect()->route('tables.index');
    }

    public function RestoreTable(Request $request)
    {
        $restore = DB::table('tables')->where('id', $request->id)->where('deleted_at', '!=', null)->update(['deleted_at' => null]);
        
        $response['requestStatus']  = ($restore) ? true : false;
        $response['message']        = ($restore) ? 'Table Restored Successfully' : 'Server Internal Error 500';

        return response()->json($response);
    }

    public function RemoveTable(Request $request)
    {
        $remove = DB::table('tables')->where('id', $request->id)->where('deleted_at', '!=', null);

        if ($remove->image) File::delete('uploaded/tables/'.$remove->image);

        $remove->delete();
        
        $response['requestStatus']  = ($remove) ? true : false;
        $response['message']        = ($remove) ? 'Table Removed Successfully' : 'Server Internal Error 500';

        return response()->json($response);
    }
}
