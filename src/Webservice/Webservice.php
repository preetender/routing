<?php

namespace Preetender\Routing\Webservice;

/**
 * Class Webservice
 * @package Preetender\Routing\Webservice
 */
class Webservice implements Renderable
{
    /** @var */
    protected $data;

    /**
     * Webservice constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Formatar resposta e emiti-la ao solicitante.
     *
     * @return mixed
     */
    public function render()
    {
        return $this->data;
    }
}