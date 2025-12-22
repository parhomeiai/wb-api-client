<?php

class WbApiClientTest extends TestCase
{
    public function test_ping()
    {
        $client = app(\Escorp\WbApiClient\WbApiClient::class);

        $this->assertEquals('WB API client works', $client->ping());
    }
}

