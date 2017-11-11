<?php

namespace Pinkwhale\Jellyfish\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $table = 'jelly_content';

    public function json(){
        return json_decode($this->data);
    }
}
