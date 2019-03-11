<?php

namespace App\Library\Exceptions;

/**
 * Class ParameterMissingException
 * @package App\Library\Exceptions
 */
class ParameterMissingException extends \Exception
{
    /**
     * @var string $paramName
     */
    private $paramName;

    /**
     * ParameterMissingException constructor.
     * @param $paramName
     */
    public function __construct($paramName)
    {
        $this->paramName = $paramName;
        parent::__construct(sprintf('param "%s" missing e.g.:(Spain)', $paramName), null, null);
    }

    /**
     * @return string
     */
    public function getParamName()
    {
        return $this->paramName;
    }
}
