
$('#sifre, #resifre').on('keyup', function () {
    if ($('#sifre').val() == $('#resifre').val()) {
        $('#message').html('Şifreler Uyumlu').css('color', 'green');

    } else 
        $('#message').html('Şifreler Eşleşmiyor !').css('color', 'red');

});



$('#xsifcode, #xresifcode').on('keyup', function () {
    if ($('#xsifcode').val() == $('#xresifcode').val()) {
        $('#kodmessage').html('Şifreler Uyumlu').css('color', 'green');

    } else 
        $('#kodmessage').html('Şifreler Eşleşmiyor !').css('color', 'red');

});



/* filtre */


$("#ad").keyup(function(){
    this.value = this.value.replace(/\s{2,10}/g, ' ');
});


$("#telefon, #desteknum").keypress(function (e){

    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      return false;
      }

});


$("#ad").keyup(function (){

  if (this.value.match(/[^a-zA-Z .çöşüğıİ]/gi)){

    this.value = this.value.replace(/[^a-zA-Z .çöşüğıİ]/gi,'');
  }

});


$("#soyad").keyup(function (){

  if (this.value.match(/[^a-zA-Zçöşüğıİ]/gi)){

    this.value = this.value.replace(/[^a-zA-Zçöşüğıİ]/gi,'');
  }

});



$("#email").keyup(function (){

  if (this.value.match(/[^a-zA-Z0-9@._]/gi)){

    this.value = this.value.replace(/[^a-zA-Z0-9@._]/gi,'');
  }

});


$("#telefon").keyup(function (){

  if (this.value.match(/[^0-9]/gi)){

    this.value = this.value.replace(/[^0-9]/gi,'');
  }

});


$("#metin").keyup(function (){

  if (this.value.match(/[^a-zA-Z0-9@._]/gi)){

    this.value = this.value.replace(/[^a-zA-Z0-9@._]/gi,'');
  }

});


$("#referans").keyup(function (){

  if (this.value.match(/[^a-zA-Z0-9]/gi)){

    this.value = this.value.replace(/[^a-zA-Z0-9]/gi,'');
  }

});



$("#desteknum").keyup(function (){

  if (this.value.match(/[^0-9]/gi)){

    this.value = this.value.replace(/[^0-9]/gi,'');
  }

});



$("#yayin-kodu").keyup(function (){

  if (this.value.match(/[^a-zA-Z0-9]/gi)){

    this.value = this.value.replace(/[^a-zA-Z0-9]/gi,'');
  }

});


$("#kullanici-kodu").keyup(function (){

  if (this.value.match(/[^a-zA-Z0-9]/gi)){

    this.value = this.value.replace(/[^a-zA-Z0-9]/gi,'');
  }

});



$("#arama-islemi").keyup(function(){
    this.value = this.value.replace(/\s{2,10}/g, ' ');
});


$("#arama-islemi").keyup(function (){

  if (this.value.match(/[^a-zA-Z .çöşüğıİ]/gi)){

    this.value = this.value.replace(/[^a-zA-Z .çöşüğıİ]/gi,'');
  }

});


$("#video-id").keyup(function (){

  if (this.value.match(/[^a-zA-Z0-9?!=&$_-]/gi)){

    this.value = this.value.replace(/[^a-zA-Z0-9?!=&$_-]/gi,'');
  }

});



$("#meslekdetay").keyup(function (){

  if (this.value.match(/[^a-zA-Z). çöşüğıİ]/gi)){

    this.value = this.value.replace(/[^a-zA-Z). çöşüğıİ]/gi,'');
  }

});


/* /filtre */


/* uzunluk */
$(document).ready(function()
{
    $("#ad").attr('maxlength','14');
    $("#ad").attr('minlength','2');
    $("#ad").prop('required',true);
});


$(document).ready(function()
{
    $("#soyad").attr('maxlength','10');
    $("#soyad").attr('minlength','2');
    $("#soyad").prop('required',true);
});


$(document).ready(function()
{
    $("#sifre").attr('maxlength','20');
    $("#sifre").attr('minlength','6');
    $("#sifre").prop('required',true);
});



$(document).ready(function()
{
    $("#k_sifre_type").attr('maxlength','20');
    $("#k_sifre_type").attr('minlength','6');
    $("#k_sifre_type").prop('required',true);
});


$(document).ready(function()
{
    $("#resifre").attr('maxlength','20');
    $("#resifre").attr('minlength','6');
    $("#resifre").prop('required',true);
});


$(document).ready(function()
{
    $("#email").attr('maxlength','35');
    $("#email").attr('minlength','12');
    $("#email").prop('required',true);
});


$(document).ready(function()
{
    $("#telefon").attr('maxlength','11');
    $("#telefon").attr('minlength','11');
    $("#telefon").prop('required',true);
});


$(document).ready(function()
{
    $("#tarih_gun").prop('required',true);
});


$(document).ready(function()
{
    $("#tarih_ay").prop('required',true);
});


$(document).ready(function()
{
    $("#tarih_yil").prop('required',true);
});


$(document).ready(function()
{
    $("#il").prop('required',true);
});


$(document).ready(function()
{
    $("#cinsiyet").prop('required',true);
});


$(document).ready(function()
{
    $("#metin").attr('maxlength','35');
    $("#metin").attr('minlength','11');
    $("#metin").prop('required',true);
});


$(document).ready(function()
{
    $("#kullanici_type").attr('maxlength','35');
    $("#kullanici_type").attr('minlength','5');
    $("#kullanici_type").prop('required',true);
});


$(document).ready(function()
{
    $("#guvenlik").attr('maxlength','12');
    $("#guvenlik").attr('minlength','6');
    $("#guvenlik").prop('required',true);
});


$(document).ready(function()
{
    $("#referans").attr('maxlength','10');
    $("#referans").attr('minlength','10');
    $("#referans").prop('required',true);
});


$(document).ready(function()
{
    $("#dg-sifre").attr('maxlength','20');
    $("#dg-sifre").attr('minlength','6');
    $("#dg-sifre").prop('required',true);
});


$(document).ready(function()
{
    $("#xsifcode").attr('maxlength','12');
    $("#xsifcode").attr('minlength','6');
    $("#xsifcode").prop('required',true);
});


$(document).ready(function()
{
    $("#xresifcode").attr('maxlength','12');
    $("#xresifcode").attr('minlength','6');
    $("#xresifcode").prop('required',true);
});


$(document).ready(function()
{
    $("#desteknum").attr('maxlength','20');
    $("#desteknum").attr('minlength','20');
    $("#desteknum").prop('required',true);
});

$(document).ready(function()
{
    $("#yayin-kodu").attr('maxlength','10');
    $("#yayin-kodu").attr('minlength','10');
    $("#yayin-kodu").prop('required',true);
});

$(document).ready(function()
{
    $("#kullanici-kodu").attr('maxlength','10');
    $("#kullanici-kodu").attr('minlength','10');
    $("#kullanici-kodu").prop('required',true);
});

$(document).ready(function()
{
    $("#arama-islemi").attr('maxlength','30');
    $("#arama-islemi").attr('minlength','1');
    $("#arama-islemi").prop('required',true);
});


$(document).ready(function()
{
    $("#video-id").attr('maxlength','11');
    $("#video-id").attr('minlength','11');
    $("#video-id").prop('required',false);
});

$(document).ready(function()
{
    $("#meslekdetay").attr('maxlength','30');
    $("#meslekdetay").attr('minlength','3');
    $("#meslekdetay").prop('required',false);
});

/* /uzunluk */


/* şifreyi göster */
$(document).ready(function() {
  $("#showHide").click(function() {
    if ($(".password").attr("type") == "password") {
      $(".password").attr("type", "text");

    } else {
      $(".password").attr("type", "password");
    }
  });
});


$(document).ready(function() {
  $("#ssak").click(function() {
    if ($(".dg_sifre").attr("type") == "password") {
      $(".dg_sifre").attr("type", "text");

    } else {
      $(".dg_sifre").attr("type", "password");
    }
  });
});



$(document).ready(function() {
  $("#kp_sf").click(function() {
    if ($(".k_sifre").attr("type") == "password") {
      $(".k_sifre").attr("type", "text");

    } else {
      $(".k_sifre").attr("type", "password");
    }
  });
});
/* /şifreyi göster */



/* yaş sorgusu */
var checkboxes = $("#butonac"),
    submitButt = $("#kilit");

checkboxes.click(function() {
    submitButt.attr("disabled", !checkboxes.is(":checked"));
});


/* panel 1 */

$(document).ready(function(){
$(".hknd-buton").click(function(){
        if($(".hknd-ackapat").text()=== "Aç"){
            $(".hknd-ackapat").text("Kapat");
        }
        else{
            $(".hknd-ackapat").text("Aç");           
        }
         $(".hakkinda-acilir-panel").slideToggle(300);
    });
});


/* panel 2 */

$(document).ready(function(){
$(".hakref-buton").click(function(){
        if($(".ref-ackapat").text()=== "Aç"){
            $(".ref-ackapat").text("Kapat");
        }
        else{
            $(".ref-ackapat").text("Aç");           
        }
         $(".hakkinda-ref-panel").slideToggle(300);
    });
});

/* panel 3 */

$(document).ready(function(){
$(".resifre-buton").click(function(){
        if($(".key_txt").text()=== "Aç"){
            $(".key_txt").text("Kapat");
        }
        else{
            $(".key_txt").text("Aç");           
        }
         $(".resifre-acilir-panel").slideToggle(300);
    });
});


/* panel 4 */

$(document).ready(function(){
$(".gsr-buton").click(function(){
        if($(".gsr_txt").text()=== "Aç"){
            $(".gsr_txt").text("Kapat");
        }
        else{
            $(".gsr_txt").text("Aç");           
        }
         $(".gsr-acilir-panel").slideToggle(300);
    });
});


$(document).ready(function(){
$(".resimat-buton").click(function(){
        if($(".resimat-ackapat").text()=== "Aç"){
            $(".resimat-ackapat").text("Kapat");
        }
        else{
            $(".resimat-ackapat").text("Aç");           
        }
         $(".resimat-panel").slideToggle(300);
    });
});



$(document).ready(function(){
$(".kategori-buton").click(function(){
        if($(".kategori-ackapat").text()=== "Aç"){
            $(".kategori-ackapat").text("Kapat");
        }
        else{
            $(".kategori-ackapat").text("Aç");           
        }
         $(".kategori-panel").slideToggle(200);
    });
});



$(document).ready(function(){
$(".fotobuton").click(function(){
        if($(".foto-ackapat").text()=== "Aç"){
            $(".foto-ackapat").text("Kapat");
        }
        else{
            $(".foto-ackapat").text("Aç");           
        }
         $(".foto-panel").slideToggle(300);
    });
});



$(document).ready(function(){
$(".yayinbuton").click(function(){
        if($(".yayin-ackapat").text()=== "Aç"){
            $(".yayin-ackapat").text("Kapat");
        }
        else{
            $(".yayin-ackapat").text("Aç");           
        }
         $(".yayin-panel").slideToggle(300);
    });
});


$(document).ready(function(){
$(".yayin-ara-buton").click(function(){
        if($(".yayin-arama-panel-ackapat").text()=== "Aç"){
            $(".yayin-arama-panel-ackapat").text("Kapat");
        }
        else{
            $(".yayin-arama-panel-ackapat").text("Aç");           
        }
         $(".yayin-ara-panel").slideToggle(300);
    });
});


$(document).ready(function(){
$(".kullanici-ara-buton").click(function(){
        if($(".kullanici-arama-panel-ackapat").text()=== "Aç"){
            $(".kullanici-arama-panel-ackapat").text("Kapat");
        }
        else{
            $(".kullanici-arama-panel-ackapat").text("Aç");           
        }
         $(".kullanici-ara-panel").slideToggle(300);
    });
});


$(document).ready(function(){
$(".gorbuton").click(function(){
        if($(".yayackapat").text()==="Aç"){
            $(".yayackapat").text("Kapat");
        }
        else{
            $(".yayackapat").text("Aç");           
        }
         $(".gorus-panel").slideToggle(300);
    });
});



$(document).ready(function(){
$(".kazananbuton").click(function(){
        if($(".kazanankapak").text()==="Sonuçları göster"){
            $(".kazanankapak").text("Sonuçları gizle");
        }
        else{
            $(".kazanankapak").text("Sonuçları göster");           
        }
         $(".kazanan-panel").slideToggle(300);
    });
});


$(document).ready(function(){
$(".yazobuton").click(function(){
        if($(".yazobackapat").text()==="aç"){
            $(".yazobackapat").text("kapat");
        }
        else{
            $(".yazobackapat").text("aç");           
        }
         $(".ozellik-panel").slideToggle(300);
    });
});


$(document).ready(function(){
$(".gorlistbuton").click(function(){
        if($(".gorlistackapat").text()==="göster"){
            $(".gorlistackapat").text("gizle");
        }
        else{
            $(".gorlistackapat").text("göster");           
        }
         $(".gorlist-panel").slideToggle(300);
    });
});


$(document).ready(function(){
$(".kateg-style").click(function(){
        if($(".kate-ackapat").text()==="göster"){
            $(".kate-ackapat").text("gizle");
        }
        else{
            $(".kate-ackapat").text("göster");           
        }
         $(".kapakkate").slideToggle(300);
    });
});



$(document).ready(function(){
$(".secimyap-buton").click(function(){

         $(".secimyap-panel").slideToggle(200);
         

        $(".resim-alani-ac").css("display", "none");
        $(".video-alani-ac").css("display", "none");


    });
});


$(document).ready(function(){
$(".resim-secildi").click(function(){

      $(".resim-alani-ac").css("display", "block"); 
      $(".video-alani-ac").css("display", "none");  
      $(".secimyap-panel").css("display", "none");  
   var $el = $('#video-id');
   $el.wrap('<form>').closest('form').get(0).reset();

   $el.unwrap();

    });
});


$(document).ready(function(){
$(".video-secildi").click(function(){

      $(".video-alani-ac").css("display", "block");
      $(".resim-alani-ac").css("display", "none"); 
      $(".secimyap-panel").css("display", "none");
   var $el = $('#resimst-file');
   $el.wrap('<form>').closest('form').get(0).reset();
   onres.style.display = "none";
   onyazi.style.display = "block";
   $el.unwrap();

    });
});


$(document).ready(function(){
$(".kpt-butpan").click(function(){

      $(".resim-alani-ac").css("display", "none"); 
      $(".video-alani-ac").css("display", "none");  
      $(".secimyap-panel").css("display", "none");  
   var $el = $('#video-id');
   $el.wrap('<form>').closest('form').get(0).reset();

   $el.unwrap();

   var $el2 = $('#resimst-file');
   $el2.wrap('<form>').closest('form').get(0).reset();
   onres.style.display = "none";
   onyazi.style.display = "block";
   $el2.unwrap();
    });
});


var yaybas = document.querySelector(".yaybas");
var yaybuy = document.querySelector(".yaybuy");
var yay_baslik = document.getElementById("yay_baslik");

var yaybl = document.querySelector(".yaybl");



yay_baslik.addEventListener("input", function() {
    
 
    yaybl.textContent = 120 - yay_baslik.value.length;
    
  
    if (yaybl.textContent == 0) {
      
        yaybl.style.color = "#e01ab5";
        yaybas.style.display = "none";
        yaybuy.style.display = "block";
        
    }else if (yaybl.textContent < 1) {
     
        yaybl.style.color = "#e01ab5";
        yaybas.style.display = "block"; 
        yaybuy.style.display = "none";
        
    }else if (yaybl.textContent >= 1) {
     
       yaybas.style.display = "none";  
       yaybl.style.color = "#6b92a8";
       yaybuy.style.display = "none";
    }


    else {

        yaybl.style.color = "#6b92a8";
    }
});


