<?php 
include 'tkpan/database/baglan.php';



if (isset($_POST['gonder'])) {


	$gelen=$_POST['id'];

	$kaydet=$db->prepare("UPDATE users set  
		
		uye_ad=:uye_ad,
		uye_soyad=:uye_soyad,
		uye_tc=:uye_tc,
		uye_yas=:uye_yas,
		uye_isegiristarihi=:uye_isegiristarihi,
		uye_istencikistarihi=:uye_istencikistarihi,
		uye_telefon=:uye_telefon,
		uye_departman=:uye_departman,
		uye_email=:uye_email,
		uye_meslek=:uye_meslek,
		uye_medenihal=:uye_medenihal,
		uye_kangrup=:uye_kangrup,
		uye_askerlikdurum=:uye_askerlikdurum,
		uye_ehliyet=:uye_ehliyet,
		uye_seyehat=:uye_seyehat,
		uye_sgkno=:uye_sgkno,
		uye_adres=:uye_adres,
		uye_il=:uye_il,
		uye_ilce=:uye_ilce,
		uye_ulke=:uye_ulke
		





		where id=$gelen");

	$insert=$kaydet->execute(array(

		
		'uye_ad' => $_POST['uye_ad'],
		'uye_soyad' => $_POST['uye_soyad'],
		'uye_tc' => $_POST['uye_tc'],
		'uye_yas' => $_POST['uye_yas'] ,
		'uye_isegiristarihi' => $_POST['uye_isegiristarihi'],
		'uye_istencikistarihi' => $_POST['uye_istencikistarihi'],
		'uye_telefon' => $_POST['uye_telefon'],
		'uye_departman' => $_POST['uye_departman'],
		'uye_email' => $_POST['uye_email'],
		'uye_meslek' => $_POST['uye_meslek'],
		'uye_medenihal' => $_POST['uye_medenihal'],
		'uye_kangrup' => $_POST['uye_kangrup'],
		'uye_askerlikdurum' => $_POST['uye_askerlikdurum'],
		'uye_ehliyet' => $_POST['uye_ehliyet'],
		'uye_seyehat' => $_POST['uye_seyehat'],
		'uye_sgkno' => $_POST['uye_sgkno'],
		'uye_adres' => $_POST['uye_adres'],
		'uye_il' => $_POST['uye_il'],
		'uye_ilce' => $_POST['uye_ilce'],
		'uye_ulke' => $_POST['uye_ulke']

	));

	if ($insert) {

        //echo "kayıt başarılı";

		Header("Location:personelliste.php?sonuc=ok");



		exit;

	} else {

        //echo "kayıt başarısız";
		Header("Location:personelliste.php?sonuc=no");
		exit;
	}



}



















?>