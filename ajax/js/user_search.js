function is_int(n)
{
    return n%1 == 0;
}

jQuery(document).ready(function($) {

	$(document).on('click', '#search_user', search_user);
	$(document).on('click', 'a.paginate', search_paginate);

	function search_user(event)
    {
    	var s_site = $("#site").val();
    	var s_age = $("#age").val();
    	var s_city = $("#city").val();
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
        location.href = str+page+(page=="" ? "" : "&")+"s_site="+s_site+
        "&s_age="+s_age+"&s_city="+s_city;
        return false;
    }
});