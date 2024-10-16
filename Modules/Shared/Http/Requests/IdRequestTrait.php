<?php 
namespace Modules\Shared\Http\Requests;

trait IdRequestTrait {

    public function getRulesId($condition) {
        if(request()->routeIs($condition . 'update')) $id = 'required';
        else $id = 'sometimes';
        return [
            $id,
            'numeric',
        ];
    }
}