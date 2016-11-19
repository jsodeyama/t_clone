<?php

namespace Application\Controllers\Base;

use Symfony\Component\HttpFoundation\Request;

abstract class Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}