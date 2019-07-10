<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hash, DB, Image, Auth, File;

class Admin extends Authenticatable
{
    use Notifiable, SoftDeletes;

    public $guard = 'admin';

    protected $guarded = ['id', 'password_confirmation', '_token'];

    protected $hidden = ['password', 'remember_token'];

    protected $dates = ['deleted_at'];

    protected $casts = ['status' => 'boolean'];

    public function scopeIsSuperAdmin($query, $parm = false)
    {
        return ($parm == false) ? $query->where('is_super_admin', 0) : $query->where('is_super_admin', 1);
    }

    public function scopeStatus($query, $parm)
    {
        return $query->where('status', $parm);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function setStatusAttribute($value)
    {
        if (is_null($value)) $value = false;

        $this->attributes['status'] = (boolean) $value;
    }

    public static function uploadImage($img)
    {
        $filename = 'admin_' . str_random(12) . '_' . date('Y-m-d') . '.' . strtolower($img->getClientOriginalExtension());

        if (!file_exists(public_path('uploaded/admins/')))
            mkdir(public_path('uploaded/admins/'), 0777, true);

        $path = public_path('uploaded/admins/');
        
        $img = Image::make($img)->save($path . $filename);

        return $filename;
    }

    public static function createAdmin($adminData) 
    {
        if (request()->hasFile('image')) $adminData['image'] = Admin::uploadImage($adminData['image']);
        
        else $adminData = array_except($adminData, ['image']);
        
        $createdAdmin = Admin::updateOrcreate(array_except($adminData, ['_token']));

        return $createdAdmin;
    }

    public static function updateAdmin($adminData, $currentAdmin)
    {
        if (request()->hasFile('image'))
        {
            $adminData['image'] = Admin::uploadImage($adminData['image']);
            File::delete('/uploaded/users/'.$currentAdmin->image);
        }

        else $adminData = array_except($adminData, ['image']);

        $updateAdmin = $currentAdmin->update($adminData);

        return $updateAdmin;
    }

    public static function updateAdminStatus($adminData, $currentAdmin)
    {
        $value = $adminData['value'];

        // if the value comes with checked that mean we want the reverse value of it;
        return ($value == 'checked') ? $currentAdmin->update(['status' => 0]) : $currentAdmin->update(['status' => 1]);
    }
}
