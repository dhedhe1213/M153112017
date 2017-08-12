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
        url: base_url+'mitra/catalog_filter/'+page_num,
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
        url: base_url+'mitra/catalog_review/'+page_num,
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

function add_to_cart(id_item){
    var nm_catalog = $('#nm_catalog').val();

        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: base_url + "mitra/act_add_to_cart",
            data: 'id_item='+id_item+'&nm_catalog='+nm_catalog,
            beforeSend: function () {
                $('.add2cart').button('loading');
            },
            success: function (response) {
                if (response.error == false) {
                    $('.add2cart').button('reset');
                    loadCountCart();
                    sweet(response.title, response.pesan, 'true.jpg', '#')
                } else {
                    $('.add2cart').button('reset');
                    sweet(response.title, response.pesan, 'false.jpg', '#');
                }
            }
        });
}

function loadCatalogCart() {
    $.ajax({
        type: 'GET',
        url: base_url+'mitra/catalog_cart_load',
        success: function (html) {
            $('.goods-page').html(html);
        }
    });
}

function loadCountCart() {
    $.ajax({
        type: 'GET',
        url: base_url+'mitra/catalog_count_cart',
        success: function (html) {
            $('.top-cart-info').html(html);
        }
    });
}


function deleteAlamat(data_id) {
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
                actDeleteAlamat(data_id);
            }
        });
}

function actDeleteAlamat(data_id) {
    var url_action = base_url+'mitra/deleteAlamat/'+data_id;

    $.ajax({
        type:"DELETE",
        dataType: "JSON",
        url: url_action,
        success:function(response){
            if(response.error == false){
                loadAlamat();
                $('.alamat_checkout').html('');
                sweet(response.title,response.pesan,'true.jpg','#');
            }else{
                sweet(response.title,response.pesan,'false.jpg','#');
            }
        }
    });
}

function deleteCart(data_id) {
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
                actDeleteCart(data_id);
            }
        });
}

function actDeleteCart(data_id) {
    var url_action = base_url+'mitra/deleteCart/'+data_id;

    $.ajax({
        type:"DELETE",
        dataType: "JSON",
        url: url_action,
        success:function(response){
            if(response.error == false){
                loadCountCart();
                loadCatalogCart();
                sweet(response.title,response.pesan,'true.jpg','#');
            }else{
                sweet(response.title,response.pesan,'false.jpg','#');
            }
        }
    });
}


function loadAlamat(){
    $.ajax({
        type: 'GET',
        url: base_url+'mitra/getDataAlamat',
        beforeSend: function () {
        },
        success: function (html) {
            $('#select_alamat').html(html);
        }
    });
}



$(document).ready(function() {
    //karena per catalog jadi kategory nya harus di bawa terus
    var nm_catalog = $('#nm_catalog').val();

   $('#keywords').autocomplete({
       minLength:2,
       source: base_url+'mitra/autocomplete_catalog/'+nm_catalog
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
            url: base_url + "mitra/act_replay_review",
            data: $('#form_add').serialize(),
            beforeSend: function () {
                $('#add_review').button('loading');
            },
            success: function (response) {
                if (response.error == false) {
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


    $(document).on('click','.edit-jumlah',function(e){
        id_item = $(this).attr('data-id');
        nama = $(this).attr('data-nama');
        jumlah = $(this).attr('data-jumlah');

        $("#ModalJumlah").modal('show');
        $("#id_item").val(id_item);
        $("#jumlah").val(jumlah);
        $("#nama").val(nama);

    });

    $('#btn-ubah-jumlah').click(function () {
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: base_url + "mitra/act_edit_jumlah",
            data: $('#form-edit-jumlah').serialize(),
            beforeSend: function () {
                $('#btn-ubah-jumlah').button('loading');
            },
            success: function (response) {

                if (response.error == false) {
                    $('#btn-ubah-jumlah').button('reset');
                    $("#ModalJumlah").modal('hide');
                    loadCatalogCart();
                    sweet(response.title, response.pesan, 'true.jpg', '#')
                } else {
                    $('#btn-ubah-jumlah').button('reset');
                    sweet(response.title, response.pesan, 'false.jpg', '#');
                }
            }
        });
    });


    $('#select_alamat').change(function () {

        $.ajax({
            type: 'POST',
            url: base_url+'mitra/getAlamat',
            data: $('#form_alamat').serialize(),
            beforeSend: function () {
            },
            success: function (html) {
                $('.alamat_checkout').html(html);
            }
        });

    });

    $('#tambah_alamat').click(function () {
        $("#ModalTambahAlamat").modal('show');
        $("#kd_pos_tambah").hide();
    });


    $('.tambah_kode').click(function () {
        $("#kd_pos").empty();
        $("#kd_pos_default").hide();
        $("#kd_pos_tambah").show();
    });

    $('#tutup').click(function () {
        $("#kd_pos_default").show();
        //isi kembali datanya kode pos default
        nm_kec = $('#kecamatan').val();
        $.ajax({
            type: 'POST',
            url: base_url+'mitra/getPos',
            data: 'kecamatan='+nm_kec,
            beforeSend: function () {
            },
            success: function (html) {
                $('#kd_pos').html(html);
            }
        });
        //hilangkan yang tambah
        $("#kd_tambah").val('');
    });

    $('#provinsi').change(function () {
        id_prov = $('#provinsi').val();

        $.ajax({
            type: 'POST',
            url: base_url+'mitra/getKabupaten',
            data: 'id='+id_prov,
            beforeSend: function () {
            },
            success: function (html) {
                $('#kabupaten').html(html);
            }
        });

    });

    $('#kabupaten').change(function () {
        id_kab = $('#kabupaten').val();

        $.ajax({
            type: 'POST',
            url: base_url+'mitra/getKecamatan',
            data: 'id='+id_kab,
            beforeSend: function () {
            },
            success: function (html) {
                $('#kecamatan').html(html);
            }
        });

    });

    $('#kecamatan').change(function () {
        nm_kec = $('#kecamatan').val();

        $.ajax({
            type: 'POST',
            url: base_url+'mitra/getPos',
            data: 'kecamatan='+nm_kec,
            beforeSend: function () {
            },
            success: function (html) {
                $('#kd_pos').html(html);
            }
        });

    });

    $('#btn-tambah-alamat').click(function () {
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: base_url + "mitra/act_tambah_alamat",
            data: $('#form-tambah-alamat').serialize(),
            beforeSend: function () {
                $('#btn-tambah-alamat').button('loading');
            },
            success: function (response) {

                if (response.error == false) {
                    $('#btn-tambah-alamat').button('reset');
                    $("#ModalTambahAlamat").modal('hide');
                    loadAlamat();
                    sweet(response.title, response.pesan, 'true.jpg', '#')
                } else {
                    $('#btn-tambah-alamat').button('reset');
                    sweet(response.title, response.pesan, 'false.jpg', '#');
                }
            }
        });
    });

    $('#btn-konfirmasi').click(function () {
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: base_url + "mitra/act_konfirmasi",
            data: $('#form-konfirmasi').serialize(),
            beforeSend: function () {
                $('#btn-konfirmasi').button('loading');
            },
            success: function (response) {
                if (response.error == false) {
                    sweet(response.title, response.pesan, 'true.jpg', response.link);
                    $("#ModalKonfirmasi").modal('hide');
                } else {
                    $('#btn-konfirmasi').button('reset');
                    sweet(response.title, response.pesan, 'false.jpg', '#');
                }
            }
        });
    });

    $('#btn-terima-barang').click(function () {
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: base_url + "mitra/act_konfirmasi_terima",
            data: $('#form-konfirmasi').serialize(),
            beforeSend: function () {
                $('#btn-terima-barang').button('loading');
            },
            success: function (response) {
                if (response.error == false) {
                    sweet(response.title, response.pesan, 'true.jpg', response.link);
                    $("#ModalKonfirmasi").modal('hide');
                } else {
                    $('#btn-terima-barang').button('reset');
                    sweet(response.title, response.pesan, 'false.jpg', '#');
                }
            }
        });
    });


    $(document).delegate('.delete_alamat', 'click', function() {
        id = $('.delete_alamat').attr('data-id');
        deleteAlamat(id);

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

    var konfirmasi = $("#t_konfirmasi").dataTable();
    var pengiriman = $("#t_pengiriman").dataTable();
    var daftar_transaksi = $("#daftar_transaksi").dataTable();

    var daftar_transaksi = $("#riwayat_transaksi").dataTable({

        initComplete: function() {
            var api = this.api();
            $('#t_konfirmasi_filter input')
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
        ajax: {"url": base_url +"mitra/load_tb_riwayat_transaksi", "type": "POST"},
        columns: [
            {
                "data": "id",
                "orderable": false
            },
            {"data": "no_invoice"},
            {"data": "total_pembayaran"},
            {"data": "batas_waktu"}
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

});
