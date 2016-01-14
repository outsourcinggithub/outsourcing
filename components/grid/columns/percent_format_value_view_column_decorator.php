<?php

class PercentFormatValueViewColumnDecorator extends NumberFormatValueViewColumnDecorator
{
    public function GetValue()
    {
        return parent::GetValue().'%';
    }
}
