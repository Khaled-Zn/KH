<?php
namespace Modules\Shared\Http\Requests;
use Illuminate\Validation\Rule;
trait NameRequestTrait {

    public function getRulesName($table = null,$edit = null) {
        $rules =  [
            'bail',
            $edit ? 'sometimes':'required',
            'string',
            'max:100',
        ];
        if($table) 
            $rules [] = $this->get("id") != null ? Rule::unique($table)->ignore($this->id, 'id')  : "unique:{$table}";
        return $rules;
    }
}