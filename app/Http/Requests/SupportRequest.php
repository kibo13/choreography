<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupportRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'file'      => 'nullable|file|max:5120',
        ];
    }

    public function messages()
    {
        return [
            'file.max'  => 'Размер файла не должен превышать 5MБ',
        ];
    }
}
