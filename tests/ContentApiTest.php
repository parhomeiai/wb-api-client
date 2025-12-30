<?php


namespace Escorp\WbApiClient\Tests;

use Http\Mock\Client;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Escorp\WbApiClient\Api\Content\ContentApi;
use Escorp\WbApiClient\Http\Psr18HttpClient;
use Escorp\WbApiClient\Auth\StaticTokenProvider;
use Escorp\WbApiClient\Api\ApiHostRegistry;

/**
 * Tests contents
 *
 * @author parhomey
 */
class ContentApiTest  extends TestCase
{
    public function testGetParentCategories(): void
    {
        $psr17 = new Psr17Factory();
        $mock = new Client();

        $mock->addResponse(new Response(200, [], json_encode([
            'data' => [
                ['id' => 479, 'name' => 'Электроника', 'isVisible' => true],
                ['id' => 8693, 'name' => 'Текстиль для дома', 'isVisible' => true]
            ],
            'error' => false,
            'errorText' => '',
            'additionalErrors' => ''
        ])));

        $http = new Psr18HttpClient($mock, $psr17, $psr17);
        $api = new ContentApi($http, new StaticTokenProvider('TOKEN'), new ApiHostRegistry());

        $response = $api->getParentCategories('ru');

        self::assertFalse($response->error);
        self::assertCount(2, $response->categories);
        self::assertSame('Электроника', $response->categories[0]->name);
        self::assertSame(479, $response->categories[0]->id);
        self::assertSame(true, $response->categories[0]->isVisible);
        self::assertSame('Текстиль для дома', $response->categories[1]->name);
    }

    public function testGetSubjects(): void
    {
        $psr17 = new Psr17Factory();
        $mock = new Client();

        $mock->addResponse(new Response(200, [], json_encode([
            'data' => [
                [
                    'subjectID' => 2560,
                    'subjectName' => '3D очки',
                    'parentID' => 479,
                    'parentName' => 'Электроника'
                ],
                [
                    'subjectID' => 1152,
                    'subjectName' => '3D-принтеры',
                    'parentID' => 858,
                    'parentName' => 'Оргтехника'
                ]
            ],
            'error' => false,
            'errorText' => '',
            'additionalErrors' => null
        ])));

        $http = new Psr18HttpClient($mock, $psr17, $psr17);
        $api = new ContentApi($http, new StaticTokenProvider('TOKEN'), new ApiHostRegistry());

        $response = $api->getSubjects(['limit' => 100]);

        self::assertFalse($response->error);
        self::assertCount(2, $response->subjects);
        self::assertSame(2560, $response->subjects[0]->subjectID);
        self::assertSame('3D очки', $response->subjects[0]->subjectName);
        self::assertSame(479, $response->subjects[0]->parentId);
        self::assertSame('Электроника', $response->subjects[0]->parentName);
    }
}
