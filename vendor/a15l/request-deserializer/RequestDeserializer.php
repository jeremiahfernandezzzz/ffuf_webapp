<?php


namespace a15l\serialization\request\deserializer;


use a15l\serialization\deserializer\DeserializerInterface;
use a15l\serialization\request\deserializer\exception\MissingParameterNameException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RequestDeserializer implements EventSubscriberInterface{

    /**
     * @var \a15l\serialization\deserializer\DeserializerInterface
     */
    private $deserializer;

    /**
     * @param \a15l\serialization\deserializer\DeserializerInterface $deserializer
     */
    public function __construct(DeserializerInterface $deserializer){
        $this->deserializer = $deserializer;
    }


    public function onKernelController(FilterControllerEvent $event){
        $r = $event->getRequest();
        if (null !== ($class = $r->attributes->get('a15l.deserialize.class'))) {
            if (null === ($param = $r->attributes->get('a15l.deserialize.param'))) {
                throw new MissingParameterNameException('Target parameter name is not defined');
            }
            $data = $r->isMethod('GET') ? $r->getQueryString() : $r->getContent();
            $r->attributes->set($param, $this->deserializer->deserialize($data, $class));
        }
    }

    public static function getSubscribedEvents(){
        return array(
            KernelEvents::CONTROLLER => array(array('onKernelController', 8))
        );
    }
}