<?php

namespace a15l\cmp\symfony\http\error\logger;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class HttpKernelErrorHandler
 */
class HttpKernelErrorHandler implements EventSubscriberInterface{

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var \Closure[]
     */
    private $exceptionHandler = array();

    /**
     * @var array
     */
    private $contexts = array();

    /**
     * @var string
     */
    private $notFoundTpl = '<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">'
                           . '<html><head><title>404 Not Found</title></head>'
                           . '<body><h1>Not Found</h1><p>The requested URL was not found on this server.</p>'
                           . '</body></html>';

    /**
     * @var string
     */
    private $errorTpl = '<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN"><html><head><title>500 Internal Server Error'
                        . '</title></head><body><h1>Internal Server Error</h1>'
                        . '<p>The server encountered an internal error and was unable to complete your request!</p>'
                        . '</body></html>';

    /**
     * @var \Closure
     */
    private $templateRenderer;

    /**
     * HttpKernelErrorHandler constructor.
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger){
        $this->logger = $logger;
    }

    /**
     * @param string $class
     * @param \Closure $handler
     */
    public function addExceptionHandler($class, \Closure $handler){
        $this->exceptionHandler[$class] = $handler;
    }

    /**
     * @param \Closure $renderer
     * @return self
     */
    public function setTemplateRenderer(\Closure $renderer = null){
        $this->templateRenderer = $renderer;
        return $this;
    }

    /**
     * @param array $contexts
     */
    public function addContexts(array $contexts){
        foreach ($contexts as $key => $context) {
            $this->contexts[$key] = $context;
        }
    }

    /**
     * @param \Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent $e
     */
    public function onKernelException(GetResponseForExceptionEvent $e){
        $ex = $e->getException();
        $response = new Response();
        $exClass = get_class($ex);
        if ($ex instanceof NotFoundHttpException) {
            $content = $this->getNotFoundTemplate();
            if ($this->templateRenderer !== null) {
                $renderer = $this->templateRenderer;
                $content = $renderer($ex);
            }
            if (isset($this->exceptionHandler[$exClass])) {
                $content = $this->exceptionHandler[$exClass]($ex);
            }
            $response->setContent($content);
            $e->setResponse($response);
            $this->logger->error(
                'Route not found!',
                array_merge(
                    array(
                        'message' => $ex->getMessage(),
                    ),
                    $this->contexts
                )
            );
            return;
        }
        $content = $this->getErrorTemplate();
        if ($this->templateRenderer !== null) {
            $renderer = $this->templateRenderer;
            $content = $renderer($ex);
        }
        if (isset($this->exceptionHandler[$exClass])) {
            $content = $this->exceptionHandler[$exClass]($ex);
        }
        $response->setContent($content);
        $e->setResponse($response);
        $this->logger->critical(
            'Uncaught Exception ' . $exClass . ': "' . $ex->getMessage() . '" at ' . $ex->getFile() . ' line ' .
            $ex->getLine(),
            array_merge(
                array(
                    'trace' => $ex->getTraceAsString(),
                    'exception' => $ex,
                ),
                $this->contexts
            )
        );
    }

    /**
     * @return string
     */
    public function getNotFoundTemplate(){
        return $this->notFoundTpl;
    }

    /**
     * @return string
     */
    private function getErrorTemplate(){
        return $this->errorTpl;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(){
        return array(
            KernelEvents::EXCEPTION => array(array('onKernelException', 1))
        );
    }

    /**
     * @param string $notFoundTpl
     * @return self
     */
    public function setNotFoundTpl($notFoundTpl){
        $this->notFoundTpl = $notFoundTpl;
        return $this;
    }

    /**
     * @param string $errorTpl
     * @return self
     */
    public function setErrorTpl($errorTpl){
        $this->errorTpl = $errorTpl;
        return $this;
    }
}
