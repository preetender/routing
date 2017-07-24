<?php

namespace Preetender\Routing\Webservice;

/**
 * Interface Renderable
 * @package Preetender\Routing\Webservice
 */
interface Renderable
{
    /**
     * Formatar resposta e emiti-la ao solicitante.
     *
     * @return mixed
     */
    public function render();
}