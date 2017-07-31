<?php

namespace Preetender\Routing\Response;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Preetender\Routing\RouteResponse;

/**
 * Class ExecuteResponse
 * @package Preetender\Routing\Response
 */
final class ExecuteResponse
{
    /**
     * Response to request
     *
     * @param $typeResponse
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public static function factory($typeResponse, Request $request, Response $response)
    {
        if(is_bool($typeResponse)) {
            return $response->setContent((string)$typeResponse)->send();
        }
        $baseResponse = RouteResponse::create($typeResponse);
        if(is_array($typeResponse)) {
            return (new JsonResponse($baseResponse, $request, $response))->render();
        }
        return (new TextPlainResponse($baseResponse, $request, $response))->render();
    }
}