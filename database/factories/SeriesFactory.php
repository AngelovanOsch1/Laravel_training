<?php

namespace Database\Factories;

use App\Models\Series;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeriesFactory extends Factory
{
    protected $model = Series::class;

    // public $images = [
    //     ['title' => 'Frieren',               'image' => 'storage/series/1.jpg'],
    //     ['title' => 'Fullmetal Alchemist',   'image' => 'storage/series/2.jpg'],
    //     ['title' => 'SteinsGate',            'image' => 'storage/series/3.jpg'],
    //     ['title' => 'Attack on Titan',       'image' => 'storage/series/4.jpg'],
    //     ['title' => 'Gintama',               'image' => 'storage/series/5.jpg'],
    //     ['title' => 'Gintama 2',             'image' => 'storage/series/6.jpg'],
    //     ['title' => 'One Piece',             'image' => 'storage/series/7.jpg'],
    //     ['title' => 'Hunter x Hunter',       'image' => 'storage/series/8.jpg'],
    //     ['title' => 'Gintama 3',             'image' => 'storage/series/9.jpg'],
    //     ['title' => 'Kaguya-sama',           'image' => 'storage/series/10.jpg'],
    // ];

    public $images = [
        'storage/series/1.jpg',
        'storage/series/2.jpg',
        'storage/series/3.jpg',
        'storage/series/4.jpg',
        'storage/series/5.jpg',
        'storage/series/6.jpg',
        'storage/series/7.jpg',
        'storage/series/8.jpg',
        'storage/series/9.jpg',
        'storage/series/10.jpg',
    ];

    public function definition()
    {
        // $entry = array_shift($this->images);

        // return [
        //     'title' => $entry['title'],
        //     'type' => $this->faker->randomElement(['TV', 'Movie', 'OVA']),
        //     'cover_image' => $entry['image'],
        //     'episodes' => $this->faker->numberBetween(1, 100),
        //     'aired_start_date' => $this->faker->dateTimeBetween('-5 years', '-3 year'),
        //     'aired_end_date' => $this->faker->dateTimeBetween('-2 year', '+2 year'),
        //     'score' => $this->faker->randomFloat(2, 0, 10),
        // ];

        return [
            'title' => $this->faker->unique()->sentence(2),
            'type' => $this->faker->randomElement(['TV', 'Movie', 'OVA']),
            'cover_image' => $this->faker->randomElement($this->images),
            'episodes' => $this->faker->numberBetween(1, 100),
            'aired_start_date' => $this->faker->dateTimeBetween('-5 years', '-3 years'),
            'aired_end_date' => $this->faker->dateTimeBetween('-2 years', '+2 years'),
            'score' => $this->faker->randomFloat(2, 0, 10),
        ];
    }
}
