<?php

namespace Modules\Admins\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Shared\Http\Requests\Credentials\BaseCredentialsRequest;
use Modules\Shared\Http\Requests\IdRequestTrait;
use Modules\Shared\Http\Requests\NameRequestTrait;

class AdminRequest extends FormRequest
{
    use BaseCredentialsRequest,
    IdRequestTrait,
    NameRequestTrait;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $table = 'admins';
        return [
            'id' => $this->getRulesId($table . '.'),
            'full_name' => $this->getRulesName(),
            'email' => $this->getRulesEmail($table,true),
            'password' => $this->getRulesPassword(true),
            'role_id' => ['bail','sometimes','required','integer']
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
