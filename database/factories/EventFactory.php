<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start_time = $this->faker->dateTimeBetween('+1 week', '+1 month');
        $end_time = (clone $start_time)->modify('+'.rand(1, 8).' hours');

        return [
            'name' => $this->faker->sentence(3),
            'start_time' => $start_time,
            'end_time' => $end_time,
            'organization_id' => Organization::inRandomOrder()->first()->id,
        ];
    }
}
