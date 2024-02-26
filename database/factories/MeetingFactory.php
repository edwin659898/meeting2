<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Meeting>
 */
class MeetingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->text(10),
            'location' => 'Head office',
            'frequency' => 'Weekly',
            'zoom_link' => 'https://us02web.zoom.us/j/83841372154?pwd=cmNNRXVDMTU5VmwxeWQ1TzI0emlHdz09',
            'meeting_id' => '83841372154',
            'passcode' => 'cmNNRXVDMTU5VmwxeWQ1TzI0emlHdz09',
            'start_time' => fake()->date(),
            'end_time' => fake()->date(),
        ];
    }
}
