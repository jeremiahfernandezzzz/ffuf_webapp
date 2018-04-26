<?php

// Session
$sessionHandler = new \Symfony\Component\HttpFoundation\Session\Storage\Handler\NativeFileSessionHandler();
$sessionStorage = new \Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage(['gc_maxlifetime' => 21600],
    $sessionHandler);
$session = new \Symfony\Component\HttpFoundation\Session\Session($sessionStorage);
$session->setName(APPLICATION_NAME);
$session->start();
$request->setSession($session);

$diContainer->addSharedInstance($session, \Symfony\Component\HttpFoundation\Session\SessionInterface::class);