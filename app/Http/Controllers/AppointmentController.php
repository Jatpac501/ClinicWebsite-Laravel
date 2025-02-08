<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function store() {

    }

    public function getBookedTimes(Request $request, Doctor $doctor) {
        return response("OK");
    }
}
