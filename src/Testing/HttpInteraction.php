<?php
/**
 * Created by PhpStorm.
 * User: cesinha
 * Date: 31/07/17
 * Time: 08:15
 */

namespace Preetender\Routing\Testing;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * Trait HttpInteraction
 * @package Preetender\Routing\Testing
 */
trait HttpInteraction
{
    /** @var string  */
    protected $baseUrl = 'http://routing_v1_2.app';

    /** @var float  */
    protected $timeout = 2.0;

    /** @var Client */
    protected $http;

    /**
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    protected function getResponse(ResponseInterface $response)
    {
        return $response;
    }

    /**
     * ....
     *
     * @inheritdoc
     */
    public function setUp()
    {
        $this->http = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => $this->timeout
        ]);
    }
}