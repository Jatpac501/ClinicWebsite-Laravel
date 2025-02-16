<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PanelController extends Controller
{
    public function index() {
        $doctor = Doctor::where('user_id', Auth::id())->first();
        $appointments = $doctor ? $doctor->appointments()
                ->whereDate('date', '>=', Carbon::today())
                ->orderBy('date', 'asc')
                ->orderBy('time', 'asc')
                ->get()
            : collect();
    
        return view("appointment.index", compact('appointments'));
    }
    
}
