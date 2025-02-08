<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;

class DoctorController extends Controller
{
    public function index(Doctor $doctor) {
        $doctor->load('user', 'speciality');
        return view('doctor.index', compact('doctor'));
    }
}
