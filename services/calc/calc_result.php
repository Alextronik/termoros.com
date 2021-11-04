<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
/**
 * Created by PhpStorm.
 * User: Jager
 * Date: 12.10.2020
 * Time: 14:56
 */

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE);
\Bitrix\Main\Diag\Debug::writeToFile($input);

if($input['type'] == 'calcResult'){

    $arSend = array(

        "EMAIL" => $input['email'],
        "FIO" => $input["fio"],
        "PHONE" => $input["phone"],

        "PASCAGE" => $input["pascage"],
        "PRICE" => $input["price"],

        "B_TYPE" => $input["b_type"],
        "B_BRAND" => $input["b_brand"],
        "B_COND" => $input["b_cond"],
        "B_POWER" => $input["b_power"],

        "S_1" => $input["s_1"],
        "S_2" => $input["s_2"],
        "S_3" => $input["s_3"],
        "S_4" => $input["s_4"],
        "COMMENT" => $input["comment"]

    );
    CEvent::Send("CALC_SERVICE", 's1', $arSend);

    echo 555;

}