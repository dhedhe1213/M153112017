function deleteKurir(e){swal({title:"Are you sure?",text:"You will not be able to recover this record!",type:"warning",showCancelButton:!0,confirmButtonColor:"#DD6B55",confirmButtonText:"Yes, delete it!",closeOnConfirm:!0},function(t){t&&actdeleteKurir(e)})}function sweet_tolak(e){swal({title:"Apakah kamu yakin ingin menolak pesanan?",text:"Akun kamu akan di nonaktifkan apabila menolak pesanan lebih dari 3x!",type:"warning",showCancelButton:!0,confirmButtonColor:"#DD6B55",confirmButtonText:"Ya, Tolak Pesanan!",closeOnConfirm:!0},function(t){t&&actTolak(e)})}function sweet(e,t,a,n){swal({title:e,text:t,imageUrl:base_url+"assets/images/sweet_alert/"+a,imageSize:"180x180",allowOutsideClick:!0},function(){window.location.href=n})}function sweetReview(e,t,a,n){swal({title:e,text:t,imageUrl:base_url+"assets/images/sweet_alert/"+a,imageSize:"180x180",allowOutsideClick:!0},function(){viewRewiew()})}function readURL1(e){if(e.files&&e.files[0]){var t=new FileReader;t.onload=function(e){$("#tampil1").attr("src",e.target.result)},t.readAsDataURL(e.files[0])}}function readURL2(e){if(e.files&&e.files[0]){var t=new FileReader;t.onload=function(e){$("#tampil2").attr("src",e.target.result)},t.readAsDataURL(e.files[0])}}function readURL3(e){if(e.files&&e.files[0]){var t=new FileReader;t.onload=function(e){$("#tampil3").attr("src",e.target.result)},t.readAsDataURL(e.files[0])}}function delete_item(e){swal({title:"Apakah kamu yakin ingin menghapus Barang ini?",text:"",type:"warning",showCancelButton:!0,confirmButtonColor:"#DD6B55",confirmButtonText:"Ya, Hapus saja!",closeOnConfirm:!0},function(t){t&&act_delete_item(e)})}function actdeleteKurir(e){var t=base_url+"seller/actDeleteKurir/"+e;$.ajax({type:"DELETE",dataType:"JSON",url:t,success:function(e){0==e.error?sweet(e.title,e.pesan,"true.jpg",base_url+"seller/daftarKurir"):sweet(e.title,e.pesan,"false.jpg","#")}})}function act_delete_item(e){var t=base_url+"seller/act_delete_item/"+e;$.ajax({type:"DELETE",dataType:"JSON",url:t,success:function(e){0==e.error?sweet(e.title,e.pesan,"true.jpg",base_url+"seller/barangKu"):$("#modalInputKurir").modal("show")}})}function actTolak(e){var t=base_url+"seller/actTolakPesanan/"+e;$.ajax({type:"POST",dataType:"JSON",url:t,beforeSend:function(){$("#barangku").html("Please wait...")},success:function(e){0==e.error?sweet(e.title,e.pesan,"true.jpg",base_url+"seller/pesananBarang"):sweet(e.title,e.pesan,"false.jpg","#")}})}function viewRewiew(e){e=e?e:0;var t=$("#id_item").val();$.ajax({type:"POST",url:base_url+"seller/item_review/"+e,data:"page="+e+"&id="+t,beforeSend:function(){$("#Reviews").hide(),$(".loading").show()},success:function(e){$(".loading").hide(),$("#Reviews").html(e),$("#Reviews").show()}})}function inputResi(e){var t=e;$("#modalInputResi").modal("show");var e=$("#id_transaksi").val(t)}$(document).ready(function(){function e(){$("#images1").val(""),$("#deletetampil1").html("<img id='tampil1' src='../assets/images/img/default.jpg' alt='' width='150px' height='150px'/>"),$("#btndeletetampil1").hide()}function t(){$("#images2").val(""),$("#deletetampil2").html("<img id='tampil2' src='../assets/images/img/default.jpg' alt='' width='150px' height='150px'/>"),$("#btndeletetampil2").hide()}function a(){$("#images3").val(""),$("#deletetampil3").html("<img id='tampil3' src='../assets/images/img/default.jpg' alt='' width='150px' height='150px'/>"),$("#btndeletetampil3").hide()}var n=$("#cat1").val(),i=$("#cat2").val(),r=$("#cat3").val();$("#keywords").autocomplete({minLength:2,source:base_url+"mitra/autocomplete_item/"+n+"/"+i+"/"+r}),$("#btn_search").click(function(){searchFilter()}),$("#keywords").keypress(function(e){13==e.which&&searchFilter()}),$("#sortBy").change(function(){searchFilter()}),$("#showOn").change(function(){searchFilter()}),$("#btn-add-kurir").click(function(){$("#modalInputKurir").modal("show")}),$("#btn_edit_user").click(function(){var e=(new FormData($("form_add")[0]),new FormData),t=$("#foto")[0].files[0];e.append("foto",t),$.each($("#form_edit_user").serializeArray(),function(t,a){e.append(a.name,a.value)}),$.ajax({type:"POST",dataType:"JSON",url:base_url+"seller/act_edit_user",data:e,processData:!1,contentType:!1,beforeSend:function(){$("#btn_edit_user").button("loading")},success:function(e){0==e.error?($("#btn_edit_user").button("reset"),sweet(e.title,e.pesan,"true.jpg","seller")):($("#btn_edit_user").button("reset"),sweet(e.title,e.pesan,"false.jpg","#"))}})}),$("#images1").change(function(){readURL1(this),$("#btndeletetampil1").show()}),$("#images2").change(function(){readURL2(this),$("#btndeletetampil2").show()}),$("#images3").change(function(){readURL3(this),$("#btndeletetampil3").show()}),$("#btndeletetampil1").hide(),$("#btndeletetampil2").hide(),$("#btndeletetampil3").hide(),$("#progress-div").hide(),$("#btndeletetampil1").click(function(){e()}),$("#btndeletetampil2").click(function(){t()}),$("#btndeletetampil3").click(function(){a()}),$("#btn_edit_pass").click(function(){$.ajax({type:"POST",dataType:"JSON",url:base_url+"seller/act_edit_pass",data:$("#form_edit_pass").serialize(),beforeSend:function(){$("#btn_edit_pass").button("loading")},success:function(e){0==e.error?($("#btn_edit_pass").button("reset"),sweet(e.title,e.pesan,"true.jpg","#")):($("#btn_edit_pass").button("reset"),sweet(e.title,e.pesan,"false.jpg","#"))}})}),$("#btn-input-resi").click(function(){$.ajax({type:"POST",dataType:"JSON",url:base_url+"seller/act_input_resi",data:$("#form-input-resi").serialize(),beforeSend:function(){$("#btn-input-resi").button("loading")},success:function(e){0==e.error?($("#btn-input-resi").button("reset"),$("#modalInputResi").modal("hide"),sweet(e.title,e.pesan,"true.jpg",base_url+"seller/pesananBarang")):($("#modalInputResi").modal("hide"),sweet(e.title,e.pesan,"false.jpg","#"))}})}),$("#btn-input-kurir").click(function(){$.ajax({type:"POST",dataType:"JSON",url:base_url+"seller/act_input_kurir",data:$("#form-input-kurir").serialize(),beforeSend:function(){$("#btn-input-kurir").button("loading")},success:function(e){0==e.error?($("#btn-input-kurir").button("reset"),$("#form-input-kurir").trigger("reset"),sweet(e.title,e.pesan,"true.jpg",base_url+"seller/daftarKurir")):($("#btn-input-kurir").button("reset"),$("#modalInputKurir").modal("hide"),sweet(e.title,e.pesan,"false.jpg","#"))}})}),$("#category1").change(function(){id=$("#category1").val(),$.ajax({type:"POST",url:base_url+"seller/getKategori2",data:"id="+id,beforeSend:function(){},success:function(e){$("#category2").html(e)}})}),$("#category2").change(function(){id=$("#category2").val(),$.ajax({type:"POST",url:base_url+"seller/getKategori3",data:"id="+id,beforeSend:function(){},success:function(e){$("#category3").html(e)}})}),$("#form_tambah_barang").submit(function(n){return n.preventDefault(),$("#progress-div").show(),$("#btn_tambah_barang").button("loading"),$(this).ajaxSubmit({target:"#targetLayer",dataType:"JSON",beforeSubmit:function(){$("#progress-bar").width("0%")},uploadProgress:function(e,t,a,n){$("#progress-bar").width(n+"%"),$("#progress-bar").html('<div id="progress-status">'+n+" %</div>")},success:function(n){0==n.error?($("#btn_tambah_barang").button("reset"),$("#form_tambah_barang").trigger("reset"),e(),t(),a(),$("#progress-div").hide(),sweet(n.title,n.pesan,"true.jpg","#")):($("#btn_tambah_barang").button("reset"),sweet(n.title,n.pesan,"false.jpg","#"))},resetForm:!0}),!1}),$("#form_ubah_barang").submit(function(e){return e.preventDefault(),$("#progress-div").show(),$("#btn_ubah_barang").button("loading"),$(this).ajaxSubmit({target:"#targetLayer",dataType:"JSON",beforeSubmit:function(){$("#progress-bar").width("0%")},uploadProgress:function(e,t,a,n){$("#progress-bar").width(n+"%"),$("#progress-bar").html('<div id="progress-status">'+n+" %</div>")},success:function(e){0==e.error?($("#btn_ubah_barang").button("reset"),$("#progress-div").hide(),sweet(e.title,e.pesan,"true.jpg",base_url+"seller/barangKu")):($("#btn_ubah_barang").button("reset"),sweet(e.title,e.pesan,"false.jpg",base_url+"seller/barangKu"))},resetForm:!0}),!1}),$("#provinsi").change(function(){id_prov=$("#provinsi").val(),$.ajax({type:"POST",url:base_url+"seller/getKabupaten",data:"id="+id_prov,beforeSend:function(){},success:function(e){$("#kabupaten").html(e)}})}),$("#kabupaten").change(function(){id_kab=$("#kabupaten").val(),$.ajax({type:"POST",url:base_url+"seller/getKecamatan",data:"id="+id_kab,beforeSend:function(){},success:function(e){$("#kecamatan").html(e)}})}),$("#barangku").dataTable()});