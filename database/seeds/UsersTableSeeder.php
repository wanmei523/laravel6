<?php

use App\Models\Flight;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // Flight::create([
        //     'name'=>'ggg',
        //     'content'=>'12346'
        // ]);
            DB::table('flights')->insert([
                'name'=>'456',
                'content'=>'88888',
            ]);
    }
}
