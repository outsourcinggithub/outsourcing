<?php

class CurrencyFormatValueViewColumnDecorator extends NumberFormatValueViewColumnDecorator
{
    private $currencySign;

    public function __construct(
        $innerField,
        $numberAfterDecimal,
        $thousandsSeparator,
        $decimalSeparator,
        $currencySign = '$'
    ) {
        parent::__construct($innerField, $numberAfterDecimal, $thousandsSeparator, $decimalSeparator);
        $this->currencySign = $currencySign;
    }

    public function GetValue()
    {
        if (!$this->IsNull()) {
            return $this->currencySign.parent::GetValue();
        } else {
            return $this->GetInnerFieldValue();
        }
    }
}