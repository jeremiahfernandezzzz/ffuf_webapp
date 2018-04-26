<?php


namespace a15l\serialization\request\deserializer;


use a15l\serialization\deserializer\DeserializerInterface;
use a15l\serialization\request\deserializer\exception\MissingFormatException;
use a15l\serialization\request\deserializer\exception\MissingParameterNameException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RestRequestDeserializer implements EventSubscriberInterface{

    /**
     * @var DeserializerInterface[]
     */
    private $deserializer = array();

    /**
     * @param string $format
     * @param \a15l\serialization\deserializer\DeserializerInterface $deserializer
     */
    public function addDeserializer($format, DeserializerInterface $deserializer){
        $this->deserializer[$format] = $deserializer;
    }

    public function onKernelController(FilterControllerEvent $event){
        $request = $event->getRequest();
        if (null !== ($class = $request->attributes->get('a15l.deserialize.class'))) {
            if (null === ($param = $request->attributes->get('a15l.deserialize.param'))) {
                throw new MissingParameterNameException('Parameter name is not defined');
            }
            $format = $request->attributes->get('a15l.rest.request.format');
            if (!isset($this->deserializer[$format])) {
                throw new MissingFormatException("No deserializer defined for the format: '" . $format . "'");
            }
            $data = $request->isMethod('GET') ? $request->getQueryString() : $request->getContent();
            $request->attributes->set($param, $this->deserializer[$format]->deserialize($data, $class));
        }
    }

    public static function getSubscribedEvents(){
        return array(
            KernelEvents::CONTROLLER => array(array('onKernelController', 8))
        );
    }

}