<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
/** @var TYPE_NAME $arResult */
/** @var TYPE_NAME $APPLICATION */
//var_dump($arResult['USERS']);

$APPLICATION->IncludeComponent(
    "bitrix:main.interface.grid",
    "",
    array(
        "GRID_ID"=>"users_grid",
        "HEADERS"=>array(
            array("id"=>"ID", "name"=>"ID", "default"=>true),
            array("id"=>"NAME", "name"=>"Название", "default"=>true),
            array("id"=>"EMAIL", "name"=>"Email", "default"=>true),
        ),
        "ROWS"=>$arResult['USERS'],
        "FOOTER"=>array(array("title"=>"Всего", "value"=>$arResult['COUNT'])),
        "NAV_OBJECT"=>$arResult['NAV'],
        "NAV_PARAMS"=>array(
            "SEF_MODE" => "N"
        ),
        "AJAX_MODE"=>"Y",
        "AJAX_OPTION_JUMP"=>"N",
        "AJAX_OPTION_STYLE"=>"Y",
    )
);
?>
<div>
    <a id="dfile_csv" class="btn btn-default">Download csv</a>
    <a id="dfile_xml" class="btn btn-default">Download xml</a>
</div>
<script>
    $(document).on('click', 'a[id^="dfile_"]', function(e) {
        e.preventDefault();
        dl(this.id)
    });
    function dl(type){
        let request = BX.ajax.runComponentAction('test:uc_users', 'ajax', {
            mode:'class',
            data: {
                param1: type
            }
        });
        BX.showWait();
        request.then(function(response){
            BX.closeWait();
            let link = document.createElement('a');
            link.setAttribute('href',response.data.file);
            link.setAttribute('download',response.data.file);
            onload=link.click();
            //link.remove();
        }, function(error) {
            BX.closeWait();
            console.error("Failed!", error);
        });
    }
</script>
