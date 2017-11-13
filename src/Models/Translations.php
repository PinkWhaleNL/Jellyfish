<?php

namespace Pinkwhale\Jellyfish\Models;

use Illuminate\Database\Eloquent\Model;

class Translations extends Model
{
    protected $table = 'jelly_translations';

    /**
     * @param $lang
     *
     * @return null
     */
    public function language($lang){
        return json_decode($this->data,true)[$lang] ?? null;
    }


    /**
     * @param      $string
     * @param null $lang
     *
     * @return null
     */
    static function get($string,$lang=null){

        $lang = ($lang == null ? app()->getLocale() : $lang);
        $expl = explode('.',$string);

        // Get page info.
        $page = (new Pages)->where('key',$expl[0])->first();
        if($page == null) return $lang . '.' . $string;

        // Get translation info.
        $trans = (new Translations)->where('page_id',$page->id)->where('key',$expl[1])->first();
        if($trans == null) return $lang . '.' . $string;

        // Return right String.
        return $trans->language($lang);
    }

}
