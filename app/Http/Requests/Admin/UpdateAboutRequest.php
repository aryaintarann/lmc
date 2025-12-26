<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAboutRequest extends FormRequest
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
            'description.id' => 'nullable|string',
            'description.en' => 'nullable|string',
            'vision.id' => 'nullable|string',
            'vision.en' => 'nullable|string',
            'mission.id' => 'nullable|string',
            'mission.en' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ];
    }
}
