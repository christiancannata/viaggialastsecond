<?php
/**
 * Created by PhpStorm.
 * User: christiancannata
 * Date: 15/12/15
 * Time: 10:21
 */

namespace Meritocracy\Validation;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Inflector\Inflector;
use Validator;

class DoctrineValidator
{

    protected $input;
    protected $rules;
    protected $entity;

    public function validate($input, $entityName)
    {
        $entity= new $entityName();
        $this->input = $input;
        $this->rules = $entity->getRules();


        $reader = new AnnotationReader();


      /*  $reader = new AnnotationReader();
        $reflectionObj = new \ReflectionObject(new $entityName);
        foreach(['status'] as $value) {
            $property = Inflector::camelize($value);

            if($reflectionObj->hasProperty($property)) {
                $reflectionProp = new \ReflectionProperty($entityName, $property);
                $relation = $reader->getPropertyAnnotation($reflectionProp, 'Meritocracy\\Annotations\\ApiRelation');


            }
        }


        die(); */

        return Validator::make($this->input, $this->rules);
    }
}