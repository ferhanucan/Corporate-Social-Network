<?php 
ob_start();
session_start();

include '../tkpan/database/baglan.php';
date_default_timezone_set('Europe/Istanbul');


$uyecodes = $_SESSION['uye_code'];


if ($_POST['ax5321c'] == 'c2vbz26gd845hgcvxker') {
  $adres_satir = 'Location:../destek-olustur.php?dstk=1&';
}elseif ($_POST['ax5321c'] == 'k12n6ck8t769yd67xz4s') {
  $adres_satir = 'Location:../destek-mesaj.php?dstk=2&';
}else {
    header('profil?destekgonder=hata&kp=1');
    exit(); 
}


if ($_SESSION['sessizin'] != 1 and strlen($uyecodes) != 30) {
    header('Location:../anasayfa.php?koruma=etkin');
    exit();
}


if (isset($_POST['destek-kaydet'])) {

$talep_aktif = '1';
$destek_sorgula=$db->prepare("SELECT * from destek_talep where talep_kimin=:talepkim and talep_durum=:tadurum");
$destek_sorgula->execute(array(
  'talepkim' => $uyecodes,
  'tadurum'=> $talep_aktif
));

$destek_varmi=$destek_sorgula->rowCount();
if ($destek_varmi > 10) {
  header($adres_satir.'destekgonder=coktalepvar');
  exit();  
}

$konular = $_POST['konular'];


$yazi_1 = strip_tags($_POST['destek-metin']);
$yazi_2 = stripslashes($yazi_1);
$yazi_3 = trim($yazi_2);
$yazi_4 = htmlspecialchars_decode($yazi_3, ENT_COMPAT);

$yazi_5 = htmlentities($yazi_4);

function replaceSpace($string)
  {
    $string = preg_replace("/\s+/", " ", $string);
    $string = trim($string);
    return $string;
  }

$yazi_6 = replaceSpace($yazi_5);

$metin = str_replace("\r\n",'', $yazi_6);


if ($konular < 1 or $konular > 4 or strlen($konular) > 1) {
    header($adres_satir.'destekgonder=hata');
    exit();  
}elseif (empty($konular) or empty($yazi_1)) {
    header($adres_satir.'destekgonder=boslukvar');
    exit();  
}elseif (strlen(utf8_decode($yazi_1)) < 10 or strlen(utf8_decode($yazi_1)) > 1000) {
    header($adres_satir.'destekgonder=hata');
    exit();  
}elseif ($_SESSION['sondestek'] === $yazi_1) {
    header($adres_satir.'destekgonder=tekrar');
    exit();
}elseif (!ctype_digit($konular)) {
    header($adres_satir.'destekgonder=hata');
    exit();  
}else {
  if ($konular == 1) {
    $destek_konu = 'Destek - bilgi alma';
  }elseif ($konular == 2) {
    $destek_konu = 'Şikayet';
  }elseif ($konular == 3) {
    $destek_konu = 'Öneri ve görüş';
  }elseif ($konular == 4) {
    $destek_konu = 'Hesap işlemleri';
  }else {
    $destek_konu = 'Boş';
  }
}


  $bs1=rand(10000,99000);

  $bs2=rand(10000,99000);

  $bs3=rand(10000,99000);

  $bs4=rand(10000,99000);

  $bs5=rand(10000,99000);

  $bs6=rand(10000,99000);

  $benzersizad=$bs1.$bs2.$bs3.$bs4.$bs5.$bs6;
  $destekkod = $benzersizad;


  $talep_durum = 1;
  $destek_kimin = 0;
  $tason = 0;


  $destek_talep_olustur=$db->prepare("INSERT INTO destek_talep SET
    talep_kimin=:talkim,
    talep_durum=:tadur,
    talep_konu=:takonu,
    talep_kod=:takod,
    talep_sonmesaj=:tason
    ");
  $talep_kayit=$destek_talep_olustur->execute(array(
    'talkim'=> $uyecodes,
    'tadur'=> $talep_durum,
    'takonu'=> $destek_konu,
    'takod'=> $destekkod,
    'tason'=> $tason
    ));

if($talep_kayit) {

  $destek_bas=$db->prepare("INSERT INTO destekler SET
    destek_isteyen=:distyn,
    destek_mesaj=:dmesaj,
    destek_kod=:deskod,
    destek_kimin=:dkim
    ");
  $destek_kayit=$destek_bas->execute(array(
    'distyn'=> $uyecodes,
    'dmesaj'=> $metin,
    'deskod'=> $destekkod,
    'dkim'=> $destek_kimin
    ));

  if($destek_kayit) {
    $_SESSION['sondestek'] = $yazi_1;
    header($adres_satir.'destekgonder=tamam');
    exit(); 
  }else {
    header($adres_satir.'destekgonder=hata');
    exit();                     
  }

}else {
    header($adres_satir.'destekgonder=hata');
    exit();  
}



}elseif (isset($_POST['destek-cevapla'])) {


$destek_talep_num = $_POST['dg843xas'];


$metin_1 = strip_tags($_POST['cevap-metin']);
$metin_2 = stripslashes($metin_1);
$metin_3 = trim($metin_2);
$metin_4 = htmlspecialchars_decode($metin_3, ENT_COMPAT);

$metin_5 = htmlentities($metin_4);

function replaceSpace($string)
  {
    $string = preg_replace("/\s+/", " ", $string);
    $string = trim($string);
    return $string;
  }

$metin_6 = replaceSpace($metin_5);

$destek_mesaj = str_replace("\r\n",'', $metin_6);


if (strlen($destek_talep_num) != 30) {
    header($adres_satir.'destekcevap=hata&dmk='.$destek_talep_num);
    exit();  
}elseif (empty($destek_talep_num) or empty($metin_1)) {
    header($adres_satir.'destekcevap=boslukvar&dmk='.$destek_talep_num);
    exit();  
}elseif (strlen(utf8_decode($metin_1)) < 1 or strlen(utf8_decode($metin_1)) > 1000) {
    header($adres_satir.'destekcevap=hata&dmk='.$destek_talep_num);
    exit();  
}elseif ($_SESSION['sonmetin'] === $metin_1) {
    header($adres_satir.'destekcevap=tekrar&dmk='.$destek_talep_num);
    exit();
}elseif (!ctype_digit($destek_talep_num)) {
    header($adres_satir.'destekcevap=hata&dmk='.$destek_talep_num);
    exit();  
}else {

$talep_hal = '1';
$destek_talep_sor=$db->prepare("SELECT * from destek_talep where talep_kimin=:taode and talep_kod=:takox and talep_durum=:taludur");
$destek_talep_sor->execute(array(
  'taode' => $uyecodes,
  'takox'=> $destek_talep_num,
  'taludur'=> $talep_hal
));

$talepvarmi=$destek_talep_sor->rowCount();
if ($talepvarmi == 0) {
  header($adres_satir.'destekcevap=hata&dmk='.$destek_talep_num);
  exit();
}

$talep_cek = $destek_talep_sor->fetch(PDO::FETCH_ASSOC);
$tal_id = $talep_cek['id'];

$sonyazan = $talep_cek['talep_sonmesaj'];

if ($sonyazan == 0) {
  header($adres_satir.'destekcevap=bekle&dmk='.$destek_talep_num);
  exit();
}else {


  $destek_1 = '0';
  $des_sonuc = '0';

  $destekupdate=$db->prepare("UPDATE destek_talep SET
    talep_sonmesaj=:talos                  
    WHERE id=$tal_id");
  $updatedestek=$destekupdate->execute(array(
    'talos'=> $des_sonuc               
    ));

  if ($updatedestek) {

    $destek_kaydet=$db->prepare("INSERT INTO destekler SET
      destek_isteyen=:distyn,
      destek_mesaj=:dmesaj,
      destek_kod=:deskod,
      destek_kimin=:dkim
      ");
    $destek_islem=$destek_kaydet->execute(array(
      'distyn'=> $uyecodes,
      'dmesaj'=> $destek_mesaj,
      'deskod'=> $destek_talep_num,
      'dkim'=> $destek_1
      ));

    if($destek_islem) {
      $_SESSION['sonmetin'] = $yazi_1;
      header($adres_satir.'destekcevap=tamam&dmk='.$destek_talep_num);
      exit(); 
    }else {
      header($adres_satir.'destekcevap=hata&dmk='.$destek_talep_num);
      exit();                     
    }

  }else {
      header($adres_satir.'destekcevap=hata&dmk='.$destek_talep_num);
      exit();   
  }


  }//sorgu elsesi bitiş


}//guvenlik elsesi bitiş

}else {
    header($adres_satir.'hile=v6');
    exit();
    //guvenlik
}

?>














