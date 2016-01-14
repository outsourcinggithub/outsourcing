<?php

class DateTimeViewColumn extends CustomDatasetFieldViewColumn
{
    private $dateTimeFormat;

    public function __construct($fieldName, $caption, $dataset, $orderable = true)
    {
        parent::__construct($fieldName, $caption, $dataset, $orderable);
        $this->dateTimeFormat = 'Y-m-d';
    }

    public function SetDateTimeFormat($value)
    {
        $this->dateTimeFormat = $value;
    }

    public function GetDateTimeFormat()
    {
        return $this->dateTimeFormat;
    }

    public function GetOSDateTimeFormat()
    {
        return ServerToClientConvertFormatDate($this->dateTimeFormat);
    }

    protected function DoGetValue()
    {
        $value = $this->GetDataset()->GetFieldValueByNameAsDateTime($this->GetName());

        $stringValue = isset($value) ? $value->ToString($this->dateTimeFormat) : null;
        $dataset = $this->GetDataset();
        $this->BeforeColumnRender->Fire(array(&$stringValue, &$dataset));

        return isset($stringValue) ? $stringValue : 'NULL';
    }
}