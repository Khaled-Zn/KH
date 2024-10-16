<?php

namespace Modules\CompleteInfo\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCompleteInfoStepOneRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'full_name' => 'required|regex:/^[a-zA-Z ]*$/',
            'username' => 'required|string|between:4,100',
            'age' => 'required|date',
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
