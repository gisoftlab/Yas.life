<?php

namespace App\Library\Exceptions;

/**
 * Class ResponseInvalidException
 * @package App\Library\Exceptions
 */
class ResponseInvalidException extends \Exception
{
    /**
     * @var \ArrayObject
     */
    private $params;

    /**
     * ResponseInvalidException constructor.
     * @param $params
     * @param $field
     */
    public function __construct($params, $field)
    {
        parent::__construct(sprintf('Response invalid field "%s" is not exist', $field), null, null);
        $this->params = new \ArrayObject($params);
    }

    public function getParams()
    {
        return $this->params;
    }
}
