<?php

abstract class CustomDatasetFieldViewColumn extends CustomViewColumn
{
    /** @var string */
    private $fieldName;

    /** @var Dataset */
    private $dataset;

    /** @var bool */
    private $orderable;

    /** @var Dataset|null */
    private $lookupDataset;

    #region Events
    public $BeforeColumnRender;

    #endregion

    public function __construct($fieldName, $caption, $dataset, $orderable = true)
    {
        parent::__construct($caption);
        $this->BeforeColumnRender = new Event();
        //
        $this->fieldName = $fieldName;
        $this->dataset = $dataset;
        $this->orderable = $orderable;
        $this->lookupDataset = null;
        $this->lookupHandlerName = null;
    }

    public function SetLookupDataset(Dataset $dataset)
    {
        $this->lookupDataset = $dataset;
    }

    public function GetLookupDataset()
    {
        return $this->lookupDataset;
    }

    public function GetLookupHandlerName()
    {
        return $this->lookupHandlerName;
    }

    public function RegisterLookupHTTPHandler($parentPageName, $idField, $valueField)
    {
        $this->lookupHandlerName = $parentPageName.'_'.$this->fieldName.'_search';
        GetApplication()->RegisterHTTPHandler(
            new DynamicSearchHandler(
                $this->lookupDataset,
                null,
                $this->lookupHandlerName,
                $idField,
                $valueField,
                null
            )
        );
    }

    public function SetOrderable($value)
    {
        $this->orderable = $value;
    }

    public function GetOrderable()
    {
        return $this->orderable;
    }

    protected function GetFieldName()
    {
        return $this->fieldName;
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
        return $this->GetDataset()->GetFieldValueByName($this->GetFieldName());
    }

    protected abstract function DoGetValue();

    public function GetValue()
    {
        $result = $this->GetData();

        return isset($result) ? $this->DoGetValue() : null;
    }

    /**
     * @param Renderer $renderer
     * @return void
     */
    public function Accept($renderer)
    {
        $renderer->RenderCustomDatasetFieldViewColumn($this);
    }

    public function ShowOrderingControl()
    {
        if ($this->GetGrid() != null) {
            return $this->GetOrderable() && $this->GetGrid()->GetAllowOrdering();
        } else {
            return $this->GetOrderable();
        }
    }

    protected function CreateHeaderControl()
    {
        if ($this->ShowOrderingControl()) {
            $result = new HintedTextBox('HeaderControl', $this->GetCaption());
            $result->SetHint($this->GetDescription());

            return $result;
        } else {
            return parent::CreateHeaderControl();
        }
    }

    protected function GetActualKeys()
    {
        $keys = array(
            'Primary' => false,
            'Foreign' => false
        );

        if ($this->GetGrid()->GetShowKeyColumnsImagesInHeader()) {
            if ($this->dataset->IsFieldPrimaryKey($this->fieldName)) {
                $keys['Primary'] = true;
            }
            if ($this->dataset->IsLookupField($this->fieldName)) {
                $keys['Foreign'] = true;

                if ($this->dataset->IsLookupFieldNameByDisplayFieldName($this->fieldName)) {
                    if ($this->dataset->IsFieldPrimaryKey(
                        $this->dataset->IsLookupFieldNameByDisplayFieldName($this->fieldName)
                    )
                    ) {
                        $keys['Primary'] = true;
                    }
                }
            }
        }

        return $keys;
    }

    protected function getSortIndex()
    {
        return $this->GetGrid()->getSortIndexByFieldName($this->fieldName);
    }

    protected function getSortOrderType()
    {
        return $this->GetGrid()->getSortOrderTypeByFieldName($this->fieldName);
    }

    public function IsDataColumn()
    {
        return true;
    }
}
