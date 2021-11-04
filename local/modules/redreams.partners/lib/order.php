<?php
/**
 * Created by PhpStorm.
 * User: bearl
 * Date: 05.07.2016
 * Time: 17:55
 */

namespace Redreams\Partners;


class order
{
    public static function getBillByOrderID($order)
    {
        $bill = "";

        $xmlID = \Redreams\Partners\partner::getXMLID();

        $id1C = $order['ID_1C'];
        if($xmlID && $id1C && $order['STATUS_ID'] != 'N' && $order['CANCELED'] != 'Y')
        {
            $bill = "http://termoros.pro/exchange/?RefPartner=$xmlID&RefOrder=$id1C&OrderID={$order['ID']}";
        }

        return $bill;
    }
}