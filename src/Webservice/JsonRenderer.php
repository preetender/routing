<?php

namespace Preetender\Routing\Webservice;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class JsonRenderer
 * @package Preetender\Routing\Webservice
 */
class JsonRenderer extends ToRender
{
    /**
     * Informar cabeçalhos para chamadas JSON.
     *
     * @var array
     */
    protected $headers = [
        'Content-type' => 'application/json'
    ];

    /**
     * Formatar resposta e emiti-la ao solicitante.
     *
     * @return mixed
     */
    public function render()
    {
        $this->response->setContent( json_encode( $this->wrapped->render() ) );
        $this->response->headers->add( $this->headers );
        $this->response->prepare( $this->request );
        $this->response->send();
    }
}