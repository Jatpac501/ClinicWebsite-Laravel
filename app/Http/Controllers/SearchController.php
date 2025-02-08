<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Speciality;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function homepage() {
        $specialities = Speciality::all();
        return view('welcome', compact('specialities'));
    }

    public function searchBySpeciality(Speciality $speciality) {
        $doctors = Doctor::where('speciality_id', $speciality->id)->with(['speciality', 'user'])->get();
        return view('search', compact('doctors', 'speciality'));
    }
}
