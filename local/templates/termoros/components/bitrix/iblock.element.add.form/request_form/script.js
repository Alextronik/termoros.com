jQuery(document).ready(function(){
	jQuery('#send_request').click(function() {
		jQuery('#request_form').slideToggle();
		return false;
	});
	jQuery('#add_more_doc').click(function() {
		var curFilesCount = jQuery(".anketa input[type=file]").length;
		jQuery(this).parent().before('<input type="hidden" value="" name="PROPERTY[644]['+curFilesCount+']"><div class="green_color">Прикрепить документ, подтверждающий квалификацию участника</div><div class="row"><input type="file" id="FILE_ID_'+curFilesCount+'" name="PROPERTY[644]['+curFilesCount+']" data-message="Прикрепить документ, подтверждающий квалификацию участника"></div><br>');
		/*
		jQuery('#FILE_ID_'+curFilesCount).filestyle({
			multiple: false,
			width : 400,
			height: 16
		});
		*/
		return false;
		
	});
	/*
	jQuery(".anketa select").coreUISelect({
		jScrollPane : {}
	});
	*/
	
	jQuery(".anketa input[type=file]").each(function(){
		var bmulti = false;
		if (jQuery(this).attr("multiple") == "multiple") {
			bmulti = true
		}
		/*
		jQuery(this).filestyle({
			multiple: bmulti,
			width : 400,
			height: 16
		});
		*/
	});
	
	var anketa_frm = jQuery("#anketa_frm");
	
	if (typeof jQuery.fn.maskInput == "function") {
		jQuery(".phone-number",anketa_frm).maskInput("+7 (999) 999-99-99");
	}
	/*
	anketa_frm.submit(function(){
		
	});
	*/
	/*
	anketa_frm.submit(function(){
		jQuery(this).ajaxSubmit({
			beforeSubmit: function(){
				jQuery.fancybox.showLoading();
			},
			success: function(responseText) {
				var arMessage = BX.parseJSON(responseText);
				
				if (arMessage.STATUS == "ERROR") {
					jQuery.fancybox({
						"content":arMessage.MESSAGE
					});
				} else if (arMessage.STATUS == "OK"){
					jQuery("#anketa_frm").fadeOut("slow",function(){
						jQuery(this).replaceWith(arMessage.MESSAGE);
					});
				}
				jQuery.fancybox.hideLoading();
			}
		}); 
		return false;
	});
	*/
	
	/*jQuery(document).on("click",".copy_study_btn",function() {
		var copy_study_wp = jQuery(this).closest(".copy_study_wp");		
		var copy_study = copy_study_wp.find(".copy_study:last");		
		
		var btrueval = true;
		copy_study.find("select,input,textarea").each(function(){
			if (!jQuery(this).val()) {
				btrueval = false;				
			}
		});
		
		if (!btrueval) {
			PX_FancyResult({
				"content":"Предыдущие данные указаны не полностью"
			});
			return false;
		}
		
		
		jQuery(".anketa select").coreUISelect("destroy");
		
		var parentclone = copy_study.clone(false);
		parentclone.find("select,input,textarea").val("");		
		copy_study_wp.append(parentclone);
		
		
		jQuery(".anketa select").coreUISelect({
			jScrollPane : { }
		});
		//PXScrollToNode(parentclone);		
		return false;
	});*/
});