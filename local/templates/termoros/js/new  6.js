/*V2*/
	
	/**/
	if($('.left_filter').length){
		var first_pos = $('.left_filter').offset().top;
		
		var w_h2 = $(window).height() - 300;
		
		var lf_minh = $('.left_filter>li').length * 35 +190;
		//var lf_minh = $('.left_filter>li').length * 35 +140;
		console.log($('.left_filter>li').length);
		$('.left_filter').css({'height':lf_minh});
		//$('.left_filter').css({'min-height':lf_minh});
		//$('.left_filter').css({'max-height':w_h2});
		/*$('.lf_1>a').live('click',function(){
			var inn_h = $(this).parent().find('.pars>li').length * 20;
			if($('.left_filter').hasClass('fixed_to_top')){
				if( inn_h > w_h2){
					$('.left_filter').css({'height':w_h2});
				}else{
					$('.left_filter').css({'height':lf_minh});
				}
			}else{
				if( inn_h > w_h2){
					var ft_h = w_h2 - $('.left_menu').height();
					$('.left_filter').css({'height':ft_h});
				}else{
					$('.left_filter').css({'height':lf_minh});
				}
			}
			
			
			
		});*/
		
		$('.lf_1.opened>a').live('click',function(){
					$('.left_filter').css({'height':lf_minh});

		});
					/*$('.left_filter').jScrollPane({
					autoReinitialise:true
					});*/
		$(window).scroll(function(){
			var foot_pos2 = $('.footer').offset().top;
			var btn_pos2 = $(window).scrollTop() + $(window).height();
			var btn_pos22 = $(window).scrollTop() +  151 + $('.left_filter').height();
			
			var w_h = $(window).height() - 300;
			
			if( $('.right_sidebar').height() > $('.left_sidebar').height()  ){
				
				/*if($('.left_filter').height() > w_h){
					
					$('.left_filter').css({'height':w_h});
					$('.left_filter').jScrollPane({
					autoReinitialise:true
					});
					
				}else{*/
					if( $(window).scrollTop() > first_pos - 120 ){					
						
						
						if( btn_pos22 > foot_pos2-100){
							var ff_raznica = btn_pos2 - foot_pos2;
							ff_raznica = ff_raznica + 40;
							$('.left_filter').css({'bottom': ff_raznica+'px','top':'auto', 'position':'fixed'}, 100);
						}else{
							var lf_ofset = $('.left_filter').position().top;
							
							$('.left_filter').css({'position':'fixed', 'top':'151px','bottom':'auto'});
							$('.left_filter').addClass('fixed_to_top');
						}
						/**/
					}else{
						$('.left_filter').css({'position':'relative', 'top':'0','bottom':'auto'});
						$('.left_filter').removeClass('fixed_to_top');
					}
				//}
				
				
				
			}
			
		});
	}
	
	/*V2*/