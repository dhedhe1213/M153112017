
function deleteKurir(data_id) {
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
                actdeleteKurir(data_id);
            }
        });

}


function sweet_tolak(noInvoice) {
    swal({
            title: "Apakah kamu yakin ingin menolak pesanan?",
            text: "Akun kamu akan di nonaktifkan apabila menolak pesanan lebih dari 3x!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Tolak Pesanan!",
            closeOnConfirm: true
        },
        function (isConfirm) {
            if (isConfirm) {
                actTolak(noInvoice);
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

function readURL1(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#tampil1').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function readURL2(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#tampil2').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function readURL3(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#tampil3').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function delete_item(data_id){
    swal({
            title: "Apakah kamu yakin ingin menghapus Barang ini?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Hapus saja!",
            closeOnConfirm: true
        },
        function (isConfirm) {
            if (isConfirm) {
                act_delete_item(data_id);
            }
        });

}


function actdeleteKurir(data_id) {
    var url_action = base_url+'seller/actDeleteKurir/'+data_id;

    $.ajax({
        type:"DELETE",
        dataType: "JSON",
        url: url_action,
        success:function(response){
            if(response.error == false){
                sweet(response.title,response.pesan,'true.jpg',base_url+'seller/daftarKurir');

            }else{
                sweet(response.title,response.pesan,'false.jpg','#');
            }
        }
    });
}

function act_delete_item(data_id) {
    var url_action = base_url+'seller/act_delete_item/'+data_id;

    $.ajax({
        type:"DELETE",
        dataType: "JSON",
        url: url_action,
        success:function(response){
            if(response.error == false){
                sweet(response.title,response.pesan,'true.jpg',base_url+'seller/barangKu');
            }else{
                $("#modalInputKurir").modal('show');
            }
        }
    });
}


function actTolak(noInvoice) {
    var url_action = base_url+'seller/actTolakPesanan/'+noInvoice;

    $.ajax({
        type:"POST",
        dataType: "JSON",
        url: url_action,
        beforeSend: function () {
            $('#barangku').html('Please wait...');
        },
        success:function(response){
            if(response.error == false){
                sweet(response.title,response.pesan,'true.jpg',base_url+'seller/pesananBarang');

            }else{
                sweet(response.title,response.pesan,'false.jpg','#');
            }
        }
    });
}

function viewRewiew(page_num) {
    page_num = page_num?page_num:0;

    var id = $('#id_item').val();

    $.ajax({
        type: 'POST',
        url: base_url+'seller/item_review/'+page_num,
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

function inputResi(id) {
    var id_transaksi = id;
    $("#modalInputResi").modal('show');
    var id = $('#id_transaksi').val(id_transaksi);

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

    $('#btn-add-kurir').click(function(){
        $("#modalInputKurir").modal('show');
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
            url: base_url + "seller/act_edit_user",
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
                    sweet(response.title, response.pesan, 'true.jpg', 'seller');
                } else {
                    $('#btn_edit_user').button('reset');
                    sweet(response.title, response.pesan, 'false.jpg', '#');
                }
            }
        });
    });


    $("#images1").change(function(){
        readURL1(this);
        $("#btndeletetampil1").show();

    });
    $("#images2").change(function(){
        readURL2(this);
        $("#btndeletetampil2").show();
    });
    $("#images3").change(function(){
        readURL3(this);
        $("#btndeletetampil3").show();
    });

    $("#btndeletetampil1").hide();
    $("#btndeletetampil2").hide();
    $("#btndeletetampil3").hide();
    $("#progress-div").hide();


    function btnDelete1(){
    $("#images1").val('');
    $("#deletetampil1").html("<img id='tampil1' src='../assets/images/img/default.jpg' alt='' width='150px' height='150px'/>");
    $("#btndeletetampil1").hide();
    }
    function btnDelete2(){
        $("#images2").val('');
        $("#deletetampil2").html("<img id='tampil2' src='../assets/images/img/default.jpg' alt='' width='150px' height='150px'/>");
        $("#btndeletetampil2").hide();
    }
    function btnDelete3(){
        $("#images3").val('');
        $("#deletetampil3").html("<img id='tampil3' src='../assets/images/img/default.jpg' alt='' width='150px' height='150px'/>");
        $("#btndeletetampil3").hide();
    }

    $("#btndeletetampil1").click(function(){
        btnDelete1();
    });
    $("#btndeletetampil2").click(function(){
        btnDelete2();
    });
    $("#btndeletetampil3").click(function(){
        btnDelete3();
    });

    $('#btn_edit_pass').click(function () {
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: base_url + "seller/act_edit_pass",
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

    $('#btn-input-resi').click(function () {
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: base_url + "seller/act_input_resi",
            data: $('#form-input-resi').serialize(),
            beforeSend: function () {
                $('#btn-input-resi').button('loading');
            },
            success: function (response) {
                if (response.error == false) {
                    $('#btn-input-resi').button('reset');
                    $("#modalInputResi").modal('hide');
                    sweet(response.title, response.pesan, 'true.jpg', base_url+'seller/pesananBarang');
                } else {
                    $("#modalInputResi").modal('hide');
                    sweet(response.title, response.pesan, 'false.jpg', '#');

                }
            }
        });
    });

    $('#btn-input-kurir').click(function () {
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: base_url + "seller/act_input_kurir",
            data: $('#form-input-kurir').serialize(),
            beforeSend: function () {
                $('#btn-input-kurir').button('loading');
            },
            success: function (response) {
                if (response.error == false) {
                    $('#btn-input-kurir').button('reset');
                    $('#form-input-kurir').trigger("reset");
                    sweet(response.title, response.pesan, 'true.jpg', base_url+'seller/daftarKurir');
                } else {
                    $('#btn-input-kurir').button('reset');
                    $("#modalInputKurir").modal('hide');
                    sweet(response.title, response.pesan, 'false.jpg', '#');
                }
            }
        });
    });

    $('#category1').change(function () {
        id = $('#category1').val();

        $.ajax({
            type: 'POST',
            url: base_url+'seller/getKategori2',
            data: 'id='+id,
            beforeSend: function () {
            },
            success: function (html) {
                $('#category2').html(html);
            }
        });

    });

    $('#category2').change(function () {
        id = $('#category2').val();

        $.ajax({
            type: 'POST',
            url: base_url+'seller/getKategori3',
            data: 'id='+id,
            beforeSend: function () {
            },
            success: function (html) {
                $('#category3').html(html);
            }
        });

    });

    $('#form_tambah_barang').submit(function(e) {
            e.preventDefault();
            $("#progress-div").show();
            $('#btn_tambah_barang').button('loading');
            $(this).ajaxSubmit({
                target:   '#targetLayer',
                dataType: "JSON",
                beforeSubmit: function() {
                    $("#progress-bar").width('0%');
                },
                uploadProgress: function (event, position, total, percentComplete){
                    $("#progress-bar").width(percentComplete + '%');
                    $("#progress-bar").html('<div id="progress-status">' + percentComplete +' %</div>')
                },
                success: function (response) {
                    if (response.error == false) {
                        $('#btn_tambah_barang').button('reset');
                        $('#form_tambah_barang').trigger("reset");
                        btnDelete1();btnDelete2();btnDelete3();
                        $("#progress-div").hide();
                        sweet(response.title, response.pesan, 'true.jpg', '#');
                    } else {
                        $('#btn_tambah_barang').button('reset');
                        sweet(response.title, response.pesan, 'false.jpg', '#');
                    }
                },
                resetForm: true
            });
            return false;
    });

    $('#form_ubah_barang').submit(function(e) {
        e.preventDefault();
        $("#progress-div").show();
        $('#btn_ubah_barang').button('loading');
        $(this).ajaxSubmit({
            target:   '#targetLayer',
            dataType: "JSON",
            beforeSubmit: function() {
                $("#progress-bar").width('0%');
            },
            uploadProgress: function (event, position, total, percentComplete){
                $("#progress-bar").width(percentComplete + '%');
                $("#progress-bar").html('<div id="progress-status">' + percentComplete +' %</div>')
            },
            success: function (response) {
                if (response.error == false) {
                    $('#btn_ubah_barang').button('reset');
                    $("#progress-div").hide();
                    sweet(response.title, response.pesan, 'true.jpg', base_url+'seller/barangKu');
                } else {
                    $('#btn_ubah_barang').button('reset');
                    sweet(response.title, response.pesan, 'false.jpg', base_url+'seller/barangKu');
                }
            },
            resetForm: true
        });
        return false;
    });


    $('#provinsi').change(function () {
        id_prov = $('#provinsi').val();

        $.ajax({
            type: 'POST',
            url: base_url+'seller/getKabupaten',
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
            url: base_url+'seller/getKecamatan',
            data: 'id='+id_kab,
            beforeSend: function () {
            },
            success: function (html) {
                $('#kecamatan').html(html);
            }
        });

    });



    $('#barangku').dataTable();



});