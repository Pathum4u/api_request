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
    private $services = [];

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
     * @var bool
     */
    protected $verify = true;

    /**
     * constructor
     *
     */
    public function __construct()
    {
        $this->services = config('services');
    }

    /**
     * Base url provider
     *
     */
    public function base_url($url)
    {
        $this->baseUri = $url;

        return $this;
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
     * Verify
     *
     */
    public function verify($verify = true)
    {
        $this->verify = $verify;
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
    public function request($service, $method, $url, $params = [], $headers = [], $debug = false, $verify = true)
    {
        //
        $this->service($service);
        $this->url($url);
        $this->method($method);
        $this->params($params);
        $this->headers($headers);
        $this->debug($debug);
        $this->verify($verify);
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
                'json' => $this->params
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
            'timeout'  => 10.0,
            'base_uri' => $this->baseUri,
            'headers' => [
                'Secret' => $this->secret,
                'Accept'     => 'application/json',
                'Content-Type'      => 'application/json'
            ]
        ]);


        if ($this->debug) {

            $response =  $client->request(
                $this->method,
                $this->url,
                [
                    'json' => $this->params,
                    'verify' => $this->verify,
                    'debug' => $this->debug
                ]
            );

            return $response->getBody()->getContents();

        } else {
            try {
                $response =  $client->request(
                    $this->method,
                    $this->url,
                    [
                        'json' => $this->params,
                        'verify' => $this->verify,
                        'debug' => $this->debug
                    ]
                );

                return $this->successResponse($response->getStatusCode(), $response->getBody()->getContents());
            } catch (ClientException $e) {

                return $this->errorResponse($e);
            } catch (ServerException $e) {

                return $this->errorResponse($e);
            } catch (BadResponseException $e) {

                return $this->errorResponse($e);
            } catch (RequestException $e) {

                return $this->errorRequest($this, $e->getHandlerContext()['error']);
            }
        }
    }
}
