<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Admin;
use App\Models\Teachers;
use App\Models\Student;

use Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Admin::create([
            "f_name" => "admin",
            "l_name" => "admin",
            "username" => "admin",
            "plain_password" => "admin",
            "password" => Hash::make("admin")
        ]);

    }
}
