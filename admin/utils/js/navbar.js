jQuery(document).ready(function($) {
	var pagename = $('#pagename').html();
    $('.nav a').filter(function(index) {
        if ($.trim(this.innerHTML)==$.trim(pagename))
    	{
    		return true;
    	}
    }).parent().addClass('active');
});