<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hash, DB, Image, Auth;

class Category extends Model
{
	use SoftDeletes;
	
    protected $guarded = ['id'];

    protected $casts = ['status' => 'boolean'];

    public function scopeStatus($query, $parm)
    {
        return $query->where('status', $parm);
    }

    public function setStatusAttribute($value) //mutator for active column.
    {
        if (is_null($value)) $value = false;

        $this->attributes['status'] = (boolean) $value;
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\Category', 'parent_id', 'id')->withDefault();
        // return $this->belongsTo('App\Models\Category', 'parent_id', 'id');
    }

    public static function uploadImage($img)
    {
        $filename = 'category_' . str_random(12) . '_' . date('Y-m-d') . '.' . strtolower($img->getClientOriginalExtension());

        if (!file_exists(public_path('uploaded/categories/')))
            mkdir(public_path('uploaded/categories/'), 0777, true);

        $path = public_path('uploaded/categories/');
        
        $img = Image::make($img)->save($path . $filename);

        return $filename;
    }

    public static function createCategory($categoryData) 
    {
        if (request()->hasFile('image')) $categoryData['image'] = Category::uploadImage($categoryData['image']);
        
        else $categoryData = array_except($categoryData, ['image']);
        
        $createdCategory = Category::create($categoryData);

        return $createdCategory;
    }

    public static function updateCategory($categoryData, $currentCategory)
    {
        if (request()->hasFile('image')) $categoryData['image'] = Category::uploadImage($categoryData['image']);
        
        else $categoryData = array_except($categoryData, ['image']);

        $updateCategory = $currentCategory->update($categoryData);

        return $updateCategory;
    }

    public static function updateCategoryStatus($categoryData, $currentCategory)
    {
        $value = $categoryData['value'];

        // if the value comes with checked that mean we want the reverse value of it;
        return ($value == 'checked') ? $currentCategory->update(['status' => 0]) : $currentCategory->update(['status' => 1]);
    }
}
