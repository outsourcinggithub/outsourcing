<?php

class CheckBoxFormatValueViewColumnDecorator extends CustomFormatValueViewColumnDecorator
{
    private $trueValue;
    private $falseValue;

    public function GetValue()
    {
        $value = $this->GetInnerField()->GetDataset()->GetFieldValueByName($this->GetName());
        if (!isset($value)) {
            return $this->GetInnerFieldValue();
        } else {
            if (empty($value)) {
                return '<input type="checkbox" onclick="return false;">';
            } else {
                return '<input type="checkbox" checked="checked" onclick="return false;">';
            }
        }
    }

    public function SetDisplayValues($trueValue, $falseValue)
    {
        $this->trueValue = $trueValue;
        $this->falseValue = $falseValue;
    }

    public function GetTrueValue()
    {
        return $this->trueValue;
    }

    public function GetFalseValue()
    {
        return $this->falseValue;
    }

    /**
     * @param Renderer $renderer
     * @return void
     */
    public function Accept($renderer)
    {
        $renderer->RenderCheckBoxViewColumn($this);
    }

    public function IsDataColumn()
    {
        return false;
    }
}