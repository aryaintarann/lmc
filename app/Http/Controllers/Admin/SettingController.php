<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Header;
use App\Models\Contact;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    // ====================
    // Header Management
    // ====================
    // Section: Header
    public function header()
    {
        $header = Header::firstOrCreate([]);
        return view('admin.settings.header', compact('header'));
    }

    public function updateHeader(Request $request)
    {
        $data = $request->validate([
            'title.id' => 'required|string|max:255',
            'title.en' => 'required|string|max:255',
            'tagline.id' => 'required|string|max:255',
            'tagline.en' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $header = Header::firstOrCreate([]);

        // Handle Logo Upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($header->logo) {
                Storage::disk('public')->delete($header->logo);
            }
            $data['logo'] = $request->file('logo')->store('headers', 'public');
        }

        // Update title and tagline
        $header->update([
            'title' => ['id' => $data['title']['id'], 'en' => $data['title']['en']],
            'tagline' => ['id' => $data['tagline']['id'], 'en' => $data['tagline']['en']],
            'logo' => $data['logo'] ?? $header->logo,
        ]);

        return redirect()->route('admin.settings.header')->with('success', 'Header updated successfully.');
    }

    // Section: About
    public function about()
    {
        $about = About::firstOrCreate([]);
        return view('admin.settings.about', compact('about'));
    }

    public function updateAbout(Request $request)
    {
        $data = $request->validate([
            'title.id' => 'required|string|max:255',
            'title.en' => 'required|string|max:255',
            'description.id' => 'required|string',
            'description.en' => 'required|string',
            'vision.id' => 'nullable|string',
            'vision.en' => 'nullable|string',
            'mission.id' => 'nullable|string',
            'mission.en' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $about = About::firstOrCreate([]);

        // Handle Image Upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($about->image) {
                Storage::disk('public')->delete($about->image);
            }
            $data['image'] = $request->file('image')->store('abouts', 'public');
        }

        // Update about data
        $about->update([
            'title' => ['id' => $data['title']['id'], 'en' => $data['title']['en']],
            'description' => ['id' => $data['description']['id'], 'en' => $data['description']['en']],
            'vision' => isset($data['vision']) ? ['id' => $data['vision']['id'] ?? '', 'en' => $data['vision']['en'] ?? ''] : null,
            'mission' => isset($data['mission']) ? ['id' => $data['mission']['id'] ?? '', 'en' => $data['mission']['en'] ?? ''] : null,
            'image' => $data['image'] ?? $about->image,
        ]);

        return redirect()->route('admin.settings.about')->with('success', 'About section updated successfully.');
    }

    // Section: Contact
    public function contact()
    {
        $contact = Contact::firstOrCreate([]);
        return view('admin.settings.contact', compact('contact'));
    }

    public function updateContact(Request $request)
    {
        $data = $request->validate([
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address.id' => 'required|string',
            'address.en' => 'required|string',
            'whatsapp' => 'nullable|string|max:255',
            'maps_embed' => 'nullable|string',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
        ]);

        $contact = Contact::firstOrCreate([]);
        
        $contact->update([
            'phone' => $data['phone'],
            'email' => $data['email'],
            'address' => ['id' => $data['address']['id'], 'en' => $data['address']['en']],
            'whatsapp' => $data['whatsapp'] ?? null,
            'maps_embed' => $data['maps_embed'] ?? null,
            'facebook' => $data['facebook'] ?? null,
            'instagram' => $data['instagram'] ?? null,
        ]);

        return redirect()->route('admin.settings.contact')->with('success', 'Contact section updated successfully.');
    }

}
