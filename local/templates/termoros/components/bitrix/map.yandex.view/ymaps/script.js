var cnt = 0;

	window.BX_YMapAddPlacemark = function(map, arPlacemark)
	{
		
		if (null == map)
			return false;

		if(!arPlacemark.LAT || !arPlacemark.LON)
			return false;

		var props = {};
		if (null != arPlacemark.TEXT && arPlacemark.TEXT.length > 0)
		{
			var value_view = '';

			if (arPlacemark.TEXT.length > 0)
			{
				var rnpos = arPlacemark.TEXT.indexOf("\n");
				value_view = rnpos <= 0 ? arPlacemark.TEXT : arPlacemark.TEXT.substring(0, rnpos);
			}

			props.balloonContent = arPlacemark.TEXT.replace(/\n/g, '<br />');
			props.hintContent = value_view;
			
		}
		//console.log(props);
		var obPlacemark = new ymaps.Placemark(
			[arPlacemark.LAT, arPlacemark.LON],
			props,
			{
			iconImageHref: '/local/templates/termoros/img/flag.png',
            iconImageSize: [25, 31],
            iconImageOffset: [-12, -29],
			balloonCloseButton: true
			}
		);
		
		//console.log(obPlacemark);
		window['obPlacemark'+cnt] = obPlacemark;
		cnt++;
		map.geoObjects.add(obPlacemark);
		//console.log(cnt);
		return obPlacemark;
	}
if (!window.BX_YMapAddPlacemark)
{}
/*
		var plmark4 = new ymaps.Placemark([47.280732,56.107614], {
							balloonContent: $('.market-cell .market-block').eq(3).html()
						}, {
							iconImageHref: '/bitrix/templates/termoros/images/ya_marker.png', // картинка иконки
							iconImageSize: [65, 53], // размеры картинки
							iconImageOffset: [-25, -55] // смещение картинки
						});					
*/
if (!window.BX_YMapAddPolyline)
{
	window.BX_YMapAddPolyline = function(map, arPolyline)
	{
		if (null == map)
			return false;

		if (null != arPolyline.POINTS && arPolyline.POINTS.length > 1)
		{
			var arPoints = [];
			for (var i = 0, len = arPolyline.POINTS.length; i < len; i++)
			{
				arPoints.push([arPolyline.POINTS[i].LAT, arPolyline.POINTS[i].LON]);
			}
		}
		else
		{
			return false;
		}

		var obParams = {clickable: true};
		if (null != arPolyline.STYLE)
		{
			obParams.strokeColor = arPolyline.STYLE.strokeColor;
			obParams.strokeWidth = arPolyline.STYLE.strokeWidth;
		}
		var obPolyline = new ymaps.Polyline(
			arPoints, {balloonContent: arPolyline.TITLE}, obParams
		);

		map.geoObjects.add(obPolyline);

		return obPolyline;
	}
}