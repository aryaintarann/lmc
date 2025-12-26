<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\TranslationHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateAboutRequest;
use App\Http\Requests\Admin\UpdateContactRequest;
use App\Http\Requests\Admin\UpdateHeaderRequest;
use App\Models\About;
use App\Models\Contact;
use App\Models\Header;
use App\Services\ImageService;
use App\Services\TranslationService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function header()
    {
        $header = Header::firstOrCreate([], [
            'title' => ['en' => 'Default Title', 'id' => 'Judul Default'],
            'tagline' => ['en' => 'Default Tagline', 'id' => 'Slogan Default'],
            'button_text' => ['en' => 'Start', 'id' => 'Mulai'],
        ]);

        return view('admin.settings.header', compact('header'));
    }

    public function updateHeader(UpdateHeaderRequest $request, TranslationService $translationService, ImageService $imageService)
    {
        $data = $request->validated();

        // Ensure at least one language for title and tagline
        if (empty($request->input('title.en')) && empty($request->input('title.id'))) {
            return back()->withErrors(['title' => 'Please provide title in at least one language.'])->withInput();
        }
        if (empty($request->input('tagline.en')) && empty($request->input('tagline.id'))) {
            return back()->withErrors(['tagline' => 'Please provide tagline in at least one language.'])->withInput();
        }
        if (empty($request->input('button_text.en')) && empty($request->input('button_text.id'))) {
            return back()->withErrors(['button_text' => 'Please provide button text in at least one language.'])->withInput();
        }

        // Auto-translate missing language fields
        $data = TranslationHelper::autoTranslateFields($data, ['title', 'tagline', 'button_text'], $translationService);

        $header = Header::firstOrCreate([], [
            'title' => ['en' => 'Default Title', 'id' => 'Judul Default'],
            'tagline' => ['en' => 'Default Tagline', 'id' => 'Slogan Default'],
            'button_text' => ['en' => 'Start', 'id' => 'Mulai'],
        ]);

        // Handle Logo Upload
        if ($request->hasFile('logo')) {
            $data['logo'] = $imageService->upload($request->file('logo'), 'settings', $header->logo);
        }

        $header->fill($data);
        $header->save();

        return redirect()->route('admin.settings.header')->with('success', 'Header updated successfully.');
    }

    public function about()
    {
        $about = About::firstOrCreate([], [
            'title' => ['en' => 'About Us', 'id' => 'Tentang Kami'],
            'description' => ['en' => 'Description here.', 'id' => 'Deskripsi di sini.'],
        ]);

        return view('admin.settings.about', compact('about'));
    }

    public function updateAbout(UpdateAboutRequest $request, TranslationService $translationService, ImageService $imageService)
    {
        $data = $request->validated();

        // Ensure at least one language for title and description
        if (empty($request->input('title.en')) && empty($request->input('title.id'))) {
            return back()->withErrors(['title' => 'Please provide title in at least one language.'])->withInput();
        }
        if (empty($request->input('description.en')) && empty($request->input('description.id'))) {
            return back()->withErrors(['description' => 'Please provide description in at least one language.'])->withInput();
        }

        // Auto-translate missing language fields
        $data = TranslationHelper::autoTranslateFields($data, ['title', 'description', 'vision', 'mission'], $translationService);

        $about = About::firstOrCreate([], [
            'title' => ['en' => 'About Us', 'id' => 'Tentang Kami'],
            'description' => ['en' => 'Description here.', 'id' => 'Deskripsi di sini.'],
        ]);

        // Handle Image Upload
        if ($request->hasFile('image')) {
            $data['image'] = $imageService->upload($request->file('image'), 'abouts', $about->image);
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
        $contact = Contact::firstOrCreate([], [
            'address' => ['en' => 'Address here', 'id' => 'Alamat di sini'],
            'phone' => '-',
            'email' => 'admin@example.com',
        ]);

        return view('admin.settings.contact', compact('contact'));
    }

    public function updateContact(UpdateContactRequest $request, TranslationService $translationService)
    {
        $data = $request->validated();

        // Ensure at least one language for address
        if (empty($request->input('address.en')) && empty($request->input('address.id'))) {
            return back()->withErrors(['address' => 'Please provide address in at least one language.'])->withInput();
        }

        // Auto-translate missing language fields
        $data = TranslationHelper::autoTranslateFields($data, ['address'], $translationService);

        $contact = Contact::firstOrCreate([], [
            'address' => ['en' => 'Address here', 'id' => 'Alamat di sini'],
            'phone' => '-',
            'email' => 'admin@example.com',
        ]);

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
