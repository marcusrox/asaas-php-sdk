<?php
namespace Adrianovcar\Asaas\Adapter;


// Asaas
use Adrianovcar\Asaas\Exception\AsaasApiException;
use Adrianovcar\Asaas\Exception\HttpException;

// GuzzleHttp
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;



/**
 * Guzzle Http Adapter
 *
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
     * @var Response|GuzzleHttp\Message\ResponseInterface
     */
    protected $response;

    /**
     * Constructor
     *
     * @param string $token   Access Token
     * @param  ClientInterface|null  $client  Client Instance
     */
    public function __construct(string $token, ClientInterface $client = null)
    {
        $this->client = $client ?: new Client(['headers' => ['access_token' => $token]]);
    }

    /**
     * @throws \Exception
     */
    public function get($url)
    {
        try
        {
            $this->response = $this->client->get($url);
        }
        catch (RequestException $e) {
            $this->handleError($e);
        }

        return $this->response->getBody();
    }

    /**
     * @throws \Exception
     */
    public function delete($url)
    {
        try
        {
            $this->response = $this->client->delete($url);
        }
        catch (RequestException $e) {
            $this->handleError($e);
        }

        return $this->response->getBody();
    }

    /**
     * @throws \Exception
     */
    public function put($url, $content = '')
    {
        $options = [];
        $options['body'] = $content;

        try
        {
            $this->response = $this->client->put($url, $options);
        }
        catch (RequestException $e) {
            $this->handleError($e);
        }

        return $this->response->getBody();
    }

    /**
     * {@inheritdoc}
     * @throws \Exception
     */
    public function post($url, $content = '')
    {
        $options = [];
        $options['json'] = $content;

        try
        {
            $this->response = $this->client->post($url, $options);
        }
        catch (RequestException $e) {
            $this->handleError($e);
        }

        return $this->response->getBody();
    }

    /**
     * {@inheritdoc}
     */
    public function getLatestResponseHeaders()
    {
        if(null === $this->response)
        {
            return;
        }

        return [
            'reset'     => (int) (string) $this->response->getHeader('RateLimit-Reset'),
            'remaining' => (int) (string) $this->response->getHeader('RateLimit-Remaining'),
            'limit'     => (int) (string) $this->response->getHeader('RateLimit-Limit'),
        ];
    }

    /**
     * @throws \Exception
     */
    protected function handleError(RequestException $e)
    {
        $content = json_decode((string) $e->getResponse()->getBody());
        $message = $content->errors[0]->description ?? $content ?? $e->getResponse()->getReasonPhrase() ?? '--';

        throw new \Exception($message, $e->getCode());
    }
}
