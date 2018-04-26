<?php

// Request deserializer
$fLoader = new \a15l\serialization\metadata\loader\file\XMLFileLoader('config/metadata');
$mdLoader = new \a15l\serialization\metadata\loader\LazyMetadataLoader($fLoader);
$mdFactory = new \a15l\serialization\metadata\factory\MetadataFactory($mdLoader,
    $fLoader->getClassMetadataConfig('default'));
$diContainer->addSharedInstance($mdFactory, '\a15l\serialization\metadata\factory\MetadataFactoryInterface');
$dispatcher = new \a15l\serialization\events\EventDispatcher();
$dispatcher->addListener(\a15l\serialization\events\EventDispatcherInterface::EVENT_DESERIALIZE, 'escapeHTML',
    function ($v){
        if (is_string($v)) {
            return strlen($v) > 0 ? htmlspecialchars($v, ENT_QUOTES) : null;
        }
        if (is_array($v)) {
            $escaped = null;
            foreach ($v as $k => $val) {
                if (is_array($val) || is_object($val)) {
                    // nested arrays are not supported
                    return $v;
                }
                if (strlen($val) === 0) {
                    $escaped[$k] = null;
                    continue;
                }
                $escaped[$k] = strlen($val) > 0 ? htmlspecialchars($val, ENT_QUOTES) : null;
            }
            return $escaped;
        }
        return $v;
    });
$deserializer = new \a15l\serialization\deserializer\HTTPQueryStringDeserializer($dispatcher, $mdFactory);
$eventDispatcher->addSubscriber(new \a15l\serialization\request\deserializer\RequestDeserializer($deserializer));