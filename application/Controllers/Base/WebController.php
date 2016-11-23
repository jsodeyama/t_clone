<?php

namespace Application\Controllers\Base;

use Application\Supports\Config;

abstract class WebController extends Controller
{

    public function render_view(string $template_name, array $vars = array()) : string
    {
        $template = (new \Twig_Environment(new \Twig_Loader_Filesystem(__DIR__ . '/../../../templates')))->load($template_name);

        return $template->render(array_merge($vars, Config::get('template.default_assign_vars')));
    }
}