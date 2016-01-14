<?php

class ExtendedHyperLinkColumnDecorator extends CustomFormatValueViewColumnDecorator
{
    private $template;
    private $target;
    private $dataset;

    public function __construct($innerField, $dataset, $template, $target = '_blank')
    {
        parent::__construct($innerField);
        $this->template = $template;
        $this->target = $target;
        $this->dataset = $dataset;
    }

    public function GetLink()
    {
        return FormatDatasetFieldsTemplate($this->dataset, $this->template);
    }

    public function GetTarget()
    {
        return $this->target;
    }

    // TODO: delete
    public function GetValue()
    {
        return sprintf(
            '<a href="%s" target="%s">%s</a>',
            $this->GetLink(),
            $this->target,
            $this->GetInnerFieldValue()
        );
    }

    /**
     * @param Renderer $renderer
     * @return void
     */
    public function Accept($renderer)
    {
        $renderer->RenderExtendedHyperLinkColumnDecorator($this);
    }
}