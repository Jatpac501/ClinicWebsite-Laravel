<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Doctor;
use App\Models\User;
use App\Models\Speciality;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    protected $model = Doctor::class;

    public function definition(): array
    {
        return [
            'user_id' => User::where('role', 'doctor')->inRandomOrder()->first()->id,
            'speciality_id' => Speciality::inRandomOrder()->first()->id,
            'experience' => fake()->numberBetween(5, 40)
        ];
    }
}
