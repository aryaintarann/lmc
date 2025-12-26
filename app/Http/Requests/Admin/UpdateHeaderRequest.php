<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHeaderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title.id' => 'nullable|string|max:255',
            'title.en' => 'nullable|string|max:255',
            'tagline.id' => 'nullable|string|max:255',
            'tagline.en' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'button_text.id' => 'nullable|string|max:255',
            'button_text.en' => 'nullable|string|max:255',
            'button_url' => 'nullable|string|max:255',
        ];
    }
}
