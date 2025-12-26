<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\StoreDoctorRequest;
use App\Http\Requests\Admin\UpdateDoctorRequest;
use App\Models\Doctor;
use App\Services\ImageService;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::latest()->paginate(10);

        return view('admin.doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('admin.doctors.create');
    }

    public function store(StoreDoctorRequest $request, ImageService $imageService)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $imageService->upload($request->file('image'), 'doctors');
        }

        Doctor::create($validated);

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor added successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Doctor $doctor)
    {
        return view('admin.doctors.edit', compact('doctor'));
    }

    public function update(UpdateDoctorRequest $request, Doctor $doctor, ImageService $imageService)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $imageService->upload(
                $request->file('image'),
                'doctors',
                $doctor->image
            );
        }

        $doctor->update($validated);

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor updated successfully.');
    }

    public function destroy(Doctor $doctor, ImageService $imageService)
    {
        // Delete image if it exists in storage
        if ($doctor->image) {
            $imageService->delete($doctor->image);
        }

        $doctor->delete();

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor deleted successfully.');
    }
}
