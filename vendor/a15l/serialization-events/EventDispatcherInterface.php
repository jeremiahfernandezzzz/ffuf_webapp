<?php

namespace a15l\serialization\events;

interface EventDispatcherInterface{

    const EVENT_SERIALIZE = 'serialize';
    const EVENT_DESERIALIZE = 'deserialize';
    const EVENT_BOTH = 'both';

    /**
     * @param string $eventType serialize/deserialize/both
     * @param string $eventName The event to listen on
     * @param array $subscriber [Class, method]
     * @return EventDispatcherInterface
     */
    public function addSubscriber($eventType, $eventName, array $subscriber);

    /**
     * @param string $eventType
     * @param string $class
     * @param callable $listener
     * @return self
     */
    public function addClassListener($eventType, $class, $listener);

    /**
     * @param string $eventType
     * @param string $class
     * @return boolean
     */
    public function hasClassListener($eventType, $class);

    /**
     * @param string $eventType
     * @param object|string $class
     * @param array $data
     * @return object|array
     */
    public function dispatchClass($eventType, $class, $data = []);

    /**
     * @param string $eventType serialize/deserialize/both
     * @param string $eventName The event to listen on
     * @param callable $listener The listener
     * @return self
     */
    public function addListener($eventType, $eventName, $listener);

    /**
     * @param string $eventType serialize/deserialize/both
     * @param $eventName
     * @param mixed $value
     * @return mixed
     */
    public function dispatch($eventType, $eventName, $value);

    /**
     * @param string $eventType
     * @param string $eventName
     * @return boolean
     */
    public function hasSubscriber($eventType, $eventName);
}