<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<script id="ISDEKscript" type="text/javascript" src="/store/cdek/pvzwidget/widget/widjet.js"></script>

<script type="text/javascript">
	var ourWidjet = new ISDEKWidjet ({
        defaultCity: 'Москва', //какой город отображается по умолчанию
        cityFrom: 'Москва', // из какого города будет идти доставка
        country: 'Россия', // можно выбрать страну, для которой отображать список ПВЗ
        link: "forpvz", // id элемента страницы, в который будет вписан виджет
        path: 'https://www.termoros.com/store/cdek/pvzwidget/widget/scripts/', //директория с бибилиотеками
        servicepath: 'https://www.termoros.com/store/cdek/pvzwidget/widget/scripts/service.php', //ссылка на файл service.php на вашем сайте
		choose: true,
        popup: true,
		hidedress: true,
		hidecash: true,
		hidedelt: true,
		onReady: onReady,
        onChoose: onChoose,
        onChooseProfile: onChooseProfile,
        onCalculate: onCalculate,
		
		goods: [
			{length: 20, width: 20, height: 20, weight: 2}, 
			//{length: 30, width: 40, height: 50, weight: 20}
		]
    });
	
	function onReady() {
        //alert('Виджет загружен');
		//$('#forpvz').show();
		
    }

    function onChoose(wat) {
        alert(
            'Выбран пункт выдачи заказа ' + wat.id + "\n" +
            'цена ' + wat.price + "\n" +
            'срок ' + wat.term + " дн.\n" +
            'город ' + wat.cityName + ', код города ' + wat.city
        );
		$('#forpvz').hide();
    }

    function onChooseProfile(wat) {
        alert(
            'Выбрана доставка курьером в город ' + wat.cityName + ', код города ' + wat.city + "\n" +
            'цена ' + wat.price + "\n" +
            'срок ' + wat.term + ' дн.'
        );
		
    }

    function onCalculate(wat) {
       // alert('Расчет стоимости доставки произведен');
    }

	
</script>
<div id="forpvz" style="width:100%; height:600px;"></div>
<?/*<div style="position: fixed; top: 0; left: 0; width: 400px; height: 20px; background-color: skyblue; z-index: 1500; text-align: center">
    <a href='javascript:void(0);' onclick='ourWidjet.open(); $(".slide_panel").hide();'>Показать виджет</a>
    <a href='javascript:void(0);' onclick='ourWidjet.close(); $(".slide_panel").show();' style="padding-left: 15px;">Скрыть виджет</a>
</div>*/?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>