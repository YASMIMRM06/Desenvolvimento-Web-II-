<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RateSongRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ];
    }
}
