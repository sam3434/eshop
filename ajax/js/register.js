var global_data;
$(function() {
	$( document ).tooltip({
		//track:true
	});
});

jQuery(document).ready(function($) {
	$(':text, :password, textarea').val("");
	$('._form').submit(function(event) {
		var _login = $('#login').val();
		var _pass = $("#pass").val();
		var _pass_rpt = $('#pass_rpt').val();
		var _fam = $('#fam').val();
		var _im = $('#im').val();
		var _ot = $('#ot').val();
		var _email = $('#email').val();
		var _tel = $('#tel').val();
		var _addr = $('#addr').val();
		$.ajax({
			url: "ajax/register_ajax.php",
			type: "POST",
			dataType: "json",
			success: function (data) {
				/*
				Глобально запоминаем ошибки, чтоб знать нужно ли при blur
				соотв. input выделять его красным (ошибочный) или белым
				*/
				global_data = data;
				var array = ["login", "pass", "pass_rpt", 
				"fam", "im", "ot", "email", "tel", "addr"];
				/*
				Выводим сообщения об ошибках заполнения полей при регистрации
				В array названия полей, для которых ошибка определена
				Идентификаторы input полей в форме совпадают с именами свойств
				в объекте data. Это позволило к свойствам data обращаться как к 
				data[array[i]], а к input через jQuery как $('#'+array[i]).					
				*/
				var first_error = null;
				for (var i in array)
				{
					if (data[array[i]])
					{
						first_error = first_error || array[i];
						$('#'+array[i]).next().html(data[array[i]]);
						$('#'+array[i]).css("box-shadow", "0px 0px 7px rgb(185, 74, 72)");
					}
					else
					{
						$('#'+array[i]).next().html("");
						$('#'+array[i]).css("box-shadow", "0px 0px 0px");	
					}	
				}
				$("html, body").animate({scrollTop: $("#"+first_error).offset().top-70}, 300);
						
				if (data['href']) 
				{
					window.location.href = data['href'];
				}
				
			},
			error: function (obj, err) {
				alert("Error "+err);
			},
			data: {login: _login, pass: _pass, pass_rpt: _pass_rpt,
			fam: _fam, im: _im, ot: _ot, email: _email, 
			tel: _tel, addr: _addr}
		});
		return false;			
	});

	$("._form input[type='text'],._form input[type='password'],._form textarea")
	.focus(function(event) {
		$(this).css("box-shadow", "0px 0px 7px rgb(0, 102, 255)");
	}).blur(function(event) {
		if (typeof(global_data) == "undefined")
		{
			$(this).css("box-shadow", "0px 0px 0px");	
		}
		else
		{
			if (typeof(global_data[$(this).attr('id')]) == "undefined") 
			{
				$(this).css("box-shadow", "0px 0px 0px");	
			}
			else
			{
				$(this).css("box-shadow", "0px 0px 7px rgb(185, 74, 72)");
			}				
		}
		
	});

});