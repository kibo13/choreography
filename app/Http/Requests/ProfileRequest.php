<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'password'      => 'nullable|min:8|confirmed',
        ];
    }

    public function attributes()
    {
        return [
            'password'      => 'пароль',
        ];
    }

    public function messages()
    {
        return [
            'min'           => 'Минимальная длина поля :min символов',
            'confirmed'     => 'Пароли не совпадают',
        ];
    }
}
