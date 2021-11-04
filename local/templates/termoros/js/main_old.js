$(document).ready(function(){

	if($('.main_slider .slider_block').length){
		$('.main_slider .slider_block').bxSlider({
			controls:true,
			pager:false,
			pause:6000,
			nextText:'',
			prevText:'',
			mode:'fade'
			

		});
	}
	
	$('.header .head_mid .search_wp .inp_self').live('focusin', function(){
		$('.header .head_mid .search_wp .btn_clear').fadeIn();
	});

	$('.header .head_mid .search_wp .inp_self').live('focusout', function(){
		$('.header .head_mid .search_wp .btn_clear').fadeOut();
	});
	
	$('.header .head_mid .search_wp .btn_clear').live('click', function(){
		$('.header .head_mid .search_wp .inp_self').val('');
		return false;
	});
	
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
	
	$('.header .lk_wrap').live('click', function(){
		if($(this).attr("href")=="") {
			$('.loginform').show();
			$('.global_overflow').show();
			return false;
		}
	});
	
	$('.order_tend_info').live('click', function(){
		$('.tenderform').show();
		$('.global_overflow').show();
		return false;
	});
	
	$('.global_overflow').live('click', function(){
		$('.pop_up').hide();
		$('.global_overflow').hide();
		return false;
	});
	
	$('.popclose').live('click', function(){
		$('.pop_up').hide();
		$('.global_overflow').hide();
		return false;
	});
	
	$('.header .catlink_wp .catlink').live('click', function(){
		if($('.header .head_bott .catlink_wp').hasClass('opened')){
			$('.header .head_bott .catlink_wp').removeClass('opened');
		}else{
			$('.header .head_bott .catlink_wp').addClass('opened');
		}
		return false
	});
	
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
	
	if($('.left_sidebar .fltr_section .fltr_list').length){
		$('.left_sidebar .fltr_section .fltr_list').each(function(){
			if($(this).find('li').length > 10 || $(this).find('li').length == 10){
				$(this).jScrollPane();
			}
		});
	}
	
	$('.left_sidebar .left_fltr .fltr_section .section_btn').live('click', function(){
		if($(this).parents('.fltr_section').hasClass('opened')){
			$(this).parents('.fltr_section').removeClass('opened');
		}else{
			$(this).parents('.fltr_section').addClass('opened');
			if($(this).find('li').length > 10 || $(this).find('li').length == 10){
				$(this).jScrollPane();
			}
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
	
	$('.previtem').live('click',function()
	{
		var id = $(this).data('id');
		$('.previtem').removeClass('active');
		$(this).addClass('active');
		$('.detpage_im').find('.fullimgitem').hide();
		$('.detpage_im').find('#big_detailimg'+id).show();		
	});
	
	
});