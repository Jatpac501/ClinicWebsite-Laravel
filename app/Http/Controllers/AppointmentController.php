<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function store(StoreAppointmentRequest $request, Doctor $doctor) {
        $validated = $request->validated();
        $isBooked = Appointment::where('doctor_id', $doctor->id)
                           ->where('date', $validated['date'])
                           ->where('time', $validated['time'])
                           ->exists();

        if ($isBooked) {
            return back();
        }
        Appointment::create([
            'date'=> $request->date,
            'time'=> $request->time,
            'doctor_id'=> $doctor->id,
            'user_id' => Auth::user()->id,
        ]);
        return back();
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

    public function complete($userId, $appointmentId) {
        $appointment = Appointment::findOrFail($appointmentId);
        $appointment->status = 'Завершено';
        $appointment->save();
        
        return back();
    }
    public function cancel($userId, $appointmentId) {
        $appointment = Appointment::findOrFail($appointmentId);
        $appointment->status = 'Отменено';
        $appointment->save();
    
        return back();
    }

    public function show($doctor, $id) {
        $appointment = Appointment::findOrFail($id)->load('doctor', 'user');
        return view('appointment.show', compact('appointment'));
    }

    public function uploadFile(Request $request, $userId, $appointmentId) {
        $request->validate([
            'file' => 'required|mimes:pdf|max:2048',
        ]);
    
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $path = $file->store('uploads/appointments', 'public');
            $appointment = Appointment::findOrFail( $appointmentId );
            $appointment->file_path = $path;
            $appointment->save();
            return back();
        }
    
        return back();
    } 
}
