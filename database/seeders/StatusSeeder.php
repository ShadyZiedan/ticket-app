<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses =[
            ['id' => 1, 'name' => 'Открыт'],
            ['id' => 2, 'name' => 'В работе'],
            ['id' => 3, 'name' => 'Закрыт'],
        ];

        DB::table('statuses')->insert($statuses);
    }
}
