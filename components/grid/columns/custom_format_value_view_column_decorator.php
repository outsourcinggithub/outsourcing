<?php

abstract class CustomFormatValueViewColumnDecorator extends CustomViewColumn
{
    /** @var CustomDatasetFieldViewColumn */
    protected $innerField;

    public function __construct($innerField)
    {
        parent::__construct('');
        $this->innerField = $innerField;
        $this->Bold = null;

    }

    public function GetDescription()
    {
        return $this->innerField->GetDescription();
    }

    public function SetDescription($value)
    {
        $this->innerField->SetDescription($value);
    }

    public function GetName()
    {
        return $this->innerField->GetName();
    }

    public function GetData()
    {
        return $this->innerField->GetData();
    }

    protected function GetInnerFieldValue()
    {
        return $this->innerField->GetValue();
    }

    protected function IsNull()
    {
        return $this->innerField->IsNull();
    }

    public function GetInnerField()
    {
        return $this->innerField;
    }

    public function GetCaption()
    {
        return $this->innerField->GetCaption();
    }

    public function SetGrid($value)
    {
        $this->innerField->SetGrid($value);
    }

    public function GetAfterRowControl()
    {
        return $this->innerField->GetAfterRowControl();
    }

    public function GetHeaderControl()
    {
        return $this->innerField->GetHeaderControl();
    }

    public function ProcessMessages()
    {
        $this->innerField->ProcessMessages();
    }

    public function SetFixedWidth($value)
    {
        $this->innerField->SetFixedWidth($value);
    }

    public function GetFixedWidth()
    {
        return $this->innerField->GetFixedWidth();
    }

    public function IsDataColumn()
    {
        return $this->innerField->IsDataColumn();
    }

    #region Edit operation
    public function SetEditOperationColumn(CustomEditColumn $value)
    {
        $this->innerField->SetEditOperationColumn($value);
    }

    public function GetEditOperationColumn()
    {
        return $this->innerField->GetEditOperationColumn();
    }

    public function GetEditOperationEditor()
    {
        return $this->innerField->GetEditOperationEditor();
    }
    #endregion

    #region Insert operation
    public function SetInsertOperationColumn(CustomEditColumn $value)
    {
        $this->innerField->SetInsertOperationColumn($value);
    }

    public function GetInsertOperationColumn()
    {
        return $this->innerField->GetInsertOperationColumn();
    }

    public function GetInsertOperationEditor()
    {
        return $this->innerField->GetInsertOperationEditor();
    }

    public function GetGrid()
    {
        return $this->innerField->GetGrid();
    }

    public function SetOrderable($value)
    {
        if (SMReflection::IsInstanceOf($this->GetInnerField(), 'CustomDatasetFieldViewColumn')) {
            $this->GetInnerField()->SetOrderable($value);
        }
    }

    public function GetOrderable()
    {
        if (SMReflection::IsInstanceOf($this->GetInnerField(), 'CustomDatasetFieldViewColumn')) {
            return $this->GetInnerField()->GetOrderable();
        } else {
            return false;
        }
    }

    public function ShowOrderingControl()
    {
        return $this->GetInnerField()->ShowOrderingControl();
    }

    public function GetGridColumnClass()
    {
        return $this->GetInnerField()->GetGridColumnClass();
    }

    public function getMinimalVisibility()
    {
        return $this->GetInnerField()->getMinimalVisibility();
    }

    public function setMinimalVisibility($value)
    {
        $this->GetInnerField()->setMinimalVisibility($value);
    }

    public function GetViewData()
    {
        return $this->GetInnerField()->GetViewData();
    }


    #endregion
}