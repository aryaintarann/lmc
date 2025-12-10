<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = \App\Models\Service::latest()->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|array',
            'title.en' => 'required|max:255',
            'title.id' => 'nullable|max:255',
            'description' => 'required|array',
            'description.en' => 'required',
            'description.id' => 'nullable',
            'icon' => 'nullable|max:255',
        ]);

        \App\Models\Service::create($validated);

        return redirect()->route('admin.services.index')->with('success', 'Service created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $service = \App\Models\Service::findOrFail($id);
        return view('admin.services.edit', compact('service'));
    }

    public function update(\Illuminate\Http\Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required|array',
            'title.en' => 'required|max:255',
            'title.id' => 'nullable|max:255',
            'description' => 'required|array',
            'description.en' => 'required',
            'description.id' => 'nullable',
            'icon' => 'nullable|max:255',
        ]);

        $service = \App\Models\Service::findOrFail($id);
        $service->update($validated);

        return redirect()->route('admin.services.index')->with('success', 'Service updated successfully.');
    }

    public function destroy(string $id)
    {
        $service = \App\Models\Service::findOrFail($id);
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Service deleted successfully.');
    }
}
