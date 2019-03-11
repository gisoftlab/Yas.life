<?php

namespace App\Library\Exceptions;

/**
 * Class ResponseNotFoundException
 * @package App\Library\Exceptions
 */
class ResponseNotFoundException extends \Exception
{
    /**
     * @var \ArrayObject
     */
    private $params;

    /**
     * ResponseNotFoundException constructor.
     * @param $param
     */
    public function __construct($param)
    {
        parent::__construct('Response not found for '.$param);
    }

    public function getParam()
    {
        return $this->param;
    }
}
