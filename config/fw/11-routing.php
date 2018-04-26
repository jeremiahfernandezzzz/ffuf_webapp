<?php

// application routes ...
$stack = new \Symfony\Component\HttpFoundation\RequestStack();
$fl = new \Symfony\Component\Config\FileLocator(array(realpath('config/routing')));
$loader = new \Symfony\Component\Routing\Loader\XmlFileLoader($fl);
$context = new \Symfony\Component\Routing\RequestContext();
$context->fromRequest($request);
$router = new \Symfony\Component\Routing\Router($loader, 'routes.xml', array(/*'cache_dir' => 'tmp/routes'*/),
    $context);
try {
    $request->attributes->add($router->match($request->getPathInfo()));
} catch (\Symfony\Component\Routing\Exception\ResourceNotFoundException $ex) {
    // The exception must be handled by the HTTP-Kernel!
    // We achieve this by not setting the _controller attribute to the request.
}
