$(document).ready(function()
{
	$('form.validate').on('submit',function(e)
	{
		if(!validate_form(this))
		{
			e.preventDefault();
		}
	});
	
	$('.error').on('focus',function()
	{
		$(this).removeClass('error');
		$(this).parent().find('.errorreport').next('img').remove();
		$(this).parent().find('.errorreport').remove();
	});
	
});

function validate_form(form,image,text_flag)
{
		var error = false;	
		var password = false;
		var confirm = false;
		
		$('.error_mess').remove();
		
		$('input,textarea',form).each(function()
		{
			//console.log('wadwadw');
			if(!$(this).attr('disabled'))
			{				
			
				//console.log($(this).val());
				//console.log($(this).attr('placeholder'));
				
				var img = '';
				var text = '';
				if(!image)
				{
					//img = '<img class="error_img" src="/bitrix/templates/eshop_adapt_blue/img/error_img.png">';
				}
				
				if(!text_flag)
				{

					//text = '<span class="error_mess">Это поле необходимо заполнить</span>';
				}				
				
				if($(this).data('req') == '1' && 
					(
						!$(this).val() 						
					)
				)
				{
					if(!$(this).parent().find('.errorreport').length)
					$(this).after('<div class="errorreport"></div>');
					
					$(this).parent().find('.errorreport').append('<span class="error_mess">Не заполнено поле. </span>');
					$(this).addClass('error');
					error = true;
				}	
				
				if($(this).data('req') == '1' && $(this).attr('type')=='checkbox' && !$(this).is(':checked'))
				{
					if(!$(this).parent().find('.errorreport').length)
					$(this).parent().find('label').after('<div class="errorreport"></div>'+img);  					
					//$(this).parent().find('.errorreport').append('<span class="error_mess">'+$(this).data('error_mes')+'</span>');
					$(this).parent().find('.errorreport').append('<span class="error_mess">'+$(this).data('error_mes')+'</span>');
					$(this).addClass('error');		
					error = true;
				}					
				
				if($(this).data('email') == '1')
				{
					if($(this).val()!='admin')
					{
						if(!validateEmail($(this).val()))
						{
							//if(!error)
							//	error = false;
							if(!$(this).parent().find('.errorreport').length)
							$(this).after('<div class="errorreport"></div>'+img); 		
							
							$(this).parent().find('.errorreport').append('<span class="error_mess">Введите E-mail формата example@mail.ru</span>');
							$(this).addClass('error');
							error = true;
							
						}
						else if(!$(this).val())
						{
							if(!$(this).parent().find('.errorreport').length)
							$(this).after('<div class="errorreport"></div>'+img); 				
						
							$(this).parent().find('.errorreport').append('<span class="error_mess">Введите E-mail формата example@mail.ru</span>');
							$(this).addClass('error');
							error = true;
						}
					}
					
				}
				
				if($(this).data('phone') == '1')
				{
					if(validatePhone($(this).val()))
					{
						if(!error)
							error = false;
					}
					else if(!$(this).val())
					{
						if(!$(this).parent().find('.errorreport').length)
						$(this).after('<div class="errorreport"></div>');
						
						$(this).parent().find('.errorreport').append('<span class="error_mess">Неверный формат телефона</span>');
						$(this).addClass('error');
						error = true;
					}				
				}
				
				if($(this).data('password')=='1')
				{
					password = $(this).val();
					if(password.toString().length < 6)
					{
						if(!$(this).parent().find('.errorreport').length)
							$(this).after('<div class="errorreport"></div>'+img); 
								
						$(this).parent().find('.errorreport').append('<span class="error_mess">Длина пароля должна быть больше 6 символов</span>')
						error = true;
						$(this).addClass('error');	
						
					}
				}
				
				if($(this).data('confirm')=='1')
				{
					confirm = $(this).val();
					if(password!=confirm)
					{
						if(!$(this).parent().find('.errorreport').length)
							$(this).after('<div class="errorreport"></div>');						
					
						$(this).parent().find('.errorreport').append('<span class="error_mess">Неверный повтор пароля</span>')
						error = true;
						$(this).addClass('error');
					}
				}								
			}			
		});				

	
		//alert(error);
		
		if(error)
		{
			var top = $('.error').offset().top-200;
			$(document).scrollTop(top);
			return false; 
			
		}
		else
		{
			return true;
		}		
}





$('input.error,textarea.error').on('keyup',function()
{
	$(this).removeClass('error');
	$(this).parent().find('.errorreport').remove();
});	

$('.errorreport').on('click',function(){
	console.log(122);
	$(this).parent().find('.error').removeClass('error');
	$(this).parent().find('.errorreport').remove();
});


$('.customCheckbox').on('click',function()
{
	$(this).removeClass('error');
	$(this).parent().find('.errorreport').remove();

});

function validateEmail(email) 
{
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}

function validatePhone(phone)
{
	var re = /^\+7\([0-9]{3}\)[0-9]{3}-[0-9]{2}\-[0-9]{2}/;
    return re.test(phone);
}
