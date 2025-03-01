<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoctorRequest;
use App\Models\Doctor;
use App\Models\Speciality;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $doctors = Doctor::orderBy('id')->get();
        return view('admin.index', compact('doctors'));
    }

    public function create()
    {
        $users = User::whereNotIn('role', ['doctor', 'admin'])->get();
        $specialities = Speciality::all();
        return view('admin.create', compact('users', 'specialities'));
    }

    
    public function store(DoctorRequest $request)
    {
        Doctor::create($request->validated());

        return redirect()->route('admin.index')->with('success', 'Врач успешно добавлен!');
    }

    public function edit(Request $request)
    {
        $doctor = Doctor::findOrFail($request->id)->load('user', 'speciality');
        $specialities = Speciality::all();
        return view('admin.edit', compact('doctor', 'specialities'));
    }

    public function update(DoctorRequest $request, Doctor $doctor)
    {
        $doctor->update($request->validated());

        return redirect()->route('admin.index')
            ->with('success', 'Врач успешно обновлён');
    }

    public function destroy(Request $request)
    {
        Doctor::findOrFail($request->doctor_id)->delete();

        return redirect()->route('admin.index')
            ->with('success', 'Врач успешно удалён');
    }
}
