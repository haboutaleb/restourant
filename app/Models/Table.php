<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hash, DB, Image, Auth, File;

class Table extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    public function scopeStatus($query, $parm)
    {
        return $query->where('status', $parm);
    }

    public function setStatusAttribute($value) //mutator for active column.
    {
        if (is_null($value)) $value = false;

        $this->attributes['status'] = (boolean) $value;
    }

    public static function uploadImage($img)
    {
        $filename = 'Table_' . str_random(12) . '_' . date('Y-m-d') . '.' . strtolower($img->getClientOriginalExtension());

        if (!file_exists(public_path('uploaded/tables/')))
            mkdir(public_path('uploaded/tables/'), 0777, true);

        $path = public_path('uploaded/tables/');
        
        $img = Image::make($img)->save($path . $filename);

        return $filename;
    }

    public static function createTable($tableData) 
    {
        if (request()->hasFile('image')) $tableData['image'] = Table::uploadImage($tableData['image']);
        
        else $tableData = array_except($tableData, ['image']);
        
        $createdTable = Table::create($tableData);

        return $createdTable;
    }

    public static function updateTable($tableData, $currentTable)
    {
        if (request()->hasFile('image'))
        {
            $tableData['image'] = Table::uploadImage($tableData['image']);
            File::delete('uploaded/tables/'.$currentTable->image);
        }
        
        else $tableData = array_except($tableData, ['image']);

        $updateTable = $currentTable->update($tableData);

        return $updateTable;
    }

    public static function updateTableStatus($tableData, $currentTable)
    {
        $value = $tableData['value'];

        // if the value comes with checked that mean we want the reverse value of it;
        return ($value == 'checked') ? $currentTable->update(['status' => 0]) : $currentTable->update(['status' => 1]);
    }
}
