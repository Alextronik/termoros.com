<?
$aMenuLinks = Array(
	Array(
		"Настройки пользователя",
		"/personal/profile/",
		Array(),
		Array(),
		""
	),
	Array(
		\Redreams\Partners\partner::isPartner() ? "Контрагенты" : "Профили пользователя",
		"/personal/profs/", 
		Array(),
		Array(),
		""
	),
	Array(
		"История заказов",
		"/personal/order/",
		Array(),
		Array(),
		""
	)
	/*Array(
		"Отложенные заказы",
		"/personal/order/",
		Array(),
		Array(),
		""
	),*/
);
?>