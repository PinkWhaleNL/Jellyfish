<?php

namespace Pinkwhale\Jellyfish\Models;

use Illuminate\Database\Eloquent\Model;

class Translations extends Model
{
    protected $table = 'jelly_translations';

    public function language($lang){
        return json_decode($this->data,true)[$lang] ?? null;
    }

}
