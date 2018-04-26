<?php


namespace a15l\cmp\symfony\validator\container\exception;


class UserInputException extends \Exception implements ValidationExceptionInterface{

    /**
     * @var string
     */
    private $propertyName;

    /**
     * UserInputException constructor.
     * @param string $message
     * @param string $propertyName
     */
    public function __construct($message, $propertyName = null){
        parent::__construct($message);
        $this->propertyName = $propertyName;
    }

    /**
     * @return string
     */
    public function getPropertyName(){
        return $this->propertyName;
    }


}