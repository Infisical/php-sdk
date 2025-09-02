<?php

declare(strict_types=1);

namespace Infisical\SDK\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

/**
 * Simple HTTP client wrapper around Guzzle
 */
class HttpClient
{
    private Client $client;
    private string $baseUrl;

    /**
     * @param array<string, string> $headers
     */
    public function __construct(string $baseUrl, array $headers = [])
    {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->client = new Client(
            [
            'base_uri' => $this->baseUrl,
            'timeout' => 30,
            'headers' => array_merge(
                [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                ], $headers
            ),
            ]
        );
    }

    /**
     * Send a GET request
     *
     * @param  string                $endpoint
     * @param  array<string, mixed>  $query
     * @param  array<string, string> $headers
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function get(string $endpoint, array $query = [], array $headers = []): ResponseInterface
    {
        return $this->client->get(
            $endpoint, [
            'query' => $query,
            'headers' => $headers,
            ]
        );
    }

    /**
     * Send a POST request
     *
     * @param  string                $endpoint
     * @param  array<string, mixed>  $data
     * @param  array<string, string> $headers
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function post(string $endpoint, array $data = [], array $headers = []): ResponseInterface
    {
        return $this->client->post(
            $endpoint, [
            'json' => $data,
            'headers' => $headers,
            ]
        );
    }

    /**
     * Send a PATCH request
     *
     * @param  string                $endpoint
     * @param  array<string, mixed>  $data
     * @param  array<string, string> $headers
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function patch(string $endpoint, array $data = [], array $headers = []): ResponseInterface
    {
        return $this->client->patch(
            $endpoint, [
            'json' => $data,
            'headers' => $headers,
            ]
        );
    }

    /**
     * Send a DELETE request
     *
     * @param  string                $endpoint
     * @param  array<string, mixed>  $data
     * @param  array<string, string> $headers
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function delete(string $endpoint, array $data = [], array $headers = []): ResponseInterface
    {
        return $this->client->delete(
            $endpoint, [
            'json' => $data,
            'headers' => $headers,
            ]
        );
    }

    /**
     * Get the base URL
     *
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }
}
