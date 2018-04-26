<?php

namespace a15l\serialization\events;

class EventDispatcher implements EventDispatcherInterface{

    /**
     * @var array
     */
    private $events = array();

    /**
     * @var array
     */
    private $classEvents = array();

    /**
     * @param string $eventType serialize/deserialize/both
     * @param string $eventName The event to listen on
     * @param array $subscriber [Class, method]
     * @return EventDispatcherInterface
     */
    public function addSubscriber($eventType, $eventName, array $subscriber){
        if ($eventType === EventDispatcherInterface::EVENT_BOTH) {
            $this->events[EventDispatcherInterface::EVENT_SERIALIZE][$eventName] = $subscriber;
            $this->events[EventDispatcherInterface::EVENT_DESERIALIZE][$eventName] = $subscriber;
            return $this;
        }
        $this->events[$eventType][$eventName] = $subscriber;
        return $this;
    }

    /**
     * @param string $eventType serialize/deserialize/both
     * @param string $eventName The event to listen on
     * @param callable $listener The listener
     * @return self
     */
    public function addListener($eventType, $eventName, $listener){
        if ($eventType === EventDispatcherInterface::EVENT_BOTH) {
            $this->events[EventDispatcherInterface::EVENT_SERIALIZE][$eventName] = $listener;
            $this->events[EventDispatcherInterface::EVENT_DESERIALIZE][$eventName] = $listener;
            return $this;
        }
        $this->events[$eventType][$eventName] = $listener;
        return $this;
    }

    /**
     * @param string $eventType serialize/deserialize
     * @param $eventName
     * @param mixed $value
     * @return mixed
     */
    public function dispatch($eventType, $eventName, $value){
        if (isset($this->events[$eventType][$eventName])) {
            return call_user_func_array($this->events[$eventType][$eventName], array($value));
        }
        return $value;
    }

    /**
     * @param string $eventType
     * @param string $eventName
     * @return boolean
     */
    public function hasSubscriber($eventType, $eventName){
        return isset($this->events[$eventType][$eventName]);
    }

    /**
     * @param string $eventType
     * @param callable $listener
     * @return self
     */
    public function addClassListener($eventType, $class, $listener){
        $class = ltrim($class, '\\');
        if ($eventType === EventDispatcherInterface::EVENT_BOTH) {
            $this->classEvents[$class][EventDispatcherInterface::EVENT_SERIALIZE][] = $listener;
            $this->classEvents[$class][EventDispatcherInterface::EVENT_DESERIALIZE][] = $listener;
            return $this;
        }
        $this->classEvents[$class][$eventType][] = $listener;
        return $this;
    }

    /**
     * @param string $eventType
     * @param object|string $class
     * @param array $data
     * @return object|array
     */
    public function dispatchClass($eventType, $class, $data = []){
        $className = is_object($class) ? ltrim(get_class($class), '\\') : $class;
        $args = is_object($class) ? $class : $data;

        if (!isset($this->classEvents[$className][$eventType])) {
            return $args;
        }
        foreach ($this->classEvents[$className][$eventType] as $listener) {
            $args = call_user_func_array($listener, array($args));
        }
        return $args;
    }

    /**
     * @param string $eventType
     * @return boolean
     */
    public function hasClassListener($eventType, $class){
        return isset($this->classEvents[$class][$eventType]);
    }
}