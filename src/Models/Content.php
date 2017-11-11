<?php

namespace Pinkwhale\Jellyfish\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model {

    protected $table = 'jelly_content';

    protected $casts = [
        //'data' => 'json'
    ];

    public function json() {
        return json_decode($this->data);
    }

    public function data($arr = false) {

        $merge = array_merge(json_decode($this->data, true), [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id'         => $this->id,
            'type'       => $this->type,
        ]);
        if ( $arr == false ) return (object) $merge;
        return (array) $merge;
    }


    /*
     *
     *
     *
     *
     *
     *
     */

    static function Module($type) {
        return (new Content)->where('type', $type);
    }

}
