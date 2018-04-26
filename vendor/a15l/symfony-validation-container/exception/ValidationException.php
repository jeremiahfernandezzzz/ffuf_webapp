<?php


namespace a15l\cmp\symfony\validator\container\exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends \Exception implements ValidationExceptionInterface{

    /**
     *
     * @var ConstraintViolationListInterface
     */
    private $violations;

    public function __construct(ConstraintViolationListInterface $violations){
        $this->violations = $violations;
    }

    /**
     *
     * @return ConstraintViolationListInterface
     */
    public function getViolations(){
        return $this->violations;
    }

}