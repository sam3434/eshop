function is_int(n)
{
    return n%1 == 0;
}

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

$(document).ready(function () {  
    $('.dropdown-toggle').dropdown();

    $(document).on('dblclick', '#characters tr td:nth-child(2)', function(event) {
        event.preventDefault();
        if ($(this).prev().html()=="")
        {
            return false;
        }
        text = $(this).html();
        $(this).html('<input type="text" name="" id="">');
        $input = $(this).find("input");
        $input.val(text);
        $input.blur(function(){
            $(this).parent().html($input.val());
        });
        $input.focus();        
        // Act on the event
    });
   
    $(document).on('click', '#confirm_btn_char', function(event) {
        event.preventDefault();
        $removed_icon.parent().parent().parent().hide('400', function(){
            $(this).remove();
        });
    });

    $(document).on('click', '#confirm_btn_crt_char', function(event) {
        var name = $('#name_character').val();
        var value = $('#value_character').val();
        $('#tr_insert').before("<tr><td>"+name+"</td><td>"+value+"</td><td><a href='#ModalDeleteChar' data-toggle='modal'><i class='icon-remove remove_char'></i></a></td></tr>");
        // $('i.icon-remove').click(function(event) {
        //     $removed_icon = $(this);
        // });
    });

    $(document).on('click', 'i.remove_char', function(event) {
        event.preventDefault();
        $removed_icon = $(this);
    });

    $('#create_product').submit(function(event) {
        var name = $('#name').val();
        var small_pic = $('#small_pic').val();
        var big_pic = $('#big_pic').val();
        var price = $('#price').val();
        var short_desc = $('#short_desc').val();
        var long_desc = $('#long_desc').val();
        var trs_length = $('#characters tr').length;
        var mode;
        var id = get_parametr_from_url("id");
        if ($.trim($('#main_button').html())=="Изменить")
        {
            mode = "edit";
        }
        else
        {
            mode = "create";
        }
        var chars = {};
        $('#characters tr').each(function(index, val) {
            if ((index!=0) && (index!=trs_length-1))
            {
                var childs = $(val).children();
                chars[$(childs[0]).html()] = $(childs[1]).html();
            } 
        });
        var category_id = $('ul.nav-list li.active a').next().val();
        $.post("utils/products/prod_ajax.php", {"chars":chars, name : name,
            small_pic:small_pic, big_pic:big_pic, price:price, 
            short_desc:short_desc, long_desc:long_desc, category_id:category_id, mode:mode, id:id},{},"json")
        .done(
            function(data) {
                var array = ["name", "price"];
                var $first_error;
                for (var i in array)
                {
                    if (data[array[i]])
                    {
                        $first_error = $first_error||$("#"+array[i]);
                        $("#"+array[i]).parent().parent().addClass("error");
                        $("#"+array[i]).after("<span class='help-inline'>"+data[array[i]]+"</span>")
                    }
                    else
                    {
                           
                    }   
                }
                if (data['href']) 
                {
                    window.location.href = data['href'];
                }
                else
                {
                    $("html, body").animate({scrollTop: $first_error.offset().top-10}, 300);
                }
        })
        .fail(
            function(){
                //alert("Извините, ошибка. Внимательно просмотрите все поля")
                window.location.href = "products.php";
            }
        );
        return false;
    });

    $(document).on('click', '#confirm_btn_crt_category', function(event) {
        event.preventDefault();
        var name_category = $("#name_category").val();
        var desc_category = $("#desc_category").val();      
        $.post('utils/products/create_category.php', {name_category: name_category,
        desc_category : desc_category}, function(data, textStatus, xhr) {
            alert(data["err"])
            var array = ["name_category", "desc_category"];
            for (var i in array)
            {
                if (data[array[i]])
                {
                    $("#"+array[i]).parent().parent().addClass("error");
                    $("#"+array[i]).after("<span class='help-inline'>"+data[array[i]]+"</span>")
                }
            }
        }, "json");
        $('#ModalCreateCategory').modal("hide");
        return false;
    });

    $(document).on('click', '#confirm_btn_del_prod', function(event) {
        //var delete_id = $(this).next().val();
        $.post('utils/products/delete_product.php', {delete_id: delete_id}, 
            function(data, textStatus, xhr) {
                window.location.href = "products.php";
        });
        
    });    

    $(document).on('click', 'a.remove_product', function(event) {
        delete_id = $(this).next().next().val();
    });

    $(document).on('click', 'i.edit_product', function(event) {
        edit_id = $(this).next().val();
        window.location.href = "add_product.php?id="+edit_id;
    });

    $(document).on('click', 'i.edit_image', function(event) {
        edit_id = $(this).next().next().next().val();
        window.location.href = "change_image.php?id="+edit_id;
    });

    function search_product(event)
    {
        var search_date_added = $('#date_added').val();
        var search_categories = $.trim($('#categories option:selected').text());
        var search_price = $('#price').val();
        var search_sorting = $('#sorting').val();
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
        location.href = str+page+(page=="" ? "" : "&")+"search_categories="+search_categories+"&search_date_added="+search_date_added
        +"&search_price="+search_price+"&search_sorting="+search_sorting;
        return false;
    }

    $(document).on('click', '#search', search_product);
    $(document).on('click', 'a.paginate', search_paginate);    
}); 


