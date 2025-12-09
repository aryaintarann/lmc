<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = \App\Models\Doctor::latest()->paginate(10);
        return view('admin.doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('admin.doctors.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'specialty' => 'required|max:255',
            'bio' => 'nullable',
            'image' => 'nullable|url',
        ]);

        \App\Models\Doctor::create($validated);

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor added successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $doctor = \App\Models\Doctor::findOrFail($id);
        return view('admin.doctors.edit', compact('doctor'));
    }

    public function update(\Illuminate\Http\Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'specialty' => 'required|max:255',
            'bio' => 'nullable',
            'image' => 'nullable|url',
        ]);

        $doctor = \App\Models\Doctor::findOrFail($id);
        $doctor->update($validated);

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor updated successfully.');
    }

    public function destroy(string $id)
    {
        $doctor = \App\Models\Doctor::findOrFail($id);
        $doctor->delete();

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor deleted successfully.');
    }
}
