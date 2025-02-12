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
        return view('homepage', compact('specialities'));
    }

    public function searchBySpeciality(Speciality $speciality) {
        $doctors = Doctor::whereBelongsTo($speciality)->with(['speciality', 'user'])->get();
        return view('doctor.index', compact('doctors', 'speciality'));
    }

    public function search(Request $request) {
        $query = $request->query('query');

        $doctors = Doctor::whereHas('user', function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->orWhereHas('speciality', function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->get();

        return view('doctor.index', compact('doctors', 'query'));
    }
}
