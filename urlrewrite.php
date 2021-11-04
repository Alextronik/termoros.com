<?php
$arUrlRewrite=array (
  22 => 
  array (
    'CONDITION' => '#^={$arResult["FOLDER"].$paths[2]."/"."(.+?)/filter/(.+?)/apply/"}\\??(.*)#',
    'RULE' => 'SECTION_CODE_PATH=$1&SMART_FILTER_PATH=$2&$3',
    'ID' => 'redreams:catalog.smart.filter',
    'PATH' => '/local/templates/termoros/components/bitrix/news/brands-tpl-2/detail.php',
    'SORT' => 100,
  ),
  1 => 
  array (
    'CONDITION' => '#^/about_company/portfolio/([A-Za-z0-9\\.\\-_]+)/#',
    'RULE' => 'ELEMENT_CODE=$1',
    'PATH' => '/about_company/portfolio/index.php',
    'SORT' => 100,
  ),
  2 => 
  array (
    'CONDITION' => '#^/online/([\\.\\-0-9a-zA-Z]+)(/?)([^/]*)#',
    'RULE' => 'alias=$1',
    'ID' => '',
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  3 => 
  array (
    'CONDITION' => '#^/video/([\\.\\-0-9a-zA-Z]+)(/?)([^/]*)#',
    'RULE' => 'alias=$1&videoconf',
    'ID' => 'bitrix:im.router',
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  4 => 
  array (
    'CONDITION' => '#^/cooperation/subpodryadchiki/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/cooperation/subpodryadchiki/index.php',
    'SORT' => 100,
  ),
  0 => 
  array (
    'CONDITION' => '#^/catalog/filter/(.+?)/apply/#',
    'RULE' => 'SMART_FILTER_PATH=$1',
    'ID' => 'bitrix:catalog.smart.filter',
    'PATH' => '/catalog/index.php',
    'SORT' => 100,
  ),
  5 => 
  array (
    'CONDITION' => '#^/technical_support/articles/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/technical_support/articles/index.php',
    'SORT' => 100,
  ),
  6 => 
  array (
    'CONDITION' => '#^/technical_support/training/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/technical_support/training/index.php',
    'SORT' => 100,
  ),
  8 => 
  array (
    'CONDITION' => '#^/bitrix/services/ymarket/#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/bitrix/services/ymarket/index.php',
    'SORT' => 100,
  ),
  9 => 
  array (
    'CONDITION' => '#^/about_company/career/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/about_company/career/index.php',
    'SORT' => 100,
  ),
  12 => 
  array (
    'CONDITION' => '#^/online/(/?)([^/]*)#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  11 => 
  array (
    'CONDITION' => '#^/buyers/promotions/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/buyers/promotions/index.php',
    'SORT' => 100,
  ),
  13 => 
  array (
    'CONDITION' => '#^/personal/order/#',
    'RULE' => '',
    'ID' => 'bitrix:sale.personal.order',
    'PATH' => '/personal/order/index.php',
    'SORT' => 100,
  ),
  15 => 
  array (
    'CONDITION' => '#^/actions/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/actions/index.php',
    'SORT' => 100,
  ),
  16 => 
  array (
    'CONDITION' => '#^/catalog/#',
    'ID' => 'bitrix:catalog',
    'PATH' => '/catalog/index.php',
    'SORT' => 100,
  ),
  17 => 
  array (
    'CONDITION' => '#^/novosti/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/novosti/index.php',
    'SORT' => 100,
  ),
  18 => 
  array (
    'CONDITION' => '#^/brands/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/brands/index.php',
    'SORT' => 100,
  ),
  19 => 
  array (
    'CONDITION' => '#^/rest/#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/bitrix/services/rest/index.php',
    'SORT' => 100,
  ),
  20 => 
  array (
    'CONDITION' => '#^/news/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/news/index.php',
    'SORT' => 100,
  ),
  21 => 
  array (
    'CONDITION' => '#^/#',
    'RULE' => '',
    'ID' => 'bitrix:main.register',
    'PATH' => '/local/templates/termoros/header.php',
    'SORT' => 100,
  ),
);
