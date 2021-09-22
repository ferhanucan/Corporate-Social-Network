var $select1 = $( '#select1' ),
		$select2 = $( '#select2' ),
    $options = $select2.find( 'option' );
    
$select1.on( 'change', function() {
	$select2.html( $options.filter( '[value="' + this.value + '"]' ) );
} ).trigger( 'change' );




function acB(event)  {
document.getElementById(event).style.display = "block";  }
function kapatB(event)  {
document.getElementById(event).style.display = "none";  }


