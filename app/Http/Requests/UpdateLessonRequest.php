<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLessonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'lesson_name' => ['required', 'max:50'],
            'price' => ['required', 'numeric', 'min:0'],
            'lesson_date' => ['required', 'date'],
            'start_time' => ['required'],
            'end_time' => ['required', 'after:start_time'],
            'max_people' => ['required', 'numeric', 'between:1,20'],
            'is_visible' => ['required', 'boolean']
        ];
    }
}
