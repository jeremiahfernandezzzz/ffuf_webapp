<?php

// controller resolver implementation (alternatives ReflectionCacheControllerResolver, ConfigControllerResolver)
$conrollerResolver = new \yapcdi\controller\resolver\symfony\ReflectionControllerResolver($diContainer);
