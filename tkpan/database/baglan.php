<?php 


if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
  header("Location:../../index.php"); 
  exit();
}


try {
	
	$db=new PDO("mysql:host=localhost;dbname=proje;charset=utf8",'root','');
	//echo "veritabanı baglantısı başarılı";
	
}

catch(PDOException $e) {
	echo $e->getMessage();
}

 ?>