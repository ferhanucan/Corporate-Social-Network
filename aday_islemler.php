<?php 
ob_start();
session_start();
include 'tkpan/database/baglan.php';
date_default_timezone_set('Europe/Istanbul');




$uyecodes = $_SESSION['uye_code'];

if (isset($_POST['aday_kayit'])) {


	$aday_ad = $_POST['aday_ad'];
	$aday_soyad = $_POST['aday_soyad'];
	$aday_tc = $_POST['aday_tc'];
	$aday_telefon = $_POST['aday_telefon'];
	$aday_email = $_POST['aday_email'];
	$aday_hakkinda = $_POST['aday_hakkinda'];
	$aday_cinsiyet = $_POST['aday_cinsiyet'];
	$tarih_gun = trim(strip_tags($_POST['tarih_gun']));
	$tarih_ay = trim(strip_tags($_POST['tarih_ay']));
	$tarih_yil = trim(strip_tags($_POST['tarih_yil']));
	$aday_dogumtarihi = $tarih_yil.'-'.$tarih_ay.'-'.$tarih_gun;
	$aday_medenidurum = $_POST['aday_medenidurum'];
	$aday_askerlikdurum = $_POST['aday_askerlikdurum'];
	$aday_surucubelgesi = $_POST['aday_surucubelgesi'];
	$aday_okul = $_POST['aday_okul'];
	$aday_bolum = $_POST['aday_bolum'];
	$aday_egitimdurum = $_POST['aday_egitimdurum'];
	$aday_oncekiisyeri = $_POST['aday_oncekiisyeri'];
	$aday_oncekiisyeri_sure = $_POST['aday_oncekiisyeri_sure'];
	$aday_oncekiisyeri_pozisyon = $_POST['aday_oncekiisyeri_pozisyon'];
	$aday_uzmanlik = $_POST['aday_uzmanlik'];
	$aday_referans_adsoyad=$_POST['aday_referans_adsoyad'];
	$aday_referans_iletisim=$_POST['aday_referans_iletisim'];
	$aday_yabancidil = $_POST['aday_yabancidil'];
	$aday_code = $uyecodes;
	



	$bs1=rand(10000,99000);

	$bs2=rand(10000,99000);

	$bs3=rand(10000,99000);

	$bs4=rand(10000,99000);

	$bs5=rand(10000,99000);

	$bs6=rand(10000,99000);

	$benzersizad=$bs1.$bs2.$bs3.$bs4.$bs5.$bs6;
	$aday_cv_code = $benzersizad;


	$aday_kayit_olustur=$db->prepare("INSERT INTO aday_veritabani_cv SET
		aday_ad=:aday_ad,
		aday_soyad=:aday_soyad,
		aday_email=:aday_email,
		aday_telefon=:aday_telefon,
		aday_cinsiyet=:aday_cinsiyet,
		aday_dogumtarihi=:aday_dogumtarihi,
		aday_hakkinda=:aday_hakkinda,
		aday_surucubelgesi=:aday_surucubelgesi,
		aday_code=:aday_code,
		aday_okul=:aday_okul,
		aday_bolum=:aday_bolum,
		aday_egitimdurum=:aday_egitimdurum,
		aday_tc=:aday_tc,
		aday_askerlikdurum=:aday_askerlikdurum,
		aday_medenidurum=:aday_medenidurum,
		aday_referans_iletisim=:aday_referans_iletisim,
		aday_referans_adsoyad=:aday_referans_adsoyad,
		aday_yabancidil=:aday_yabancidil,
		aday_uzmanlik=:aday_uzmanlik,
		aday_oncekiisyeri=:aday_oncekiisyeri,
		aday_oncekiisyeri_sure=:aday_oncekiisyeri_sure,
		aday_oncekiisyeri_pozisyon=:aday_oncekiisyeri_pozisyon,
		aday_cv_code=:aday_cv_code

		
		

		");
	$aday_kayit=$aday_kayit_olustur->execute(array(

		'aday_ad'=>$aday_ad,
		'aday_soyad'=>$aday_soyad,
		'aday_email'=>$aday_email,
		'aday_telefon'=>$aday_telefon,
		'aday_cinsiyet'=>$aday_cinsiyet,
		'aday_dogumtarihi'=>$aday_dogumtarihi,
		'aday_hakkinda'=>$aday_hakkinda,
		'aday_surucubelgesi'=>$aday_surucubelgesi,
		'aday_code'=>$aday_code,
		'aday_okul'=>$aday_okul,
		'aday_bolum'=>$aday_bolum,
		'aday_egitimdurum'=>$aday_egitimdurum,
		'aday_tc'=>$aday_tc,
		'aday_askerlikdurum'=>$aday_askerlikdurum,
		'aday_medenidurum'=>$aday_medenidurum,
		'aday_referans_iletisim'=>$aday_referans_iletisim,
		'aday_referans_adsoyad'=>$aday_referans_adsoyad,
		'aday_yabancidil'=>$aday_yabancidil,
		'aday_uzmanlik'=>$aday_uzmanlik,
		'aday_oncekiisyeri'=>$aday_oncekiisyeri,
		'aday_oncekiisyeri_sure'=>$aday_oncekiisyeri_sure,
		'aday_oncekiisyeri_pozisyon'=>$aday_oncekiisyeri_pozisyon,
		'aday_cv_code'=>$aday_cv_code

		
		

	));

	if ($aday_kayit) {
		header("Location:aday_anasayfa.php?kayit=tamam");
		exit;
	}else{

		header("Location:aday_anasayfa.php?kayit=hatali");

		exit;
	}









}

















?>