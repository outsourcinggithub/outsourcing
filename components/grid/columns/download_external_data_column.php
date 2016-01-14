<?php

class DownloadExternalDataColumn extends CustomViewColumn
{
    private $fieldName;
    private $dataset;
    private $downloadTextTemplate;
    private $downloadLinkHintTemplate;

    private $sourcePrefix;
    private $sourceSuffix;
    private $captions;


    public function __construct(
        $fieldName,
        $caption,
        $dataset,
        $downloadTextTemplate,
        Captions $captions,
        $downloadLinkHintTemplate = ''
    ) {
        parent::__construct($caption);
        $this->fieldName = $fieldName;
        $this->dataset = $dataset;
        $this->downloadTextTemplate = $downloadTextTemplate;
        $this->downloadLinkHintTemplate = $downloadLinkHintTemplate;
        $this->captions = $captions;
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

    public function GetValue()
    {
        $fieldValue = $this->GetDataset()->GetFieldValueByName($this->fieldName);
        if ($fieldValue == null) {
            return '<em class="pgui-null-value">NULL</em>';
        } else {
            return StringUtils::Format(
                '<i class="icon-download"></i>&nbsp;'.
                '<a target="_blank" title="%s" href="%s">%s</a>',
                FormatDatasetFieldsTemplate($this->dataset, $this->downloadLinkHintTemplate),
                $this->sourcePrefix.$fieldValue.$this->sourceSuffix,
                $this->captions->GetMessageString('Download')
            );
        }
    }
}