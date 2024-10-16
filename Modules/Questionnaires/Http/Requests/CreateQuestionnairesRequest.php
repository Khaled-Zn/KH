<?php

namespace Modules\Questionnaires\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateQuestionnairesRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string',
            'questions' => 'required|array',
            'questions.*.question' => 'required|string',
            'questions.*.answers' => 'required|array',
            'questions.*.answers.*.answer' => 'required|string'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
