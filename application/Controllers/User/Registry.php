<?php

namespace Application\Controllers\User;

use Application\Controllers\Base\WebController;

class Registry extends WebController
{
    /**
     * @return string
     */
    public function index()
    {
        return $this->render_view('Registry/index.twig');
    }

    public function confirm()
    {
    }
}
