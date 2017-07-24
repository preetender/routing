<?php

namespace Preetender\Routing\Webservice;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class XmlRenderer
 * @package Preetender\Routing\Webservice
 */
class XmlRenderer extends ToRender
{
    /**
     * Informar cabeçalhos para requisições XML.
     *
     * @var array
     */
    protected $headers = [];

    /**
     * Formatar resposta e emiti-la ao solicitante.
     *
     * @return mixed
     */
    public function render()
    {

        $data_format = $this->wrapped->render();

        $this->response->setContent( $data_format );
        $this->response->headers->add( $this->headers );
        $this->response->prepare( $this->request );
        $this->response->send();
    }
}