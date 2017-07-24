<?php

namespace Preetender\Routing\Webservice;

/**
 * Class TextPlainRenderer
 * @package Preetender\Routing\Webservice
 */
class TextPlainRenderer extends ToRender
{
    protected $headers = [
        'Content-type' => 'text/plain'
    ];

    /**
     * Formatar resposta e emiti-la ao solicitante.
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