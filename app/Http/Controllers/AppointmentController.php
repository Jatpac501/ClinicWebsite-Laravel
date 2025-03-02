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
        
        if (Appointment::where(['doctor_id' => $doctor->id, 'date' => $validated['date'], 'time' => $validated['time']])->exists()) {
            return back();
        }
        
        $doctor->appointments()->create([
            'date' => $validated['date'],
            'time' => $validated['time'],
            'user_id' => Auth::id(),
        ]);
        
        return back();
    }

    public function getBookedTimes(Request $request, Doctor $doctor) {
        $date = $request->query('date');
        
        return response()->json($date ? $doctor->appointments()->where('date', $date)->pluck('time') : []);
    }

    private function updateStatus($appointmentId, $status) {
        $appointment = Appointment::findOrFail($appointmentId);
        $appointment->update(['status' => $status]);
        return back();
    }

    public function complete($userId, $appointmentId) {
        return $this->updateStatus($appointmentId, 'Завершено');
    }

    public function cancel($appointmentId) {
        return $this->updateStatus($appointmentId, 'Отменено');
    }

    public function show($doctor, $id) {
        $appointment = Appointment::with(['doctor', 'user'])->findOrFail($id);
        return view('appointment.show', compact('appointment'));
    }

    public function uploadFile(Request $request, $userId, $appointmentId) {
        $validated = $request->validate(['file' => 'required|mimes:pdf|max:2048']);
        
        if ($request->hasFile('file')) {
            $appointment = Appointment::findOrFail($appointmentId);
            $appointment->update(['file_path' => $request->file('file')->store('uploads/appointments', 'public')]);
        }
        
        return back();
    }

    public function panel() {
        $user = Auth::user();
        $appointments = $user ? $user->appointments()
                ->orderBy('date', 'desc')
                ->orderBy('time', 'desc')
                ->get()
            : collect();
    
        return view("appointment.index", compact('appointments'));
    }
}
