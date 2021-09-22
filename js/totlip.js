
$(document).ready(function(){
    $("i").tooltip();
});

$(document).ready(function(){
    $("a").tooltip();
});

$(document).ready(function(){
    $("button").tooltip();
});

$(document).ready(function(){
    $("input").tooltip();
});



(function() {

  function destekarea() {
    $('.dest-area').each(function(index, desalan) {
       var xdesalan = desalan,
          $xdesalan = $(desalan),
          initialHeight = initialHeight || $xdesalan.height(),
          delta = parseInt( $xdesalan.css('paddingBottom') ) + parseInt( $xdesalan.css('paddingTop') ) || 0,
          resize = function() {
            $xdesalan.height(initialHeight);
            $xdesalan.height( xdesalan.scrollHeight - delta );
        };
      
      $xdesalan.on('input change keyup', resize);
      resize();
    });
    
  };


  destekarea();
  

})();




var birinciyazi = document.querySelector(".birinciyazi");
var ikinciyazi = document.querySelector(".ikinciyazi");
var saydir = document.getElementById("saydir");
// Select <p>
var sayiyonet = document.querySelector(".sayitakip");
// Select <button>
var buttonclas = document.querySelector(".buttonclas");


saydir.addEventListener("input", function() {
    
    // Count characters down    
    sayiyonet.textContent = 1000 - saydir.value.length;
    
    // If there are < 10 characters left    
    if (sayiyonet.textContent == 0) {
        // Change text color to red         
        sayiyonet.style.color = "#e01ab5";
        birinciyazi.style.display = "none";
        ikinciyazi.style.display = "block"; 
        buttonclas.disabled = false;
        
    }else if (sayiyonet.textContent < 1) {
        // Change text color to red         
        sayiyonet.style.color = "#e01ab5";
        birinciyazi.style.display = "block"; 
        ikinciyazi.style.display = "none";
        buttonclas.disabled = true;
        
    }else if (sayiyonet.textContent >= 1) {
        // Display <button>         
       birinciyazi.style.display = "none";  
       sayiyonet.style.color = "#6b92a8";
       ikinciyazi.style.display = "none";  
       buttonclas.disabled = false;
    }


    else {
        // Otherwise, keep default text color   
        sayiyonet.style.color = "#6b92a8";
        // Hide <button>
        buttonclas.style.display = "none";
    }
});

$(document).ready(function()
{
    $(".dezx").attr('maxlength','1000');
    $(".dezx").attr('minlength','1');
    $(".dezx").prop('required',true);
});

$(document).ready(function()
{
    $(".dezst").attr('maxlength','1000');
    $(".dezst").attr('minlength','10');
    $(".dezst").prop('required',true);
});







