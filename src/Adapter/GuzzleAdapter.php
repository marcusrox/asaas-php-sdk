<?php

namespace Adrianovcar\Asaas\Adapter;

use Adrianovcar\Asaas\Exception\HttpException;
use Guzzle\Http\Client;
use Guzzle\Http\ClientInterface;
use Guzzle\Http\Exception\RequestException;

/**
 * Guzzle Adapter
 *
 * @author Adriano Carrijo <adrianovieirac@gmail.com>
 * @author Agência Softr <agencia.softr@gmail.com>
 */
class GuzzleAdapter implements AdapterInterface
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
        $this->client = $client ?: new Client();

        $this->client->setDefaultOption('headers/access_token', $token);
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $url): string
    {
        try {
            $this->response = $this->client->get($url)->send();
        } catch (RequestException $e) {
            $this->response = $e->getResponse();
            $this->handleError();
        }

        return $this->response->getBody(true);
    }

    /**
     * @throws HttpException
     */
    protected function handleError()
    {
        $body = (string) $this->response->getBody(true);
        $code = (int) $this->response->getStatusCode();

        $content = json_decode($body);

        throw new HttpException($content->message ?? 'Request not processed.', $code);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(string $url): string
    {
        try {
            $this->response = $this->client->delete($url)->send();
        } catch (RequestException $e) {
            $this->response = $e->getResponse();
            $this->handleError();
        }

        return $this->response->getBody(true);
    }

    /**
     * {@inheritdoc}
     */
    public function put(string $url, $content = ''): string
    {
        $request = $this->client->put($url, [], $content);

        try {
            $this->response = $request->send();
        } catch (RequestException $e) {
            $this->response = $e->getResponse();

            $this->handleError();
        }

        return $this->response->getBody(true);
    }

    /**
     * {@inheritdoc}
     */
    public function post(string $url, $content = ''): string
    {
        $request = $this->client->post($url, [], $content);

        try {
            $this->response = $request->send();
        } catch (RequestException $e) {
            $this->response = $e->getResponse();

            $this->handleError();
        }

        return $this->response->getBody(true);
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
