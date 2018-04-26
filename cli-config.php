<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

require 'vendor/autoload.php';
require_once 'config/app/00-db.php';

return ConsoleRunner::createHelperSet($entityManager);
