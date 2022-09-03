<?php
namespace Pathum4u\ApiRequest;

use GuzzleHttp\Client;


class ApiRequest
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
     * constructer
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
        if($service = $this->checkService($service)){
            $this->baseUri = $service['base_uri'];
            $this->secret = $service['secret'];
        }

        return $this;
    }

    /**
     * Check Service
     *
     */
    function checkService($service){

        if(array_key_exists($service, $this->services)){
            //
            return config('services.'.$service);
        }

        return dd('service not available');
    }

    /**
     * method
     *
     */
    public function method($method){
        //
        $this->method = $method;

        return $this;
    }

    /**
     * Get method
     *
     */
    public function get($url){
        //
        $this->method = 'get';
        $this->url($url);

        return $this;
    }

    /**
     * Post method
     *
     */
    public function post($url){
        //
        $this->method = 'post';
        $this->url($url);

        return $this;
    }

    /**
     * Url
     *
     */
    public function url($url){
        //
        if($url){
            $this->url = $url;
        }else{
            return dd('url not valied');
        }

        return $this;
    }

    /**
     * Url
     *
     */
    public function params($v){
        //
        $this->params;

        return $this;
    }

    /**
     * Headers
     *
     */
    function headers($headers){
        //
        if(is_array($headers)){
            array_merge($headers, $this->headers);
        }else{
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
    public function request($service, $method, $url, $params = [], $headers = []){
        //
        $this->service($service);
        $this->url($url);
        $this->method($method);
        $this->params($params);
        $this->headers($headers);

        $response = $this->send();

        return $response->getBody()->getContents();
    }

    /**
     * Send request
     *
     *
     */
    public function send(){
        //

        $client = new Client([
            'base_uri' => $this->baseUri
        ]);


        if ($this->secret) {
            $this->headers['Authorization'] = $this->secret;
            $this->headers['Accept'] = 'application/json';
            $this->headers['Content-Type'] = 'application/json';
        }
        dd($this->url);

        return $client->request(
            $this->method,
            $this->url,
            [
                'json' => $this->params,
                'headers' => $this->headers
            ]
        );
    }
}
