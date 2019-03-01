<?php

namespace App\Exception;

/**
 * @package App\Exception
 */
class ResourceValidationException extends \Exception implements ExceptionInterface
{

    protected $fields;

    /**
     * @return mixed
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param mixed $fields
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
    }
}
