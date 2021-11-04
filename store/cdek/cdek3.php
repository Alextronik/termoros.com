<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<script id="ISDEKscript" type="text/javascript" src="/store/cdek/pvzwidget/widget/widjet.js"></script>

<script type="text/javascript">
    /*
	var ourWidjet = new ISDEKWidjet ({
        defaultCity: 'Москва', //какой город отображается по умолчанию
        cityFrom: 'Москва', // из какого города будет идти доставка
        country: 'Россия', // можно выбрать страну, для которой отображать список ПВЗ
        link: 'forpvz', // id элемента страницы, в который будет вписан виджет
        path: 'https://www.cdek.ru/website/edostavka/template/scripts/', //директория с бибилиотеками
        servicepath: 'https://www.termoros.com/store/cdek/pvzwidget/widget/scripts/service.php', //ссылка на файл service.php на вашем сайте
		choose: true,
        popup: true,
		hidedress: true,
		onReady: onReady,
        onChoose: onChoose,
        onChooseProfile: onChooseProfile,
        onCalculate: onCalculate
    });
	*/
	var cartWidjet = new ISDEKWidjet ({
        defaultCity: 'Москва', //какой город отображается по умолчанию
        cityFrom: 'Москва', // из какого города будет идти доставка
        country: 'Россия', // можно выбрать страну, для которой отображать список ПВЗ
        link: 'forpvz', // id элемента страницы, в который будет вписан виджет
        path: 'https://www.cdek.ru/website/edostavka/template/scripts/', //директория с бибилиотеками
        servicepath: 'https://www.termoros.com/store/cdek/pvzwidget/widget/scripts/service.php', //ссылка на файл service.php на вашем сайте
        choose: true, // не будем отображать кнопку выбора ПВЗ
        hidedelt: true, // скроем возможность выбора типа доставки
        goods: [ // установим данные о товаре для корректного расчета стоимости доставки
            { length: 20, width: 20, height: 20, weight: 2 }
        ],
        popup: true, // включим режим всплывающего окна
        onCalculate: calculated
    });
    // сделаем так, чтобы при расчете доставки до ПВЗ обновлялась информация в блоке с деталями доставки
    function calculated(params){
        console.log(params.profiles.pickup.price);
        console.log(params.profiles.pickup.term);
		//ipjq('#delPrice').html(params.profiles.pickup.price);
        //ipjq('#delTime').html(params.profiles.pickup.term);
    }
	
	function onReady() {
        alert('Виджет загружен');
    }

    function onChoose(wat) {
        alert(
            'Выбран пункт выдачи заказа ' + wat.id + "\n" +
            'цена ' + wat.price + "\n" +
            'срок ' + wat.term + " дн.\n" +
            'город ' + wat.cityName + ', код города ' + wat.city
        );
		
    }

    function onChooseProfile(wat) {
        alert(
            'Выбрана доставка курьером в город ' + wat.cityName + ', код города ' + wat.city + "\n" +
            'цена ' + wat.price + "\n" +
            'срок ' + wat.term + ' дн.'
        );
    }
/*
    function onCalculate(wat) {
        alert('Расчет стоимости доставки произведен');
    }
*/
	
	
</script>
<div id="forpvz" style="width:100%; height:600px;"></div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>