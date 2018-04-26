<?php

// Create automatically responses
$responseCreator = new \xvsys\autoresponse\ResponseCreator();
$eventDispatcher->addSubscriber($responseCreator);
