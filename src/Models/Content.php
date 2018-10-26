<?php

namespace Pinkwhale\Jellyfish\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $table = 'jelly_content';

    protected $casts = [
        'data' => 'object',
    ];

    /**
     * OLD
     *
     * @param boolean $arr
     * @return void
     */
    public function data($arr = false)
    {
        $merge = array_merge((array)$this->data, [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id'         => $this->id,
            'type'       => $this->type,
        ]);
        if ($arr == false) {
            return (object) $merge;
        }
        return (array) $merge;
    }
    
    /**
     * Query stuff based on type.
     *
     * @param [type] $type
     * @return void
     */
    public static function Module($type)
    {
        return (new Content)->where('type', $type);
    }
}
