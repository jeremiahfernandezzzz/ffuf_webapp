<?php

// Create reqeust from globals (_get, _post...) and share it for all classes.
$request = Symfony\Component\HttpFoundation\Request::createFromGlobals();
$diContainer->addSharedInstance($request);

if (($requestMethodBypass = $request->request->get('http-method')) !== null) {
    $request->setMethod($requestMethodBypass);
}