<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response as IlluminateResponse;
use Response;

/**
 * Base API Controller.
 */
class ApiController extends Controller
{
    /**
     * default status code.
     *
     * @var int
     */
    protected $statusCode = 200;

    /**
     * get the status code.
     *
     * @return statuscode
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * set the status code.
     *
     * @param [type] $statusCode [description]
     *
     * @return statuscode
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * response.
     *
     * @param array $data
     * @param array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function response($data = [], $message = 'Successfully', $headers = [])
    {
        return response()->json([
            'status' => $this->getStatusCode(),
            'message' => $message,
            'data' => $data
        ], 200, $headers);
    }

    /**
     * response with pagincation.
     *
     * @param Paginator $items
     * @param array     $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseWithPagination($items, $data)
    {
        $data = array_merge($data, [
            'paginator' => [
                'total_count'  => $items->total(),
                'total_pages'  => ceil($items->total() / $items->perPage()),
                'current_page' => $items->currentPage(),
                'limit'        => $items->perPage(),
             ],
        ]);

        return $this->response($data);
    }

    /**
     * responsd not found.
     *
     * @param string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseNotFound($message = 'Not Found', $data = [])
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_NOT_FOUND)->response($data, $message);
    }

    /**
     * response with error.
     *
     * @param string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseInternalError($message = 'Internal Error')
    {
        return $this->setStatusCode(500)->response([], $message);
    }

    /**
     * response with unauthorized.
     *
     * @param string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseUnauthorized($message = 'Unauthorized')
    {
        return $this->setStatusCode(401)->response([], $message);
    }

    /**
     * response with forbidden.
     *
     * @param string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseForbidden($message = 'Forbidden', $data = [])
    {
        if (!$data) $data = new \stdClass;
        return $this->setStatusCode(403)->response($data, $message);
    }

    /**
     * response with no content.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseWithNoContent($message = 'No content')
    {
        return $this->setStatusCode(204)->response([], $message);
    }

    /**Note this function is same as the below function but instead of responseing with error below function returns error json
     * Throw Validation.
     *
     * @param string $message
     *
     * @return mix
     */
    public function throwValidation($message)
    {
        return $this->setStatusCode(422)->response([], $message);
    }
}
