<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
            'description'   => ['required', 'max:255'],
            'subtitle'      => ['nullable', 'max:255'],
            'date'          => ['required'],
            'hours'         => ['required', 'numeric', 'max:999.99', 'min:0.5'],
            'time_start'    => ['required'],
            'time_end'      => ['required'],
            'image'         => ['nullable'],
            'active'        => ['nullable'],
        ];
    }
}
