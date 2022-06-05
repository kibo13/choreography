<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AwardRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->route()->named('admin.awards.store')) {
            $rules = [
                'num' => 'unique:awards',
            ];
        };

        if ($this->route()->named('admin.awards.update')) {
            $rules = [
                'num' => Rule::unique('awards')->ignore($this->route()->parameter('award')->id)
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
