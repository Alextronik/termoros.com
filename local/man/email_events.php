<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
define("NO_KEEP_STATISTIC", true);
define('BX_NO_ACCELERATOR_RESET', true);

/** @var TYPE_NAME $APPLICATION */
$APPLICATION->SetTitle("Шаблоны последних писем по событиям");?>
<?php
use Bitrix\Main\Mail;

global $DB;

$res = $DB->Query(
    "SELECT * FROM b_event order by DATE_EXEC desc LIMIT 3000"
);
$arEventsName = [];
$arEventsNameExclude = ['STATISTIC_DAILY_REPORT'];
$arEventsNameExample = [];
while($mess = $res->fetch())
{
    if(!in_array($mess['EVENT_NAME'],$arEventsName) && !in_array($mess['EVENT_NAME'],$arEventsNameExclude)){
        $arEventsName[] = $mess['EVENT_NAME'];
        $arEventsNameExample[$mess['ID']] = $mess;
        //var_dump($mess);
    }
}
//var_dump($arEventsName);
//var_dump($arEventsNameExample);

/* get all templates
$rsMess = CEventMessage::GetList($by="s1", $order="desc", array());

while($arMess = $rsMess->GetNext())
{
    var_dump($arMess);
}
*/

function getEventMessages(array $ar){
    if(is_array($ar)){
        foreach ($ar as $k=>$v){
            try
            {
                /**
                 * First, try to find event
                 */
                $arEvent = Mail\Internal\EventTable::getRow([
                    'filter' => [
                        '=ID' => $k,
                    ]
                ]);

                if ( !$arEvent )
                {
                    throw new \Exception('Event not found');
                }

                $arEvent['FIELDS'] = $arEvent['C_FIELDS'];

                /**
                 * Try to find all message templates for
                 * sites. In event handler we send for one letter
                 * per site.
                 */
                $arEventMessageFilter = [
                    '=ACTIVE' => 'Y',
                    '=EVENT_NAME' => $arEvent["EVENT_NAME"],
                    '=EVENT_MESSAGE_SITE.SITE_ID' => ['s1'],
                ];

                $messageDb = Mail\Internal\EventMessageTable::getList([
                    'select' => ['ID'],
                    'filter' => $arEventMessageFilter,
                    'group' => ['ID']
                ]);

                foreach ($messageDb as $arMessage)
                {
                    $eventMessage = Mail\Internal\EventMessageTable::getRowById($arMessage['ID']);
                    //v($eventMessage);
                    //v($arEvent['FIELDS']);

                    $eventMessage['FILES'] = array();
                    $attachmentDb = Mail\Internal\EventMessageAttachmentTable::getList(array(
                        'select' => array('FILE_ID'),
                        'filter' => array('=EVENT_MESSAGE_ID' => $arMessage['ID']),
                    ));
                    while($arAttachmentDb = $attachmentDb->fetch())
                    {
                        $eventMessage['FILE'][] = $arAttachmentDb['FILE_ID'];
                    }

                    $arFields = $arEvent['FIELDS'];

                    // get message object for send mail
                    $arMessageParams = array(
                        'EVENT' => $arEvent,
                        'FIELDS' => $arFields,
                        'MESSAGE' => $eventMessage,
                        'SITE' => ['s1'],
                        'CHARSET' => false,
                    );
                    $message = Mail\EventMessageCompiler::createInstance($arMessageParams);
                    $message->compile();
                    echo "<h4 style='color:red;font-weight:bold;text-align: center'>EVENT TYPE: ".$v['EVENT_NAME'].", EVENT ID: ".$k.", DATE: ".$v['DATE_EXEC'].", SUCCESS: ".$v['SUCCESS_EXEC'].", DUPLICATE: ".$v['DUPLICATE'].", TEMPLATE_ID: ".$eventMessage['ID'].", TEMPLATE: ".$eventMessage['SITE_TEMPLATE_ID']."</h4><br>";
                    echo "<h4 style='color:blue;font-weight:bold;text-align: center'>";
                    echo ($arEvent['FIELDS']['EMAIL']) ? "EMAIL: ".$arEvent['FIELDS']['EMAIL']."&nbsp;" : "";
                    echo ($arEvent['FIELDS']['SALE_EMAIL']) ? "SALE_EMAIL: ".$arEvent['FIELDS']['SALE_EMAIL']."&nbsp;" : "";
                    echo ($arEvent['FIELDS']['BCC']) ? "BCC: ".$arEvent['FIELDS']['BCC']."&nbsp;" : "";
                    echo ($arEvent['FIELDS']['EMAIL_COPY']) ? "EMAIL_COPY: ".$arEvent['FIELDS']['EMAIL_COPY']."&nbsp;" : "";
                    echo ($arEvent['FIELDS']['MANAGER_EMAIL']) ? "MANAGER_EMAIL: ".$arEvent['FIELDS']['MANAGER_EMAIL']."&nbsp;" : "";
                    echo "</h4>";
                    echo $message->getMailBody()."<hr>";
                }
            }
            catch( \Exception $e )
            {
                var_dump($e);
            }
        }
    }else return "Dont array!";
}

getEventMessages($arEventsNameExample);

?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
