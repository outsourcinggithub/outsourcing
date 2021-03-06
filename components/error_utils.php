<?php

include_once dirname(__FILE__) . '/../libs/smartylibs/Smarty.class.php';
include_once dirname(__FILE__) . '/renderers/list_renderer.php';
include_once dirname(__FILE__) . '/common_page.php';
include_once dirname(__FILE__) . '/captions.php';

function RaiseError($message = '')
{
    @session_destroy();
    throw new Exception($message);
}

function RaiseCannotRetrieveSingleRecordError() {
    RaiseError('Cannot retrieve single record. Check the primary key fields.');
}

/**
 * @param Page $parentPage
 * @param string $message
 */
function ShowSecurityErrorPage($parentPage, $message)
{
    $urlToRedirect = '';
    if ($parentPage instanceof Page) {
        $linkBuilder = $parentPage->CreateLinkBuilder();
        GetApplication()->GetSuperGlobals()->fillGetParams($linkBuilder);
        $urlToRedirect = '?redirect='.urlencode($linkBuilder->GetLink());
    }

    $renderer = new ViewAllRenderer($parentPage->GetLocalizerCaptions());
    $errorPage = new CustomErrorPage(
        $parentPage->GetLocalizerCaptions()->GetMessageString('AccessDenied'),
        $parentPage->GetContentEncoding(),
        $message,
        sprintf($parentPage->GetLocalizerCaptions()->GetMessageString('AccessDeniedErrorSuggestions'),
            'login.php'.$urlToRedirect),
        $parentPage
    );
    echo $renderer->Render($errorPage);
}

function RaiseSecurityError($parentPage, $message = '')
{
    @session_destroy();
    ShowSecurityErrorPage($parentPage, $message);
    exit;
}

function ShowErrorPage($message)
{
    $smarty = new Smarty();
    $smarty->template_dir = '/components/templates';
    $smarty->assign('Message', $message);
    $captions = GetCaptions('UTF-8');
    $smarty->assign('Captions', $captions);

    $common = new CommonPageViewData();
    $common
        ->setTitle($captions->GetMessageString('Error'))
        ->setHeader(GetPagesHeader())
        ->setFooter(GetPagesFooter());
      
    $smarty->assign('common', $common);

    $smarty->display('error_page.tpl');
}

class CustomErrorPage extends CommonPage
{
    private $parentPage;
    private $message;
    private $description;

    /**
     * @param string $caption
     * @param string $contentEncoding
     * @param string $message
     * @param string $description
     * @param Page   $parentPage
     */
    public function __construct($caption, $contentEncoding, $message, $description, $parentPage)
    {
        parent::__construct($caption, $contentEncoding);
        $this->parentPage = $parentPage;
        $this->message = $message;
        $this->description = $description;
    }

    public function GetContentEncoding() { return $this->parentPage->GetContentEncoding(); }
    public function GetHeader() { return $this->parentPage->GetHeader(); }
    public function GetFooter() { return $this->parentPage->GetFooter(); }

    public function GetMessage() { return $this->message; }
    public function GetDescription() { return $this->description; }

    public function GetCommonViewData() {
        return $this->parentPage->GetCommonViewData()
            ->setCustomHead('')
            ->setTitle($this->getCaption());
    }

    public function GetAuthenticationViewData() {
        return $this->parentPage->GetAuthenticationViewData();
    }

    /**
     * @param Renderer $renderer
     */
    public function Accept($renderer)
    {
        $renderer->RenderCustomErrorPage($this);
    }

    public function GetValidationScripts()
    {
        return '';
    }

    public function GetReadyPageList()
    {
        return null;
    }

    public function GetPageFileName() {
        return '';
    }

}

?>