<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'description' => ['required', 'max:255'],
            'type' => ['required', 'max:30'],
            'date' => ['required'],
            'active' => ['nullable'],
            'flg_test_exam' => ['nullable'],
            'flg_asist' => ['nullable'],
            'flg_survey_course' => ['nullable'],
            'flg_survey_evaluation' => ['nullable'],
            'exam_id' => ['required'],
            'test_exam_id' => ['nullable'],
            'elearning_id' => ['nullable'],
            'user_id' => ['required'],
            'responsable_id' => ['required'],
            'room_id' => ['required'],
            'owner_companies_id' => ['nullable']
        ];
    }
}
