<?php

namespace Pathum4u\ApiRequest;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Utils;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Http;
use Pathum4u\ApiRequest\ApiResponse;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Client\PendingRequest;
use GuzzleHttp\Exception\BadResponseException;


class ApiRequest extends Http
{

    /**
     * @var string
     */
    protected $services = [];

    /**
     * constructor
     *
     */
    public function __construct()
    {
        $this->services = config('services');
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
     * Dump the request before sending and end the script.
     *
     * @return $this
     */
    public function Service($service)
    {
        if ($service = $this->checkService($service)) {
            return Http::withHeaders([
                'secret' => $service['secret'],
            ])->baseUrl($service['base_uri']);
        }
    }
}
