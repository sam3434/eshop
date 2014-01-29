jQuery(document).ready(function($) {
	$(document).on('click', '.info', function(event) {
		event.preventDefault();
		var _id = parseInt($(this).next("input.info").val());
		$.ajax({
			url: "utils/users/info_users.php",
			type: "GET",
			dataType: "text",
			success: function (data) {
				$("#info_users").html(data);
				$("html, body").animate({scrollTop: $("#info_users").offset().top}, 300);
			},
			error: function (obj, err) {
				alert("Error "+err);
			},
			data: {info_id: _id}
		});
		return false;
	});

	$(document).on('click', '.block', function(event) {
		event.preventDefault();
		id = parseInt($(this).parent().prev("input.info").val());
		link = $(this);
		var html = link.html();
		if (html.indexOf("Разблокировать")==-1) 
		{
			$('#myModalLabel').html('Блокировка пользователя');
			$('.modal-body p').html('Вы уверены что хотите заблокировать пользователя?');
		}
		else
		{
			$('#myModalLabel').html('Разблокирование пользователя');
			$('.modal-body p').html('Вы уверены что хотите разблокировать пользователя?');	
		}
	});

	$(document).on('click', '#myModal #confirm_btn', function(event) {
		event.preventDefault();
		$.ajax({
			url: "utils/users/user_block_ajax.php",
			type: "GET",
			dataType: "text",
			success: function (data) {
				//alert(data);
				window.location.href="users.php";
			},
			error: function (obj, err) {
				alert("Error "+err);
			},
			data: {block_id: id}
		});	
	});
});