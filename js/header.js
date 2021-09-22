$(document).ready(function () {
	$('.res-menu-tipi').on('click', function() {
		$('.nav-dizayn .nav-liste').toggleClass('ackapat');
		$(this).find('i').toggleClass('fa-bars fa-close')

	});
});


$('.mesaj_tablosu').scrollTop($('.mesaj_tablosu').prop('scrollHeight'));
