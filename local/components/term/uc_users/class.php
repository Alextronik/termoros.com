<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use \Bitrix\Main\Loader;
use \Bitrix\Main\Application;
use Bitrix\Main\Engine\ActionFilter;
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\UI\PageNavigation;
use Bitrix\Main\UserTable;

Loc::loadMessages(__FILE__);

class UCUsers extends CBitrixComponent implements Controllerable
{
    private $_request;
    protected $name = "uc_users";
    protected $csv_path = '/temp.csv';
    protected $xml_path = '/temp.xml';

    public function onPrepareComponentParams($arParams) {
        return $arParams;
    }

    public function executeComponent()
    {
        if ($this->startResultCache($this->arParams["CACHE_TIME"], SITE_ID . "-" . $this->name, $this->name)) {
            $this->_request = Application::getInstance()->getContext()->getRequest();

            $this->arResult = $this->makeResult();

            $this->includeComponentTemplate();
        }
        return $this->arResult;
    }

    /**
     * @return array
     */
    protected function makeResult()
    {
        $nav = new PageNavigation("nav-grid-users");
        $nav->allowAllRecords(true)->setPageSize(10)->initFromUri();


        $dbUser = UserTable::getList(array(
            'select' => array('ID', 'NAME', 'EMAIL'),
            "count_total" => true,
            'offset' => $nav->getOffset(),
            'limit' => $nav->getLimit(),
            'cache' => array('ttl' => 86400, 'cache_joins' => true)
        ));

        $nav->setRecordCount($dbUser->getCount());

        $ar = [];
        while ($arRes = $dbUser->fetch()) {
            $cols = array(
                "ID" => $arRes["ID"],
                "NAME" => $arRes["NAME"],
                "EMAIL" => $arRes["EMAIL"],
            );

            $rows[] = array(
                "columns" => $cols,
            );
            $ar['USERS'] = $rows;
        }
        $ar['NAV'] = $nav;
        $ar['COUNT'] = $dbUser->getCount();
        $ar['FILES']['CSV'] = $this->csv_path;
        $ar['FILES']['XML'] = $this->xml_path;

        return $ar;
    }

    /**
     * @return array
     */
    protected function makeVirtualUsers()
    {
        $ar = [];
        for ($x = 200000; $x < 400000; $x++) {
            $user = ["ID" => (string)$x, 'NAME' => 'username' . $x, 'EMAIL' => 'username' . $x . "@gmail.com"];
            $ar[] = $user;
        }

        return $ar;
    }

    /**
     * make csv & xml files
     */
    protected function checkFiles()
    {
        $filemtimeCSV = time() - filemtime($_SERVER['DOCUMENT_ROOT'] . $this->csv_path);
        $filemtimeXML = time() - filemtime($_SERVER['DOCUMENT_ROOT'] . $this->xml_path);
        //if($filemtimeCSV > 86400 || $filemtimeXML > 86400){
        $dbUser = UserTable::getList(array(
            'select' => array('ID', 'NAME', 'EMAIL'),
            'cache' => array('ttl' => 86400, 'cache_joins' => true)
        ));
        $ar = [];
        while ($arRes = $dbUser->fetch()) {
            $ar[] = $arRes;
        }

        //if($filemtimeCSV > 86400) $this->makeCSV($ar);
        //if($filemtimeXML > 86400) $this->makeXML($ar);

        if (1 > 0) {
            $arV = $this->makeVirtualUsers();
            $finalAr = array_merge($ar,$arV);
        } else $finalAr = $ar;

        $this->makeCSV($finalAr);
        $this->makeXML($finalAr);
        //}

        return;
    }

    /**
     * @param $ar
     */
    protected function makeCSV($ar)
    {
        $csv_file = fopen($_SERVER['DOCUMENT_ROOT'] . $this->csv_path, 'w');
        fputcsv($csv_file, ["ID", "NAME", "EMAIL"], ';');
        foreach ($ar as $k => $v) {
            fputcsv($csv_file, $v, ';');
        }
        fclose($csv_file);

        return;
    }

    /**
     * @param $ar
     */
    protected function makeXML($ar)
    {
        $xml = new DOMDocument("1.0");
        $users = $xml->createElement("users");
        $xml->appendChild($users);
        foreach ($ar as $k => $v) {
            $user = $xml->createElement("user");
            $users->appendChild($user);

            $id = $xml->createElement("id", $v['ID']);
            $user->appendChild($id);

            $uname = $xml->createElement("name", $v['NAME']);
            $user->appendChild($uname);

            $email = $xml->createElement("email", $v['EMAIL']);
            $user->appendChild($email);
        }
        $xml->save($_SERVER['DOCUMENT_ROOT'] . $this->xml_path);
        return;
    }

    /**
     * @return array
     */
    public function configureActions()
    {
        return [
            'ajax' => [
                'prefilters' => [
                    new ActionFilter\Authentication(),
                    new ActionFilter\HttpMethod(
                        array(ActionFilter\HttpMethod::METHOD_GET, ActionFilter\HttpMethod::METHOD_POST)
                    ),
                    new ActionFilter\Csrf(),
                ],
                'postfilters' => []
            ]
        ];
    }

    /**
     * @param string $param1
     * @return mixed
     */
    public function ajaxAction($param1 = '')
    {
        if ($param1 == 'dfile_csv' || $param1 == 'dfile_xml') {
            $this->checkFiles();
            $file = ($param1 == 'dfile_csv') ? $this->csv_path : $this->xml_path;
            return ['download' => true, 'file' => $file];
        } else return false;
    }
}