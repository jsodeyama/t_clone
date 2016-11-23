<?php

namespace Application\Controllers\Base;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

abstract class Controller
{
    /**
     * @var ParameterBag
     */
    protected $post_parameter = [];

    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->post_parameter = $request->request;
    }
}
