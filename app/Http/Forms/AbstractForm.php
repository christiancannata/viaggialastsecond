<?php
/**
 * Created by PhpStorm.
 * User: christiancannata
 * Date: 23/12/15
 * Time: 14:52
 */

namespace Meritocracy\Http\Forms;


use Doctrine\Common\Annotations\AnnotationReader;
use Kris\LaravelFormBuilder\Form;

class AbstractForm extends Form
{

    public function buildForm()
    {
        die(var_dump($this->getEntityColumnValues($this->entity)));
    }

    private function getEntityColumnValues($entity)
    {

        $object = "Meritocracy\\Entity\\" . $entity;
        $entity = new $object();


        $cols = app('em')->getClassMetadata(get_class($entity))->getColumnNames();
        $values = array();

        $fields = [];
        $docReader = new AnnotationReader();
        $reflect = new \ReflectionClass($entity);


        foreach ($cols as $key => $col) {

            if (!$reflect->hasProperty($col)) {
                var_dump('the entity does not have a such property');
                continue;
            }


            $docInfos = $docReader->getPropertyAnnotations($reflect->getProperty($col));

            die(var_dump($docInfos[0]->type));


            $field = [
                "name" => $this->from_camel_case($col),
                "type" => "",
                "value" => "",
            ];
            $fields[] = $field;
        }


        return $fields;
    }


    private function from_camel_case($input)
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }
}