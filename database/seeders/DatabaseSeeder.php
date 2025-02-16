<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Speciality;
use App\Models\Doctor;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Speciality::factory(3)->create();
        User::factory(45)->create();
        User::factory()->create([
            'name' => 'Администратор',
            'email' => 'admin@example.com',
            'password'=> bcrypt('admin'),
            'phone' => '+7 (999) 123-45-67',
            'role' => 'admin'
        ]);

        $users = User::where('role', 'user')->inRandomOrder()->limit(15)->get();
        foreach ($users as $user) {
            $user->update(['role' => 'doctor']);
            Doctor::factory()->create(['user_id' => $user->id]);
        }
        Appointment::factory(50)->create();
    }
}
