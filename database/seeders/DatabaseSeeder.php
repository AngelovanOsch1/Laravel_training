<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Gender;
use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $country = Country::factory()->count(10)->create();
        $gender = Gender::factory()->count(3)->create();
        $role = Role::factory()->count(3)->create();

        User::create([
            'email' => 'Angelo.van.osch@hotmail.com',
            'password' => Hash::make('wachtwoord123'),
            'role_id' => $role->random()->id,
            'first_name' => 'Angelo',
            'last_name' => 'van Osch',
            'date_of_birth' => '1996-09-04',
            'country_id' => $country->random()->id,
            'gender_id' => $gender->random()->id,
            'description' => 'This is a description!.',
            'profile_photo' => null,
            'profile_banner' => null,
        ]);
    }
}
