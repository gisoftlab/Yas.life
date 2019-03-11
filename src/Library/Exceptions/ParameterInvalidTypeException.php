<?php

namespace App\Library\Exceptions;

/**
 * Class ParameterInvalidTypeException
 * @package App\Library\Exceptions
 */
class ParameterInvalidTypeException extends \Exception
{
    /**
     * @var string $paramName
     */
    private $paramName;

    /**
     * @var string $paramName
     */
    private $paramType;

    /**
     * @var string $paramName
     */
    private $expectedType;

    const TYPE_INT = "int";
    const TYPE_STRING = "string";
    const TYPE_ARRAY = "array";

    /**
     * ParameterInvalidTypeException constructor.
     * @param $paramName
     * @param $paramType
     * @param $expectedType
     */
    public function __construct($paramName, $paramType, $expectedType)
    {
        $this->paramType = $paramType;
        $this->expectedType = $expectedType;
        $this->paramName = $paramName;
        parent::__construct(
            sprintf('param "%s" invalid, expected type: %s, current is: %s)', $paramName, $expectedType, $paramType),
            null,
            null
        );
    }

    /**
     * @return string
     */
    public function getParamName()
    {
        return $this->paramName;
    }

    /**
     * @return string
     */
    public function getExpectedType()
    {
        return $this->expectedType;
    }

    /**
     * @return string
     */
    public function getParamType()
    {
        return $this->paramType;
    }
}