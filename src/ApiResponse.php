<?php

namespace Pathum4u\ApiRequest;

class  ApiResponse
{
    /**
     * @param     $data
     * @param int $statusCode
     *
     * @return mixed
     */
    public function successResponse($statusCode, $data)
    {
        //
        if(!$data){
            $data = 'success';
        }

        return response($data, $statusCode);
    }

    /**
     * @param $errorMessage
     * @param $statusCode
     *
     * @return mixed
     */
    public function errorResponse($e)
    {
        $response = $e->getResponse();
        $responseBodyAsString = $response->getBody()->getContents();

        return response()->json(['error' => $response->getReasonPhrase(), 'message' => $this->errorMessage($responseBodyAsString)], $response->getStatusCode());
    }

    /**
     * @param $errorMessage
     * @param $statusCode
     *
     * @return mixed
     */
    public function errorMessage($errorMessage)
    {
        return json_decode($errorMessage)->message;
    }


    /**
     * @param $errorMessage
     * @param $statusCode
     *
     * @return mixed
     */
    public function errorRequest($client, $errorMessage = 'Ooops! Something not ok in request')
    {
        //
        return response()->json(['error' => 'Request Error', 'message' => $errorMessage , 'client' => $client], 400);
    }


    /**
     * @param $errorMessage
     * @param $statusCode
     *
     * @return mixed
     */
    public function getResponse($response)
    {
        return json_decode($response);
    }
}
