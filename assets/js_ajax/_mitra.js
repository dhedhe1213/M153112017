
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

function sweetReview(title, pesan, img, url) {
    swal({
            title: title,
            text: pesan,
            imageUrl: base_url + "assets/images/sweet_alert/" + img,
            imageSize: "180x180",
            allowOutsideClick: true
        },
        function () {
            viewRewiew();
        });
}

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#tampil').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

//function deleteCart(data_id) {
//    var url_action = base_url+'mitra/deleteCart/'+data_id;
//
//    $.ajax({
//        type:"DELETE",
//        dataType: "JSON",
//        url: url_action,
//        success:function(response){
//            if(response.error == false){
//                var table = $('#' + data_table).DataTable();
//                table.ajax.reload(null, false); // user paging is not reset on reload}
//                sweet(response.title,response.pesan,'true.jpg','#');
//            }else{
//                sweet(response.title,response.pesan,'false.jpg','#');
//            }
//        }
//    });
//}

function searchFilter(page_num) {
    page_num = page_num?page_num:0;

    var cat1 = $('#cat1').val();
    var cat2 = $('#cat2').val();
    var cat3 = $('#cat3').val();

    var show = $('#showOn').val();
    var keywords = $('#keywords').val();
    var sortBy = $('#sortBy').val();
    $.ajax({
        type: 'POST',
        url: base_url+'mitra/item_filter/'+page_num,
        data:'page='+page_num+'&keywords='+keywords+'&sortBy='+sortBy+'&show='+show+'&cat1='+cat1+'&cat2='+cat2+'&cat3='+cat3,
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

function viewRewiew(page_num) {
    page_num = page_num?page_num:0;

    var id = $('#id_item').val();

    $.ajax({
        type: 'POST',
        url: base_url+'mitra/item_review/'+page_num,
        data:'page='+page_num+'&id='+id,
        beforeSend: function () {
            $('#Reviews').hide();
            $('.loading').show();
        },
        success: function (html) {
            $('.loading').hide();
            $('#Reviews').html(html);
            $('#Reviews').show();

        }
    });
}

function add_to_catalog(id_item){
    //var id_item = $('#add_to_catalog').val();
    $.ajax({
        type: "POST",
        dataType: "JSON",
        url: base_url + "mitra/act_add_to_catalog",
        data:'id_item='+id_item,
        beforeSend: function () {
            $('#add_to_catalog').button('loading');
        },
        success: function (response) {
            if (response.error == false) {
                sweet(response.title, response.pesan, 'true.jpg', '#');
            } else {
                $('#add_to_catalog').button('reset');
                sweet(response.title, response.pesan, 'false.jpg', '#');
            }
        }
    });
}

$(document).ready(function() {
    //karena per kategory jadi kategory nya harus di bawa terus
    var cat1 = $('#cat1').val();
    var cat2 = $('#cat2').val();
    var cat3 = $('#cat3').val();

   $('#keywords').autocomplete({
       minLength:2,
       source: base_url+'mitra/autocomplete_item/'+cat1+'/'+cat2+'/'+cat3
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
            url: base_url + "mitra/act_add_review",
            data: $('#form_add').serialize(),
            beforeSend: function () {
                $('#add_review').button('loading');
            },
            success: function (response) {
                if (response.error == false) {
                    $('#add_review').button('reset');
                    $('#form_add').trigger("reset");
                    sweetReview(response.title, response.pesan, 'true.jpg', '#');
                } else {
                    sweet(response.title, response.pesan, 'false.jpg', '#');
                }
            }
        });
    });

    $('#btn_edit_user').click(function () {
        var data = new FormData($("form_add")[0]);
        /*untuk ajax upload*/
        var formdata = new FormData();
        var file = $('#foto')[0].files[0];
        formdata.append('foto', file);
        $.each($('#form_edit_user').serializeArray(), function(a, b){
            formdata.append(b.name, b.value);
        });
        $.ajax({
            type: 'POST',
            dataType: "JSON",
            url: base_url + "mitra/act_edit_user",
            data: formdata,
            processData: false,
            contentType: false,
            beforeSend: function () {
                $('#btn_edit_user').button('loading');
            },
            success: function (response) {
                if (response.error == false) {
                    //$('#form_edit_user').trigger("reset");
                    //viewRewiew();
                    $('#btn_edit_user').button('reset');
                    sweet(response.title, response.pesan, 'true.jpg', 'mitra');
                } else {
                    $('#btn_edit_user').button('reset');
                    sweet(response.title, response.pesan, 'false.jpg', '#');
                }
            }
        });
    });

    $("#foto").change(function(){
        readURL(this);
    });

    $('#btn_edit_pass').click(function () {
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: base_url + "mitra/act_edit_pass",
            data: $('#form_edit_pass').serialize(),
            beforeSend: function () {
                $('#btn_edit_pass').button('loading');
            },
            success: function (response) {
                if (response.error == false) {
                    $('#btn_edit_pass').button('reset');
                    sweet(response.title, response.pesan, 'true.jpg', '#');
                } else {
                    $('#btn_edit_pass').button('reset');
                    sweet(response.title, response.pesan, 'false.jpg', '#');
                }
            }
        });
    });

    $('#btn_add_catalog').click(function () {
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: base_url + "mitra/act_add_catalog",
            data: $('#form_add').serialize(),
            beforeSend: function () {
                $('#btn_add_catalog').button('loading');
            },
            success: function (response) {
                if (response.error == false) {
                    $('#form_add').trigger("reset");
                    sweet(response.title, response.pesan, 'true.jpg', 'mitra');
                } else {
                    $('#btn_add_catalog').button('reset');
                    sweet(response.title, response.pesan, 'false.jpg', '#');
                }
            }
        });
    });



});
