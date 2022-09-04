<?php

namespace Pathum4u\ApiRequest;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Pathum4u\ApiRequest\ApiResponse;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\BadResponseException;


class ApiRequest extends ApiResponse
{
    /**
     * @var string
     */
    protected $baseUri;

    /**
     * @var string
     */
    protected $secret;

    /**
     * @var string
     */
    protected $services = [];

    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $params;

    /**
     * @var string
     */
    protected $headers = [];

    /**
     * @var bool
     */
    protected $debug = false;

    /**
     * constructor
     *
     */
    public function __construct()
    {
        $this->services = config('services');
    }

    /**
     * Service providers
     *
     */
    public function service($service)
    {
        //
        if ($service = $this->checkService($service)) {
            $this->baseUri = $service['base_uri'];
            $this->secret = $service['secret'];
        }

        return $this;
    }

    /**
     * Check Service
     *
     */
    function checkService($service)
    {

        if (array_key_exists($service, $this->services)) {
            //
            return config('services.' . $service);
        }

        return dd('service not available');
    }

    /**
     * method
     *
     */
    public function method($method)
    {
        //
        $this->method = $method;

        return $this;
    }

    /**
     * Get method
     *
     */
    public function get($url)
    {
        //
        $this->method = 'get';
        $this->url($url);

        return $this;
    }

    /**
     * Post method
     *
     */
    public function post($url)
    {
        //
        $this->method = 'post';
        $this->url($url);

        return $this;
    }

    /**
     * Url
     *
     */
    public function url($url)
    {
        //
        if ($url) {
            $this->url = $url;
        } else {
            return dd('url not valied');
        }

        return $this;
    }

    /**
     * Url
     *
     */
    public function params($params)
    {
        //
        $this->params = $params;

        return $this;
    }

    /**
     * Debug
     *
     */
    public function debug($debug = true)
    {
        $this->debug = $debug;
    }

    /**
     * Headers
     *
     */
    function headers($headers)
    {
        //
        if (is_array($headers)) {
            array_merge($headers, $this->headers);
        } else {
            return dd('Headers not in array');
        }

        return $this;
    }

    /**
     * @param       $method
     * @param       $requestUrl
     * @param array $formParams
     * @param array $headers
     *
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request($service, $method, $url, $params = [], $headers = [], $debug = false)
    {
        //
        $this->service($service);
        $this->url($url);
        $this->method($method);
        $this->params($params);
        $this->headers($headers);
        $this->debug($debug);

        return $this->send();
    }

    /**
     * Create request
     *
     * @response $request
     */
    public function set_request()
    {
        //
        return  new Request(
            $this->method,
            $this->url,
            [
                'json' => $this->params,
                'headers' => [
                    'Authorization' => $this->secret,
                    'Accept'     => 'application/json',
                    'Content-Type'      => 'application/json'
                ]
            ]
        );
    }

    /**
     * Send request
     *
     *
     */
    public function send()
    {
        //
        $client = new Client([
            'timeout'  => 2.0,
            'base_uri' => $this->baseUri,
            'headers' => [
                'Authorization' => $this->secret,
                'Accept'     => 'application/json',
                'Content-Type'      => 'application/json'
            ]
        ]);

        try {
            $response =  $client->request(
                    $this->method,
                    $this->url,
                    [
                        'json' => $this->params
                    ]
                );

            return $this->successResponse($response->getStatusCode(), $response->getBody()->getContents());
        } catch (ClientException $e) {

            return $this->errorResponse($e);
        } catch (ServerException $e) {

            return $this->errorResponse($e);
        } catch (BadResponseException $e) {

            return $this->errorResponse($e);
        } catch(RequestException $e){

            return $this->errorRequest($client, $this->set_request());
        }

    }
}
