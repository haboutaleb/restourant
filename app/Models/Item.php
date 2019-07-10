<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hash, DB, Image, Auth, File;

class Item extends Model
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
        $filename = 'Item_' . str_random(12) . '_' . date('Y-m-d') . '.' . strtolower($img->getClientOriginalExtension());

        if (!file_exists(public_path('uploaded/items/')))
            mkdir(public_path('uploaded/items/'), 0777, true);

        $path = public_path('uploaded/items/');
        
        $img = Image::make($img)->save($path . $filename);

        return $filename;
    }

    public static function createItem($itemData) 
    {
        if (request()->hasFile('image')) $itemData['image'] = Item::uploadImage($itemData['image']);
        
        else $itemData = array_except($itemData, ['image']);
        
        $createdItem = Item::create($itemData);

        return $createdItem;
    }

    public static function updateItem($itemData, $currentItem)
    {
        if (request()->hasFile('image'))
        {
            $itemData['image'] = Item::uploadImage($itemData['image']);
            File::delete('uploaded/items/'.$currentItem->image);
        }
        
        else $itemData = array_except($itemData, ['image']);

        $updateItem = $currentItem->update($itemData);

        return $updateItem;
    }

    public static function updateItemStatus($itemData, $currentItem)
    {
        $value = $itemData['value'];

        // if the value comes with checked that mean we want the reverse value of it;
        return ($value == 'checked') ? $currentItem->update(['status' => 0]) : $currentItem->update(['status' => 1]);
    }
}
