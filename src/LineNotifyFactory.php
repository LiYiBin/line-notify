<?php

namespace LiYiBin\LineNotify;

use GuzzleHttp\Client;
use Exception;

class LineNotifyFactory
{
    const LINE_NOTIFY_URI = 'https://notify-api.line.me/api/notify';

    protected $client;

    public function __construct(Client $client = null)
    {
        $this->client = $client ?: new Client;
    }

    public function send(String $message)
    {
        $token = config('line-notify.token');

        if (!$token) {
            throw new Exception('The line notify token is required.');
        }
        $response = $this->client->post(self::LINE_NOTIFY_URI, [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
            'form_params' => [
                'message' => $message,
            ],
        ]);
    }
}
