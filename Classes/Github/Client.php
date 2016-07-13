<?php

namespace T3G\Intercept\Github;

use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use T3G\Intercept\Traits\Logger;

/**
 * Class GithubRequests
 *
 * Responsible for all requests sent to Github
 *
 * @codeCoverageIgnore tested via integration tests only
 * @package T3G\Intercept\Requests
 */
class Client
{
    use Logger;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    protected $accessKey = '7ec461d8d612c343d225f8b126866b59cec50100';

    public function __construct(LoggerInterface $logger = null)
    {
        $this->setLogger($logger);
        $this->client = new GuzzleClient();
    }

    public function get(string $url) : ResponseInterface
    {
        $this->logger->info('GET request to: ' . $url);
        return $this->client->get($url);
    }

    public function patch(string $url, array $data) : ResponseInterface
    {
        $this->logger->info('PATCH request to:' . $url);
        $url .= '?access_token=' . $this->accessKey;
        return $this->client->patch($url, ['json' => $data]);
    }

    public function post(string $url, array $data)
    {
        $this->logger->info('POST request to:' . $url);
        $url .= '?access_token=' . $this->accessKey;
        return $this->client->post($url, ['json' => $data]);
    }

    public function put(string $url)
    {
        $this->logger->info('PUT request to:' . $url);
        $url .= '?access_token=' . $this->accessKey;
        return $this->client->put($url);
    }

}