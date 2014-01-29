jQuery(document).ready(function($) {
		$(':text, :password').val("");
		$("._form input[type='text'],._form input[type='password']")
		.focus(function(event) {
			$(this).css("box-shadow", "0px 0px 7px rgb(0, 102, 255)");
		}).blur(function(event) {
			$(this).css("box-shadow", "0px 0px 0px");				
		});	

		$('._form').submit(function(event) {
			var _login = $('#login').val();
			var _pass = $('#password').val();
			$.ajax({
				url: "ajax/auth_ajax.php",
				type: "POST",
				dataType: "text",
				success: function (data) {
					//alert(data);
					if (data!="")
					{
						$('#auth_error').html(data);	
					}
					else
					{
						document.location.href = "index.php";
					}			
				},
				error: function (obj, err) {
					alert("Error "+err);
				},
				data: {login: _login, pass: _pass}
			});
			return false;			
		});
	});