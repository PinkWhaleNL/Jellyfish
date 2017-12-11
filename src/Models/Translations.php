<?php

namespace Pinkwhale\Jellyfish\Models;

use Illuminate\Database\Eloquent\Model;

class Translations extends Model
{
    protected $table = 'jelly_translations';

    /**
     * @param      $lang
     * @param bool $lorem
     *
     * @return null|string
     */
    public function language($lang,$lorem=false){

        if(isset(json_decode($this->data,true)[$lang])){
            return json_decode($this->data,true)[$lang];
        } elseif($lorem != null && $lorem != false){
            return $this->lorem($lorem);
        }
        return null;
    }

    /**
     * @param      $string
     * @param null $lang
     *
     * @return null
     */
    static function get($string,$lang=null,$lorem=null){

        $lang = ($lang == null ? app()->getLocale() : $lang);
        $expl = explode('.',$string);

        // Get page info.
        $page = (new Pages)->where('key',$expl[0])->first();
        if($page == null) return ($lorem == null ? ($lang . '.' . $string) : (new Translations)->lorem($lorem));

        // Get translation info.
        $trans = (new Translations)->where('page_id',$page->id)->where('key',$expl[1])->first();
        if($trans == null) return ($lorem == null ? ($lang . '.' . $string) : (new Translations)->lorem($lorem));

        // Return right String.
        return $trans->language($lang,$lorem);
    }

    /**
     * @param $string
     *
     * @return string
     */
    public function lorem($string){
        $lorem_string = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut luctus lorem elementum elit porta, euismod semper tortor volutpat. Donec iaculis nisi mollis gravida eleifend. Nunc ac tincidunt lorem. Nulla facilisi. Curabitur ac ornare nisi, ac sollicitudin ante. In non semper metus. Etiam molestie turpis ac quam efficitur finibus. Integer aliquet est vel lectus condimentum mollis. Nam faucibus porta ipsum sed consequat. Praesent tincidunt ultricies scelerisque. Etiam a augue eget nisl condimentum luctus. Etiam mollis tristique dolor. Nunc ornare, dolor et imperdiet maximus, urna sapien ullamcorper justo, vitae rutrum mauris magna eget neque. Phasellus vitae urna ut mi varius suscipit. Maecenas tincidunt in purus vel egestas. Quisque a finibus lectus, quis sodales orci. Pellentesque nulla leo, suscipit nec felis ut, bibendum auctor diam. Nulla ornare varius nisl sed porttitor. Ut commodo sapien non lacinia consectetur. Cras faucibus sollicitudin feugiat. Praesent tempus, ligula sit amet rutrum lobortis, nisl purus fermentum lectus, at tempor nibh nisl eget lectus. Nam in nibh in elit fringilla pretium. Nullam et sapien elementum, volutpat tortor quis, facilisis eros. Phasellus rutrum lectus sit amet molestie condimentum. Praesent a scelerisque massa. Nunc venenatis lacus arcu, nec pellentesque augue porttitor eu. Vivamus eu lacus tellus. Sed feugiat imperdiet nunc nec mattis.';
        $expl = explode(':',$string);
        return (isset($expl[1]) ? str_limit($lorem_string,(int)$expl[1],(isset($expl[2])?$expl[2]:'')) : $lorem_string);
    }

}
