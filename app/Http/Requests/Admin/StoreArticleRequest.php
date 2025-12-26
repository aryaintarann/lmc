<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Assuming admin middleware handles auth
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
            'excerpt' => 'nullable|array',
            'excerpt.en' => 'nullable|max:255',
            'excerpt.id' => 'nullable|max:255',
            'content' => 'nullable|array',
            'content.en' => 'nullable|required_without:content.id',
            'content.id' => 'nullable|required_without:content.en',
            'image' => 'nullable|image|max:2048',
            'published_at' => 'nullable|date',
        ];
    }
}
