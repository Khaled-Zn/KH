<?php

namespace Modules\WorkSpace\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Shared\Http\Requests\IdRequestTrait;
use Modules\Shared\Http\Requests\NameRequestTrait;
class WorkSpaceRequest extends FormRequest
{
    use IdRequestTrait,NameRequestTrait;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $table = 'work_spaces';
        $rule = ['sometimes','string'];
        return [
            'id' => $this->getRulesId($table . '.'),
            'name' => $this->getRulesName($table,true),
            'description' => $rule,
            'phone_number' => ['sometimes','max:10'],
            'address' => $rule,
            'working_days' => $rule,
            'image_ids' => ['sometimes','array'],
            'image_ids.*' => 'integer'
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
