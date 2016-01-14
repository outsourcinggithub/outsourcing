<?php

class DownloadDataColumn extends CustomViewColumn
{
    private $dataset;
    private $fieldName;
    private $linkInnerHtml;

    public function __construct($fieldName, $caption, $dataset, $linkInnerHtml = 'download')
    {
        parent::__construct($caption);
        $this->fieldName = $fieldName;
        $this->dataset = $dataset;
        $this->linkInnerHtml = $linkInnerHtml;
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
        return $this->GetData();
    }

    public function GetLinkInnerHtml()
    {
        return $this->linkInnerHtml;
    }

    public function GetDownloadLink()
    {
        $result = $this->GetGrid()->CreateLinkBuilder();
        $result->AddParameter('hname', $this->fieldName.'_handler');
        AddPrimaryKeyParameters($result, $this->GetDataset()->GetPrimaryKeyValues());

        return $result->GetLink();
    }

    /**
     * @param Renderer $renderer
     * @return void
     */
    public function Accept($renderer)
    {
        $renderer->RenderDownloadDataColumn($this);
    }

    public function IsDataColumn()
    {
        return false;
    }
}