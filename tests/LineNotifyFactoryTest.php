<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use LiYiBin\LineNotify\LineNotifyFactory;
use Orchestra\Testbench\TestCase;

class LineNotifyFactoryTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('line-notify.token', 'FAKE_TOKEN');
    }

    /** @test */
    public function send_message_success()
    {
        $mock = new MockHandler([
            new Response(200, [
                'status' => 200,
                'message' => 'ok',
            ]),
        ]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $lineNotify = new LineNotifyFactory($client);

        $lineNotify->send('FAKE_MESSAGE');

        $this->assertTrue(true);
    }

    /** @test */
    public function send_message_error()
    {
        $this->expectException(ClientException::class);

        $mock = new MockHandler([
            new Response(400, [
                'status' => 400,
                'message' => 'Unauthorized request',
            ]),
        ]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $lineNotify = new LineNotifyFactory($client);
        $lineNotify->send('FAKE_MESSAGE');
    }

    /** @test */
    public function send_message_with_empty_token_error()
    {
        $this->app['config']->set('line-notify.token', null);

        $this->expectExceptionMessage('The line notify token is required.');

        $lineNotify = new LineNotifyFactory();
        $lineNotify->send('FAKE_MESSAGE');
    }
}
