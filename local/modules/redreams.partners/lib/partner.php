<?php
/**
 * Created by PhpStorm.
 * User: bearl
 * Date: 05.07.2016
 * Time: 16:39
 */

namespace Redreams\Partners;


class partner
{
    public static $partnerGroupID = 11;
    public static $curatorGroupID = 12;
    public static $operatorGroupID = 13;


    public static function isPartner()
    {
        $result = false;

        global $USER;
        $groups = $USER->GetUserGroupArray();
        if (in_array(self::$partnerGroupID, $groups)) {
            $result = true;
        }

        return $result;
    }

    public static function isOperator()
    {
        $result = false;

        global $USER;
        $groups = $USER->GetUserGroupArray();
        if (in_array(self::$operatorGroupID, $groups)) {
            $result = true;
        }

        return $result;
    }

    public static function isCurator()
    {
        $result = false;

        global $USER;
        $groups = $USER->GetUserGroupArray();
        if (in_array(self::$curatorGroupID, $groups)) {
            $result = true;
        }

        return $result;
    }


    public function import($fileName)
    {
        $import = new import($fileName);
        $partners = $import->parseNode('Партнер');

        foreach ($partners as $partner) {
            foreach ($partner->attributes() as $k => $v) {
                $resultPartner[$k] = (string)$v;
            }

            $this->addPartner($resultPartner);
        }
    }

    public function addPartner($partner)
    {
        $send = false;

        $user = new \CUser();

        $password = randString(10);

        $partner['Email'] = str_replace(array(";", ",", "/"), " ", trim($partner['Email']));
        $emailArr = explode(" ", $partner['Email']);
        $partner['Email'] = trim($emailArr[0]);

        $by = "id";
        $order = "desc";

        $dbUser = \CUser::GetList($by, $order, array('=EMAIL' => $partner['Email'], 'EMAIL_EXACT_MATCH' => 'Y'));
        $bxUser = $dbUser->GetNext();

        $fields = [
            "NAME" => substr($partner['Name'], 0, 49),
            "EMAIL" => $partner['Email'],
            "LOGIN" => $partner['Email'],
            "LID" => "ru",
            "ACTIVE" => "Y",
            "GROUP_ID" => array(2, 3, 5, 11),
            "PASSWORD" => $password,
            "CONFIRM_PASSWORD" => $password,
            "XML_ID" => $partner['ID'],
            "UF_MAIN_MANAGER" => $partner['mainManager'],
            "UF_MANAGER" => $partner['maintenanceManager']
        ];

        //if ($partner['Email'] != 'anastasia0579@mail.ru') return;
        //$array_b = ["ak@remgaz.com", "stm_oskol@mail.ru", "gtstorg@yandex.ru", "stm_oskol@mail.ru", "info@santehnika.me", "mail@tss-gas.ru", "sankor4721@mail.ru", "yantukhovich@psksanteh.ru", "yantukhovich@psksanteh.ru", "pinskaya@art-technologia.ru", "ooosistema35@gmail.com", "zakup@santem35.ru", "ooo.servisnik@mail.ru", "grachev@comfort-montage.ru", "urzak@bk.ru", "tsvetkov.onis@gmail.com", "2171784@BK.RU", "polteplov@yandex.ru", "smg2275599@mail.ru", "E10@inbox.ru", "sale196@yandex.ru", "v.i.zlobin@duim.ru", "dvt.pump@gmail.com", "9253295@vteple.net", "mail@comforama.ru", "a.pankov@novoeteplo.com", "radiat7@yandex.ru", "led178@yandex.ru", "gazizzz@mail.ru", "andrei.nikolaevich.shabalin@gmail.ru", "hozsnabkem@mail.ru", "tsvetkova.ergos@gmail.com", "service@oteplenie.ru", "9218515@mail.ru", "mail@comforama.ru", "dvj_djalil@mail.ru", "kit352@rambler.ru", "teplokomfortku@gmail.com", "oskolteplo@mail.ru", "stm_oskol@mail.ru", "dilara@artcentre.club", "mirkotlov-spb@yandex.ru", "sales.proektnn@gmail.com", "1207571@bk.ru", "alexandr.t@santehmir.ru", "info@otopleniebel.ru", "79210597580@ya.ru", "energomir@energomir.su", "Santexplus18@yandex.ru", "info@teceprofi.ru", "santehmos@mail.ru", "info@baikalterm.ru"];
        /*if ($bxUser['EMAIL'] == "pinskaya@art-technologia.ru") {

            if (!in_array(11, $user::GetUserGroup($bxUser['ID']))) {

                echo "-";
                //var_dump($bxUser);
            } else echo "+";
        }*/

        if (!$bxUser['ID']) {// add new user
            if (!$user->Add($fields)) {
                $ex = new \Exception("User cant add");
                echo $ex->getMessage();
                //var_dump($fields);
                $fp = fopen($_SERVER['DOCUMENT_ROOT'] . '/1c-services/import.partner.log', 'a+');
                fwrite($fp, print_r($fields, TRUE));
                fwrite($fp, date("Y-m-d H:i:s") . "\r\n");
                fclose($fp);

                //mail();
            } else {
                $dbUser = \CUser::GetList($by, $order, ['=EMAIL' => $partner['Email']]);
                $bxUser = $dbUser->GetNext();

                $bxUser['PASSWORD'] = $password;

                $send = true;
            }
        } else // update user
        {
            unset($fields['PASSWORD']);
            unset($fields['CONFIRM_PASSWORD']);

            /*if (!$bxUser['XML_ID'] || !in_array(11, $user::GetUserGroup($bxUser['ID'])))//
            {
                $bxUser['PASSWORD'] = $password;
                $send = true;
            } else {
                unset($fields['PASSWORD']);
                unset($fields['CONFIRM_PASSWORD']);
            }*/
            //var_dump($bxUser['ID']);
            //var_dump($fields);

            //Check current groups, add required, update
            //unset($fields["GROUP_ID"]);


            $user->Update($bxUser['ID'], $fields);
            //var_dump($user->LAST_ERROR);
            //$send = true;
        }

        if ($send) {
            $hldata = \Bitrix\Highloadblock\HighloadBlockTable::getById(8)->fetch();
            $hlentity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hldata);
            $entityClass = $hlentity->getDataClass();

            $res = $entityClass::getList(array(
                'select' => array('UF_EMAIL'),
                'filter' => array('UF_XML_ID' => $partner['maintenanceManager'])
            ))->fetch();

            if (!empty($res)) {
                $bxUser['MANAGER_EMAIL'] = $res['UF_EMAIL'];
            } else $bxUser['MANAGER_EMAIL'] = 'site@termoros.com';

            $bxUser['URL_LOGIN'] = $partner['Email'];
            $arrSITE = array("s1");
            $fields['ID'] = $bxUser['ID'];
            \CEvent::Send("UPDATE_PARTNER", $arrSITE, $bxUser, "Y");
        }
    }

    public static function getByXMLID($xmlID)
    {
        $dbUser = \CUser::GetList($by, $order, ['XML_ID' => $xmlID]);
        if ($bxUser = $dbUser->GetNext()) {
            return $bxUser['ID'];
        }
    }

    public static function getXMLID()
    {
        global $USER;

        $dbUser = \CUser::GetList($by, $order, ['ID' => $USER->GetID()]);
        if ($bxUser = $dbUser->GetNext()) {
            return $bxUser['XML_ID'];
        }
    }
}
