<?php

namespace Preetender\Routing\Response;

/**
 * Class JsonResponse
 * @package Preetender\Routing\Response
 */
class JsonResponse extends BaseResponse
{
    /**
     * Inform headers for json requests
     *
     * @var array
     */
    protected $headers = [
        'Content-type' => 'application/json'
    ];

    /**
     * Format and return to requester
     *
     * @return mixed
     */
    public function render()
    {
        $this->response->setContent(json_encode($this->wrapped->render()));
        $this->response->headers->add($this->headers);
        $this->response->prepare($this->request);
        $this->response->send();
    }
}