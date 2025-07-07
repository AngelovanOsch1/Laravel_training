<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Genre;
use App\Models\Gender;
use App\Models\Series;
use App\Models\Country;
use App\Models\SeriesStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $country = Country::factory()->count(10)->create();
        $gender = Gender::factory()->count(3)->create();
        $role = Role::factory()->count(3)->create();

        $userCollection = collect();

        $emails = [
            'angelo.van.osch@hotmail.com',
            'angelo.van.osch1@hotmail.com',
            'angelo.van.osch2@hotmail.com',
        ];

        $firstNames = ['Angelo', 'Angela', 'Angelina'];
        $lastNames = ['van Osch', 'van Oscha', 'van Oschy'];

        foreach ($emails as $index => $email) {
            $user = User::create([
                'email' => $email,
                'password' => Hash::make('wachtwoord123'),
                'role_id' => $role->random()->id,
                'first_name' => $firstNames[$index],
                'last_name' => $lastNames[$index],
                'date_of_birth' => '1996-09-04',
                'country_id' => $country->random()->id,
                'gender_id' => $gender->random()->id,
                'description' => 'This is a description!.',
                'profile_photo' => null,
                'profile_banner' => null,
            ]);
            $userCollection->push($user);
        }


        $images = [
            ['title' => 'Frieren',               'image' => 'storage/series/1.jpg'],
            ['title' => 'Fullmetal Alchemist',   'image' => 'storage/series/2.jpg'],
            ['title' => 'SteinsGate',            'image' => 'storage/series/3.jpg'],
            ['title' => 'Attack on Titan',       'image' => 'storage/series/4.jpg'],
            ['title' => 'Gintama',               'image' => 'storage/series/5.jpg'],
            ['title' => 'Gintama 2',             'image' => 'storage/series/6.jpg'],
            ['title' => 'One Piece',             'image' => 'storage/series/7.jpg'],
            ['title' => 'Hunter x Hunter',       'image' => 'storage/series/8.jpg'],
            ['title' => 'Gintama 3',             'image' => 'storage/series/9.jpg'],
            ['title' => 'Kaguya-sama',           'image' => 'storage/series/10.jpg'],
        ];

        $seriesCollection = collect();

        foreach ($images as $entry) {
            $type = $faker->randomElement(['TV', 'Movie', 'OVA']);
            $minutes_per_episode = $type === 'TV' ? 20 : 100;

            $series = Series::create([
                'title' => $entry['title'],
                'type' => $type,
                'cover_image' => $entry['image'],
                'episode_count' => $faker->numberBetween(1, 100),
                'minutes_per_episode' => $minutes_per_episode,
                'aired_start_date' => $faker->dateTimeBetween('-5 years', '-3 years'),
                'aired_end_date' => $faker->dateTimeBetween('-2 years', '+2 years'),
                'score' => $faker->numberBetween(1, 10),
            ]);

            $seriesCollection->push($series);
        }

        $genres = Genre::factory()->count(5)->create();

        $series_status_names = ['Watching', 'Completed', 'Dropped', 'Plan to watch', 'On-Hold'];

        $series_statuses = collect($series_status_names)->map(function ($name) {
            return SeriesStatus::create(['name' => $name]);
        });

        $series->each(function ($serie) use ($genres) {
            $serie->genres()->attach(
                $genres->random(rand(1, 3))->pluck('id')->toArray()
            );
        });

        $userCollection->each(function ($user) use ($seriesCollection, $series_statuses, $faker) {
            $seriesCollection->each(function ($serie) use ($user, $series_statuses, $faker) {
                $user->series()->attach($serie->id, [
                    'series_status_id' => $series_statuses->random()->id,
                    'start_date' => $faker->dateTimeBetween('-5 years', '-3 years'),
                    'end_date' => $faker->dateTimeBetween('-2 years', '+2 years'),
                    'episode_count' => $faker->numberBetween(1, $serie->episode_count ?? 24),
                    'score' => $faker->numberBetween(1, 10),
                ]);
            });
        });
    }
}
