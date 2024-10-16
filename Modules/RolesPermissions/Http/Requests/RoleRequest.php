<?php

namespace Modules\RolesPermissions\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Shared\Http\Requests\IdRequestTrait;
use Modules\Shared\Http\Requests\NameRequestTrait;

class RoleRequest extends FormRequest
{
    use NameRequestTrait,IdRequestTrait;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $table = 'roles';
        return [
            'id' => $this->getRulesId('role.'),
            'name' => $this->getRulesName($table),
            'permissions' => 'bail|required|array',
            'permissions.*' => 'integer'
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
