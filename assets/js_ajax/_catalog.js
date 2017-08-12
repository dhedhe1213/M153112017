
function sweet(title, pesan, img, url) {
    swal({
            title: title,
            text: pesan,
            imageUrl: base_url + "assets/images/sweet_alert/" + img,
            imageSize: "180x180",
            allowOutsideClick: true
        },
        function () {
            window.location.href = url;
        });
}

function sweet_catalog_review(title, pesan, img, url) {
    swal({
            title: title,
            text: pesan,
            imageUrl: base_url + "assets/images/sweet_alert/" + img,
            imageSize: "180x180",
            allowOutsideClick: true
        },
        function () {
            viewRewiewCatalog();
        });
}


function searchFilter(page_num) {
    page_num = page_num?page_num:0;


    var nm_catalog = $('#nm_catalog').val();

    var show = $('#showOn').val();
    var keywords = $('#keywords').val();
    var sortBy = $('#sortBy').val();
    $.ajax({
        type: 'POST',
        url: base_url+'catalog/item_filter/'+page_num,
        data:'page='+page_num+'&keywords='+keywords+'&sortBy='+sortBy+'&show='+show+'&nm_catalog='+nm_catalog,
        beforeSend: function () {
            $('.product-list').hide();
            $('.loading').show();
        },
        success: function (html) {
            $('.loading').hide();
            $('.product-list').html(html);
            $('.product-list').show();

        }
    });
}
function viewRewiewCatalog(page_num) {
    page_num = page_num?page_num:0;

    var nm_catalog = $('#nm_catalog').val();

    $.ajax({
        type: 'POST',
        url: base_url+'catalog/catalog_review/'+page_num,
        data:'page='+page_num+'&nm_catalog='+nm_catalog,
        beforeSend: function () {
            $('#Reviews').hide();
            $('.loading-catalog').show();
        },
        success: function (html) {
            $('.loading-catalog').hide();
            $('#Reviews').html(html);
            $('#Reviews').show();

        }
    });
}



$(document).ready(function() {
    //karena per kategory jadi kategory nya harus di bawa terus
    var nm_catalog = $('#nm_catalog').val();

   $('#keywords').autocomplete({
       minLength:2,
       source: base_url+'catalog/autocomplete_item/'+nm_catalog
   });


    $('#btn_search').click(function(){
        searchFilter();
    });

    $('#keywords').keypress(function(e){
        if(e.which == 13) {
            searchFilter();
        }
    });

    $('#sortBy').change(function(){
        searchFilter();
    });

    $('#showOn').change(function(){
        searchFilter();
    });

    $('#add_review').click(function () {
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: base_url + "catalog/act_add_review",
            data: $('#form_add').serialize(),
            beforeSend: function () {
                $('#add_review').button('loading');
            },
            success: function (response) {
                if (response.error == false) {
                    $('#add_review').button('reset');
                    $('#form_add').trigger("reset");
                    $('#add_review').button('reset');
                    sweet_catalog_review(response.title, response.pesan, 'true.jpg', '#')
                } else {
                    $('#add_review').button('reset');
                    sweet(response.title, response.pesan, 'false.jpg', '#');
                }
            }
        });
    });

});


