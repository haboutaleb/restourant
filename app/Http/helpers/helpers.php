<?php

function user() { return new App\Models\User; }
function order() { return new App\Models\Order; }
function item() { return new App\Models\Item; }
function item_detail() { return new App\Models\ItemDetail; }
function order_detail() { return new App\Models\OrderDetail; }
function table() { return new App\Models\Table; }
function admin() { return new App\Models\Admin; }

function str() { return new Illuminate\Support\Str; }
function carbon() { return new \Carbon\Carbon; }

function getImage($type, $img)
{
	if($type == 'user') return ($img != null) ? asset('uploaded/users/'.$img) : asset('admin/img/avatar10.jpg');

	elseif($type == 'admins') return ($img != null) ? asset('uploaded/admins/'.$img) : asset('admin/img/avatar10.jpg');

	elseif($type == 'categories') return ($img != null) ? asset('uploaded/categories/'.$img) : asset('admin/img/avatar10.jpg');

	elseif($type == 'tables') return ($img != null) ? asset('uploaded/tables/'.$img) : asset('admin/img/avatar10.jpg');

	elseif($type == 'items') return ($img != null) ? asset('uploaded/items/'.$img) : asset('admin/img/avatar10.jpg');

	else return asset('admin/img/avatar10.jpg');
}

function getModelCount($model, $withDeleted = false)
{
	if($withDeleted)
	{
		if($model == 'admin') return admin()->onlyTrashed()->where('is_super_admin', '!=', 1)->count();
		
		$mo = "App\\Models\\$model";
	
		return $mo::onlyTrashed()->count();
	}
	
	if($model == 'admin') return admin()->status(1)->where('is_super_admin', '!=', 1)->count();
		
	$mo = "App\\Models\\$model";
	
	return $mo::where('status', 1)->count();
}

function is_admin($admin_id)
{
	$admin = admin()->find($admin_id);
	
	if($admin->is_super_admin == 0) return 0;

	elseif($admin->is_super_admin == 1) return 1;

	else return 2;
}