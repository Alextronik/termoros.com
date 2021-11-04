<?php
/**
 * Created by PhpStorm.
 * User: bearl
 * Date: 05.07.2016
 * Time: 2:51
 */

namespace Redreams\Partners;


class tools
{
    public static function AddMessage2Log($subject,$module)
    {
        if(self::$WRITE_LOG)
        {
            if(is_array($subject))
            {
                $subject = print_r($subject,true);
            }

            $filename = '/logs/discounts_'.date('d.m.Y').'.txt';
            \Bitrix\Main\Diag\Debug::writeToFile(date('d.m.Y H:i:s').':'.$subject,$module, $filename);
        }
    }
}