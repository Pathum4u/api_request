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
        return response()->json([$data], $statusCode);
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
    public function errorRequest($client)
    {
        //
        return response()->json(['error' => 'Request Error', 'message' => 'Ooops! Something not ok in request', 'client' => $client], 400);
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
