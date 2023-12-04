<?php

namespace App\Notifications\Channels;


use Exception;
use GuzzleHttp\Client;
use Illuminate\Notifications\Notification;

class MSG91WatsappChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $key = getenv('MSG91_AUTHKEY');
        //dd($key, 'aa', config('mail.mailer.msg91.client_key'));

        $client = new Client();
        $message = $notification->toMSG91Watsapp($notifiable)['data'];
        $template = $notification->toMSG91Watsapp($notifiable)['template'];
        //dd('abc',$message);
        // $failedUsers =
        try {
            $response = $client->post('https://api.msg91.com/api/v5/whatsapp/whatsapp-outbound-message/', [
                'headers' => [
                    'authkey' =>   '388260A6Kcd8wv5pYU63bd07b3P1',
                    'Accept'     => 'application/json',
                    'Content-Type'     => 'application/json',
                ],
                'body' => json_encode([
                    "integrated_number" => "919360777089",
                    "content_type" => "template",
                    'payload' => [
                        "to" => "9888046026",
                        "type" => "template",
                        "template" => [
                            "name" => $template,
                            "language" => [
                                "code" => "en_US",
                                "policy" => "deterministic"
                            ],
                            "components" => [
                                [
                                    "type" => "header",
                                    "parameters" => [
                                        [
                                            "type" => "image",
                                            "image" => [
                                                "link" => "https://happywed.in/assets/PWA/512x512.png",
                                            ]
                                        ]
                                    ],
                                ],
                                [
                                    "type" => "body",
                                    "parameters" => $message
                                ]
                            ],
                        ],
                        "messaging_product" => "whatsapp"
                    ]
                ])
            ]);
            //dd(json_decode($response->getBody(), true));
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            dd('ss', $e->getResponse()->getBody()->getContents());
            $response = $e->getResponse();
            $failedUsers =
                $responseBodyAsString = $response->getBody()->getContents();
            throw new Exception('API call failed: ' . $responseBodyAsString);
            // return ['status' => 'error', 'message' => $response->getStatusCode(), 'error' => $responseBodyAsString];
        }
    }
}
