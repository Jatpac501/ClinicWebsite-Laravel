<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
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
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $this->validateDoctor($request);

        Doctor::create($request->validated());

        return redirect()->route('admin.index')
            ->with('success', 'Врач успешно добавлен');
    }

    public function edit(Doctor $doctor)
    {
        return view('admin.edit', compact('doctor'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $this->validateDoctor($request);

        $doctor->update($request->validated());

        return redirect()->route('admin.index')
            ->with('success', 'Врач успешно обновлён');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();

        return redirect()->route('admin.index')
            ->with('success', 'Врач успешно удалён');
    }

    private function validateDoctor(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'experience' => 'required|integer|min:0',
            'about'      => 'nullable|string',
        ]);
    }
}
