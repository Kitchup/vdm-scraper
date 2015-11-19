<?php

namespace App\Http\Controllers\Vdm;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as CustomResponse;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    /**
     * The status code for JSON response, 200 OK by default
     *
     * @var int
     */
    private $statusCode = CustomResponse::HTTP_OK;

    /**
    * Getter for statusCode
    *
    * @return int
    */
    public function getStatusCode(){return $this->statusCode;}


    /**
    * Setter for statusCode
    *
    * @param int $status : HTTP status code
    * @return    $this   : returns object calls chaining
    */
    public function setStatusCode($status){
        $this->statusCode=$status;
        return $this;
    }  

    /**
    * Generates a simple JSON response
    *
    * @param         $data    : data to be sent
    * @param   array $headers : headers for the HTTP response
    * @return    JsonResponse
    */
    public function respond($data, $headers=[]){ return Response::json($data, $this->getStatusCode(), $headers); } 

    /**
    * Generates a JSON response with a count
    *
    * @param   Collection   $collection 
    * @param                $data
    * @return  JsonResponse : merged $data and count value
    */
    public function respondWithCount(Collection $collection, $data)
    { 
        $response = array_merge ($data, ['count' => $collection->count()]);
        return $this->respond($response); 
    } 

    /**
    * Generates a JSON response with an error message
    *
    * @param   String   $message  : custom error message
    * @return  JsonResponse
    */
    public function respondWithError($message)
    { 
        return $this->respond([
            'error' => [
                        'message' => $message,
                        'status_code' => $this->getStatusCode()
            ]
        ]);
    } 

    /**
    * Generates a JSON 404 Not found error message
    *
    * @return  JsonResponse
    */
    public function respondNotFound()
    { 
        return $this
            ->setStatusCode(CustomResponse::HTTP_NOT_FOUND)
            ->respondWithError('404 not found');
    } 
}
