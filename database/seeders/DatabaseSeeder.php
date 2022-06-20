<?php

namespace Database\Seeders;

use App\Models\Faculty\Faculty;
use App\Models\Student\Student;
use Illuminate\Database\Eloquent\Model;
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
        Model::unguard();
        $this->call(Student::class);
        $this->call(Faculty::class);
        $this->call(PermissionTableSeeder::class);
        Model::reguard();
    }
}
