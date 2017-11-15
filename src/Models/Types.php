<?php

namespace Pinkwhale\Jellyfish\Models;

use Illuminate\Database\Eloquent\Model;
use Pinkwhale\Jellyfish\Models\Content;

class Types extends Model
{
    protected $table = 'jelly_types';

    public function isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    public function json(){
        return json_decode($this->data);
    }

    public function GetValidationRules($type){

        $rules = [];
        $typeData = $this->where('type',$type)->firstOrFail();
        foreach($typeData->json()->fields ?? [] as $field){
            if(isset($field->validation)){
                $rules[$field->name] = $field->validation;
            }
        }
        return $rules;
    }

    public function rows(){
        return (new Content)->where('type',$this->type)->count();
    }
}
