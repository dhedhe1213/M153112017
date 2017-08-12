
function sweet_delete(data_id,data_table) {
    swal({
            title: "Are you sure?",
            text: "You will not be able to recover this record!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: true
        },
        function (isConfirm) {
            if (isConfirm) {
                act_delete(data_id,data_table);
            }
        });

}

function sweet_confirm(data_id) {
    swal({
            title: "Are you sure?",
            text: "this is about money, please be careful!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, confirm it!",
            closeOnConfirm: true
        },
        function (isConfirm) {
            if (isConfirm) {
                $("#conf_pembayaran").html('wait a moment...');
                act_confirm(data_id);
            }
        });

}

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


function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#tampil').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function delete_global(data_id){
    var data_table = $('.fa-trash-o').attr('data-table');
    sweet_delete(data_id,data_table);
}


function act_delete(data_id,data_table) {
    var url_action = base_url+'dashboard/act_delete/'+data_id+'/'+data_table;

    $.ajax({
        type:"DELETE",
        dataType: "JSON",
        url: url_action,
        success:function(response){
            if(response.error == false){
                if(data_table == 'r_cat_item'){
                    $('.'+ data_id).hide();
                }else {
                    var table = $('#' + data_table).DataTable();
                    table.ajax.reload(null, false); // user paging is not reset on reload
                }
                sweet(response.title,response.pesan,'true.jpg','#');
            }else{
                sweet(response.title,response.pesan,'false.jpg','#');
            }
        }
    });
}

function act_confirm(data_id) {
    var url_action = base_url+'dashboard/act_confirm/'+data_id;

    $.ajax({
        type:"UPDATE",
        dataType: "JSON",
        url: url_action,
        success:function(response){
            if(response.error == false){
                sweet(response.title,response.pesan,'true.jpg',base_url+'dashboard/confPembayaran');
            }else{
                sweet(response.title,response.pesan,'false.jpg','#');
            }
        }
    });
}

function actPayment(nm_catalog){
    $('#modalPayment').modal('show');
    $('#nm_catalog').val(nm_catalog);
}

function actPaymentSeller(id_seller){
    $('#modalPayment').modal('show');
    $('#id_seller').val(id_seller);
}

$(document).ready(function() {

    $("#btn-payment-reseller").click(function () {
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: base_url + "dashboard/act_paymentReseller",
            data: $('#form-payment').serialize(),
            beforeSend: function () {
                $('#btn-payment-reseller').button('loading');
            },
            success: function (response) {
                if (response.error == false) {
                    $('#modalPayment').modal('hide');
                    sweet(response.title, response.pesan, 'true.jpg', base_url + 'dashboard/paymentReseller');
                } else {
                    $('#btn-payment-reseller').button('reset');
                    sweet(response.title, response.pesan, 'false.jpg', '#');
                }
            }
        });
    });

    $("#btn-payment-refund").click(function () {
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: base_url + "dashboard/act_paymentRefund",
            data: $('#form-payment').serialize(),
            beforeSend: function () {
                $('#btn-payment-refund').button('loading');
            },
            success: function (response) {
                if (response.error == false) {
                    $('#modalPayment').modal('hide');
                    sweet(response.title, response.pesan, 'true.jpg', base_url + 'dashboard/paymentRefund');
                } else {
                    $('#btn-payment-refund').button('reset');
                    sweet(response.title, response.pesan, 'false.jpg', '#');
                }
            }
        });
    });

    $("#btn-payment-seller").click(function () {
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: base_url + "dashboard/act_paymentSeller",
            data: $('#form-payment').serialize(),
            beforeSend: function () {
                $('#btn-payment-seller').button('loading');
            },
            success: function (response) {
                if (response.error == false) {
                    $('#modalPayment').modal('hide');
                    sweet(response.title, response.pesan, 'true.jpg', base_url + 'dashboard/paymentSeller');
                } else {
                    $('#btn-payment-seller').button('reset');
                    sweet(response.title, response.pesan, 'false.jpg', '#');
                }
            }
        });
    });

    $("#edit_user_admin").click(function () {
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: base_url + "dashboard/act_edit_user",
            data: $('#form_edit').serialize(),
            beforeSend: function () {
                $('#edit_user_admin').button('loading');
            },
            success: function (response) {
                if (response.error == false) {
                    sweet(response.title, response.pesan, 'true.jpg', base_url + 'dashboard/user');
                } else {
                    $('#edit_user_admin').button('reset');
                    sweet(response.title, response.pesan, 'false.jpg', '#');
                }
            }
        });
    });

    $("#add_about").click(function () {
        // save TinyMCE instances before serialize
        tinyMCE.triggerSave();
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: base_url + "dashboard/act_add_about",
            data: $('#form_add').serialize(),
            beforeSend: function () {
                $('#add_about').button('loading');
            },
            success: function (response) {
                if (response.error == false) {
                    sweet(response.title, response.pesan, 'true.jpg', base_url + 'dashboard/about/' + response.category);
                } else {
                    $('#add_about').button('reset');
                    sweet(response.title, response.pesan, 'false.jpg', '#');
                }
            }
        });
    });

    $("#edit_about").click(function () {
        // save TinyMCE instances before serialize
        tinyMCE.triggerSave();
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: base_url + "dashboard/act_edit_about",
            data: $('#form_add').serialize(),
            beforeSend: function () {
                $('#edit_about').button('loading');
            },
            success: function (response) {
                if (response.error == false) {
                    sweet(response.title, response.pesan, 'true.jpg', base_url + 'dashboard/about/' + response.category);
                } else {
                    $('#edit_about').button('reset');
                    sweet(response.title, response.pesan, 'false.jpg', '#');
                }
            }
        });
    });

    $("#thumbnail").change(function(){
        readURL(this);
    });

    $("#add_blog").click(function () {
        var data = new FormData($("form_add")[0]);
        // save TinyMCE instances before serialize
        tinyMCE.triggerSave();

        /*untuk ajax upload*/
        var formdata = new FormData();
        var file = $('#thumbnail')[0].files[0];
        formdata.append('thumbnail', file);
        $.each($('#form_add').serializeArray(), function(a, b){
            formdata.append(b.name, b.value);
        });
        $.ajax({
            type: 'POST',
            dataType: "JSON",
            url: base_url + "dashboard/act_add_blog",
            data: formdata,
            processData: false,
            contentType: false,
            beforeSend: function(){
                $('#add_blog').button('loading');
            },
            success: function (response) {
                        if (response.error == false) {
                            sweet(response.title, response.pesan, 'true.jpg', base_url + 'dashboard/blog/' + response.category);
                        } else {
                            $('#add_blog').button('reset');
                            sweet(response.title, response.pesan, 'false.jpg', '#');
                        }
                    }
        });

    });

    $("#edit_blog").click(function () {
        var data = new FormData($("form_add")[0]);
        // save TinyMCE instances before serialize
        tinyMCE.triggerSave();

        /*untuk ajax upload*/
        var formdata = new FormData();
        var file = $('#thumbnail')[0].files[0];
        formdata.append('thumbnail', file);
        $.each($('#form_add').serializeArray(), function(a, b){
            formdata.append(b.name, b.value);
        });
        $.ajax({
            type: 'POST',
            dataType: "JSON",
            url: base_url + "dashboard/act_edit_blog",
            data: formdata,
            processData: false,
            contentType: false,
            beforeSend: function(){
                $('#edit_blog').button('loading');
            },
            success: function (response) {
                if (response.error == false) {
                    sweet(response.title, response.pesan, 'true.jpg', base_url + 'dashboard/blog/' + response.category);
                } else {
                    $('#edit_blog').button('reset');
                    sweet(response.title, response.pesan, 'false.jpg', '#');
                }
            }
        });

    });

    $("#add_cat").click(function () {
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: base_url + "dashboard/act_add_cat",
            data: $('#form_add').serialize(),
            beforeSend: function(){
                $('#add_cat').button('loading');
            },
            success: function (response) {
                if (response.error == false) {
                    sweet(response.title, response.pesan, 'true.jpg', base_url + 'dashboard/cat_item/' + response.category);
                } else {
                    $('#add_cat').button('reset');
                    sweet(response.title, response.pesan, 'false.jpg', '#');
                }
            }
        });
    });

    $("#edit_cat").click(function () {
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: base_url + "dashboard/act_edit_cat",
            data: $('#form_add').serialize(),
            beforeSend: function(){
                $('#edit_cat').button('loading');
            },
            success: function (response) {
                if (response.error == false) {
                    sweet(response.title, response.pesan, 'true.jpg', base_url + 'dashboard/cat_item/' + response.category);
                } else {
                    $('#edit_cat').button('reset');
                    sweet(response.title, response.pesan, 'false.jpg', '#');
                }
            }
        });
    });

//    ++++++++++++++++++++++++++++++++++LOAD DATA TABLE++++++++++++++++++++++++++++++++++++++++++++++
    $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
    {
        return {
            "iStart": oSettings._iDisplayStart,
            "iEnd": oSettings.fnDisplayEnd(),
            "iLength": oSettings._iDisplayLength,
            "iTotal": oSettings.fnRecordsTotal(),
            "iFilteredTotal": oSettings.fnRecordsDisplay(),
            "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
            "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
        };
    };

    var cat = $('.category').val();

    //Table About
    var t = $("#t_about").dataTable({

        initComplete: function() {
            var api = this.api();
            $('#t_about_filter input')
                .off('.DT')
                .on('keyup.DT', function(e) {
                    if (e.keyCode == 13) {
                        api.search(this.value).draw();
                    }
                });
        },
        oLanguage: {
            sProcessing: "loading..."
        },
        processing: true,
        serverSide: true,
        ajax: {"url": base_url +"dashboard/load_tb_about/"+cat, "type": "POST"},
        columns: [
            {
                "data": "id",
                "orderable": false
            },
            {"data": "title"},
            {"data": "description"},
            {"data": "view","orderable": false}
        ],
        order: [[1, 'asc']],
        rowCallback: function(row, data, iDisplayIndex) {
            var info = this.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
            var index = page * length + (iDisplayIndex + 1);
            $('td:eq(0)', row).html(index);
        }
    });

    //table blog
    var blog = $("#t_blog").dataTable({

        initComplete: function() {
            var api = this.api();
            $('#t_about_filter input')
                .off('.DT')
                .on('keyup.DT', function(e) {
                    if (e.keyCode == 13) {
                        api.search(this.value).draw();
                    }
                });
        },
        oLanguage: {
            sProcessing: "loading..."
        },
        processing: true,
        serverSide: true,
        ajax: {"url": base_url +"dashboard/load_tb_blog/"+cat, "type": "POST"},
        columns: [
            {
                "data": "id",
                "orderable": false
            },
            {"data": "title"},
            {"data": "description"},
            {"data": "thumbnail"},
            {"data": "view","orderable": false}
        ],
        order: [[1, 'asc']],
        rowCallback: function(row, data, iDisplayIndex) {
            var info = this.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
            var index = page * length + (iDisplayIndex + 1);
            $('td:eq(0)', row).html(index);
        }
    });


    var cat_item = $("#r_cat_item").dataTable();
    var conf_pembayaran = $("#conf_pembayaran").dataTable();
    var catalogMember = $("#catalogMember").dataTable();
    var member = $("#member").dataTable();



    //AUTO RELOAD UNTUK TRANSAKSI NANTI
    //setInterval( function () {
    //    var table = $("#tb_about").DataTable();
    //    table.ajax.reload( null, false ); // user paging is not reset on reload
    //},30000 );

    /*fungsi delegate adalah event untuk menangkap parameter yang baru ada setelah di load ajax*/
    //$(document).delegate('.fa-trash-o', 'click', function() { });

});
