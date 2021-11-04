$(document).ready(function(){

	const observer = lozad();
	observer.observe();

	$('.fancy').fancybox();

	// fix NOZ to Распродажа + other
	let nameFilters = document.querySelectorAll('.bx-filter-parameters-box-hint');
	let findNOZ = false;
	for (let elem of nameFilters) {
		if(elem.innerHTML.indexOf('NOZ') === 0){
			elem.innerHTML = "Распродажа";
			findNOZ = true;
		}
	}
	if(findNOZ){
		// label = 0
		let labelNoNOZ = document.querySelectorAll('label[data-role="label_arrFilter_729_4108050209"]');
		// label text = 1
		let labelNOZtext = document.querySelectorAll('label[data-role="label_arrFilter_729_2212294583"] .bx-filter-param-text');
		// del label 0 & replace
		if(labelNoNOZ[0] && labelNOZtext[0]) {
			labelNoNOZ[0].parentNode.parentNode.removeChild(labelNoNOZ[0].parentNode);
		}else if(labelNoNOZ[0] && labelNOZtext[0] === undefined) {
			document.getElementById('arrFilter_729_4108050209').remove();
			labelNoNOZ[0].querySelector('.bx-filter-param-text').innerHTML = "Нет товаров с такой меткой";
		}
		// replace 1 to "Да"
		if(labelNOZtext[0]) labelNOZtext[0].innerHTML = labelNOZtext[0].innerHTML.replace(/1/i, 'Да ');
		//console.log(labelNoNOZ[0],labelNOZtext[0]);
	}

	let sf = document.querySelector('.bx-touch form.smartfilter');
	if(sf){
		sf.classList.toggle('hidden');
		document.querySelector('.bx-touch .bx-filter-title').onclick = function() {
			sf.classList.toggle('hidden');
		}
	}



	/*$('.tech_table .inp label').on('click', function(){
		if($(this).prev().attr('checked'))
			$(this).prev().removeAttr('checked');
		else
			$(this).prev().attr('checked', 'checked');
	});*/

	/*$('.bx_filter.listfilter .bx_filter_param_label').on('click', function(){
		if($(this).find('input').is(':checked')) $(this).prev().removeAttr('checked');
		else $(this).find('input').attr('checked', 'checked');
		setFilterPage();
	});*/

	$('.tech_table .inp label').on('click', function(){
		//if($(this).prev().is(':checked')) $(this).prev().removeAttr('checked');
		//else $(this).prev().attr('checked', 'checked');
	});

	$('.del_terms.pops').on('click', function(){
		$('.global_overflow').show();
		$('.cart-delivery-text.pop_up.pops-text').show();
		return false;
	});

	$('.main_menu > li').hover(function(){
		$(this).addClass('hover');
	}, function(){
		$(this).removeClass('hover');
	});

	if($('.anketa.pop_up form[name="SIMPLE_FORM_9"]').length){
		$('.anketa.pop_up form[name="SIMPLE_FORM_9"] input[type="radio"]').customRadio();
	}

	$('.edit, .profilepage .prof_list .prof_item .prof_opener_wp .prof_opener').on('click', function(){

		if($(this).parent().parent().hasClass('opened')){
			$(this).parent().parent().removeClass('opened');
			$(this).parents('.partner_detail').removeClass('edited');
		}else{
			$(this).parent().parent().addClass('opened');
		}
		/**/

		if($('.slide_panel').length){

			var foot_pos = $('.footer').offset().top;
			var btn_pos = $(window).scrollTop() + $(window).height();

			/**/
			if( btn_pos > foot_pos){
				var raznica = btn_pos - foot_pos;
				raznica = raznica + 0;
				$('.slide_panel').css({'bottom': raznica+'px'}, 100);
			}else if(btn_pos = foot_pos){
				$('.slide_panel').css({'bottom':'-1px'}, 100);
			}else{
				$('.slide_panel').css({'bottom':'-1px'}, 100);
			}
		}
		/**/

		return false;
	});

	$('.change_i').on('click',function()
	{
		if($(this).parents('.partner_detail').hasClass('edited')){
			$(this).parents('.partner_detail').removeClass('edited');
		}else{
			$(this).parents('.partner_detail').addClass('edited');
		}

		return false;
	});


	/*
	$('.del_terms.pops').on('click', function(){

		$.fancybox(	$('.pops-text').html() );

		return false;
	});*/

	//for menubar
	$('.leftside_menu .lm_section a.selected').parents('.lm_section').addClass('opened');


	$('.down_selected').on('click', function(){
		$('.tech_table tr td span.customCheckbox.checkboxAreaChecked').each(function(indx){
			console.log($(this));
			console.log();
			var href = $(this).parent().siblings('.action').find('a').attr('href');
			$(this).prev().click();
			window.open(href,'_blank');

		});

		return false;
	});



	if($('.main_slider .slider_block').length){
		$('.main_slider .slider_block').bxSlider({
			controls:true,
			pager:false,
			pause:4000,
			nextText:'',
			prevText:'',
			mode:'fade',
			adaptiveHeight:true


		});
	}

	if($('.port_mainblock .slider_block').length){
		$('.port_mainblock .slider_block').bxSlider({
			controls:true,
			pager:false,
			pause:6000,
			nextText:'',
			prevText:'',
			mode:'fade'


		});
	}

	if($('.bx_filtren_container input[type="checkbox"]')){
		$('.bx_filtren_container input[type="checkbox"]').customCheckbox();
	}



	if($(window).width() > 1023){
		if($('.objects_wp .objects_slider').length){
			$('.objects_wp .objects_slider').carouFredSel({
				direction: 'left',
				infinite: true,
				circular: true,
				auto:false,
				prev: '.os_prev',
				next: '.os_next',
				scroll:{
					items:1
				},
				items:{
					visible:'variable'
				},
				width:'100%',
				align:'left',
				height:'280px'
			});
		}

		if($('.detail_page .watched_slider').length){
			$('.detail_page .watched_slider').carouFredSel({
				direction: 'left',
				infinite: true,
				circular: true,
				auto:false,
				prev: '.ws_prev',
				next: '.ws_next',
				scroll:{
					items:1
				},
				items:{
					visible:3
				},
				width:'100%',
				align:'left',
				height:'280px'
			});
		}

		$('.header .head_mid .search_wp .inp_self').on('focusin', function(){
			$('.header .head_mid .search_wp .btn_clear').fadeIn();
		});

		$('.header .head_mid .search_wp .inp_self').on('focusout', function(){
			$('.header .head_mid .search_wp .btn_clear').fadeOut();
		});

		$('.header .head_mid .search_wp .btn_clear').on('click', function(){
			$('.header .head_mid .search_wp .inp_self').val('');
			return false;
		});
	}



	$('.header .lk_wrap').on('click', function(){
		if($('.lk_wp').hasClass('logged')){
			return true;
		}else{
			$('.global_overflow').show();
			var cur_sc = $(window).scrollTop() + 100;
			$('.loginform').css({'position':'absolute', 'top':cur_sc});
			$('.loginform').show();
			
			return false;
		}
	});

	$('.order_tend_info, .header .tend').on('click', function(){
		var cur_sc = $(window).scrollTop() + 100;
		$('.global_overflow').show();
		$('.tenderform').css({'position':'absolute', 'top':cur_sc});
		$('.tenderform').show();
		
		return false;
	});

	function errorEventListener(){
		let ctrl = false; let ent = false;

		document.addEventListener('keydown', function(event) {
			//console.log(event.key);
			if (event.key === 'Control' ) ctrl = true;
			if (event.key === 'Enter' ) ent = true;

			if(ctrl && ent) {
				//console.log("Control+Space");
				document.getElementById("send_site_error").click();
			}
		});
		document.addEventListener('keyup', function(event) {
			if (event.key === 'Control' ) ctrl = false;
			if (event.key === 'Enter' ) ent = false;
		});
	}
	errorEventListener();

	$('#send_site_error').on('click', function(){
		let str = '';
		$('.global_overflow').show();
		let cur_sc = $(window).scrollTop() + 100;
		$('.site_error').css({'position':'absolute', 'top':cur_sc}).show();
		if (window.getSelection()) {
			let select = window.getSelection();
			if(select.toString()) str = "[ " +select.toString()+ " ]\n";
		}
		$('.site_error.pop_up textarea').text(str);
		return false;
	});


	$('.global_overflow').on('click', function(){
		$('.pop_up').hide();
		$('.global_overflow').hide();
		return false;
	});
	//For IPhone/Ipad
	$('.global_overflow').click(function() {
		$('.pop_up').hide();
		$('.global_overflow').hide();
		return false;
	});
	

	$('.popclose').on('click', function(){
		$('.pop_up').hide();
		$('.global_overflow').hide();
		return false;
	});

	$('.header .catlink_wp .catlink').on('click', function(){

		if($(window).width() > 1023){

			if($('.header .head_bott .catlink_wp').hasClass('noclose')){
				return false;
			}else{

				if($('.header .head_bott .catlink_wp').hasClass('opened')){
					$('.header .head_bott .catlink_wp').removeClass('opened');
				}else{
					$('.header .head_bott .catlink_wp').addClass('opened');
				}
				return false;
			}
			return false;

		}else{

			if($('.header .head_bott .catlink_wp').hasClass('opened')){
				$('.header .head_bott .catlink_wp').removeClass('opened');
			}else{
				$('.header .head_bott .catlink_wp').addClass('opened');
			}
			return false;
		}





	});

	if($(window).width() < 1023){
		if($('.header .head_bott .catlink_wp').hasClass('noclose')){
			$('.header .head_bott .catlink_wp').removeClass('opened');
			$('.header .head_bott .catlink_wp').removeClass('noclose');
		}
	}

	if($('.main_catlist .mc_list').length){
		$('.main_catlist .mc_list').each(function(){
			$(this).find('.mc_item').eq(3).addClass('last');
		});
	}

	if($('.cat_list').length){
		$('.cat_list').each(function(){
			$(this).find('.cat_item').last().addClass('last');
		});
	}

	if($('.cat_list_wp').length){
		$('.cat_list_wp').each(function(){
			$(this).last().css({'border-bottom':'1px solid #e7e8ee'});
		});
	}

	if($('.right_sidebar .cat_list').length){
		$('.cat_list').last().css({'border-bottom':'1px solid #e7e8ee'});
	}

	if($('.fav_page .cat_list').length){
		$('.cat_list').last().css({'border-bottom':'1px solid #e7e8ee'});
	}

	if($('#slider-range').length){
		$("#slider-range").slider({
		min: 0,
		max: 1000,
		values: [0,1000],
		range: true,
		//values:2,
		stop: function(event, ui) {
			jQuery("input#minCost").val(jQuery("#slider-range").slider("values",0));
			jQuery("input#maxCost").val(jQuery("#slider-range").slider("values",1));
		},
		slide: function(event, ui){
			jQuery("input#minCost").val(jQuery("#slider-range").slider("values",0));
			jQuery("input#maxCost").val(jQuery("#slider-range").slider("values",1));
			 $( ".amountfrom" ).val(ui.values[ 0 ]);
			$( ".amountto" ).val(ui.values[ 1 ] );
			$( "#amount" ).html(ui.values[ 0 ]);
			$( "#amount2" ).html(ui.values[ 1 ] );
		},
		values: [ parseInt($('.amountfrom').val()), parseInt($('.amountto').val())]

	});



	/*$('.ui-slider-handle.ui-state-default.ui-corner-all').eq(0).html('<span id="amount">'+parseInt($('.amountfrom').val())+'</span>');
	$('.ui-slider-handle.ui-state-default.ui-corner-all').eq(1).html('<span id="amount2">'+parseInt($('.amountto').val())+'</span>');*/
	$('.ui-slider-handle').eq(1).addClass('ui-slider-range-max');
	$('.ui-slider-handle').eq(0).addClass('ui-slider-range-min');


	}

	if($('.left_sidebar .fltr_section .fltr_list').length && $(window).width() >= 1023){
		$('.left_sidebar .fltr_section .fltr_list').each(function(){
			if($(this).find('li').length > 10 || $(this).find('li').length == 10){
				$(this).jScrollPane({height: 600});
				//bug...
				$(this).css('max-height', "250px");
			}
		});
	}



	if($('.shop_list').length){
		$('.shop_list').jScrollPane();
	}

	if($('.bask_pop .bask_container').length){
		$('.bask_pop .bask_container').jScrollPane();
	}

	$('.left_sidebar .left_fltr .fltr_section .section_btn').on('click', function(){
		if($(this).parents('.fltr_section').hasClass('active')){
			$(this).parents('.fltr_section').removeClass('active');
		}else{
			$(this).parents('.fltr_section').addClass('active');
			if($(this).find('li').length > 10 || $(this).find('li').length == 10){
				$(this).jScrollPane();
			}
		}
		return false;
	});

	$('.profilepage .prof_menu .profile_section .section_btn').on('click', function(){
		if($(this).parents('.profile_section').hasClass('opened')){
			$(this).parents('.profile_section').removeClass('opened');
		}else{
			$(this).parents('.profile_section').addClass('opened');
		}
		return false;
	});

	$('.leftside_menu .lm_section .section_btn').on('click', function(){
		if($(this).parents('.lm_section').hasClass('opened')){
			$(this).parents('.lm_section').removeClass('opened');
		}else{
			$(this).parents('.lm_section').addClass('opened');
		}
		return false;
	});

	if($('.im_thumbs').length){
		$('.im_thumbs').carouFredSel({
			direction: 'left',
			infinite: false,
			circular: false,
			auto:false,
			items        : 3,
			prev: '.dt_prev',
			next: '.dt_next',
			scroll:{
				items:1
			},
		});
	}

	$('.previtem').on('click',function()
	{
		var id = $(this).data('id');
		$('.previtem').removeClass('active');
		$(this).addClass('active');
		$('.detpage_im').find('.fullimgitem').hide();
		$('.detpage_im').find('#big_detailimg'+id).show();
	});

	$('.det_chars_wp .chars_links li a').on('click', function(){
		if($(this).hasClass('active')){
			return false;
		}else{
			var cur_th = $(this).parent('li').index();
			$('.det_chars_wp .chars_links li').removeClass('active');
			$(this).parent('li').addClass('active');
			$('.det_chars_wp .chars_thumbs li').removeClass('active');
			$('.det_chars_wp .chars_thumbs li').eq(cur_th).addClass('active');
			return false;
		}


	});

	$(window).load(function() {
		$(window).scroll(function(){

			var foot_pos = $('.footer').offset().top;
			var btn_pos = $(window).scrollTop() + $(window).height();

			/**/
			if( btn_pos > foot_pos){
				var raznica = btn_pos - foot_pos;
				raznica = raznica + 0;
				$('.slide_panel').css({'bottom': raznica+'px'}, 100);
			}else if(btn_pos = foot_pos){
				$('.slide_panel').css({'bottom':'-1px'}, 100);
			}else{
				$('.slide_panel').css({'bottom':'-1px'}, 100);
			}

		});
	});

	// scroll to top
	let mybutton = document.getElementById("stt");
	window.onscroll = function() {scrollFunction()};
	function scrollFunction() {
		if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
			mybutton.style.display = "flex";
		} else {
			mybutton.style.display = "none";
		}
	}


	$(document).ajaxSuccess(function(){
		if($('.slide_panel').length){
			var foot_pos = $('.footer').offset().top;
			var btn_pos = $(window).scrollTop() + $(window).height();
			if( btn_pos > foot_pos){
				var raznica = btn_pos - foot_pos;
				raznica = raznica + 0;
				$('.slide_panel').css({'bottom': raznica+'px'}, 100);
			}else if(btn_pos = foot_pos){
				$('.slide_panel').css({'bottom':'-1px'}, 100);
			}else{
				$('.slide_panel').css({'bottom':'-1px'}, 100);
			}
		}
	});


	if($('.slide_panel').length){
		$('.content').addClass('slided');
	}

	$('.header .head_top .location .location_lnk').on('click', function(){
		$('.global_overflow').show();
		var cur_sc = $(window).scrollTop() + 100;
		$('.locationform').css({'position':'absolute', 'top':cur_sc});
		$('.locationform').show();
		
		return false;
	});
	$('.loc a, .vibor_sklada').on('click', function(){
		$('.global_overflow').show();
		var cur_sc = $(window).scrollTop() + 100;
		$('.locationform').css({'position':'absolute', 'top':cur_sc});
		$('.locationform').show();
		return false;
	});

	$('.quickform  .loc a,.quickform .vibor_sklada').on('click', function(){
		$('.global_overflow').show();
		$('.quickform').hide()
		return false;
	});

	if($('.left_fltr').length){
		var left_h = $('.left_sidebar').height();
		var right_h = $('.right_sidebar').height();

		//console.log(left_h);
		//console.log(right_h);

		if( left_h < right_h){
			$('.left_sidebar').css({'min-height':right_h});
		}else if( left_h == right_h){
			$('.left_sidebar').css({'min-height':right_h});
		}

	}

	$('.top_clbk').on('click', function(){
		return false;
	});

	$('.tc_wp .ask, .foot_clbk.ask, .servpage .order_serv').on('click', function(){
		$('.global_overflow').show();
		var cur_sc = $(window).scrollTop() + 100;
		$('.callback.pop_up').css({'position':'absolute', 'top':cur_sc});
		$('.callback.pop_up').show();
		return false;
	});

	$('.vac_inner .share').on('click', function(){
		$('.global_overflow').show();
		var cur_sc = $(window).scrollTop() + 100;
		$('.vacancy.pop_up').css({'position':'absolute', 'top':cur_sc});
		$('.vacancy.pop_up').show();
		return false
	});

	$('.tc_wp .call, .foot_clbk.bk').click(function(){
		//alert('test');
		
		//alert('test2');
		var cur_sc = $(window).scrollTop() + 100;
		
		//$('.feedback.pop_up').css('z-index', 1);
		$('.global_overflow').fadeIn();
		//$('.global_overflow').css('-webkit-transform', 'translate3d(0,0,0)');
		
		$('.feedback.pop_up').fadeIn();
		$('.feedback.pop_up').css({'position':'absolute', 'top':cur_sc});
		//$('.feedback.pop_up').css('-webkit-transform', 'translate3d(0,0,1px)');
		//$('.global_overflow').css('z-index', 0);
		//$('.global_overflow').css('z-index', 1);
		//alert('test3');
		return false;
	});


	$('.semform.pop').on('click', function(){
		$('.global_overflow').show();
		var cur_sc = $(window).scrollTop() + 100;
		$('.seminar.pop_up').css({'position':'absolute', 'top':cur_sc});
		$('.seminar.pop_up').show();
		return false;
	});
	
	$('.semform_region.pop').on('click', function(){
		$('.global_overflow').show();
		var cur_sc = $(window).scrollTop() + 100;
		$('.seminar_region.pop_up').css({'position':'absolute', 'top':cur_sc});
		$('.seminar_region.pop_up').show();
		return false;
	});

	$('.cart_page .cart_right .account_block .opener').on('click', function(){
		if($(this).hasClass('opened')){
			$(this).removeClass('opened');
			$(this).parents('.account_block').find('.inp_wp').slideUp();
		}else{
			$(this).addClass('opened');
			$(this).parents('.account_block').find('.inp_wp').slideDown();
		}
		return false;
	});


	window.onscroll = function() {stickyHeader()};

	let header = document.getElementById("stickyHeader");
	let stt = document.getElementById("stt");
	let sticky = header.offsetTop;

	function stickyHeader() {
		if (window.pageYOffset > sticky) {
			header.classList.add("sticky");
			stt.setAttribute("style", "opacity:0.6;transition: 0.4s;");
		} else {
			header.classList.remove("sticky");
			stt.setAttribute("style", "opacity:0;transition: 0.4s;");
		}
	}







	/*MOBILE*/
	if($(window).width() < 1023){

		if($('.left_sidebar .fltr_section .fltr_list').length){
			$('.left_sidebar .fltr_section .fltr_list').each(function(){
				if($(this).find('li').length > 10 || $(this).find('li').length == 10){
					$(this).jScrollPane({height: 600});
					$(this).css('height', "250px");
				}
			});
		}

		if($('.left_sidebar .left_fltr .ttl').length){
			$( ".left_sidebar .left_fltr .ttl" ).replaceWith( "<a href='' class='ttl'>ПАРАМЕТРЫ ПОДБОРА</a>" );
		}
		
		
		$('.left_sidebar .left_fltr .ttl').on('click', function(){
			if($('.bx_filter').length){
				if($('.bx_filter').hasClass('opened')){
					$('.bx_filter').removeClass('opened');
					$('.bx_filter .popclose').remove();
					
					
					
				}else{
					$('.bx_filter').addClass('opened');
					$( "<a href='' class='popclose'></a>" ).appendTo( $( ".bx_filter" ) );
				}
			}
			
			if($('.left_sidebar .fltr_section .fltr_list').length){
				
				$('.left_sidebar .fltr_section .fltr_list').each(function(){
					if($(this).find('li').length > 10 || $(this).find('li').length == 10){
						$(this).jScrollPane({height: 600});
					}
				});
			}

			return false;
		});

		$('.bx_filter .popclose').on('click', function(){
			$('.bx_filter').removeClass('opened');
			$('.bx_filter .popclose').remove();
		});



		if($('.mainservices_block .services_ul').length){
			$('.mainservices_block .services_ul').bxSlider({
				controls:false,
				pager:true,
				pause:6000,
				nextText:'',
				prevText:'',
				mode:'horizontal',


			});
		}

		if($('.objects_wp .objects_slider').length){
			$('.objects_wp .objects_slider').bxSlider({
				controls:true,
				pager:false,
				pause:6000,
				nextText:'',
				prevText:'',
				mode:'fade',
				adaptiveHeight:true


			});
		}

		$('.footer .foot_mid .side .ttl').on('click', function(){
			if($(this).hasClass('opened')){
				$(this).removeClass('opened');
				$(this).next('.foot_menu').hide();
			}else{
				$(this).addClass('opened');
				$(this).next('.foot_menu').show();
			}
			return false;
		});

		$('.header .head_bott .catlink_wp .catlink_menu>li>a').on('click', function(){
			if($(this).parents('li').hasClass('opened')){
				$(this).parents('li').removeClass('opened');
				
			}else{
				$('.header .head_bott .catlink_wp .catlink_menu>li').removeClass('opened');
				$(this).parents('li').addClass('opened');
				
			}
			
			if ($(this).next().hasClass('cat_submenu'))
			{
				return false;
			}
			
		});

		if($('.detail_page .watched_slider').length){
			var ws_width = $(window).width();
			$('.detail_page .watched_slider li').css({'width':ws_width});

			$('.detail_page .watched_slider').carouFredSel({
				direction: 'left',
				infinite: true,
				circular: true,
				auto:false,
				prev: '.ws_prev',
				next: '.ws_next',
				scroll:{
					items:1
				},
				items:{
					visible:1
				},
				width:'100%',
				align:'left',
				height:'280px'
			});
		}

		$('.header .head_mid .search_wp .btn').on('click', function(){
			if($('.header .head_mid .search_wp').hasClass('opened')){
				return true;
			}else{
				$('.header .head_mid .search_wp').addClass('opened');
				return false;
			}
		});

		$('.header .head_mid .search_wp .btn_clear').on('click', function(){
			$('.header .head_mid .search_wp').removeClass('opened');
			$('.title-search-result').hide();
			return false;
		});

		if($('.header .head_top .lk_wp').hasClass('logged')){
			$('.lk_wrap').on('click', function(){
				if($('.header .head_top .lk_wp').hasClass('opened')){
					$('.header .head_top .lk_wp').removeClass('opened');
				}else{
					$('.header .head_top .lk_wp').addClass('opened');
				}
				return false;
			});
		}

		$('.header .head_top .top_submenu .ts_btn').on('click', function(){
			if($('.header .head_top .top_submenu').hasClass('opened')){
				$('.header .head_top .top_submenu').removeClass('opened');
			}else{
				$('.header .head_top .top_submenu').addClass('opened');
			}
			return false;
		});


	}
	/*MOBILE*/

	if ($('.video-slider-link').length > 0) { 
		$('.video-slider-link').click(function() {
			$('.video-slider-link').removeClass('active');
			$('.video-slider-link img').each(function() {
				$(this).attr('src', '/local/templates/termoros/img/num_bg.png');
			});
			
			$(this).addClass('active');
			$(this).find('img').attr('src', '/local/templates/termoros/img/num_bg2.png');
			
			dataId = $(this).attr('data-id');
			
			$('.video-slider-content').hide();
			$('.video-slider-content').each(function() {
				if ($(this).attr('data-id') == dataId) $(this).show();
			});
			
			return false;
		});
	}

});
