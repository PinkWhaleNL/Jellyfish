<?php

namespace Pinkwhale\Jellyfish\Models;

use Illuminate\Database\Eloquent\Model;

class Preferences extends Model
{
    protected $table = 'jelly_preferences';

    /**
     * Call data as json.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'json',
    ];

    /**
     * Obtain value from key.
     *
     * @param [type] $key
     * @return void
     */
    public static function key($key)
    {
        return (new Preferences)->where('key', strtoupper($key))->first()->data ?? null;
    }
}
