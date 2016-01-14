<?php

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *                                   ATTENTION!
 * If you see this message in your browser (Internet Explorer, Mozilla Firefox, Google Chrome, etc.)
 * this means that PHP is not properly installed on your web server. Please refer to the PHP manual
 * for more details: http://php.net/manual/install.php 
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 */

include_once dirname(__FILE__) . '/' . 'authorization.php';

include_once dirname(__FILE__) . '/' . 'components/application.php';
include_once dirname(__FILE__) . '/' . 'components/error_utils.php';

include_once dirname(__FILE__) . '/' . 'components/utils/system_utils.php';
include_once dirname(__FILE__) . '/' . 'components/utils/string_utils.php';

include_once dirname(__FILE__) . '/' . 'components/security/base_user_auth.php';
include_once dirname(__FILE__) . '/' . 'components/security/table_based_user_grants_manager.php';

SetUpUserAuthorization();

class AdminPage extends CommonPage
{
    /** @var TableBasedUserGrantsManager */
    private $tableBasedGrantsManager;

    public function __construct($tableBasedGrantsManager)
    {
        parent::__construct($this->GetCaption(), 'UTF-8');
        $this->tableBasedGrantsManager = $tableBasedGrantsManager;
        $this->OnGetCustomTemplate = new Event();
    }

    public function GetAllUsersAsJson()
    {
        return $this->tableBasedGrantsManager->GetAllUsersAsJson();
    }

    public function GetAuthenticationViewData() {
        return array(
            'Enabled' => true,
            'LoggedIn' => GetApplication()->IsCurrentUserLoggedIn(),
            'CurrentUser' => array(
                'Name' => GetApplication()->GetCurrentUser(),
                'Id' => GetApplication()->GetCurrentUserId(),
            ),
            'isAdminPanelVisible' => HasAdminPage() && GetApplication()->HasAdminGrantForCurrentUser(),
        );
    }

    public function GetReadyPageList()
    {
        return PageList::createForPage($this);
    }

    public function Accept(Renderer $renderer)
    {
        $renderer->RenderAdminPage($this);
    }

    private function GetCurrentPageMode() {
        switch (GetApplication()->GetOperation()) {
            case OPERATION_VIEWALL:
                return PageMode::ViewAll;
        }
        return null;
    }

    public function GetCustomTemplate($part, $mode, $defaultValue, &$params = null) {
        $result = null;

        if (!$mode) // for PageList
            $mode = $this->GetCurrentPageMode();
        if (!$params)
            $params = array();

        $this->OnGetCustomTemplate->Fire(array($part, $mode, &$result, &$params, $this));
        if ($result)
            return Path::Combine('custom_templates', $result);
        else
            return $defaultValue;
    }

    public function GetShowPageList()
    {
        return true;
    }

    public function GetShortCaption()
    {
        return $this->GetCaption();
    }

    public function GetCaption()
    {
        return $this->GetLocalizerCaptions()->GetMessageString('AdminPage');
    }

    public function GetPageFileName() {
        return basename(__FILE__);
    }

}

$tableBasedGrants = CreateTableBasedGrantsManager();

$page = new AdminPage($tableBasedGrants);
$page->setHeader(GetPagesHeader());
$page->setFooter(GetPagesFooter());
$page->OnGetCustomTemplate->AddListener('Global_GetCustomTemplateHandler');

if (!GetApplication()->GetUserAuthorizationStrategy()->HasAdminGrant(GetApplication()->GetCurrentUser()))
{
    RaiseSecurityError($page, 'You do not have permission to access this page.');
}


$renderer = new ViewRenderer($page->GetLocalizerCaptions());
echo $renderer->Render($page);