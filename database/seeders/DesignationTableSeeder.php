<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class DesignationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('designations')->truncate();
        $designations = [
            ['designation' => 'CEO'],
            ['designation' => 'HR'],
            ['designation' => 'EMPLOYEE'],
        ];
        DB::table('designations')->insert($designations);
    }
}
