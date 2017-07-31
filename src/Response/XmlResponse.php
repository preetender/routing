<?php

namespace Preetender\Routing\Response;

/**
 * Class XmlResponse
 * @package Preetender\Routing\Response
 */
final class XmlResponse extends BaseResponse
{
    /**
     * Inform headers for xml requests
     *
     * @var array
     */
    protected $headers = [];

    /**
     * Format and return to requester
     *
     * @return mixed
     */
    public function render()
    {
        $this->response->setContent($this->wrapped->render());
        $this->response->headers->add($this->headers);
        $this->response->prepare($this->request);
        $this->response->send();
    }
}