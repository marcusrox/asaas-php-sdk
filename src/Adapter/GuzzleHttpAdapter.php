<?php

namespace Adrianovcar\Asaas\Adapter;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;

/**
 * Guzzle Http Adapter
 *
 * @author Adriano Carrijo <adrianovieirac@gmail.com>
 * @author Agência Softr <agencia.softr@gmail.com>
 */
class GuzzleHttpAdapter implements AdapterInterface
{
    /**
     * Client Instance
     *
     * @var ClientInterface
     */
    protected $client;

    /**
     * Command Response
     *
     */
    protected $response;

    /**
     * Constructor
     *
     * @param  string  $token  Access Token
     * @param  ClientInterface|null  $client  Client Instance
     */
    public function __construct(string $token, ClientInterface $client = null)
    {
        $this->client = $client ?: new Client(['headers' => ['access_token' => $token]]);
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $url): string
    {
        try {
            $this->response = $this->client->get($url);
        } catch (RequestException $e) {
            $this->handleError($e);
        }

        return $this->response->getBody();
    }

    /**
     * @throws Exception
     */
    protected function handleError(RequestException $e)
    {
        $content = json_decode((string) $e->getResponse()->getBody());
        $message = $content->errors[0]->description ?? $content ?? $e->getResponse()->getReasonPhrase() ?? '--';

        throw new Exception($message, $e->getCode());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(string $url): string
    {
        try {
            $this->response = $this->client->delete($url);
        } catch (RequestException $e) {
            $this->handleError($e);
        }

        return $this->response->getBody();
    }

    /**
     * {@inheritdoc}
     */
    public function put(string $url, $content = ''): string
    {
        $options = [];
        $options['body'] = $content;

        try {
            $this->response = $this->client->put($url, $options);
        } catch (RequestException $e) {
            $this->handleError($e);
        }

        return $this->response->getBody();
    }

    /**
     * {@inheritdoc}
     */
    public function post(string $url, $content = ''): string
    {
        $options = [];
        $options['json'] = $content;

        try {
            $this->response = $this->client->post($url, $options);
        } catch (RequestException $e) {
            $this->handleError($e);
        }

        return $this->response->getBody();
    }

    /**
     * {@inheritdoc}
     */
    public function getLatestResponseHeaders(): ?array
    {
        if (null === $this->response) {
            return null;
        }

        return [
            'reset' => (int) (string) $this->response->getHeader('RateLimit-Reset'),
            'remaining' => (int) (string) $this->response->getHeader('RateLimit-Remaining'),
            'limit' => (int) (string) $this->response->getHeader('RateLimit-Limit'),
        ];
    }
}
