<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
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
            'title' => 'required|array',
            'title.en' => 'nullable|required_without:title.id|max:255',
            'title.id' => 'nullable|required_without:title.en|max:255',
            'description' => 'nullable|array',
            'description.en' => 'nullable',
            'description.id' => 'nullable',
            'icon' => 'nullable|max:255',
        ];
    }
}
