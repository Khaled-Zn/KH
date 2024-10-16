<?php

namespace Modules\CompleteInfo\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCompleteInfoStepTwoRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'study_type' => 'required|string',
            'residence_id' => 'required|integer',
            'talents_ids' => 'required',
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
