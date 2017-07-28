<?php

namespace Preetender\Routing\Response;

/**
 * Class TextPlainRenderer
 * @package Preetender\Routing\Response
 */
class TextPlainRenderer extends Formatter
{
    /**
     * Inform headers for text requests
     *
     * @var array
     */
    protected $headers = [
        'Content-type' => 'text/plain'
    ];

    /**
     * Format and return to requester
     *
     * @return mixed
     */
    public function render()
    {
        $this->response->setContent( $this->wrapped->render() );
        $this->response->headers->add( $this->headers );
        $this->response->prepare( $this->request );
        $this->response->send();
    }
}