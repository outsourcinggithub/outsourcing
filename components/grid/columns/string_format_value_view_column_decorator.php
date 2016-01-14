<?php

class StringFormatValueViewColumnDecorator extends CustomFormatValueViewColumnDecorator
{
    private $stringTransaformFunction;

    private function TransformString($string)
    {
        if (function_exists($this->stringTransaformFunction)) {
            return call_user_func($this->stringTransaformFunction, $string);
        } else {
            return $string;
        }
    }

    public function __construct($innerField, $stringTransaformFunction)
    {
        parent::__construct($innerField);
        $this->stringTransaformFunction = $stringTransaformFunction;
    }

    public function GetValue()
    {
        return $this->TransformString($this->GetInnerFieldValue());
    }
}