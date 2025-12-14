<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\TranslationHelper;
use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Services\TranslationService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::latest()->paginate(10);

        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request, TranslationService $translationService)
    {
        $validated = $request->validate([
            'title' => 'required|array',
            'title.en' => 'nullable|max:255',
            'title.id' => 'nullable|max:255',
            'description' => 'nullable|array',
            'description.en' => 'nullable',
            'description.id' => 'nullable',
            'icon' => 'nullable|max:255',
        ]);

        // Ensure at least one language is provided for title
        if (empty($request->input('title.en')) && empty($request->input('title.id'))) {
            return back()->withErrors(['title' => 'Please provide title in at least one language.'])->withInput();
        }

        // Auto-translate missing language fields
        $validated = TranslationHelper::autoTranslateFields($validated, ['title', 'description'], $translationService);

        Service::create($validated);

        return redirect()->route('admin.services.index')->with('success', 'Service created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $service = Service::findOrFail($id);

        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, string $id, TranslationService $translationService)
    {
        $validated = $request->validate([
            'title' => 'required|array',
            'title.en' => 'nullable|max:255',
            'title.id' => 'nullable|max:255',
            'description' => 'nullable|array',
            'description.en' => 'nullable',
            'description.id' => 'nullable',
            'icon' => 'nullable|max:255',
        ]);

        // Ensure at least one language is provided for title
        if (empty($request->input('title.en')) && empty($request->input('title.id'))) {
            return back()->withErrors(['title' => 'Please provide title in at least one language.'])->withInput();
        }

        // Auto-translate missing language fields
        $validated = TranslationHelper::autoTranslateFields($validated, ['title', 'description'], $translationService);

        $service = Service::findOrFail($id);
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
