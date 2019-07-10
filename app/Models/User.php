<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hash, DB, Image, Auth, File;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    public $guard = 'web';

    protected $dates = ['deleted_at'];

    protected $guarded = ['id', 'password_confirmation', '_token'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime', 'status' => 'boolean'];

    public function setStatusAttribute($value)
    {
        if (is_null($value)) $value = false;

        $this->attributes['status'] = (boolean) $value;
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
    
    public function scopeStatus($query, $parm)
    {
        return $query->where('status', $parm);
    }

    public static function uploadImage($img)
    {
        $filename = 'user_' . str_random(12) . '_' . date('Y-m-d') . '.' . strtolower($img->getClientOriginalExtension());

        if (!file_exists(public_path('uploaded/users/')))
            mkdir(public_path('uploaded/users/'), 0777, true);

        $path = public_path('uploaded/users/');
        
        $img = Image::make($img)->save($path . $filename);

        return $filename;
    }
    
    public static function createUser($userData) 
    {
        if (request()->hasFile('image')) $userData['image'] = User::uploadImage($userData['image']);
        
        else $userData = array_except($userData, ['image']);       
        
        $createdUser = User::updateOrcreate(array_except($userData, ['_token']));

        return $createdUser;
    }

    public static function updateUser($userData, $currentUser)
    {
        if (request()->hasFile('image'))
        {
            $userData['image'] = User::uploadImage($userData['image']);
            File::delete('/uploaded/users/'.$currentUser->image);
        }
        
        else $userData = array_except($userData, ['image']);

        $updateUser = $currentUser->update($userData);

        return $updateUser;
    }

    public static function updateUserStatus($userData, $currentUser)
    {
        $value = $userData['value'];

        // if the value comes with checked that mean we want the reverse value of it;
        return ($value == 'checked') ? $currentUser->update(['status' => 0]) : $currentUser->update(['status' => 1]);
    }

    public static function getInSelectForm($with_main = null , $with_null = null, $exceptedIds = [] )
    {
        $users   = [];

        $with_null == null ? $users = $users : $users = $users + [''  => ''];
        $with_main == null ? $users = $users : $users = $users + ['0' => 'Main'];

        $usersDB = User::whereNotIn('id',$exceptedIds)->get();

        foreach ($usersDB as $user) { $users[$user->id] = ucwords($user->fullname); }

        return $users;
    }
}
