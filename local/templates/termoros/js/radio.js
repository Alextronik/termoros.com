$(document).ready(function(){
	customInput();
    
});

function customInput() {
	$('input.customCheckbox').customCheckbox();
	$('input.customRadio').customRadio();
	$('select.customSelect').customSelect();
}

jQuery.fn.customSelect = function(_options) {
var _options = jQuery.extend({
	selectStructure: '<div class="selectArea"><div class="selectIn"><div class="selectText"></div></div></div>',
	selectText: '.selectText',
	selectBtn: '.selectIn',
	selectDisabled: '.disabled',
	optStructure: '<div class="select-sub"><ul></ul></div>',
	optList: 'ul'
}, _options);
return this.each(function() {
	var select = jQuery(this);
	if(!select.hasClass('outtaHere')) {
		//if(select.is(':visible')) {
			var replaced = jQuery(_options.selectStructure);
			var selectText = replaced.find(_options.selectText);
			var selectBtn = replaced.find(_options.selectBtn);
			var selectDisabled = replaced.find(_options.selectDisabled).hide();
			var optHolder = jQuery(_options.optStructure);
			var optList = optHolder.find(_options.optList);
			if(select.attr('disabled')) selectDisabled.show();
			select.find('option').each(function() {
				var selOpt = $(this);
				var _opt = jQuery('<li><a href="#">' + selOpt.html() + '</a></li>');
				if(selOpt.attr('selected')) {
					selectText.html(selOpt.html());
					_opt.addClass('selected');
				}
				_opt.children('a').click(function() {
					optList.find('li').removeClass('selected');
					select.find('option').removeAttr('selected');
					$(this).parent().addClass('selected');
					selOpt.attr('selected', 'selected');
					selectText.html(selOpt.html());
					optHolder.hide();
					select.change();
					return false;
				});
				optList.append(_opt);
			});
			if (select.attr('title')) selectText.html(select.attr('title'));
			replaced.width(select.outerWidth());
			replaced.insertBefore(select);
			replaced.addClass(select.attr('class'));
				optHolder.css({
					width: select.width(),
					display: 'none',
					position: 'absolute',
					zIndex: 4000
				});
			$(window).resize(function(){
				if(select.hasClass('resize')){
					var temp = select.parents('form').outerWidth()-157;
					replaced.width(temp+18);
					optHolder.css({
						width: temp+18
					});
				}
			});
			optHolder.addClass(select.attr('class'));
			jQuery(document.body).append(optHolder);
			
			var optTimer;
			replaced.hover(function() {
				if(optTimer) clearTimeout(optTimer);
			}, function() {
				optTimer = setTimeout(function() {
					optHolder.hide();
				}, 200);
			});
			optHolder.hover(function(){
				if(optTimer) clearTimeout(optTimer);
			}, function() {
				optTimer = setTimeout(function() {
					optHolder.hide();
				}, 200);
			});
			selectBtn.click(function() {
				if(optHolder.is(':visible')) {
					optHolder.hide();
				}
				else{
					optHolder.children('ul').css({height:'auto', overflow:'hidden'});
					optHolder.css({
						top: replaced.offset().top + replaced.outerHeight() -1,
						left: replaced.offset().left,
						display: 'block'
					});
					//if(optHolder.children('ul').height() > 100) optHolder.children('ul').css({height:100, overflow:'auto'});
				}
				return false;
			});
			select.addClass('outtaHere');
		//}
	}
});
}

jQuery.fn.customRadio = function(_options){
	var _options = jQuery.extend({
		radioStructure: '<span></span>',
		radioDisabled: 'radioAreaDisabled',
		radioDefault: 'radioArea',
		radioChecked: 'radioAreaChecked'
	}, _options);
	return this.each(function(){
		var radio = jQuery(this);
		if(!radio.hasClass('outtaHere') && radio.is(':radio')){
			var replaced = jQuery(_options.radioStructure);
			replaced.addClass(radio.attr('class'));
			this._replaced = replaced;
			if(radio.is(':disabled')) replaced.addClass(_options.radioDisabled);
			else if(radio.is(':checked')) replaced.addClass(_options.radioChecked);
			else replaced.addClass(_options.radioDefault);
			replaced.click(function(){
				if($(this).hasClass(_options.radioDefault)){
					/*radio.change();
					radio.attr('checked', 'checked');
					changeRadio(radio.get(0));*/ /*-------Бало--------*/
                    
                    radio.attr('checked', 'checked');/*------------нужно для AJAX-------------*/
                    radio.change();
					changeRadio(radio.get(0));
				}
			});
			radio.click(function(){
				changeRadio(this);
			});
			replaced.insertBefore(radio);
			radio.addClass('outtaHere');
		}
	});
	function changeRadio(_this){
		$('input:radio[name="'+$(_this).attr("name")+'"]').not(_this).each(function(){
			if(this._replaced && !$(this).is(':disabled')) this._replaced.removeClass('radioAreaChecked').removeClass('radioArea').addClass(_options.radioDefault);
		});
		_this._replaced.removeClass('radioAreaChecked').removeClass('radioArea').addClass(_options.radioChecked);
	}
}

jQuery.fn.customCheckbox = function(_options){
	var _options = jQuery.extend({
		checkboxStructure: '<span></span>',
		checkboxDisabled: 'disabled',
		checkboxDefault: 'checkboxArea',
		checkboxChecked: 'checkboxAreaChecked'
	}, _options);
	return this.each(function(){
		var checkbox = jQuery(this);
		if(!checkbox.hasClass('outtaHere') && checkbox.is(':checkbox')){
			var replaced = jQuery(_options.checkboxStructure);
			replaced.addClass(checkbox.attr('class'));
            
             if(checkbox.data('label')!=undefined)
			{
				replaced.text(checkbox.data('label'));
			}
            
            if(checkbox.data('color')!=undefined)
			{
				replaced.css('background','url("'+checkbox.data('color')+'")');
			}
            
            
			this._replaced = replaced;
			if(checkbox.is(':disabled')) replaced.addClass(_options.checkboxDisabled);
			else if(checkbox.is(':checked')) replaced.addClass(_options.checkboxChecked);
			else replaced.addClass(_options.checkboxDefault);
			
			replaced.click(function(){
				if(checkbox.is(':checked')) checkbox.removeAttr('checked');
				else checkbox.attr('checked', 'checked');
				changeCheckbox(checkbox);
			});
			checkbox.change(function(){
				changeCheckbox(checkbox);
			});
			replaced.insertBefore(checkbox);
			checkbox.addClass('outtaHere');
		}
	});
	function changeCheckbox(_this){
		if(_this.is(':checked')) _this.get(0)._replaced.removeClass('checkboxArea').removeClass('checkboxAreaChecked').addClass(_options.checkboxChecked);
		else _this.get(0)._replaced.removeClass('checkboxArea').removeClass('checkboxAreaChecked').addClass(_options.checkboxDefault);
	}
	
}
