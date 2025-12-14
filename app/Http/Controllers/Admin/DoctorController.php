<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

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
            'image' => 'nullable|image|max:2048', // Validate as image file, max 2MB
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('doctors', 'public');
            $validated['image'] = $path;
        }

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
            'image' => 'nullable|image|max:2048',
        ]);

        $doctor = \App\Models\Doctor::findOrFail($id);

        if ($request->hasFile('image')) {
            // Delete old image if it exists and is a file (not an external URL)
            if ($doctor->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($doctor->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($doctor->image);
            }

            $path = $request->file('image')->store('doctors', 'public');
            $validated['image'] = $path;
        }

        $doctor->update($validated);

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor updated successfully.');
    }

    public function destroy(string $id)
    {
        $doctor = \App\Models\Doctor::findOrFail($id);

        // Delete image if it exists in storage
        if ($doctor->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($doctor->image)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($doctor->image);
        }

        $doctor->delete();

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor deleted successfully.');
    }
}
