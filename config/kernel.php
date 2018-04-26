<?php

// finally create the kernel ...
$app = new \Symfony\Component\HttpKernel\HttpKernel($eventDispatcher, $conrollerResolver);
// ... submit the request ...
$response = $app->handle($request);
// ... and return the response to the client
$response->send();