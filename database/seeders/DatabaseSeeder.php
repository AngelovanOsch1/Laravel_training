<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $countries = Country::factory()->count(10)->create();

        User::create([
            'email' => 'Angelo.van.osch@hotmail.com',
            'password' => Hash::make('wachtwoord123'),
            'first_name' => 'Angelo',
            'last_name' => 'van Osch',
            'date_of_birth' => '1996-09-04',
            'country_id' => $countries->random()->id,
            'gender' => 'Male',
            'description' => 'This is a description!.',
            'profile_photo' => null,
            'profile_banner' => null,
        ]);
    }
}
