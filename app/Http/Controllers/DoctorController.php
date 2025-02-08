<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;

class DoctorController extends Controller
{
    public function index($id) {
        $doctor = Doctor::with('user', 'speciality')->findOrFail($id);
        return view('doctor.index', compact('doctor'));
    }
}
