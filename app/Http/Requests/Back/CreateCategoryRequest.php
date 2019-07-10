<?php

namespace App\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'title'       => 'required|string',
            'description' => 'required|string',
            'image'       => 'required|image|mimes:jpg,png,jpeg|max:1000',
        ];

        return $rules;
    }
}
