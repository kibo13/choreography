<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoomRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->route()->named('admin.rooms.store')) {
            $rules = [
                'num' => 'unique:rooms',
            ];
        };

        if ($this->route()->named('admin.rooms.update')) {
            $rules = [
                'num' => Rule::unique('rooms')->ignore($this->route()->parameter('room')->id)
            ];
        };

        return $rules;
    }

    public function messages()
    {
        return [
            'unique' => 'Помещение с таким номером уже существует'
        ];
    }
}
