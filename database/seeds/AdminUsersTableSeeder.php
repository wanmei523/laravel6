<?php

use App\Models\AdminUser;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //插入默认账号
        AdminUser::create([
            'username'=>'admin',
            'password'=>Hash::make('admin'),
            'state'=>AdminUser::NORMAL
        ]);
    }
}
