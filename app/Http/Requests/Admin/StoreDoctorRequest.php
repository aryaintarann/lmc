<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'specialty.en' => 'required_without:specialty.id|nullable|max:255',
            'specialty.id' => 'required_without:specialty.en|nullable|max:255',
            'bio.en' => 'nullable',
            'bio.id' => 'nullable',
            'image' => 'nullable|image|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'specialty.en.required_without' => 'Please fill in at least one specialty (English or Indonesian).',
            'specialty.id.required_without' => 'Please fill in at least one specialty (English or Indonesian).',
        ];
    }
}
