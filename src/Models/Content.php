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
