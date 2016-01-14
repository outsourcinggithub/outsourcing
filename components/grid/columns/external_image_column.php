<?php

class ExternalImageColumn extends CustomViewColumn
{
    private $fieldName;
    private $dataset;
    private $hintTemplate;
    private $sourcePrefix;
    private $sourceSuffix;

    public function __construct($fieldName, $caption, $dataset, $hintTemplate)
    {
        parent::__construct($caption);
        $this->fieldName = $fieldName;
        $this->dataset = $dataset;
        $this->hintTemplate = $hintTemplate;
        $this->sourcePrefix = '';
        $this->sourceSuffix = '';
    }

    public function GetFieldName()
    {
        return $this->fieldName;
    }

    public function SetSourcePrefix($value)
    {
        $this->sourcePrefix = $value;
    }

    public function GetSourcePrefix()
    {
        return $this->sourcePrefix;
    }

    public function SetSourceSuffix($value)
    {
        $this->sourceSuffix = $value;
    }

    public function GetSourceSuffix()
    {
        return $this->sourceSuffix;
    }

    public function GetName()
    {
        return $this->fieldName;
    }

    /**
     * @return Dataset
     */
    public function GetDataset()
    {
        return $this->dataset;
    }

    public function GetData()
    {
        return $this->GetDataset()->GetFieldValueByName($this->fieldName);
    }

    public function GetValue()
    {
        $fieldValue = $this->GetDataset()->GetFieldValueByName($this->fieldName);
        if ($fieldValue == null) {
            return '<em class="pgui-null-value">NULL</em>';
        } else {
            return sprintf(
                '<img src="%s" alt="%s">',
                $this->sourcePrefix.$fieldValue.$this->sourceSuffix,
                FormatDatasetFieldsTemplate($this->dataset, $this->hintTemplate)
            );
        }
    }
}