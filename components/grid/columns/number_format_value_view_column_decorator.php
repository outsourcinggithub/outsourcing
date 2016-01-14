<?php

class NumberFormatValueViewColumnDecorator extends CustomFormatValueViewColumnDecorator
{
    private $numberAfterDecimal;
    private $thousandsSeparator;
    private $decimalSeparator;

    public function __construct($innerField, $numberAfterDecimal, $thousandsSeparator, $decimalSeparator)
    {
        parent::__construct($innerField);
        $this->numberAfterDecimal = $numberAfterDecimal;
        $this->thousandsSeparator = $thousandsSeparator;
        $this->decimalSeparator = $decimalSeparator;
    }

    protected function GetNumberAfterDecimal()
    {
        return $this->numberAfterDecimal;
    }

    public function GetValue()
    {
        if (!$this->IsNull()) {
            return number_format(
                (double)$this->GetInnerFieldValue(),
                $this->numberAfterDecimal,
                $this->decimalSeparator,
                $this->thousandsSeparator
            );
        } else {
            return $this->GetInnerFieldValue();
        }
    }
}