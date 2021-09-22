
var onres = document.querySelector(".onres");
var onyazi = document.querySelector(".onyazi");
$(function(){    
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
            	$('#pf-foto').css('background-image', 'url("' + reader.result + '")');
                
            	onres.style.display = "block";
            	onyazi.style.display = "none";
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $(".dosyaSec").change(function(){
        readURL(this);
    });
    
});



var fores = document.querySelector(".fores");
var foyaz = document.querySelector(".foyaz");
$(function(){    
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
              $('#ft-foto').css('background-image', 'url("' + reader.result + '")');
                
              fores.style.display = "block";
              foyaz.style.display = "none";
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $(".dosyaYukle").change(function(){
        readURL(this);
    });
    
});


var yayest = document.querySelector(".yayest");
var yayaz = document.querySelector(".yayaz");
$(function(){    
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
              $('#yayin-foto').css('background-image', 'url("' + reader.result + '")');
                
              yayest.style.display = "block";
              yayaz.style.display = "none";
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $(".yayinResim").change(function(){
        readURL(this);
    });
    
});


$('#btn-resimst-file-reset').on('click', function(e){
   var $el = $('#resimst-file');
   $el.wrap('<form>').closest('form').get(0).reset();
   onres.style.display = "none";
   onyazi.style.display = "block"; 
   $el.unwrap();
});


$('#btn-fotost-file-reset').on('click', function(e){
   var $el = $('#fotost-file');
   $el.wrap('<form>').closest('form').get(0).reset();
   fores.style.display = "none";
   foyaz.style.display = "block"; 
   $el.unwrap();
});



$('#btn-yayin-file-reset').on('click', function(e){
   var $el = $('#yayin-file');
   $el.wrap('<form>').closest('form').get(0).reset();
   yayest.style.display = "none";
   yayaz.style.display = "block"; 
   $el.unwrap();
});



$(document).ready(function()
{
    $(".foto_text_lmt").attr('maxlength','30');
    $(".foto_text_lmt").attr('minlength','0');
    $(".foto_text_lmt").prop('required',false);
});


$(document).ready(function()
{
    $(".yayin_text_lmt").attr('maxlength','120');
    $(".yayin_text_lmt").attr('minlength','5');
    $(".yayin_text_lmt").prop('required',true);
});



$(".foto_text_type").keyup(function (){

  if (this.value.match(/[^a-zA-Z 0-9?)(+%/!=:.,''""İçöşüğı-]/gi)){

    this.value = this.value.replace(/[^a-zA-Z 0-9?)(+%/!=:.,''""İçöşüğı-]/gi,'');
  }

});


$(".yayin_text_type").keyup(function (){

  if (this.value.match(/[^a-zA-Z 0-9?)(+%/!=:.,''""İçöşüğı-]/gi)){

    this.value = this.value.replace(/[^a-zA-Z 0-9?)(+%/!=:.,''""İçöşüğı-]/gi,'');
  }

});


var fotbas = document.querySelector(".fotbas");
var fotbuy = document.querySelector(".fotbuy");
var foto_baslik = document.getElementById("foto_baslik");
// Select <p>
var fotbl = document.querySelector(".fotbl");
// Select <button>
var rek_buton = document.querySelector(".rek_buton");

// Listen for #sayd input event
foto_baslik.addEventListener("input", function() {
    
    // Count characters down    
    fotbl.textContent = 30 - foto_baslik.value.length;
    
    // If there are < 10 characters left    
    if (fotbl.textContent == 0) {
        // Change text color to red         
        fotbl.style.color = "#e01ab5";
        fotbas.style.display = "none";
        fotbuy.style.display = "block";
        
    }else if (fotbl.textContent < 1) {
        // Change text color to red         
        fotbl.style.color = "#e01ab5";
        fotbas.style.display = "block"; 
        fotbuy.style.display = "none";
        
    }else if (fotbl.textContent >= 1) {
        // Display <button>         
       fotbas.style.display = "none";  
       fotbl.style.color = "#6b92a8";
       fotbuy.style.display = "none";
    }


    else {
        // Otherwise, keep default text color   
        fotbl.style.color = "#6b92a8";
    }
});




