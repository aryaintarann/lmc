<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address.id' => 'nullable|string',
            'address.en' => 'nullable|string',
            'whatsapp' => 'nullable|string|max:255',
            'maps_embed' => 'nullable|string',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
        ];
    }
}
