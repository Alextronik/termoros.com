$(document).ready(function(){

    if ($('.fltr_list').length)
	{
		$('.fltr_list').each(function() {
			if ($(this).find('label').not('.disabled').length)
			{
				//console.log(1);
			}
			else
			{
				//console.log(2);
				$(this).parent().hide();
				//console.log(3);
			}
		});
		if ($('.tech_page').length > 0)
		{
			$("#id_arrFilter_ff\\[NAME\\]").parent().parent().parent().show();
			
			//console.log($("#id_arrFilter_ff\\[NAME\\]").html());
		}
	}
	
	$('.inp_line_wp .add_line').on("click", function () {
       var newLine = $('.inp_line_wp .inp_line').first().clone();

        newLine.find("input").val('');
        newLine.find("input.short").val('1');
        newLine.find("p.inp_val").html("0<span>руб.</span>");

        $('.inp_line_wp .inp_line').last().after(newLine);
        return false;
    });
    $('.inp_line_wp .inp_line .delete_line').on("click",function () {


        if($('.inp_line_wp .inp_line').length == 1)
        {
            $(this).parents(".inp_line").find('input').val('');
            $(this).parents(".inp_line").find('input.short').val('1');
            $(this).parents(".inp_line").find("p.inp_val").html("0<span>руб.</span>");
        }
        else
        {
            $(this).parents(".inp_line").remove();
        }

        return false;
    });
    $('.inp_line_wp .inp_line .inp_self.short').on("keyup",function () {
        var ob = $(this);
        var qua = $(this).val();
        var itemLine = ob.parents('.inp_line');
        var price = itemLine.data('price');
        if(qua < 1 || !$.isNumeric(qua))
        {
            qua = 1;
            ob.val(1);
        }
        else
        {
            ob.attr('value' , qua);
        }
        if(price > 0)
        {
            itemLine.find('p.inp_val.sum').html((price * qua) + "<span>руб.</span>");
        }

    });
    $(".inp_line_wp").on("click",'.to_basket',function () {
        var f = $(this).parents(".inp_line_wp");
        if ($("#multi_basket").length > 0) {
            $("#multi_basket").attr("id", "multi_basket").html(f.html());
        }
        else
        {
            $("<form/>").attr("id","multi_basket").html(f.html()).hide().appendTo($("body"));
        }
        var data = $("#multi_basket").serialize();
        if(data != "")
        {
            $.ajax({
                url: '/local/templates/.default/ajax/scripts/add_to_cart_multy.php',
                type: 'POST',
                data: data,
                success: function(response){
                    location.reload();
                }
            });
        }
        return false;
    });
    $('.inp_line_wp ').on("blur",'.inp_line .item_atr',function () {
        var ob = $(this);
        var itemLine = ob.parents('.inp_line');
        var code = ob.val();
        var qua = itemLine.find('.inp_self.short').val();
        var url = '/local/templates/.default/ajax/scripts/get_tov_info.php?ATR=' + code;
        if(code.length > 2)
        {
            $.ajax({
                url: url,
                type: 'GET',
                contentType: 'json',
                success: function(response){

                    //console.log(response);
                    if(response.ID)
                    {
                        itemLine.data("price", response.PRICE);
                        itemLine.find('p.inp_val.price').html(response.PRICE.toString() + "<span>руб.</span>");
                        itemLine.find('p.inp_val.sum').html(Math.round((response.PRICE * qua)) + "<span>руб.</span>");
                        itemLine.find('input.h_id_inp').val(response.ID);
                        itemLine.find('input.item_atr').removeClass('bad_atr');
                    }
                    else 
                    {
                        itemLine.data("price", 0);
                        itemLine.find('p.inp_val.price').html("0<span>руб.</span>");
                        itemLine.find('p.inp_val.sum').html("0<span>руб.</span>");
                        itemLine.find('input [type="hidden"]').val('');
                        itemLine.find('input.item_atr').addClass('bad_atr');
                    }
                }
            });
        }
    });
    $(".add_by_art .insert_file").on("click",function () {
        $("#xls_input").click();
        return false
    });
    $("#xls_input").on("change",function () {
        var input = $("#xls_input");
        var fd = new FormData;

        fd.append('img', input.prop('files')[0]);

        $.ajax({
            url: '/include/PHPExcel_1.8.0_doc/get_tov_list_by_file.php',
            data: fd,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (data) {
                $(".add_by_art .inp_line_wp").html(data);
                $('.inp_line input.item_atr').blur();
            }
        });
        input.val("");
    });

    $('.pm_section.add input[name="ATR"], .add_by_art input.item_atr').on("keyup",function () {
        var ob = $(this);
        var atr = ob.val();
        if(atr.length > 1)
        {
            $.ajax({
                url: '/local/templates/.default/ajax/scripts/get_atr_serch_result.php',
                type: 'POST',
                data: 'atr=' + ob.val(),
                success: function(response){
                    $("#atr_autocomplete").remove();
                    ob.after(response);
                    if(ob.hasClass("item_atr"))
                    {
                        $("#atr_autocomplete").css("margin-left","0");
                    }
                }
            });

        }
    });
    $('.pm_section.add .inp_wp.row').on("click",'p.atr_rez_rou',function () {
        var ob = $(this);
        var atr = ob.data('atr');
        ob.parents('.inp_wp').find('input[name="ATR"]').val(atr);
        $("#atr_autocomplete").remove();
    });
    $('.inp_line_wp .inp_line').on("click",'#atr_autocomplete p',function () {
        var ob = $(this);
        var atr = ob.data('atr');
        ob.parents('.inp_line').find('input.item_atr').val(atr).blur();
        $("#atr_autocomplete").remove();
    });
    $('#atr_autocomplete').on("mouseleave",function () {
       $(this).remove();
    });
	$('.ob_opener').on('click', function(){

		return false;
	});

	/*$('.top_clbk,.foot_clbk').click(function()
	{
		$('.pop_up.callback').show();
		$('.global_overflow').show();
		return false;
	});*/
	$('.send').on('click', function(e){
		e.preventDefault();
		$('.global_overflow').show();
		$('.added.pop_up').remove();
		$("body").append("<div class='added pop_up tomail' style='display: block;'><form method='get'><div style='padding: 0px 55px;' class='inpt'><p class='inp_name' >Введите E-mail</p><input type='hidden' value='"+$(this).attr('data-id')+"' name='id' /><input type='text' data-req='1' class='inp_self' value='' name='email' /><input style='margin-top: 15px;' class='formsubmit snd pop_btn' name='web_form_submit' value='Отправить' type='submit'></div><div class='popclose'></div></form></div>");


	});

	$('.tomail form').on('submit',function(e){
		if(validate_form($(this))){

		$.fancybox.showLoading();
		var data = $(this).serialize();
		var contain = $(this).parent();

		console.log(data);
			$.ajax({
				type: 'GET',
				url: '/local/templates/.default/ajax/scripts/tomail.php',
				data: data+'&ajax=y',
				success: function(html) {
					$.fancybox.hideLoading();
					console.log(html);
					$(contain).find('.inpt').empty().html('<span class="rules">Письмо отправлено!</span>');
					//$(contain).find('input').remove();
					//$(contain).find('.inp_self').remove();
					//$(contain).find('form').append('<span class="compltomail" >отправлено</span>');
				}
			});
		}
		return false;
	});


	$('form[name="SIMPLE_FORM_1"],form[name="SIMPLE_FORM_2"],form[name="SIMPLE_FORM_3"],form[name="SIMPLE_FORM_4"],form[name="SIMPLE_FORM_5"],form[name="SIMPLE_FORM_6"],form[name="SIMPLE_FORM_7"],form[name="SITE_ERROR"],form[name="SIMPLE_FORM_31"]').on('submit',function(e)
	{

		if(validate_form($(this))){

		var data = $(this).serialize();
		data = data + '&ajax=y&web_form_submit=y';
		var o = $(this);
		console.log(data);
		$.ajax({
			type: 'POST',
			url: '/local/templates/.default/ajax/scripts/callback.php',
			data: data,
			success: function(html) {
				if(html)
				{
					$(o).parents('.pop_up').html(html);
				}
			}
		});

		}
		e.preventDefault();
	});
    if($('.left_sidebar .bx_filter .bx_filter_parameters_box.active .bx_filter_parameters_box_container').length){
        $('.left_sidebar .bx_filter .bx_filter_parameters_box.active  .bx_filter_parameters_box_container').each(function(){
            if($(this).find('li').length > 10 || $(this).find('li').length == 10){
                $(this).jScrollPane();
            }
        });
    }
    $("#top_auth_form").on("submit",function(){

            var error;
            var data = $(this).serialize();
            var contain = $(this).parent(".pop_left");
            var inp = $(this).find("input");
            $(inp).removeClass("error");
            $(this).find(".errorreport").remove();

            for(var i=0;i<inp.length;i++){
                if($(inp[i]).val()==""){
                    $(inp[i]).addClass("error");
                    $(inp[i]).after("<span class='errorreport'>Введите "+$(inp[i]).siblings('.inp_name').text()+"</span>");
                    error = true;
                }
            }

            //console.log(data);
        if(!error) {
            $.ajax({
                type: 'POST',
                url: '/local/templates/.default/ajax/scripts/auth.php',
                data: data,
                success: function (html) {
                    //console.log(html);
                    if(html=="OK"){
                        $(".pop_soc").remove();
                        $(".pop_inn").html("<p style='text-align: center;'>Вы успешно авторизировались</p>");
                        setTimeout('location.reload()', 1000);
                    }
                    else {
                        $(contain).html(html);
                        customInput();
                    }
                }
            });
        }
        return false;
    });

    $("#top_reg_form").on("submit",function() {

        var error;
        var data = $(this).serialize()+"&register_submit_button=reg";
        var contain = $(this).parent(".pop_right");
        var inp = $(this).find("input");
        $(inp).removeClass("error");
        $(this).find(".errorreport").remove();

        for (var i = 0; i < inp.length; i++) {
            if ($(inp[i]).val() == "") {
                $(inp[i]).addClass("error");
                $(inp[i]).after("<span class='errorreport'>Введите " + $(inp[i]).siblings('.inp_name').text() + "</span>");
                error = true;
            }
        }
       if (!error) {
            var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
            if (!pattern.test($(inp[0]).val())) {
                $(inp[0]).addClass("error");
                $(inp[0]).after("<span class='errorreport'>Некорректный E-mail</span>");
                error = true;
            }
        }
        if (!error) {
            if ($(inp[1]).val()!=$(inp[2]).val()) {
                $(inp[2]).addClass("error");
                $(inp[2]).after("<span class='errorreport'>Неверное подтверждение пароля</span>");
                error = true;
            }
        }

       // console.log(data);
        if(!error) {
            $.ajax({
                type: 'POST',
                url: '/local/templates/.default/ajax/scripts/reg.php',
                data: data,
                success: function (html) {
                   // console.log(html);
                    if(html=="OK"){
                        $(".pop_soc").remove();
                        $(".pop_inn").html("<p style='text-align: center;'>Вы успешно зарегистрировались</p>");
                        setTimeout('location.reload()', 1000);
                    }
                    else {
                        $(contain).html(html);
                        customInput();
                    }
                }
            });
        }
        return false;
    });

    $(".more").on("click",function(){
        var lincks=$(".chars_links").find("a");
        for(var i=0;i<lincks.length;i++){
            if($(lincks[i]).text()=="Характеристики"){
                $(lincks[i]).click();
            }
        }
    });

	$('.brands_block .show_more').on('click',function(e){
		ob = this;



		$(this).addClass("wheel");
            var data = $(this).attr("href");
            var contain = $(this).parents(".container");
            console.log(data);
            $.ajax({
                type: 'GET',
                url: data,
                success: function(html) {

					$(html).find(".brands_block .container .brands_list").insertAfter($(".brands_block .container .brands_list:last"));
                    if($(html).find("a.show_more").length>0){
                        $(contain).find(".show_more").attr("href",$(html).find(".show_more").attr("href"))
                    }
                    else{
                        $(contain).find(".show_more").remove();
                    }
					$(ob).removeClass("wheel");

				/**/

		if($('.slide_panel').length){

			var foot_pos = $('.footer').offset().top;
			var btn_pos = $(window).scrollTop() + $(window).height();

				/**/
				if( btn_pos > foot_pos){
					var raznica = btn_pos - foot_pos;
					raznica = raznica - 10;
					$('.slide_panel').css({'bottom': raznica+'px'}, 100);
				}else if(btn_pos = foot_pos){
					$('.slide_panel').css({'bottom':'-1px'}, 100);
				}else{
					$('.slide_panel').css({'bottom':'-1px'}, 100);
				}
		}
		/**/

				}

            });



        return false;
    });

	$('.brands_page .show_more.news.brands').on('click',function(e){

		ob = this;
		$(this).addClass("wheel");
        var data = $(this).attr("href");
		if ($(this).parents(".right_sidebar").length)
		{
			var contain = $(this).parents(".right_sidebar");
		}
		else
		{
			var contain = $(this).parents(".container");
		}
		
        $.ajax({
            type: 'GET',
            url: data,
            success: function(html) {

                $('.brands_page_list:last').after($(html).find(".brands_page_list"));
				
                if($(html).find("a.show_more").length>0)
				{
					$(contain).find(".show_more").attr("href",$(html).find(".show_more").attr("href"));
				}
                else
				{
                    $(contain).find(".show_more").remove();
                }
				
				//console.log($(contain).find(".show_more").attr("href"));
				
				customInput();
                $(contain).find(".pager").html($(html).find(".pager").html());
				$(ob).removeClass("wheel");

            }
        });
        return false;
    });

    $('.popular_block .show_more').on('click',function(e){
		ob = this;
		$(this).addClass("wheel");
            var data = $(this).attr("href");
            var contain = $(this).parents(".popular_block");
            console.log(data);
            $.ajax({
                type: 'GET',
                url: data,
                success: function(html) {
                    console.log(html);

                    $(html).find(".cat_list").appendTo($(contain).find(".cat_list_wp"));
                    if($(html).find("a.show_more").length>0){
                        $(contain).find(".show_more").attr("href",$(html).find(".show_more").attr("href"))
                    }
                    else{
                        $(contain).find(".show_more").remove();
                    }
					$(ob).removeClass("wheel");
                }
            });

        return false;
    });

    $(".sort_sel").on("change",function(){
		$(this).parents("form").submit();
    });

	$('.tech_docs .show_more').on('click',function(e){

		ob = this;
		$(this).addClass("wheel");
        var data = $(this).attr("href");
        var contain = $(this).parents(".right_sidebar");
        console.log(data);
        $.ajax({
            type: 'GET',
            url: data,
            success: function(html) {
                console.log(html);

                $(html).find(".tech_table tr").appendTo($(".tech_table tbody"));

                if($(html).find("a.show_more").length>0){
                    $(contain).find(".show_more").attr("href",$(html).find(".show_more").attr("href"))
                }
                else{
                    $(contain).find(".show_more").remove();
                }
				customInput();
                $(contain).find(".pager").html($(html).find(".pager").html());
				$(ob).removeClass("wheel");

            }
        });
        return false;
    });

	$('.video-blk .show_more').on('click',function(e){

		ob = this;
		$(this).addClass("wheel");
        var data = $(this).attr("href");
        var contain = $(this).parents(".right_sidebar");
        console.log(data);
        $.ajax({
            type: 'GET',
            url: data,
            success: function(html) {
                console.log(html);

                $(html).find(".video-table tr").appendTo($(".video-table"));

                if($(html).find("a.show_more").length>0){
                    $(contain).find(".show_more").attr("href",$(html).find(".show_more").attr("href"))
                }
                else{
                    $(contain).find(".show_more").remove();
                }
                $(contain).find(".pager").html($(html).find(".pager").html());
				$(ob).removeClass("wheel");
            }
        });
        return false;
    });

    $('.right_sidebar .show_more,.search_page .show_more').on('click',function(e){
        if($(this).hasClass('news')) return false;

        ob = this;
        $(this).addClass("wheel");
        var data = $(this).attr("href");
        var contain = $(this).parents(".right_sidebar");
        $.ajax({
            type: 'GET',
            url: data,
            success: function(html) {
                $('.cat_list').last().css({'border-bottom':'0px'});
                $('.cat_item').last().removeClass('last');
                $(html).find(".cat_list").appendTo($(".cat_list_block"));
                $(html).find('.brands_line').appendTo($('.brands_page_list'));

                if($(html).find("a.show_more").length>0){
                    $(contain).find(".show_more").attr("href",$(html).find(".show_more").attr("href"))
                }
                else{
                    $(contain).find(".show_more").remove();
                }
                $(contain).find(".pager").html($(html).find(".pager").html());

                $('.cat_list').last().css({'border-bottom':'1px solid #e7e8ee'});

                $('.cat_list').each(function(){
                    $(this).find('.cat_item').last().addClass('last');
                });
                $(ob).removeClass("wheel");
            }
        });
        return false;
    });



	/**/

	$('.news_page .show_more.news').on('click',function(e){
		$(this).addClass("wheel");
		ob = this;
        var data = $(this).attr("href");
        var contain = $(this).parents(".main_articles");
        //console.log(data);
        $.ajax({
            type: 'GET',
            url: data,
            success: function(html) {
                //console.log($(html).find(".main_articles"));

                $('.main_articles:last').after($(html).find(".main_articles"));

                if($(html).find("a.show_more").length>0){
                    //$(contain).find(".show_more").attr("href", $(html).find(".show_more").attr("href"));
					//console.log($(html).find(".show_more").attr("href"));
					//console.log();
					$(".show_more").attr("href", $(html).find(".show_more").attr("href"));
                }
                else{
                    $(".show_more").remove();
                }
				$(".pager").html($(html).find(".pager").html());

				$(ob).removeClass("wheel");
            }
        });

        return false;
    });

	$('.with .show_more').on('click',function(e){
		$(this).addClass("wheel");
		ob = this;
        var data = $(this).attr("href");
        var contain = $(this).parents(".with");
        console.log(data);
        $.ajax({
            type: 'GET',
            url: data,
            success: function(html) {
                //console.log(html);
                $('.cat_list').last().css({'border-bottom':'0px'});
                $('.cat_item').last().removeClass('last');
                $(html).find(".cat_list").appendTo($(".cat_list_block"));

                if($(html).find("a.show_more").length>0){
                    $(contain).find(".show_more").attr("href",$(html).find(".show_more").attr("href"))
                }
                else{
                    $(contain).find(".show_more").remove();
                }
                $(contain).find(".pager").html($(html).find(".pager").html());

                    $('.cat_list').last().css({'border-bottom':'1px solid #e7e8ee'});

                    $('.cat_list').each(function(){
                        $(this).find('.cat_item').last().addClass('last');
                    });
				$(ob).removeClass("wheel");
            }
        });

        return false;
    });


	$('.analogs .show_more').on('click',function(e){
		ob = this;
		$(this).addClass("wheel");
        var data = $(this).attr("href");
        var contain = $(this).parents(".analogs");
        //console.log(data);
        $.ajax({
            type: 'GET',
            url: data,
            success: function(html) {
                //console.log(html);
                $('.cat_list').last().css({'border-bottom':'0px'});
                $('.cat_item').last().removeClass('last');
                $(html).find(".cat_list").appendTo($(".cat_list_block"));

                if($(html).find("a.show_more").length>0){
                    $(contain).find(".show_more").attr("href",$(html).find(".show_more").attr("href"))
                }
                else{
                    $(contain).find(".show_more").remove();
                }
                $(contain).find(".pager").html($(html).find(".pager").html());

                    $('.cat_list').last().css({'border-bottom':'1px solid #e7e8ee'});

                    $('.cat_list').each(function(){
                        $(this).find('.cat_item').last().addClass('last');
                    });
			$(ob).removeClass("wheel");
            }
        });
        return false;
    });

	$('.pop_btn.accept_geo').on('click', function(){
			//$.fancybox.showLoading();
			var id = $(this).data('id');
			var button = $(this);

			$.ajax({
				type: 'POST',
				url: '/local/templates/.default/ajax/scripts/geoip_ajax.php',
				data: "action=SETGEO&id="+id,
				success: function(html){
					console.log(html);
					if(html == 'true'){
						$(button).hide();
						location.reload();
					}else{
						alert('geoip_accept_error');
					}

					//$.fancybox.hideLoading();
				}
			});
		return false;
	});

	$('.btn.set_geo').on('click', function(){
			//$.fancybox.showLoading();
			var id = $(this).siblings('.city_tmp_id').val();
			var city = encodeURIComponent($(this).siblings('#tmp_val').val());
			var button = $(this);

			if(id == '0') return false;

			$.ajax({
				type: 'POST',
				url: '/local/templates/.default/ajax/scripts/geoip_ajax.php',
				data: "action=SETGEO&id="+id+"&city="+city,
				success: function(html){
					console.log(html);
					if(html == 'true'){
						location.reload();
					}else{
						alert('geoip_accept_error');
					}

					//$.fancybox.hideLoading();
				}
			});
		return false;
	});

	$('.citystorechange').on('click', function(){

		var id = $(this).val();
		if($(this).is('span')){
			id = $(this).next().val();
		}

		$.ajax({
			type: 'POST',
			url: '/local/templates/.default/ajax/scripts/geoip_ajax.php',
			data: "action=SETGEO&id="+id,
			success: function(html){
				//console.log(html);
				if(html == 'true'){
					location.reload();
				}else{
					alert('geoip_accept_error');
				}
			}
		});


		return false;
	});

	$('.to_basket.ajax.list').on('click', function(){
		//$('.quickform').remove();
		//var current_top = $(window).scrollTop();
		var butt = $(this);

		var data = $(this).siblings('form[name="fastfind"]').serialize();
		
		var quantity = $(this).parent().prev().find('.inp_self').val();
		if (quantity) data = data + '&quantity='+quantity;
		
			$.fancybox.showLoading();

			$.ajax({
				type: 'POST',
				url: '/local/templates/.default/ajax/scripts/add_to_cart.php',
				data: data+'&action=ADD2BASKET',
				success: function(html) {
					$.fancybox.hideLoading();
					$('.added.pop_up').remove();
					$("body").append("<div class='added pop_up' style='display: block;'>"+html+"<div class='popclose'></div></div>");

					getBasket();
					$(butt).text('В корзине');
					$(butt).addClass('active');
                    BX.onCustomEvent('OnBasketChange');

					 setTimeout(closePopup, 2000);
				}
			});




		return false;
	});
	
    $('.ADD2BASKET .to_basket, .ADD2BASKET .quick_basket').on('click', function(){
        
		var data = $(this).parents("form").serialize();
		var butt = $(this);

        $.ajax({
            type: "POST",
            url: "/local/templates/.default/ajax/scripts/add_to_cart.php",
            data: data,
            success: function(html){
				$.fancybox.hideLoading();
                $('.added.pop_up').remove();
                $("body").append("<div class='added pop_up' style='display: block;'>"+html+"<div class='popclose'></div></div>");

				getBasket();

                if(!butt.hasClass("quick_basket")) {
                    $(butt).text('В корзине');
                    $(butt).addClass('active');
                }
                BX.onCustomEvent('OnBasketChange');
                setTimeout(closePopup, 2000);
            }
        });

        return false;
    });

	$('.compare_btn').on('click', function(){
			$('.added.pop_up').remove();
			$.fancybox.showLoading();

			var obj = $(this);
			var data = 'ID=' + $(this).data('id') + '&action=COMPARE';

			$.ajax({
				type: 'POST',
				url: '/local/templates/.default/ajax/scripts/add_compare.php',
				data: data,
				success: function(html) {
					$('.global_overflow').hide();
					$.fancybox.hideLoading();
					$("body").append("<div class='added pop_up' style='display: block;'><div class='popclose'></div><p class='obrt'><a class='to_basket' style='display: block; text-align: center;' href='/personal/compare'>Товар добавлен в сравнение</a></p></div>");
					$(obj).addClass('active');
					getcompare();
				}
			});
			setTimeout(function(){
				$('.global_overflow').hide();
				$('.quick_block.ajax.added_item_pop').hide();
			}, 3000);

		return false;
	});

	$('.quick_btn').on('click', function(){
		$('.quickform').remove();
		var current_top = $(window).scrollTop();
		var data = $(this).parent().find('form[name="fastfind"]').serialize();

			$.fancybox.showLoading();

			$.ajax({
				type: 'POST',
				url: '/local/templates/.default/ajax/scripts/elempage.php',
				data: data,
				success: function(html) {
					$.fancybox.hideLoading();
					$('body').append(html);
					$('.global_overflow').show();
					$('.quickform').css({'top':current_top + 50});
					$('.quickform').show();
					
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
			});

		return false;
	});


	$('.fav_btn').on('click', function(){

		$('.added.pop_up').remove();

		if($(this).hasClass('del')){

			$.fancybox.showLoading();

			var obj = $(this);
			var data = 'ID=' + $(this).data('id') + '&action=DEL2FAV';

			$.ajax({
				type: 'POST',
				url: '/local/templates/.default/ajax/scripts/add_fav.php',
				data: data,
				success: function(html) {
					$.fancybox.hideLoading();
					//$("body").append("<div class='added pop_up' style='display: block;'><div class='popclose'></div><p class='obrt'><a class='to_basket' style='display: block; text-align: center;'  href='/personal/fav/'>Товар удален из избранного</a></p></div>");
					$(obj).removeClass('active');
					getfav();

					$.ajax({
						type: 'GET',
						url: '/personal/fav/',
						success: function(section){
							$('.inner_contentblock').html($(section).find('.cat_list_block.cat_list_wp'));
						}
					});
				}
			});
		}else if(!$(this).hasClass('active')){
			$.fancybox.showLoading();

			var obj = $(this);
			var data = 'ID=' + $(this).data('id') + '&action=ADD2FAV';

			$.ajax({
				type: 'POST',
				url: '/local/templates/.default/ajax/scripts/add_fav.php',
				data: data,
				success: function(html) {
					//$('.global_overflow').hide();
					$.fancybox.hideLoading();
					//$("body").append("<div class='added pop_up' style='display: block;'><div class='popclose'></div><p class='obrt'><a class='to_basket' style='display: block; text-align: center;'  href='/personal/fav/'>Товар добавлен в избранное</a></p></div>");
					$(obj).addClass('active');
					getfav();
				}
			});
			setTimeout(function(){
				//$('.global_overflow').hide();
				$('.quick_block.ajax.added_item_pop').hide();
			}, 3000);

		}else{
			$.fancybox.showLoading();

			var obj = $(this);
			var data = 'ID=' + $(this).data('id') + '&action=DEL2FAV';

			$.ajax({
				type: 'POST',
				url: '/local/templates/.default/ajax/scripts/add_fav.php',
				data: data,
				success: function(html) {
					$.fancybox.hideLoading();
					//$("body").append("<div class='added pop_up' style='display: block;'><div class='popclose'></div><p class='obrt'><a class='to_basket' style='display: block; text-align: center;'  href='/personal/fav/'>Товар удален из избранного</a></p></div>");
					$(obj).removeClass('active');
					getfav();
				}
			});

			setTimeout(function(){
				//$('.global_overflow').hide();
				$('.quick_block.ajax.added_item_pop').hide();
			}, 3000);

		}



		return false;
	});

	$('.delay-order-cart').on('click', function(){
        $.fancybox.showLoading();

        $.ajax({
            type: "POST",
            url: "/local/templates/.default/ajax/scripts/order.php",
            data: 'action=ADD2ORDER',
            success: function(html){
				$.fancybox.hideLoading();
                $('.added.pop_up').remove();
                $("body").append("<div class='added pop_up' style='display: block;'><div class='popclose'></div><p class='obrt' style='text-align: center;'>Отложенный заказ добавлен</p></div>");

                setTimeout(closePopup, 2000);
            }
        });

        return false;
    });
	
	$('.order_catalog').on('click', function(){
        $.fancybox.showLoading();

        $.ajax({
            type: "POST",
            url: "/local/templates/.default/ajax/scripts/add_to_cart.php",
            data: 'action=ADD2BASKET&id=53174',
            success: function(html){
				location.reload();
            }
        });

        return false;
    });


    $('.loginform input').on('change',function()
    {
        //console.log($(this).val());
        $(this).val($(this).val().trim());
    });

    $('.loginform input').on('keyup',function()
    {
        //console.log($(this).val());
        $(this).val($(this).val().trim());
    });

});

function getBasket(){

	$.get('/local/templates/.default/ajax/scripts/basket.php').success(function(e){
		var basket = $(e).html();
		$('.header .bask').html(e);
		if($('.bask_pop .bask_container').length){
			$('.bask_pop .bask_container').jScrollPane();
		}
	});
}

function getfav(){

	$.ajax({
		type: 'GET',
		url: '/local/templates/.default/ajax/scripts/add_fav.php',
		data: 'action=GETCNT',
		success: function(basket){
			$('.fav_link .val').text(basket);
			$('.slide_panel').removeClass('hide');
			//if(basket && !$('.fav').hasClass('active')) $('.fav').addClass('active');
		}
	});
}

function getcompare(){

	$.ajax({
		type: 'GET',
		url: '/local/templates/.default/ajax/scripts/add_fav.php',
		data: 'action=GETCOMPARE',
		success: function(basket){
			$('.comp_link .val').text(basket);
			$('.slide_panel').removeClass('hide');
			//if(basket && !$('.fav').hasClass('active')) $('.fav').addClass('active');
		}
	});
}

function getfavSection(){
	$.ajax({
		type: 'GET',
		url: '/bitrix/templates/s/ajax/fav_section.php',
		data: '',
		success: function(section){
			$('.fav-contain').html(section);
			customInput();
		}
	});
}

function basketReff(data){
	var data = data+"&BasketRefresh=Y";
	//console.log(data);
	$.ajax({
		type: 'GET',
		url: '/bitrix/templates/s/ajax/basketReff.php',
		data: data,
		success: function(basket){
			$.fancybox.hideLoading();
			$('.basket-contain').remove();
			$('.ajax-basket').html(basket);
			$('.global_overflow').hide();
			getbasket();
		}
	});
}


function closePopup()
{
    $(".addtocart.popup").hide();
    $('.added.pop_up').hide('slow');
}

function SendFile(ob) {
	//отправка файла на сервер

	if(ob.value.indexOf(".pdf")>0||ob.value.indexOf(".doc")>0||ob.value.indexOf(".docx")>0||ob.value.indexOf(".ppt")>0||ob.value.indexOf(".pptx")>0)
	{
	//console.log(ob.value.indexOf(".pdf"));
		$$f({
			formid:'test_form',//id формы
			url:'/local/templates/.default/ajax/scripts/file.php',//адрес на серверный скрипт который будет принимать файл
			onstart:function () {//действие при начале загрузки файла
				//$$('result','начинаю отправку файла');//в элемент с id="result" выводим результат
			},
			onsend:function () {//действие по окончании загрузки файла
				//$$('result',$$('result').innerHTML+'<br />файл успешно загружен');//в элемент с id="result" выводим результат
			}
		});
	}
	else
	{
		var files=parent.window.document.getElementById("files");
		files.innerHTML="<p class=\'error sub\' >Недопустимый тип файла!</p>";
	}
	return false;
}

function DeleteFile()
{
	$.ajax({
		type: 'POST',
		url: '/local/templates/.default/ajax/scripts/delete_file.php',
		data: '',
		success: function(html) {
			$('#files').html('');
			$('.file_form').val('');
			console.log(html);
		}
	});
}

function unchecks(){
	$('.left_fltr input:checked').removeAttr('checked');

}

function setFilterPage(obj){

	var ob = obj;
	$(obj).attr('checked', 'checked');
	var data = $('.left_fltr form').serialize();
	var datasend;

	$.fancybox.showLoading();

	console.log(ob);

	if(data){
		datasend = data + '&ajax=Y';
	}
	else{
		datasend = '&ajax=Y';
	}

	console.log(datasend);
	//console.log($('.left_fltr form').attr('action'));

	$.ajax({
		type: 'GET',
		url: $('.left_fltr form').attr('action'),
		data: datasend,
		success: function(html) {
			//console.log(html);
			if(html)
			{
				//console.log(html);
				path = $('.left_fltr form').attr('action');// +'?'+ datasend;

				//console.log(path);
				$('.inner_contentblock').html($(html).find('.tech_docs'));

				customInput();
				hist(path,'ajax_catalog',false,name,datasend);
				$.fancybox.hideLoading();
			}
		},
			error: function() {
			$.fancybox.hideLoading();
		}
	});

}

var histAPI=!!(window.history && history.pushState);
var loc = '';


function hist (histurl,p,blabla,title_fb,data) {

	//histurl = histurl.replace('/&ajax=Y/i','');
	if (histAPI) {
	thist = 1;
		if(!blabla)
		{
			window.history.pushState({title: title_fb,data: data}, document.title, histurl);
			return false;
		}

	} else {
		if(!blabla)
		{
			loc = window.location.hash = decodeURIComponent(histurl);
			return false
		}
	}

}

function setCookie(c_name, value, exdays) {
    console.log("mmm");
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var c_value = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString());
    document.cookie = c_name + "=" + c_value;
}