<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'type' => 'Aministrator',
        ]);
        // \App\Models\User::factory(10)->create();
    }
}
