<?php

namespace App\Service;

use Mailjet\Client;
use Mailjet\Resources;

class Mail
{

    private $api_key = 'dbb1d5045303e3083c2f22388a9e3447';
    private $api_key_secret = '94ea7b7d397ad8b34f0a0a9be6a072cf';


    public function send($to_email, $to_name, $subject, $content)
    {
        $mj = new Client($this->api_key, $this->api_key_secret, true, ['version' => 'v3.1']);

        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "justfordev@protonmail.com",
                        'Name' => "Me",
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name,
                        ],
                    ],
                    'TemplateID' => 2996648,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' =>
                        [
                            'content' => $content,
                        ],
                ],
            ],
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success() && var_dump($response->getData());
    }

    public function getSelectedMail()
    {

    }
}


