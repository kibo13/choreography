<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->route()->named('admin.users.store')) {
            $rules = [
                'username'      => 'required|string|min:3|max:20|unique:users',
                'email'         => 'email|unique:users',
                'password'      => 'required|min:8|confirmed',
                'role_id'       => 'required',
                'first_name'    => 'required|string',
                'last_name'     => 'required|string',
            ];
        };

        if ($this->route()->named('admin.users.update')) {
            $rules = [
                'username'      => [
                    'required',
                    'string',
                    'min:3',
                    'max:20',
                    Rule::unique('users')->ignore($this->route()->parameter('user')->id)
                ],
                'password'      => 'nullable|min:8|confirmed',
                'role_id'       => 'required',
                'first_name'    => 'required|string',
                'last_name'     => 'required|string',
            ];
        };

        return $rules;
    }

    public function attributes()
    {
        return [
            'username'          => 'логин',
            'password'          => 'пароль',
            'role_id'           => 'роль',
            'first_name'        => 'Имя',
            'last_name'         => 'Фамилия',
            'email'             => 'E-mail',
        ];
    }

    public function messages()
    {
        return [
            'required'          => 'Данное поле необходимо заполнить',
            'max'               => 'Максимальная длина поля :max символов',
            'min'               => 'Минимальная длина поля :min символов',
            'confirmed'         => 'Пароли не совпадают',
            'unique'            => 'Данный :attribute уже существует'
        ];
    }
}
