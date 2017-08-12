$(document).ready(function(){

    function sweet(title,pesan,img,url){
        swal({
                title: title,
                text: pesan,
                imageUrl: base_url+"assets/images/sweet_alert/"+img,
                imageSize: "180x180",
                allowOutsideClick: true
            },
            function(){
                window.location.href = url;
            });
    }



    $("#login").click(function(){
                $.ajax({
                    type:"POST",
                    dataType: "JSON",
                    url: base_url+"dpanel/act_login",
                    data : $('#login_form').serialize(),
                    beforeSend: function () {
                        $('#login').button('loading');
                    },
                    success:function(response){
                        if(response.error == false){
                            sweet(response.title,response.pesan,'true.jpg','dashboard');
                        }else{
                            $('#login').button('reset');
                            sweet(response.title,response.pesan,'false.jpg','#');
                        }
                    }
                });
    });



    $("#btn-login-content").click(function(){
        $.ajax({
            type:"POST",
            dataType: "JSON",
            url: base_url+"dpanel/act_login_reseller",
            data : $('#login-form-content').serialize(),
            beforeSend: function () {
                $('#btn-login-content').button('loading');
            },
            success:function(response){
                if(response.error == false){
                    sweet(response.title,response.pesan,'true.jpg','mitra');
                }else{
                    $('#btn-login-content').button('reset');
                    sweet(response.title,response.pesan,'false.jpg','#');
                }
            }
        });
    });

    $("#password").keypress(function(e){
        if(e.which == 13) {
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: base_url + "dpanel/act_login_reseller",
                data: $('#login-form-content').serialize(),
                beforeSend: function () {
                    $('#btn-login-content').button('loading');
                },
                success: function (response) {
                    if (response.error == false) {
                        sweet(response.title, response.pesan, 'true.jpg', 'mitra');
                    } else {
                        $('#btn-login-content').button('reset');
                        sweet(response.title, response.pesan, 'false.jpg', '#');
                    }
                }
            });
        }
    });

    $("#btn-login-seller").click(function(){
        $.ajax({
            type:"POST",
            dataType: "JSON",
            url: base_url+"dpanel/act_login_seller",
            data : $('#login-form-content').serialize(),
            beforeSend: function () {
                $('#btn-login-seller').button('loading');
            },
            success:function(response){
                if(response.error == false){
                    sweet(response.title,response.pesan,'true.jpg',base_url+'seller');
                }else{
                    $('#btn-login-seller').button('reset');
                    sweet(response.title,response.pesan,'false.jpg','#');
                }
            }
        });
    });

    $("#password_seller").keypress(function(e){
        if(e.which == 13) {
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: base_url + "dpanel/act_login_seller",
                data: $('#login-form-content').serialize(),
                beforeSend: function () {
                    $('#btn-login-seller').button('loading');
                },
                success: function (response) {
                    if (response.error == false) {
                        sweet(response.title, response.pesan, 'true.jpg', base_url + 'seller');
                    } else {
                        $('#btn-login-seller').button('reset');
                        sweet(response.title, response.pesan, 'false.jpg', '#');
                    }
                }
            });
        }
    });


});