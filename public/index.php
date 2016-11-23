<?php

error_reporting(E_ALL |E_STRICT);
ini_set('display_errors', true);

require_once '../vendor/autoload.php';

use \Symfony\Component\HttpFoundation as HttpFoundation;
use \Symfony\Component\Routing as Routing;

$request = HttpFoundation\Request::createFromGlobals();

$context = new Routing\RequestContext();
$context->fromRequest($request);

$matcher = new Routing\Matcher\UrlMatcher(require_once '../application/routes.php', $context);

try {
    $request->attributes->add($matcher->match($request->getPathInfo()));
} catch (Routing\Exception\ResourceNotFoundException $e) {
    (new HttpFoundation\Response('Not Found', 404))->send();
}

$controller = $request->attributes->get('_controller');
$action = $request->attributes->get('_action');

if (!class_exists($controller)) {
    (new HttpFoundation\Response("{$controller} is not found", 500))->send();
    exit;
}

if (!method_exists($controller, $action)) {
    (new HttpFoundation\Response("Action {$action} Not Found", 500))->send();
    exit;
}

$controller_instance = new $controller($request);
if (!$controller_instance instanceof \Application\Controllers\Base\Controller) {
    (new HttpFoundation\Response("{$controller} is not Controller", 500))->send();
    exit;
}

\Application\Supports\Config::load('../configs');

/**
 * @var $route \Symfony\Component\Routing\RouteCollection
 */
try {
    $response = new HttpFoundation\Response($controller_instance->$action());
    $response->send();
} catch (Exception $e) {
    (new HttpFoundation\Response($e->getMessage() . $e->getTraceAsString(), 500))->send();
}
