<?php

namespace App\Traits;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait ApiResponse
{
    private function apiResponse($data, $code)
    {
        return response()->json( $data, $code );
    }

    protected function showAll(Collection $collection, $code = 200)
    {
        if ($collection->count() > 0) {
            return $this->apiResponse( ['result' => $collection], $code );
        }
        return response( '', 204 );
    }

    protected function showOne(Model $model, $code = 200)
    {
        return response()->json( ['result' => $model], $code );
    }

    protected function errorResponse($message, $code = 400)
    {
        return $this->apiResponse( ['errors' => $message, 'code' => $code], $code );
    }
}
