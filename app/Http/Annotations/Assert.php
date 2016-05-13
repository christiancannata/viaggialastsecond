<?php
namespace Meritocracy\Annotations;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 */
final class ApiRelation extends Annotation
{
    public $type;

    public $class;

    public function single()
    {
        return $this->type == 'single' ? true : false;
    }

    public function multiple()
    {
        return $this->type == 'multiple' ? true : false;
    }
}