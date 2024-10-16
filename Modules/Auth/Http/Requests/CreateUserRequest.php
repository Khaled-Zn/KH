<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Shared\Http\Requests\Credentials\BaseCredentialsRequest;

class CreateUserRequest extends FormRequest
{
    use BaseCredentialsRequest;
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
            'number' => 'required|string|unique:users,number|min:9',
            'email' => $this->getRulesEmail('users'),
            'password' => $this->getRulesPassword(),
        ];
    }

}
