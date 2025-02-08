<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function store(StoreAppointmentRequest $request, Doctor $doctor) {
        $validated = $request->validated();
        $isBooked = Appointment::where('doctor_id', $doctor->id)
                           ->where('date', $validated['date'])
                           ->where('time', $validated['time'])
                           ->exists();

        if ($isBooked) {
            return back()->withErrors(['time' => 'Это время уже занято.']);
        }
        Appointment::create([
            'date'=> $request->date,
            'time'=> $request->time,
            'doctor_id'=> $doctor->id,
            'user_id' => 46,
        ]);
        return back()->with('success', 'Вы успешно записались!');;
    }

    public function getBookedTimes(Request $request, Doctor $doctor) {
        $date = $request->query("date");
        if (!$date) return response()->json([]);

        $appointments = $doctor->appointments()
                            ->where('date', $date)
                            ->pluck('time')
                            ->toArray();
        return response()->json($appointments);
    }
}
