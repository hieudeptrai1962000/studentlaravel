<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentsTableSeeder extends Seeder
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
            $title = $faker->name;
            $slug = str_slug($title, '-');
            DB::table('students')->insert(
                [
                    'full_name'=>$title,
                    'slug'=>$slug,
                    'email'=>$faker->email,
                    'birthday'=>$faker->date,
                    'gender'=>$faker->boolean,
                    'phone_number'=>$faker->phoneNumber,
                    'image'=>'uploads/mtp.png',
                    'created_at'=>$faker->dateTime,
                    'updated_at'=>$faker->dateTime,
                ]
            );
        }
    }
}
