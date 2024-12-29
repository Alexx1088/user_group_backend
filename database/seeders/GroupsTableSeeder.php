<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('groups')->insert([
            ['name' => 'Группа1', 'expire_hours' => 1],
            ['name' => 'Группа2', 'expire_hours' => 2],
        ]);
    }
}
