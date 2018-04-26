<?php

// Exceptions handler
$monologLogger = new \Monolog\Logger(APPLICATION_NAME);
$diContainer->addSharedInstance($monologLogger, '\Psr\Log\LoggerInterface');
