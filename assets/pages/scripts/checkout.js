$(document).ready(function(){
    var base_url = '<?php echo base_url();?>'
    function sweet(title,pesan,url){
        swal({
                title: title,
                text: pesan,
                imageUrl: base_url+"assets/images/sweet_alert/thumbs-up.jpg",
                imageSize: "180x180",
                allowOutsideClick: true
            },
            function(){
                window.location.href = url;
            });
    }

    $("#register").click(function(){
        $.ajax({
            type:"POST",
            dataType: "JSON",
            url: base_url+"main/act_register",
            data : $('#form_register').serialize(),
            success:function(response){
                if(response.error == false){
                    sweet(response.title,response.pesan,'index');

                }else{
                    sweet(response.title,response.pesan,'#');
                }
            }
        });
    });
});