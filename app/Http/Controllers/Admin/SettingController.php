<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Header;
use App\Models\Contact;
use App\Models\About;
use App\Helpers\TranslationHelper;
use App\Services\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function header()
    {
        $header = Header::firstOrCreate([]);
        return view('admin.settings.header', compact('header'));
    }

    public function updateHeader(Request $request, TranslationService $translationService)
    {
        $data = $request->validate([
            'title.id' => 'nullable|string|max:255',
            'title.en' => 'nullable|string|max:255',
            'tagline.id' => 'nullable|string|max:255',
            'tagline.en' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Ensure at least one language for title and tagline
        if (empty($request->input('title.en')) && empty($request->input('title.id'))) {
            return back()->withErrors(['title' => 'Please provide title in at least one language.'])->withInput();
        }
        if (empty($request->input('tagline.en')) && empty($request->input('tagline.id'))) {
            return back()->withErrors(['tagline' => 'Please provide tagline in at least one language.'])->withInput();
        }

        // Auto-translate missing language fields
        $data = TranslationHelper::autoTranslateFields($data, ['title', 'tagline'], $translationService);

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
            'title' => ['id' => $data['title']['id'] ?? '', 'en' => $data['title']['en'] ?? ''],
            'tagline' => ['id' => $data['tagline']['id'] ?? '', 'en' => $data['tagline']['en'] ?? ''],
            'logo' => $data['logo'] ?? $header->logo,
        ]);

        return redirect()->route('admin.settings.header')->with('success', 'Header updated successfully.');
    }

    public function about()
    {
        $about = About::firstOrCreate([]);
        return view('admin.settings.about', compact('about'));
    }

    public function updateAbout(Request $request, TranslationService $translationService)
    {
        $data = $request->validate([
            'title.id' => 'nullable|string|max:255',
            'title.en' => 'nullable|string|max:255',
            'description.id' => 'nullable|string',
            'description.en' => 'nullable|string',
            'vision.id' => 'nullable|string',
            'vision.en' => 'nullable|string',
            'mission.id' => 'nullable|string',
            'mission.en' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        // Ensure at least one language for title and description
        if (empty($request->input('title.en')) && empty($request->input('title.id'))) {
            return back()->withErrors(['title' => 'Please provide title in at least one language.'])->withInput();
        }
        if (empty($request->input('description.en')) && empty($request->input('description.id'))) {
            return back()->withErrors(['description' => 'Please provide description in at least one language.'])->withInput();
        }

        // Auto-translate missing language fields
        $data = TranslationHelper::autoTranslateFields($data, ['title', 'description', 'vision', 'mission'], $translationService);

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
            'title' => ['id' => $data['title']['id'] ?? '', 'en' => $data['title']['en'] ?? ''],
            'description' => ['id' => $data['description']['id'] ?? '', 'en' => $data['description']['en'] ?? ''],
            'vision' => isset($data['vision']) ? ['id' => $data['vision']['id'] ?? '', 'en' => $data['vision']['en'] ?? ''] : null,
            'mission' => isset($data['mission']) ? ['id' => $data['mission']['id'] ?? '', 'en' => $data['mission']['en'] ?? ''] : null,
            'image' => $data['image'] ?? $about->image,
        ]);

        return redirect()->route('admin.settings.about')->with('success', 'About section updated successfully.');
    }

    public function contact()
    {
        $contact = Contact::firstOrCreate([]);
        return view('admin.settings.contact', compact('contact'));
    }

    public function updateContact(Request $request, TranslationService $translationService)
    {
        $data = $request->validate([
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address.id' => 'nullable|string',
            'address.en' => 'nullable|string',
            'whatsapp' => 'nullable|string|max:255',
            'maps_embed' => 'nullable|string',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
        ]);

        // Ensure at least one language for address
        if (empty($request->input('address.en')) && empty($request->input('address.id'))) {
            return back()->withErrors(['address' => 'Please provide address in at least one language.'])->withInput();
        }

        // Auto-translate missing language fields
        $data = TranslationHelper::autoTranslateFields($data, ['address'], $translationService);

        $contact = Contact::firstOrCreate([]);
        
        $contact->update([
            'phone' => $data['phone'],
            'email' => $data['email'],
            'address' => ['id' => $data['address']['id'] ?? '', 'en' => $data['address']['en'] ?? ''],
            'whatsapp' => $data['whatsapp'] ?? null,
            'maps_embed' => $data['maps_embed'] ?? null,
            'facebook' => $data['facebook'] ?? null,
            'instagram' => $data['instagram'] ?? null,
        ]);

        return redirect()->route('admin.settings.contact')->with('success', 'Contact section updated successfully.');
    }

}
