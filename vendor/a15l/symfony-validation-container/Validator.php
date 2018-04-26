<?php


namespace a15l\cmp\symfony\validator\container;


use a15l\cmp\symfony\validator\container\exception\ValidationException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Validator{

    /**
     *
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * Validator constructor.
     * @param \Symfony\Component\Validator\Validator\ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator){
        $this->validator = $validator;
    }

    /**
     *
     * @param object $object
     * @throws ValidationException
     * @return Validator
     */
    public function validate($object){
        $violations = $this->validator->validate($object);
        if (count($violations) > 0) {
            throw new ValidationException($violations);
        }
        return $this;
    }

    /**
     *
     * @return ValidatorInterface
     */
    public function getValidator(){
        return $this->validator;
    }
}