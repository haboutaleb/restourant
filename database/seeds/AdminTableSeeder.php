<?php

use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminTableSeeder extends Seeder
{
    public function run()
    {
        $newAdmin = new Admin();
        $newAdmin->name = 'Ali labib';
        $newAdmin->email= 'alaa@test.com';
        $newAdmin->phone= '0123456789';
        $newAdmin->password = bcrypt('123456');
        $newAdmin->save();

    }
}
