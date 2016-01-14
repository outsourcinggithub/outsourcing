<?php

class DetailColumn extends CustomViewColumn
{
    private $masterKeyFields;
    private $separatePageHandlerName;
    private $inlinePageHandlerName;
    private $dataset;
    private $name;
    private $frameRandomNumber;

    public function __construct(
        $masterKeyFields,
        $name,
        $separatePageHandlerName,
        $inlinePageHandlerName,
        Dataset $dataset,
        $caption,
        $tabCaption
    ) {
        parent::__construct($caption);
        $this->masterKeyFields = $masterKeyFields;
        $this->name = $name;
        $this->separatePageHandlerName = $separatePageHandlerName;
        $this->inlinePageHandlerName = $inlinePageHandlerName;
        $this->dataset = $dataset;
        $this->frameRandomNumber = Random::GetIntRandom();
        $this->dataset->OnNextRecord->AddListener('NextRecordHandler', $this);
        $this->tabCaption = $tabCaption;
    }

    public function GetSeparatePageHandlerName()
    {
        return $this->separatePageHandlerName;
    }

    public function NextRecordHandler($sender)
    {
        $this->frameRandomNumber = Random::GetIntRandom();
    }

    public function GetName()
    {
        return '';
    }

    public function GetDataset()
    {
        return $this->dataset;
    }

    public function GetData()
    {
        return null;
    }

    private function GetDetailsControlSuffix()
    {
        return $this->frameRandomNumber;
    }

    public function GetLink()
    {
        $linkBuilder = $this->GetGrid()->CreateLinkBuilder();
        $linkBuilder->AddParameter('detailrow', 'DetailContent_'.$this->name.'_'.$this->GetDetailsControlSuffix());
        $linkBuilder->AddParameter('hname', $this->inlinePageHandlerName);
        for ($i = 0; $i < count($this->masterKeyFields); $i++) {
            $linkBuilder->AddParameter('fk'.$i, $this->GetDataset()->GetFieldValueByName($this->masterKeyFields[$i]));
        }

        return $linkBuilder->GetLink();
    }


    public function DecorateLinkForPostMasterRecord(LinkBuilder $linkBuilder)
    {
        $linkBuilder->AddParameter('details-redirect', $this->separatePageHandlerName);
    }

    public function GetSeparateViewLink()
    {
        $linkBuilder = $this->GetGrid()->CreateLinkBuilder();
        $linkBuilder->AddParameter('hname', $this->separatePageHandlerName);
        for ($i = 0; $i < count($this->masterKeyFields); $i++) {
            $linkBuilder->AddParameter('fk'.$i, $this->GetDataset()->GetFieldValueByName($this->masterKeyFields[$i]));
        }

        return $linkBuilder->GetLink();
    }

    public function GetAfterRowControl()
    {
        return new CustomHtmlControl(
            '<iframe class="hidden"'.
            ' id="DetailFrame_'.$this->name.'_'.$this->GetDetailsControlSuffix().'"'.
            ' name="DetailFrame_'.$this->name.'_'.$this->GetDetailsControlSuffix().'"'.
            ' style="width:100%"></iframe>'.
            '<div class="hidden" id="DetailContent_'.$this->name.'_'.$this->GetDetailsControlSuffix().'"></div>'
        );
    }

    public function GetValue()
    {
        return
            '<a class="page_link" onclick="expand('.
            '\'DetailFrame_'.$this->name.'_'.$this->GetDetailsControlSuffix().'\', '.
            '\'DetailContent_'.$this->name.'_'.$this->GetDetailsControlSuffix().'\', '.
            '\'ExpandImage_'.$this->name.'_'.$this->GetDetailsControlSuffix().'\', '.
            'this);" href="'.$this->GetLink().'">'.
            '<img id="ExpandImage_'.$this->name.'_'.$this->GetDetailsControlSuffix(
            ).'" src="images/expand.gif" class="collapsed">'.
            '</a>&nbsp;'.
            '<a class="page_link" href="'.$this->GetSeparateViewLink().'">'.$this->GetCaption().'</a>';
    }

    public function GetViewData()
    {
        $result = array(
            'caption' => $this->GetCaption(),
            'tabCaption' => $this->tabCaption,
            'gridLink' => $this->GetLink(),
            'SeperatedPageLink' => $this->GetSeparateViewLink(),
            'detailId' => 'detail-'.$this->GetDetailsControlSuffix()
        );

        return $result;
    }
}