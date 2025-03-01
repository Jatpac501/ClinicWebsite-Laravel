<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required',
            'speciality_id' => 'required|exists:specialities,id',
            'experience' => 'required|integer|min:0|max:100',
            'about' => 'nullable|string|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'Выберите пользователя.',
            'user_id.exists' => 'Выбранный пользователь не найден.',
            'user_id.unique' => 'Этот пользователь уже является врачом.',
            'speciality_id.required' => 'Выберите специальность.',
            'speciality_id.exists' => 'Выбранная специальность не найдена.',
            'experience.required' => 'Опыт обязателен.',
            'experience.integer' => 'Опыт должен быть числом.',
            'experience.min' => 'Опыт не может быть меньше 0 лет.',
            'experience.max' => 'Опыт не может быть больше 100 лет.',
            'about.max' => 'Описание не должно превышать 1000 символов.',
        ];
    }
}
