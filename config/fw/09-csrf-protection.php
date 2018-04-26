<?php

// CSRF-Protection
if (null === $session->get('csrftoken')) {
    $session->set('csrftoken', sha1(uniqid(APPLICATION_NAME, true)));
}

$viewEngine->assign('_csrfToken', $session->get('csrftoken'));
$csrf = new \xvsys\csrf\CSRFTokenValidator($session->get('csrftoken'));
$eventDispatcher->addSubscriber($csrf);