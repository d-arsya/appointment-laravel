<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = fake()->dateTime(now()->addCenturyWithNoOverflow(), 'Asia/Jakarta');

        return [
            'doctor_id' => fake()->numberBetween(1, 10),
            'patient_id' => fake()->numberBetween(11, 20),
            'book' => $date,
            'deleted_at' => $date < now() ? Carbon::parse($date)->addMonths(3) : null,
        ];
    }
}
