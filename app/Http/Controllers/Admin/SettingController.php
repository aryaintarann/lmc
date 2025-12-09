<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = \App\Models\Setting::orderBy('key')->paginate(20);
        return view('admin.settings.index', compact('settings'));
    }

    public function create()
    {
        // Settings are fixed keys generally, so create might not be needed, but we can allow it.
        return view('admin.settings.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|unique:settings|max:255',
            'value' => 'nullable',
            'type' => 'required|in:text,image,textarea',
        ]);

        \App\Models\Setting::create($validated);

        return redirect()->route('admin.settings.index')->with('success', 'Setting created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $setting = \App\Models\Setting::findOrFail($id);
        return view('admin.settings.edit', compact('setting'));
    }

    public function update(\Illuminate\Http\Request $request, string $id)
    {
        $validated = $request->validate([
            'value' => 'nullable',
        ]);

        $setting = \App\Models\Setting::findOrFail($id);
        $setting->update($validated);

        return redirect()->route('admin.settings.index')->with('success', 'Setting updated successfully.');
    }

    public function destroy(string $id)
    {
        $setting = \App\Models\Setting::findOrFail($id);
        $setting->delete();

        return redirect()->route('admin.settings.index')->with('success', 'Setting deleted successfully.');
    }
    // Section: Header
    public function header()
    {
        $keys = [
            'header_title',
            'header_subtitle',
            'header_badge',
            'header_btn_text',
            'header_btn_link',
            'header_image'
        ];
        $settings = \App\Models\Setting::whereIn('key', $keys)->pluck('value', 'key');
        return view('admin.settings.header', compact('settings'));
    }

    public function updateHeader(Request $request)
    {
        $data = $request->validate([
            'header_title' => 'required|string|max:255',
            'header_subtitle' => 'required|string|max:255',
            'header_badge' => 'nullable|string|max:255',
            'header_btn_text' => 'nullable|string|max:50',
            'header_btn_link' => 'nullable|string|max:255',
            'header_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle Image Upload
        if ($request->hasFile('header_image')) {
            $path = $request->file('header_image')->store('settings', 'public');
            \App\Models\Setting::updateOrCreate(['key' => 'header_image'], ['value' => $path]);
        }

        // Update Text Fields
        $textFields = ['header_title', 'header_subtitle', 'header_badge', 'header_btn_text', 'header_btn_link'];
        foreach ($textFields as $key) {
            if ($request->has($key)) {
                \App\Models\Setting::updateOrCreate(['key' => $key], ['value' => $request->input($key)]);
            }
        }

        return redirect()->route('admin.settings.header')->with('success', 'Header updated successfully.');
    }

    // Section: About
    public function about()
    {
        $settings = \App\Models\Setting::whereIn('key', ['about_title', 'about_description'])->pluck('value', 'key');
        return view('admin.settings.about', compact('settings'));
    }

    public function updateAbout(Request $request)
    {
        $data = $request->validate([
            'about_title' => 'required|string|max:255',
            'about_description' => 'required|string',
        ]);

        foreach ($data as $key => $value) {
            \App\Models\Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return redirect()->route('admin.settings.about')->with('success', 'About section updated successfully.');
    }

    // Section: Contact
    public function contact()
    {
        $settings = \App\Models\Setting::whereIn('key', ['contact_address', 'contact_email', 'contact_phone'])->pluck('value', 'key');
        return view('admin.settings.contact', compact('settings'));
    }

    public function updateContact(Request $request)
    {
        $data = $request->validate([
            'contact_address' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'required|string|max:50',
        ]);

        foreach ($data as $key => $value) {
            \App\Models\Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return redirect()->route('admin.settings.contact')->with('success', 'Contact info updated successfully.');
    }

}
