<?php

// Validator
$diContainer->addSharedInstance(function (){
    static $validator;
    if ($validator === null) {
        $builder = \Symfony\Component\Validator\Validation::createValidatorBuilder();
        $ldr = new \a15l\cmp\symfony\validator\lazyloader\LazyXmlLoader('config/validation');
        $md = new \Symfony\Component\Validator\Mapping\Factory\LazyLoadingMetadataFactory($ldr);
        $builder->setMetadataFactory($md);
        $validator = new \a15l\cmp\symfony\validator\container\Validator($builder->getValidator());
    }
    return $validator;
}, 'a15l\cmp\symfony\validator\container\Validator');