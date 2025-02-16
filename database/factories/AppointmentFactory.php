<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Doctor;
use App\Models\Speciality;
use App\Models\User;

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
    $startTime  = new \DateTime('09:00');
    $endTime    = new \DateTime('20:00');
    $lunchStart = new \DateTime('13:00');
    $lunchEnd   = new \DateTime('14:00');

    $slots = [];
    while ($startTime < $endTime) {
        if ($startTime >= $lunchStart && $startTime < $lunchEnd) {
            $startTime->modify('+20 minutes');
            continue;
        }
        $slots[] = $startTime->format('H:i');
        $startTime->modify('+20 minutes');
    }

    return [
        'date'      => $this->faker->dateTimeBetween('today', '+2 days')->format('Y-m-d'),
        'time'      => $this->faker->randomElement($slots),
        'doctor_id' => Doctor::inRandomOrder()->value('id'),
        'user_id'   => User::inRandomOrder()->value('id'),
        'status'    => $this->faker->randomElement(['Запланировано', 'Завершено', 'Отменено']),
        'file_path' => null,
    ];
}

}
