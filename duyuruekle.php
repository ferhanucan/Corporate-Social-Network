<?php 
ob_start();
session_start();

include 'tkpan/database/baglan.php';
date_default_timezone_set('Europe/Istanbul');




if (isset($_POST['duyurugonder'])) {


	$kaydetduyuru=$db->prepare("INSERT INTO genel_duyurular SET
		duyuru_icerik=:duyuru_icerik,
		duyuru_baslik=:duyuru_baslik,
		duyuru_tarih=:duyuru_tarih   ");


	$insertt=$kaydetduyuru->execute(array(

		
		'duyuru_icerik' => $_POST['duyuru_icerik'],
		'duyuru_baslik' => $_POST['duyuru_baslik'],
		'duyuru_tarih' => $_POST['duyuru_tarih']
		
	));



	if ($insertt) {

        //echo "kayıt başarılı";

		Header("Location:anasayfa.php?duyuru=ok");



		exit;

	} else {

        //echo "kayıt başarısız";
		Header("Location:anasayfa.php?duyuru=no");
		exit;
	}






}



















?>