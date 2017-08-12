
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

    $("#register").click(function(){

        $("#form_register").validate({
            rules: {
                phone:{digits: true},
                email: {email: true},
                password:{minlength:6},
                re_password: {equalTo: "#password"}
            },
            messages: {
                name: {
                    required: "Nama Lengkap harus diisi"
                },
                phone: {
                    required: "No.Handphone harus diisi",
                    digits: "No.Handphone harus angka"
                },
                email: {
                    required: "Alamat email harus diisi",
                    email: "Format email tidak valid"
                },
                password: {
                  required: "Password Harus diisi",
                  minlength:"Password minimal 6 karakter"
                },
                re_password: {
                    required: "Ulangi Password Harus diisi",
                    equalTo: "Password tidak sama"
                },
                date: {
                    required: "Harus diisi"
                },
                month: {
                    required: "Harus diisi"
                },
                year: {
                    required: "Harus diisi"
                },
                gender: {
                    required: "Jenis Kelamin Harus diisi"
                }
            },
            submitHandler: function () {
                $.ajax({
                    type:"POST",
                    dataType: "JSON",
                    url: base_url+"main/act_register",
                    data : $('#form_register').serialize(),
                    beforeSend: function () {
                        $('#register').button('loading');
                    },
                    success:function(response){
                        if(response.error == 'captcha'){
                            sweet(response.title,response.pesan,base_url+'main/register');
                        }else if(response.error == false){
                            sweet(response.title,response.pesan,'thumbs-up.jpg',base_url);
                        }else{
                            $('#register').button('reset');
                            sweet(response.title,response.pesan,'false.jpg','#');
                        }
                    }
                });
            }
        });

    });
});