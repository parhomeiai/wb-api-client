<?php

namespace Escorp\WbApiClient\Http;

use Psr\Http\Client\ClientInterface as Psr18Client;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Escorp\WbApiClient\Contracts\HttpClientInterface;
use Escorp\WbApiClient\Dto\WbErrorDto;
use Escorp\WbApiClient\Exceptions\WbApiClientException;
use Escorp\WbApiClient\Exceptions\WbHttpException;
use InvalidArgumentException;

/**
 * Поддержка любого PSR-18 клиента
 */
final class Psr18HttpClient implements HttpClientInterface
{
    private Psr18Client $client;
    private RequestFactoryInterface $requestFactory;
    private StreamFactoryInterface $streamFactory;

    public function __construct(
        Psr18Client $client,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory
    ) {
        $this->client = $client;
        $this->requestFactory = $requestFactory;
        $this->streamFactory = $streamFactory;
    }

    /**
     *
     * @param string $method
     * @param string $url
     * @param array $options
     * @return array
     * @throws WbApiClientException
     */
    public function request(string $method, string $url, array $options = []): array
    {
        $response = $this->requestRaw($method, $url, $options);

        $body = (string) $response->getBody();
        if ($body === '') {
            return [];
        }

        $decoded = json_decode($body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new WbApiClientException(
                'Invalid JSON response: ' . json_last_error_msg()
            );
        }

        return $decoded;
    }

    /**
     *
     * @param string $method
     * @param string $url
     * @param array $options
     * @return ResponseInterface
     * @throws InvalidArgumentException
     * @throws WbHttpException
     * @throws type
     * @throws WbApiClientException
     */
    public function requestRaw(string $method, string $url, array $options = []): ResponseInterface
    {
        $bodyOptions = array_intersect(['json', 'form_params', 'body', 'multipart'], array_keys($options));
        if (count($bodyOptions) > 1) {
            throw new InvalidArgumentException('Only one of json, form_params or body is allowed');
        }

        try {
            // ---------- QUERY ----------
            if (!empty($options['query'])) {
                $query = http_build_query($options['query']);
                $url .= (str_contains($url, '?') ? '&' : '?') . $query;
            }

            $request = $this->requestFactory->createRequest($method, $url);

            // headers
            if (!empty($options['headers']) && is_array($options['headers'])) {
                foreach ($options['headers'] as $name => $value) {
                    $request = $request->withHeader($name, $value);
                }
            }

            // json body
            if (array_key_exists('json', $options)) {
                $json = json_encode($options['json'], JSON_THROW_ON_ERROR);
                $stream = $this->streamFactory->createStream($json);

                $request = $request
                    ->withHeader('Content-Type', 'application/json')
                    ->withBody($stream);
            }

             // ---------- FORM PARAMS ----------
            if (array_key_exists('form_params', $options)) {
                $body = http_build_query($options['form_params']);
                $request = $request
                    ->withHeader('Content-Type', 'application/x-www-form-urlencoded')
                    ->withBody($this->streamFactory->createStream($body));
            }

            // raw body
            if (array_key_exists('body', $options)) {
                $stream = $this->streamFactory->createStream((string) $options['body']);
                $request = $request->withBody($stream);
            }

            // ---------- MULTIPART ----------
            if (array_key_exists('multipart', $options)) {
                $boundary = bin2hex(random_bytes(16));
                $streamContent = '';

                foreach ($options['multipart'] as $part) {
                    $name = $part['name'];
                    $contents = $part['contents'];
                    $filename = $part['filename'] ?? null;
                    $headers = $part['headers'] ?? [];

                    $streamContent .= "--{$boundary}\r\n";
                    $streamContent .= "Content-Disposition: form-data; name=\"{$name}\"";
                    if ($filename) {
                        $streamContent .= "; filename=\"{$filename}\"";
                    }
                    $streamContent .= "\r\n";

                    foreach ($headers as $key => $value) {
                        $streamContent .= "{$key}: {$value}\r\n";
                    }
                    $streamContent .= "\r\n{$contents}\r\n";
                }
                $streamContent .= "--{$boundary}--\r\n";

                $request = $request
                    ->withHeader('Content-Type', 'multipart/form-data; boundary=' . $boundary)
                    ->withBody($this->streamFactory->createStream($streamContent));
            }

            $response = $this->client->sendRequest($request);

            $status = $response->getStatusCode();
            if ($status < 200 || $status >= 300) {
                $body = (string) $response->getBody();
                $data = json_decode($body, true);

                if (json_last_error() === JSON_ERROR_NONE && !empty($data)) {
                    throw new WbHttpException(WbErrorDto::fromArray($data));
                }

                throw new WbApiClientException(
                    'HTTP error ' . $status . ': ' . $body,
                    $status
                );
            }

            return $response;
        } catch (WbHttpException $e) {
            throw $e;
        } catch (\Throwable $e) {
            throw WbApiClientException::fromException($e);
        }
    }
}

