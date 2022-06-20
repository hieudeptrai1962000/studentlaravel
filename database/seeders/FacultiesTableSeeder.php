<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacultiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $limit = 10;

        for ($i=0; $i<$limit;$i++)
        {
            DB::table('faculties')->insert(
                [
                    'name'=>$faker->company,
                ]
            );
        }
    }
}
