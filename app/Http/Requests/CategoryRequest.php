<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        $categoryId = $this->route('category') ? $this->route('category')->id : null;

        return [
            'name' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')->ignore($categoryId),
            ],
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:2000',
            'meta_keywords' => 'nullable|string|max:1000',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:2000',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'schema' => 'nullable|string',
        ];
    }
}
