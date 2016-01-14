<?php

class DivTagViewColumnDecorator extends CustomFormatValueViewColumnDecorator
{
    public $Bold;
    public $Italic;
    public $CustomAttributes;
    public $Align;

    public function __construct($innerField)
    {

        parent::__construct($innerField);
        $this->Bold = null;
        $this->Italic = null;
        $this->CustomAttributes = null;
        $this->innerField = $innerField;
    }

    //TODO: remove
    public function GetValue()
    {
        return $this->GetInnerField()->GetValue();
    }

    /**
     * @param Renderer $renderer
     * @return void
     */
    public function Accept($renderer)
    {
        $renderer->RenderDivTagViewColumnDecorator($this);
    }

    public function GetAlign()
    {
        return $this->Align;
    }
}