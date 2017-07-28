<?php

namespace Preetender\Routing\Contracts;

/**
 * Interface Renderable
 * @package Preetender\Routing\Contracts
 */
interface Renderable
{
    /**
     * Format and return to requester.
     *
     * @return mixed
     */
    public function render();
}