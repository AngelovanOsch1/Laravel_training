<?php

namespace Database\Factories;

use App\Models\Series;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeriesFactory extends Factory
{
    protected $model = Series::class;

    public $images = [
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

    public function definition()
    {

        $entry = array_shift($this->images);

        return [
            'title' => $entry['title'],
            'type' => $this->faker->randomElement(['TV', 'Movie', 'OVA']),
            'cover_image' => $entry['image'],
            'episodes' => $this->faker->numberBetween(1, 100),
            'aired_start_date' => $this->faker->date(),
            'aired_end_date' => $this->faker->date(),
            'score' => $this->faker->randomFloat(2, 0, 10),
        ];
    }
}
