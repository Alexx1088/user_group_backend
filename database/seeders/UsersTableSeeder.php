<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('users')->insert([
            ['name' => 'Иванов', 'email' => 'info@datainlilfe.ru', 'active' => true],
            ['name' => 'Петров', 'email' => 'job@datainlilfe.ru', 'active' => true],
        ]);
    }
}
