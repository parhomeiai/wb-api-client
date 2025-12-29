<?php

namespace Escorp\WbApiClient\Tests;

use Http\Mock\Client;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Escorp\WbApiClient\Api\Users\UsersApi;
use Escorp\WbApiClient\Dto\Users\{AccessDto, UserAccessDto, UpdateUsersAccessRequest};
use Escorp\WbApiClient\Http\Psr18HttpClient;
use Escorp\WbApiClient\Auth\StaticTokenProvider;
use Escorp\WbApiClient\Api\ApiHostRegistry;

final class UpdateUsersAccessTest extends TestCase
{
    public function testUpdateUsersAccess(): void
    {
        $psr17 = new Psr17Factory();
        $mock = new Client();
        $mock->addResponse(new Response(200, [], '{}'));

        $http = new Psr18HttpClient($mock, $psr17, $psr17);
        $api = new UsersApi($http, new StaticTokenProvider('TOKEN'), new ApiHostRegistry());

        $dto = new UpdateUsersAccessRequest([
            new UserAccessDto(1001, [
                new AccessDto('finance', false),
                new AccessDto('balance', true),
            ])
        ]);

        $api->updateUsersAccess($dto);

        self::assertCount(1, $mock->getRequests());
    }
}
