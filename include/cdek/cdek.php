<script id="ISDEKscript" type="text/javascript" src="/store/cdek/pvzwidget/widget/widjet.js"></script>

<a href='javascript:void(0);' style="display: inline-block; vertical-align: middle; margin-right: 20px;" onclick='ourWidjet.open(); $(".slide_panel").hide();'><img id="cdek_calc_img" style="top: 2px; position: relative;" src="/images/cdek_g.jpg"></a>
<style>
	#cdek_calc_img:hover {
		content: url('/images/cdek_r.jpg');
	}
</style>

<script type="text/javascript">
	var ourWidjet = new ISDEKWidjet ({
        defaultCity: 'Москва', //какой город отображается по умолчанию
        cityFrom: 'Апрелевка', // из какого города будет идти доставка
        //cityFromId: '13402', // из какого города будет идти доставка
        country: '', // можно выбрать страну, для которой отображать список ПВЗ
        link: false, // id элемента страницы, в который будет вписан виджет
        path: 'https://www.termoros.com/store/cdek/pvzwidget/widget/scripts/', //директория с бибилиотеками
        servicepath: 'https://www.termoros.com/store/cdek/pvzwidget/widget/scripts/service.php', //ссылка на файл service.php на вашем сайте
		choose: true,
        popup: true,
		hidedress: true,
		hidecash: true,
		<? if (1) { ?>
		hidedelt: false, //Курьер
		<? } else { ?>
		hidedelt: true, //Курьер
		<? } ?>
		onReady: onReady,
        onChoose: onChoose,
        onChooseProfile: onChooseProfile,
        onCalculate: onCalculate,
		
		goods: [
			{length: <?=$length?>, width: <?=$width?>, height: <?=$height?>, weight: <?=$weight?>}, 
			//{length: 30, width: 40, height: 50, weight: 20}
		]
    });
	
	function onReady() {
        //alert('Виджет загружен');
		//$('#forpvz').show();
		
    }

    function onChoose(wat) {
        /*
		alert(
            'Выбран пункт выдачи заказа ' + wat.id + "\n" +
            'цена ' + wat.price + "\n" +
            'срок ' + wat.term + " дн.\n" +
            'город ' + wat.cityName + ', код города ' + wat.city
        );
		*/
		
		$('#cdekPrice').html((wat.price * 1.1).toFixed(2) + " руб.");
		$('#cdekTerm').html(wat.term + " дн.");
		$('#cdekCity').html(wat.cityName);
		$('#cdekProfile').html('Пункт выдачи');
		$('#cdekBlockResult').show();
		//console.log(wat);
		$('#forpvz').hide();
    }

    function onChooseProfile(wat) {
        $('#cdekPrice').html((wat.price * 1.1).toFixed(2) + " руб.");
		$('#cdekTerm').html(wat.term + " дн.");
		$('#cdekCity').html(wat.cityName);
		$('#cdekProfile').html('Курьер');
		$('#cdekBlockResult').show();
		//console.log(wat);
		$('#forpvz').hide();
    }

    function onCalculate(wat) {
       // alert('Расчет стоимости доставки произведен');
    }

	
</script>
<?/*<div id="forpvz" style="width:100%; height:600px;"></div>*/?>
<?/*<div style="position: fixed; top: 0; left: 0; width: 400px; height: 20px; background-color: skyblue; z-index: 1500; text-align: center">
    <a href='javascript:void(0);' onclick='ourWidjet.open(); $(".slide_panel").hide();'>Показать виджет</a>
    <a href='javascript:void(0);' onclick='ourWidjet.close(); $(".slide_panel").show();' style="padding-left: 15px;">Скрыть виджет</a>
</div>*/?>
<style>
	.CDEK-widget__popup-mask {
		z-index: 10000;
	}
	.CDEK-widget__delivery-type__item-details {
		display:none;
	}
</style>