<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Speciality;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SpecialityFactory extends Factory
{
    protected $model = Speciality::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $names = [
            'Терапевт',
            'Психиатр',
            'Дерматолог',
            'Лор',
            'Психотерапевт',
            'Терапевт',
            'Окулист',
            'Травматолог',
            'Психолог',
            'Хирург',
            'Кардиолог'
        ];
        if (empty($names)) {
            throw new \Exception("Список пуст!");
        }
        return [
            'name' => array_shift($names)
        ];
    }
}
