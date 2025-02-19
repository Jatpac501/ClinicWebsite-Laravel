<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Speciality;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function homepage()
    {
        $specialities = Speciality::all();
        return view('homepage', compact('specialities'));
    }

    public function searchBySpeciality(Speciality $speciality)
    {
        $doctors = $speciality->doctors()->with(['speciality', 'user'])->get();
        return view('doctor.index', compact('doctors', 'speciality'));
    }

    public function search(Request $request)
    {
        $query = strtolower(trim($request->query('query')));

        $doctors = Doctor::whereHas('user', function ($q) use ($query) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%{$query}%"]);
            })
            ->orWhereHas('speciality', function ($q) use ($query) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%{$query}%"]);
            })
            ->with(['user', 'speciality'])
            ->get();

        return view('doctor.index', compact('doctors', 'query'));
    }
}
