function get_parametr_from_url(param)
{
    var query = window.location.search.substring(1);
    var vars = query.split("&");
    for (var i = 0; i < vars.length; i++) {
        var pair = vars[i].split("=");
        if (pair[0]==param)
            return pair[1];
    };
    return -1;
}

jQuery(document).ready(function($) {
	$(document).on('click', 'a.paginate', search_paginate);    

	sel_val = $("#product_show_with").val();
	$("#product_show_with").change(function () {
		var val = $(this).val();
		if (val!==sel_val)
		{
			sel_val = val;
			page = "page=1";
			var str;
			if ((index = location.href.indexOf("?"))!=-1)
			{
			    str = location.href.substring(0, index+1);
			}
			else
			{
			    str = location.href+"?";
			}
			var param = get_parametr_from_url("cat");
			var param_str = "";
			if (param!==-1)
			{
				param_str = "&cat="+param;
			}
			location.href = str+page+(page=="" ? "" : "&")+"psw="+val+param_str;
		}
	});	

	$('.basket-btn').click(function (e) {
		var prod = $(this).prev().val();
		if (confirm("Вы уверены, что хотите добавить товар в корзину?"))
		{
			$.ajax({
					url: "products/basket_ajax.php",
					type: "POST",
					dataType: "text",
					success: function (data) {
						//alert(data);
						alert("Товар добавлен в корзину!")
						location.href = "basket.php";
					},
					error: function (obj, err) {
						alert("Error "+err);
					},
					data: {prod: prod}
				});
		}
		return false;
	});

	$(document).on('click', '.delete_from_basket', function () {
		var prod = $(this).next().val();
		if (confirm("Вы уверены, что хотите удалить товар из корзины?"))
		{
			$.ajax({
						url: "templates/show_basket.php",
						type: "POST",
						dataType: "text",
						success: function (data) {
							$('#basket_ajax').html(data);							
						},
						error: function (obj, err) {
							alert("Error "+err);
						},
						data: {delete_id: prod}
					});
		}
		return false;
	});

	$(document).on('click', '.make_order', function () {
		if (confirm("Вы уверены, что хотите сделать заказ на все эти товары?"))
		{
			var user_id = $(this).next().val();
			$.ajax({
						url: "products/make_order_ajax.php",
						type: "POST",
						dataType: "text",
						success: function (data) {
							//alert(data)	
							alert("Ваша заявка отправлена")
							location.href = "index.php";					
						},
						error: function (obj, err) {
							alert("Error "+err);
						},
						data: {user_id: user_id}
					});
		}
		return false;
	});

	$('a.disabled').click(function (e) {
		return false;
	});
});


