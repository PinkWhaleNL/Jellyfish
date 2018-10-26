<?php

namespace Pinkwhale\Jellyfish\Models;

use Illuminate\Database\Eloquent\Model;
use Pinkwhale\Jellyfish\Models\Forms;
use Pinkwhale\Jellyfish\Models\Sms;
use JellyPreferences;

class Forms extends Model
{
    protected $table = 'jelly_form_data';

    /**
     * Call data as json.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'json',
    ];

    /**
     * Function wo put all form data into one single json column.
     * Call: {{ JellyFroms::put('mytype',(object)['bami is lekker'=>'test123']) }}
     *
     * @param [type] $type
     * @param [type] $data
     * @return void
     */
    public static function put($type, $data)
    {
        // Check if string given, return 501 error.
        if (is_string($data)) {
            abort(501, 'Could not save your form, please use Array\'s or Object\'s! Like JellyForms::set(\'TYPE\',[\'key\'=>\'value\'])');
        }
        
        $form = (new Forms);
        $form->type = $type;
        $form->data = (array)$data;
        $form->save();

        // Check for notification per SMS settings.
        if (JellyPreferences::key('forms_send_sms') == 'true') {
            $mobile_numbers = JellyPreferences::key('forms_sms_numbers');
            // Clean string from whitespaces and make array.
            $mobile_numbers = explode(',', str_replace(' ', '', $mobile_numbers));
            // Go trough each number.
            foreach ($mobile_numbers as $number) {
                (new Sms)->send(JellyPreferences::key('forms_sms_key'), $number, 'Er is een formulier ingevuld op je website! Om het bericht te bekijken klik hier: '. route('jelly-forms'));
            }
        }
        return $form->id;
    }
}
