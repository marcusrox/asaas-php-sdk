<?php
namespace Adrianovcar\Asaas\Adapter;


// Asaas
use Adrianovcar\Asaas\Exception\HttpException;

// GuzzleHttp
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
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
     * {@inheritdoc}
     */
    public function get($url)
    {
        try
        {
            $this->response = $this->client->get($url);
        }
        catch(RequestException $e)
        {
            $this->response = $e->getResponse();

            return $this->handleError();
        }

        return $this->response->getBody();
    }

    /**
     * {@inheritdoc}
     */
    public function delete($url)
    {
        try
        {
            $this->response = $this->client->delete($url);
        }
        catch(RequestException $e)
        {
            $this->response = $e->getResponse();

            $this->handleError();
        }

        return $this->response->getBody();
    }

    /**
     * {@inheritdoc}
     */
    public function put($url, $content = '')
    {
        $options = [];
        $options['body'] = $content;

        try
        {
            $this->response = $this->client->put($url, $options);
        }
        catch(RequestException $e)
        {
            $this->response = $e->getResponse();

            $this->handleError();
        }

        return $this->response->getBody();
    }

    /**
     * {@inheritdoc}
     */
    public function post($url, $content = '')
    {
        $options = [];
        $options['json'] = $content;

        try
        {
            $this->response = $this->client->post($url, $options);
        }
        catch(\GuzzleHttp\Exception\RequestException $e)
        {
            $this->response = $e->getResponse();

            return $this->handleError();
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
     * @throws HttpException
     */
    protected function handleError()
    {
        $body = (string) $this->response->getBody();
        $code = (int) $this->response->getStatusCode();
        $content = json_decode((string) $this->response->getBody());

        $message = $content->errors[0]->description ?? $content ?? $this->response->getReasonPhrase() ?? $body;

        $item = array(
            'success' => false,
            'code' => $code,
            'errors' => $message);

        throw new HttpException(json_encode($item, JSON_UNESCAPED_UNICODE), $code);
    }
}
