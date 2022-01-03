<?php
class STATIC_MAP_DFS
{
    public static $logic = array(
        'acl' => 'AccountLicenceLogic',
        'db' => 'DBMgrLogic',
        'dev' => 'DevelopmentLogic',
        'html' => 'StaticHTMLMgrLogic',
        'upgrade' => 'UpgradeCtrlLogic',
        'city' => 'CityManageLogic',
        'url' => 'UrlManageLogic',
        'sort' => 'SortManageLogic',
        'article' => 'ArticleManageLogic',
        'attrs' => 'AttrsManageLogic',
        'reports' => 'ReportsManageLogic',
        'image' => 'ImageProcesserLogic',
        'comment' => 'CommentManageLogic'
    );
}

$aaa=&STATIC_MAP_DFS::$logic;
print_r($aaa);

