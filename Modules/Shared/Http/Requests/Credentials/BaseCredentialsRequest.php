<?php 
namespace Modules\Shared\Http\Requests\Credentials;
use Illuminate\Validation\Rule;
trait BaseCredentialsRequest {

    public function getRulesPassword($edit = null) {
        
        return [
            'bail',
            $edit ? 'sometimes':'required',
            'string',
            'min:8'
        ];
    }

    public function getRulesEmail($guard = null,$edit = null) {
        
        $rules =  [
            'bail',
            $edit ? 'sometimes':'required',
            'email',
        ];
        if($guard) $rules[] = $this->get("id") != null ? Rule::unique($guard)->ignore($this->id, 'id')  : "unique:{$guard}";
        return $rules;
    }

}