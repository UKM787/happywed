<?php
namespace App\Notifications\Channels;

use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Illuminate\Notifications\Notification;

class MSG91WatsappChannel
{
    public function send($notifiable, Notification $notification)
    {
        $client = new Client();
        $data = $notification->toMSG91Watsapp($notifiable);
        $whatsappAuthKey = config('services.msg91.whatsapp_authkey');

        try {
            $response = $client->post('https://api.msg91.com/api/v5/whatsapp/whatsapp-outbound-message/bulk/', [
                'headers' => [
                    'authkey' => '388260A6Kcd8wv5pYU63bd07b3P1',
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'json' => $data
            ]);

            $responseBody = json_decode($response->getBody()->getContents(), true);
            Log::info('WhatsApp MSG91 Response:', $responseBody);

            return $responseBody;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $errorResponse = $e->getResponse()->getBody()->getContents();
            Log::error('WhatsApp MSG91 API Error:', ['error' => $errorResponse]);
            throw new \Exception('MSG91 API call failed: ' . $errorResponse); // Use fully qualified \Exception
        }
    }
}
