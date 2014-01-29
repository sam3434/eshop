jQuery(document).ready(function($) {
	$('ul.nav-list li>a').on('click', function(event) {
		event.preventDefault();
		$("ul.nav-list li.active").removeClass("active");
		$(this).parent().addClass("active");
		
	});

});