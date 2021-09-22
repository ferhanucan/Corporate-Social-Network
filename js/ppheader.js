$(document).ready(function () {
	$('.res-menu-tipi').on('click', function() {
		$('.nav-dizayn .nav-liste').toggleClass('ackapat');
		$(this).find('i').toggleClass('fa-bars fa-close')

	});
});


$('.mesaj_tablosu').scrollTop($('.mesaj_tablosu').prop('scrollHeight'));



$('.menu').addClass('original').clone().insertAfter('.menu').addClass('cloned').css('position','fixed').css('top','0').css('margin-top','0').css('z-index','9999').removeClass('original').hide();

scrollIntervalID = setInterval(stickIt, 10);


function stickIt() {

  var orgElementPos = $('.original').offset();
  orgElementTop = orgElementPos.top;               

  if ($(window).scrollTop() >= (orgElementTop)) {


 
    orgElement = $('.original');
    coordsOrgElement = orgElement.offset();
    leftOrgElement = coordsOrgElement.left;  
    widthOrgElement = orgElement.css('width');
    $('.cloned').css('left',leftOrgElement+'px').css('top',0).css('width',widthOrgElement).show();
    $('.original').css('visibility','hidden');
  } else {

    $('.cloned').hide();
    $('.original').css('visibility','visible');
  }
}


function openNav() {
    document.getElementById("mySidenav").style.display = "block";
}

function closeNav() {
    document.getElementById("mySidenav").style.display = "none";
}


var dropdown = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var dropdownContent = this.nextElementSibling;
    if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
    } else {
      dropdownContent.style.display = "block";
    }
  });
}