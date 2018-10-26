<?php

namespace Pinkwhale\Jellyfish\Models;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class Sms
{
    public function send($secret, $number, $message)
    {
        try {
            $output = (new Client)->post('https://smsgateway.pinkwhale.io/send/'.$secret, [
                        'form_params' => [
                            'phone' => $number,
                            'message' => $message,
                        ], 'verify' => false,
                    ]);

            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
}
