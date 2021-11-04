<?
define('LEFTBAR3', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Путеводитель по Личному кабинету Партнёра");
?>
<?
\Bitrix\Main\Loader::includeModule('redreams.partners');
?>
<?if(\Redreams\Partners\partner::isPartner()):?>
<link rel="stylesheet" type="text/css" href="instruction.css">
<p>Уважаемый Партнёр, приветствуем вас в Личном кабинете!</p>
<p>Личный кабинет – это функциональный инструмент, который позволит сделать наше сотрудничество более удобным и продуктивным.</p>
<p><b>Личный кабинет на сайте «Терморос» - это: </b></p>

<ul>
<li>Отображение индивидуальных цен на весь ассортимент продукции;</li>
<li>Актуальные остатки на всех складах;</li>
<li>Отслеживание статусов текущих заказов;</li>
<li>Формирование нового заказа в пару кликов;</li>
<li>Возможность оформлять заказы от разных контрагентов;</li>
<li>Просмотр истории заказов;</li>
<li>Оперативная техническая поддержка;</li>
<li>Вся техническая документация доступна для скачивания и всегда под рукой.</li>
</ul>

<p>Ниже представлено подробное описание работы Личного кабинета:</p>

<h2>Раздел «Сформировать заказ»</h2>

<table cellpaddin="5" cellspacing="5" class="instruction-table">
	<tr>
		<td style="width: 250px;"><img src="/personal/start/images/order.png"></td>
		<td>
		<p><i>В этом разделе вы сможете сформировать новый заказ. Для этого вам необходимо:</i></p>			
		<ul class="margin-bottom supp_list">
			<li>Перейти в каталог оборудования;</li>
			<li>Выбрать необходимое оборудование в каталоге – поиск и подбор оборудования можно осуществлять по артикулу или наименованию, уточнить критерии поиска можно с помощью удобного фильтра;</li>
			<li>Добавить выбранное оборудование в корзину;</li>
			<li>Выбрать необходимого контрагента и заполнить  данные, необходимые для оформления заказа (адрес доставки, способ оплаты);</li>
			<li>Отправить заказ.</li>
		</ul>
		</td>
	</tr>
</table>

<br/>
<p><b>Пошаговая инструкция:</b></p>
<div class="news-gallery">
	<div class="news-gallery-row">
		<div class="gallery-img img-styling">
			<a class="fancy" href="/personal/start/images/order_1.png" rel="order" title="Выбор товаров в каталоге">
				<img src="/personal/start/images/order_1_min.png" alt="Выбор товаров в каталоге">
			</a>
		</div>
		<div class="gallery-img img-styling"><a class="fancy" title="Использование фильтров в каталоге" href="/personal/start/images/order_2.png" rel="order"><img src="/personal/start/images/order_2_min.png" alt=""></a></div>
		<div class="gallery-img img-styling"><a class="fancy" title="Карточка продукта" href="/personal/start/images/order_3.png" rel="order"><img src="/personal/start/images/order_3_min.png" alt=""></a></div>
		<div class="gallery-img img-styling"><a class="fancy" title="Корзина товаров" href="/personal/start/images/order_4.png" rel="order"><img src="/personal/start/images/order_4_min.png" alt=""></a></div>
		<div class="gallery-img img-styling"><a class="fancy" title="Оформление заказа, шаг 1" href="/personal/start/images/order_5.png" rel="order"><img src="/personal/start/images/order_5_min.png" alt=""></a></div>
		<div class="gallery-img img-styling"><a class="fancy" title="Оформление заказа, шаг 2" href="/personal/start/images/order_6.png" rel="order"><img src="/personal/start/images/order_6_min.png" alt=""></a></div>
	</div>
</div>
<br/>
<div class="clear border-bottom"></div>
<br/><br/>
<h2>Раздел «Техническая документация»</h2>

<table cellpadding="5" cellspacing="5" class="instruction-table">
	<tr>
		<td style="width: 250px;"><img src="/personal/start/images/tech.png"></td>
		<td>
		<p><i>В этом разделе вы сможете найти и скачать всю необходимую документацию на оборудование:</i></p>			
		<ul class="margin-bottom supp_list">
			<li>Сертификаты</li>
			<li>Паспорта</li>
			<li>Руководства</li>
			<li>Гарантийные талоны</li>
			<li>Инструкции</li>
			<li>Каталоги и буклеты</li>
			<li>Опросные листы</li>
			<li>Взрывные схемы</li>
			<li>Чертежи</li>
		</ul>
		</td>
	</tr>
</table>
<br/>
<p><b>Пошаговая инструкция:</b></p>
<div class="news-gallery">
	<div class="news-gallery-row">
		<div class="gallery-img img-styling">
			<a class="fancy" title="Техническая документация" href="/personal/start/images/tech_doc.png" rel="tech_doc">
				<img src="/personal/start/images/tech_doc_min.png" alt="">
			</a>
		</div>
	</div>
</div>
<br/>
<div class="clear border-bottom"></div>
<br/><br/>
<h2>Раздел «Прайс-листы»</h2>

<table cellpadding="5" cellspacing="5"  class="instruction-table">
	<tr>
		<td style="width: 250px;"><img src="/personal/start/images/price.png"></td>
		<td>
		<p><i>В этом разделе вы сможете скачать прайс-листы на весь ассортимент Группы компаний «Терморос». Найти нужный прайс-лист можно, используя строку поиска или фильтр по бренду и виду продукции.</i></p>			
		</td>
	</tr>
</table>


<br/>
<p><b>Пошаговая инструкция:</b></p>
<div class="news-gallery">
	<div class="news-gallery-row">
		<div class="gallery-img img-styling">
			<a class="fancy" href="/personal/start/images/price_lists.png" title="Прайс-лист" rel="price">
				<img src="/personal/start/images/price_min.png" alt="">
			</a>
		</div>
	</div>
</div>
<br/>
<div class="clear border-bottom"></div>
<br/><br/>
<h2>Раздел «Скачать каталог»</h2>

<table cellpadding="5" cellspacing="5" class="instruction-table">
	<tr>
		<td style="width: 250px;"><img src="/personal/start/images/download_catalog.png"></td>
		<td>
		<p><i>В разделе вы сможете ознакомиться с электронной версией текущего печатного каталога продукции Терморос-2016 в удобном для вас формате:</i></p>			
		<ul class="margin-bottom supp_list">
			<li>Формат PDF</li>
			<li>Интерактивный каталог</li>
		</ul>
		</td>
	</tr>
</table>
<br/>
<div class="clear border-bottom"></div>
<br/><br/>
<h2>Раздел «Акции»</h2>

<table cellpadding="5" cellspacing="5" class="instruction-table">
	<tr>
		<td style="width: 250px;"><img src="/personal/start/images/actions.png"></td>
		<td>
		<p><i>В этом разделе представлена информация об акциях Группы компаний «Терморос»:</i></p>			
		<ul class="margin-bottom supp_list">
			<li>Скидки и распродажи</li>
			<li>Акции и специальные предложения</li>
			<li>Мотивационные программы</li>
		</ul>
		</td>
	</tr>
</table>
<br/>
<div class="clear border-bottom"></div>
<br/><br/>

<h2>Раздел «Обучение»</h2>

<table cellpadding="5" cellspacing="5" class="instruction-table">
	<tr>
		<td style="width: 250px;"><img src="/personal/start/images/learn.png"></td>
		<td>
		<p><i>В разделе вы можете ознакомиться с графиком обучающих мероприятий и зарегистрироваться на любое из них:</i></p>			
		<ul class="margin-bottom supp_list">
			<li>Вебинары</li>
			<li>Семинары</li>
		</ul>
		</td>
	</tr>
</table>
<br/>
<div class="clear border-bottom"></div>
<br/><br/>

<h2>Раздел «Рекламная поддержка»</h2>

<table cellpadding="5" cellspacing="5" class="instruction-table">
	<tr>
		<td style="width: 250px;"><img src="/personal/start/images/adv.png"></td>
		<td>
		<p><i>В разделе доступна для скачивания рекламная информация Группы компаний «Терморос»:</i></p>			
		<ul class="margin-bottom supp_list">
			<li>Буклеты и листовки</li>
			<li>Пресс-релиз</li>
			<li>Презентация</li>
			<li>Логотип</li>
		</ul>
		</td>
	</tr>
</table>
<br/>
<div class="clear border-bottom"></div>
<br/><br/>

<h2>Раздел «Мои данные»</h2>

<table cellpadding="5" cellspacing="5" class="instruction-table">
	<tr>
		<td style="width: 250px;"><img src="/personal/start/images/my_details.png"></td>
		<td>
		<p><i>В разделе «Мои данные» вы можете изменить свой пароль для входа в личный кабинет партнера.</i></p>			
		</td>
	</tr>
</table>
<br/>
<div class="clear border-bottom"></div>
<br/><br/>

<h2>Раздел «Мой контрагент»</h2>

<table cellpadding="5" cellspacing="5" class="instruction-table">
	<tr>
		<td style="width: 250px;"><img src="/personal/start/images/my_contractor.png"></td>
		<td>
		<p><i>Здесь вы можете выбрать контрагента, от лица которого будет осуществлён тот или иной заказ. </i></p>		
		</td>
	</tr>
</table>
<table cellpadding="5" cellspacing="5" class="instruction-table">
	<tr>
		<td style="width: 250px;">
			<img style="width: 900px;" src="/personal/start/images/top_menu.png">
			<p><i>Посмотреть полный перечень своих контрагентов вы можете по ссылке из верхнего меню:</i></p>
			<img style="width: 900px;" src="/personal/start/images/contractors.png">
			<p><i>Для изменения информации по контрагенту воспользуйтесь кнопкой «Сменить информацию»</i></p>
		</td>
		<td>
				
		</td>
	</tr>
</table>
<br/>
<div class="clear border-bottom"></div>
<br/><br/>

<h2>Раздел «Распродажа»</h2>

<table cellpadding="5" cellspacing="5" class="instruction-table">
	<tr>
		<td style="width: 250px;"><img src="/personal/start/images/sale.png"></td>
		<td>
			<p><i>В разделе «Распродажа» будет представлена продукция, на которую действуют специальные скидки.</i></p>			
		</td>
	</tr>
</table>
<br/>
<div class="clear border-bottom"></div>
<br/><br/>

<h2>Раздел «С вами работает»</h2>

<table cellpadding="5" cellspacing="5" class="instruction-table">
	<tr>
		<td style="width: 250px;"><img src="/personal/start/images/manager.png"></td>
		<td>
			<p><i>Благодаря этому функционалу контакты вашего личного менеджера всегда под рукой! Вы также сможете оперативно связаться с вашим менеджером, заполнив форму обратной связи.</i></p>			
		</td>
	</tr>
</table>
<br/>
<div class="clear border-bottom"></div>
<br/><br/>

<h2>Раздел «Добавить товары в корзину»</h2>

<table cellpadding="5" cellspacing="5" class="instruction-table">
	<tr>
		<td style="width: 250px;"><img src="/personal/start/images/add.png"></td>
		<td>
			<p><i>С помощью этого функционала вы сможете в пару кликов добавить необходимое оборудование в корзину – для этого будет достаточно знать артикулы.</i></p>			
		</td>
	</tr>
</table>
<br/>
<div class="clear border-bottom"></div>
<br/><br/>

<h2>Раздел «Скачать приложения»</h2>

<table cellpadding="5" cellspacing="5" class="instruction-table">
	<tr>
		<td style="width: 250px;"><img src="/personal/start/images/app.png"></td>
		<td>
			<p><i>Благодаря мобильному приложению, функционал Личного кабинета будет всегда у Вас под рукой! Приложение будет доступно для устройств на Android и IOs.</i></p>			
		</td>
	</tr>
</table>
<br/>
<div class="clear border-bottom"></div>
<br/><br/>


<h1>Функционал Личного кабинета, который появится в скором времени</h1>
<?/*
<h2>Раздел «Подбор оборудования»</h2>

<table cellpadding="5" cellspacing="5" class="instruction-table">
	<tr>
		<td style="width: 250px;"><img src="/personal/start/images/podbor.png"></td>
		<td>
			<p><i>В этом разделе вы сможете подобрать необходимое оборудование удобным для вас способом:</i></p>			
			<ul class="margin-bottom supp_list">
				<li>Заполнить опросный лист на сайте онлайн</li>
				<li>Скачать опросный лист, заполнить его и отправить по электронной почте</li>
				<li>Получить перечень необходимого оборудования</li>
			</ul>
		</td>
	</tr>
</table>
<br/>
<div class="clear border-bottom"></div>
<br/><br/>
*/?>


<h2>Раздел «Кредитная информация»</h2>

<table cellpadding="5" cellspacing="5" class="instruction-table">
	<tr>
		<td style="width: 250px;"><img src="/personal/start/images/credit.png"></td>
		<td>
			<p><i>В этом разделе будет отображаться актуальная информация по вашим кредитным лимитам.</i></p>			
		</td>
	</tr>
</table>
<br/>
<div class="clear border-bottom"></div>
<br/><br/>

<? endif; ?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>