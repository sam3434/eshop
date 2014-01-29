function is_int(n)
{
    return n%1 == 0;
}

function search_paginate() 
{
    var search_link_html = $(this).html();
    var page="";
    if (is_int(search_link_html))
    {
        page = "page="+search_link_html;
    }
    if (search_link_html=="...")
    {
        var tmp = $(this).attr("href");
        var page = tmp.substring(tmp.indexOf("=")+1, tmp.length);
        page = "page="+page;
    }        
    var ref = location.href;
    if (ref.indexOf("page=")===-1)
    {
        if (ref.indexOf("?")!==-1)
        {
            ref += "&";
        }
        else
        {
            ref += "?";
        }
        ref += "page=1";
    }

    var arr = ref.split("page=");
    if (arr.length==1)
    {
        location.href = ref+"?"+page;
    }
    else
    {
        var index_ask;
        if ((index_ask=arr[1].indexOf("&"))!==-1)
        {
            var substr = arr[1].substring(index_ask, arr[1].length);
            location.href = arr[0]+page+substr;
        }
        else
        {
            location.href = arr[0]+page;
        }
    }
    return false;
}