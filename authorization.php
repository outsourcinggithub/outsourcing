<?php

require_once 'phpgen_settings.php';
require_once 'components/security/security_info.php';
require_once 'components/security/datasource_security_info.php';
require_once 'components/security/tablebased_auth.php';
require_once 'components/security/user_grants_manager.php';
require_once 'components/security/table_based_user_grants_manager.php';

include_once 'components/security/user_identity_storage/user_identity_session_storage.php';

require_once 'database_engine/mysql_engine.php';

$grants = array('guest' => 
        array()
    ,
    'defaultUser' => 
        array('planificacion' => new DataSourceSecurityInfo(false, false, false, false),
        'planificacion.actividad' => new DataSourceSecurityInfo(false, false, false, false),
        'planificacion.objeto_planificacion' => new DataSourceSecurityInfo(true, true, true, true),
        'actividad' => new DataSourceSecurityInfo(false, false, false, false),
        'objeto_planificacion' => new DataSourceSecurityInfo(true, true, true, true),
        'objeto_refactorizacion' => new DataSourceSecurityInfo(true, true, true, true))
    ,
    'administrador' => 
        array('planificacion' => new DataSourceSecurityInfo(false, false, false, false),
        'planificacion.actividad' => new DataSourceSecurityInfo(false, false, false, false),
        'planificacion.objeto_planificacion' => new DataSourceSecurityInfo(false, false, false, false),
        'actividad' => new DataSourceSecurityInfo(false, false, false, false),
        'objeto_planificacion' => new DataSourceSecurityInfo(false, false, false, false),
        'objeto_refactorizacion' => new DataSourceSecurityInfo(false, false, false, false))
    ,
    'usuario' => 
        array('planificacion' => new DataSourceSecurityInfo(false, false, false, false),
        'planificacion.actividad' => new DataSourceSecurityInfo(false, false, false, false),
        'planificacion.objeto_planificacion' => new AdminDataSourceSecurityInfo(),
        'actividad' => new DataSourceSecurityInfo(false, false, false, false),
        'objeto_planificacion' => new DataSourceSecurityInfo(false, false, false, false),
        'objeto_refactorizacion' => new AdminDataSourceSecurityInfo())
    );

$appGrants = array('guest' => new DataSourceSecurityInfo(false, false, false, false),
    'defaultUser' => new DataSourceSecurityInfo(true, false, false, false),
    'administrador' => new AdminDataSourceSecurityInfo(),
    'usuario' => new DataSourceSecurityInfo(true, false, false, false));

$dataSourceRecordPermissions = array();

$tableCaptions = array('planificacion' => 'Planificación',
'planificacion.actividad' => 'Planificación.Actividades',
'planificacion.objeto_planificacion' => 'Planificación.Objetos a Aplicar',
'actividad' => 'Actividad',
'objeto_planificacion' => 'Objetos Planificación',
'objeto_refactorizacion' => 'Objetos Refactorización');

function CreateTableBasedGrantsManager()
{
    return null;
}

function SetUpUserAuthorization()
{
    global $grants;
    global $appGrants;
    global $dataSourceRecordPermissions;
    $hardCodedGrantsManager = new HardCodedUserGrantsManager($grants, $appGrants);
    $tableBasedGrantsManager = CreateTableBasedGrantsManager();
    $grantsManager = new CompositeGrantsManager();
    $grantsManager->AddGrantsManager($hardCodedGrantsManager);
    if (!is_null($tableBasedGrantsManager)) {
        $grantsManager->AddGrantsManager($tableBasedGrantsManager);
        GetApplication()->SetUserManager($tableBasedGrantsManager);
    }
    $userAuthorizationStrategy = new TableBasedUserAuthorization(new UserIdentitySessionStorage(GetIdentityCheckStrategy()), new MySqlIConnectionFactory(), GetGlobalConnectionOptions(), 'phpgen_users', 'user_name', 'user_id', $grantsManager);
    GetApplication()->SetUserAuthorizationStrategy($userAuthorizationStrategy);

    GetApplication()->SetDataSourceRecordPermissionRetrieveStrategy(
        new HardCodedDataSourceRecordPermissionRetrieveStrategy($dataSourceRecordPermissions));
}

function GetIdentityCheckStrategy()
{
    return new TableBasedIdentityCheckStrategy(new MySqlIConnectionFactory(), GetGlobalConnectionOptions(), 'phpgen_users', 'user_name', 'user_password', 'SHA1');
}

function CanUserChangeOwnPassword()
{
    return false;
}

?>