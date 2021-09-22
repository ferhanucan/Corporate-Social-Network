<?php 
ob_start();
session_start();

include 'tkpan/database/baglan.php';
date_default_timezone_set('Europe/Istanbul');


$uyecodes = $_SESSION['uye_code'];






if (isset($_POST['izin_gonder'])) {


  $konular = $_POST['konular'];
  $izin_baslangic=$_POST['izin_baslangic'];
  $izin_bitis=$_POST['izin_bitis'];
  $talep_mesaj=$_POST['talep_mesaj'];


  $bs1=rand(10000,99000);

  $bs2=rand(10000,99000);

  $bs3=rand(10000,99000);

  $bs4=rand(10000,99000);

  $bs5=rand(10000,99000);

  $bs6=rand(10000,99000);

  $benzersizad=$bs1.$bs2.$bs3.$bs4.$bs5.$bs6;
  $talep_kodu = $benzersizad;


  $talep_durum = 0;



  $izin_talep_olustur=$db->prepare("INSERT INTO izin_talepleri SET
    talep_kimin=:talkim,
    talep_durum=:tadur,
    talep_konu=:takonu,
    talep_kodu=:takod,
    talep_mesaj=:tamsj,
    izin_baslangic=:izin_baslangic,
    izin_bitis=:izin_bitis
    ");
  $izin_kayit=$izin_talep_olustur->execute(array(
    'talkim'=> $uyecodes,
    'tadur'=> $talep_durum,
    'takonu'=> $konular,
    'takod'=> $talep_kodu,
    'tamsj'=> $talep_mesaj,
    'izin_baslangic'=> $izin_baslangic,
    'izin_bitis'=> $izin_bitis

  ));

  if ($izin_kayit) {
    header("Location:personel_izin_talep_olustur.php?talep=tamam");
    exit;
  }else{

    header("Location:personel_izin_talep_olustur.php?talep=hatali");

    exit;
  }





}


if (isset($_POST['onayla1'])) {

  $onay_kimin=$_POST['onayla1'];

  $kaydett=$db->prepare("UPDATE izin_talepleri set  talep_durum='1' where talep_kodu=$onay_kimin");

  $insertt=$kaydett->execute();

  if ($insertt) {
    header("Location:izin_talepleri.php?onay=tamam");
    exit;
  }else{

    header("Location:izin_talepleri.php?onay=hatali");

    exit;
  }}

if (isset($_POST['reddet1'])) {

  $onay_kimin2=$_POST['reddet1'];

  $kaydett=$db->prepare("UPDATE izin_talepleri set  talep_durum='2' where talep_kodu=$onay_kimin2");

  $insertt=$kaydett->execute();

  if ($insertt) {
    header("Location:izin_talepleri.php?onay=redtamam");
    exit;
  }else{

    header("Location:izin_talepleri.php?onay=redhatali");

    exit;
  }}

















?>














