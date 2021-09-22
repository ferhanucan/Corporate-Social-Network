<?php
if ($inckont == 0) {
  header("Location:index.php"); 
  exit();
}elseif (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
  header("Location:index.php"); 
  exit();
}

if ($_GET['kp']=="2") {
  $adres_satir = 'Location:kategori-icerik?kp=2&';
  $m_satir = 'kategori-icerik?kp=2';
  $kpsay = 'kp=2';
  $kpvarmi = '2';
  $getcix = $kpsay;
}elseif ($_GET['kp']=="3") {
  $adres_satir = 'Location:kategori-icerik?kp=3&';
  $m_satir = 'kategori-icerik?kp=3';
  $kpsay = 'kp=3';
  $kpvarmi = '3';
  $getcix = $kpsay;
}elseif ($_GET['kp']=="4") {
  $adres_satir = 'Location:kategori-icerik?kp=4&';
  $m_satir = 'kategori-icerik?kp=4';
  $kpsay = 'kp=4';
  $kpvarmi = '4';
  $getcix = $kpsay;
}elseif ($_GET['kp']=="5") {
  $adres_satir = 'Location:kategori-icerik?kp=5&';
  $m_satir = 'kategori-icerik?kp=5';
  $kpsay = 'kp=5';
  $kpvarmi = '5';
  $getcix = $kpsay;
}elseif ($_GET['kp']=="6") {
  $adres_satir = 'Location:kategori-icerik?kp=6&';
  $m_satir = 'kategori-icerik?kp=6';
  $kpsay = 'kp=6';
  $kpvarmi = '6';
  $getcix = $kpsay;
}elseif ($_GET['kp']=="7") {
  $adres_satir = 'Location:kategori-icerik?kp=7&';
  $m_satir = 'kategori-icerik?kp=7'; 
  $kpsay = 'kp=7';
  $kpvarmi = '7';
  $getcix = $kpsay;
}elseif ($_GET['kp']=="8") {
  $adres_satir = 'Location:kategori-icerik?kp=8&';
  $m_satir = 'kategori-icerik?kp=8';  
  $kpsay = 'kp=8';
  $kpvarmi = '8';
  $getcix = $kpsay;
}elseif ($_GET['kp']=="9") {
  $adres_satir = 'Location:kategori-icerik?kp=9&';
  $m_satir = 'kategori-icerik?kp=9';  
  $kpsay = 'kp=9';
  $kpvarmi = '9';
  $getcix = $kpsay;
}elseif ($_GET['kp']=="10") {
  $adres_satir = 'Location:kategori-icerik?kp=10&';
  $m_satir = 'kategori-icerik?kp=10'; 
  $kpsay = 'kp=10';  
  $kpvarmi = '10';
  $getcix = $kpsay;             
}elseif ($_GET['kp']=="11") {
  $adres_satir = 'Location:kategori-icerik?kp=11&';
  $m_satir = 'kategori-icerik?kp=11';
  $kpsay = 'kp=11';
  $kpvarmi = '11';
  $getcix = $kpsay;
}elseif ($_GET['kp']=="12") {
  $adres_satir = 'Location:kategori-icerik?kp=12&';
  $m_satir = 'kategori-icerik?kp=12';
  $kpsay = 'kp=12';
  $kpvarmi = '12';
  $getcix = $kpsay;
}elseif ($_GET['kp']=="13") {
  $adres_satir = 'Location:kategori-icerik?kp=13&';
  $m_satir = 'kategori-icerik?kp=13'; 
  $kpsay = 'kp=13';
  $kpvarmi = '13';
  $getcix = $kpsay;
}elseif ($_GET['kp']=="14") {
  $adres_satir = 'Location:kategori-icerik?kp=14&';
  $m_satir = 'kategori-icerik?kp=14';  
  $kpsay = 'kp=14';
  $kpvarmi = '14';
  $getcix = $kpsay;
}elseif ($_GET['kp']=="15") {
  $adres_satir = 'Location:kategori-icerik?kp=15&';
  $m_satir = 'kategori-icerik?kp=15';  
  $kpsay = 'kp=15';
  $kpvarmi = '15';
  $getcix = $kpsay;
}elseif ($_GET['ek']=="15") {
  $adres_satir = 'Location:kullanici?ek=15&';
  $m_satir = 'kullanici?ek=15';
}elseif ($_GET['rp']=="1") {
  $adres_satir = 'Location:kullanici?rp=1&';
  $m_satir = 'kullanici?rp=1';
}elseif ($_GET['kp']=="0") {
  $adres_satir = 'Location:profil?';
  $m_satir = 'profil';
  $kpsay = 'kp=0';
  $kpvarmi = '0';
}else {
  $adres_satir = 'Location:profil?';
  $m_satir = 'profil';
  $kpsay = 'kp=0';
  $getcix = $kpsay;
}


if (strlen($_GET['ara']) == 138) { 

        $yazi_1 = strip_tags($_GET['ara']);
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

        $aranan_uye = str_replace("\r\n",'', $yazi_6);

    $uye_ara = $db->prepare("SELECT * from users where uye_profil_code=:pco");
    $uye_ara->execute(array(
    'pco' => $aranan_uye
    ));

    $uye_varmi=$uye_ara->rowCount();

    if ($uye_varmi > 0) {

    $player_cek=$uye_ara->fetch(PDO::FETCH_ASSOC);
    $sorulan_uye = $player_cek['uye_code'];

    if ($player_cek['uye_aktif'] != 1) {
      header('Location:profil?kullanici-bloke=edilmis');
      exit();
    }

    if ($sorulan_uye && $uyecodes) {

        $engelsor=$db->prepare("SELECT * from engel where engel_gonderen=:gonderen and engel_alan=:alan");
        $engelsor->execute(array(
        'gonderen' => $uyecodes,
        'alan' => $sorulan_uye
        ));
        $sor=$engelsor->rowCount();

        $ters_engelsor=$db->prepare("SELECT * from engel where engel_gonderen=:gonderen and engel_alan=:alan");
        $ters_engelsor->execute(array(
        'gonderen' => $sorulan_uye,
        'alan' => $uyecodes
        ));
        $ters_sor=$ters_engelsor->rowCount();
        
        if ($sor > 0 and $ters_sor > 0) {

            header($adres_satir.'engeltam=aktif'); 

          exit();
        }elseif ($sor > 0) {

            header($adres_satir.'engels=aktif'); 
          
          exit();

        }elseif ($ters_sor > 0) {

            header($adres_satir.'engelk=aktif');
          
          exit();
        }

    }


    }else {
      header('Location:profil?kullanici-sistemde=yok');
      exit();
    }


}elseif(strlen($_GET['href']) == 138) {

        $yazi_1 = strip_tags($_GET['href']);
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

        $aranan_uye = str_replace("\r\n",'', $yazi_6);

    $uye_ara = $db->prepare("SELECT * from users where uye_profil_code=:pco");
    $uye_ara->execute(array(
    'pco' => $aranan_uye
    ));

    $uye_varmi=$uye_ara->rowCount();

    if ($uye_varmi > 0) {

    $player_cek=$uye_ara->fetch(PDO::FETCH_ASSOC);
    $sorulan_uye = $player_cek['uye_code'];

    if ($player_cek['uye_aktif'] != 1) {
      header('Location:profil?kullanici-bloke=edilmis');
      exit();
    }

    if ($sorulan_uye && $uyecodes) {

        $engelsor=$db->prepare("SELECT * from engel where engel_gonderen=:gonderen and engel_alan=:alan");
        $engelsor->execute(array(
        'gonderen' => $uyecodes,
        'alan' => $sorulan_uye
        ));
        $sor=$engelsor->rowCount();

        $ters_engelsor=$db->prepare("SELECT * from engel where engel_gonderen=:gonderen and engel_alan=:alan");
        $ters_engelsor->execute(array(
        'gonderen' => $sorulan_uye,
        'alan' => $uyecodes
        ));
        $ters_sor=$ters_engelsor->rowCount();

        if ($sor > 0 and $ters_sor > 0) {

            header($adres_satir.'engeltam=aktif'); 

          exit();
        }elseif ($sor > 0) {

            header($adres_satir.'engels=aktif'); 
          
          exit();

        }elseif ($ters_sor > 0) {

            header($adres_satir.'engelk=aktif'); 
          
          exit();
        }

    }


    }else {
      header('Location:profil?kullanici-sistemde=yok');
      exit();
    }

}elseif (isset($_POST['kullanici-ara'])) {


    $kullanici_ref_sorgu = $_POST['referans-koduyla-ara'];

  if (strlen($kullanici_ref_sorgu) != 10) {

    header('Location:arkadaslar?kullanici-arama=yok&ark=1');
    exit();

  }else {

        $yazi_1 = strip_tags($_POST['referans-koduyla-ara']);
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

        $ref_kullanici_kodu = str_replace("\r\n",'', $yazi_6);

  }
  
    $uye_ara = $db->prepare("SELECT * from users where uye_referans_code=:urfc");
    $uye_ara->execute(array(
    'urfc' => $ref_kullanici_kodu
    ));

    $uye_varmi=$uye_ara->rowCount();

    if ($uye_varmi > 0) {

    $player_cek=$uye_ara->fetch(PDO::FETCH_ASSOC);
    $sorulan_uye = $player_cek['uye_code'];


    if ($player_cek['uye_aktif'] != 1) {
      header('Location:profil?kullanici-bloke=edilmis');
      exit();
    }elseif ($player_cek['uye_code'] == $uyecodes) {
      header('Location:profil?profil=senin&kp=1');
      exit();
    }

    if ($sorulan_uye && $uyecodes) {

        $engelsor=$db->prepare("SELECT * from engel where engel_gonderen=:gonderen and engel_alan=:alan");
        $engelsor->execute(array(
        'gonderen' => $uyecodes,
        'alan' => $sorulan_uye
        ));
        $sor=$engelsor->rowCount();

        $ters_engelsor=$db->prepare("SELECT * from engel where engel_gonderen=:gonderen and engel_alan=:alan");
        $ters_engelsor->execute(array(
        'gonderen' => $sorulan_uye,
        'alan' => $uyecodes
        ));
        $ters_sor=$ters_engelsor->rowCount();

        if ($sor > 0 and $ters_sor > 0) {

            header($adres_satir.'engeltam=aktif'); 

          exit();
        }elseif ($sor > 0) {

            header($adres_satir.'engels=aktif'); 
          
          exit();

        }elseif ($ters_sor > 0) {

            header($adres_satir.'engelk=aktif'); 
          
          exit();
        }

    }


    }else {
      header('Location:arkadaslar?kullanici-arama=yok&ark=1');
      exit();
    }

}else {
    header('Location:profil?kullanici-kodu=hatali');
    exit();
}




if ($_GET['ci'] == 1) {
//çevrimiçi
      $ad_style = 'ci=1&klx=1';
      $mesleklere_gonder = 'cevrimici';
      $getcix = 'ci=1';
}elseif ($_GET['ci'] == 2) {
//kategoriler
      $ad_style = 'ci=2&'.$kpsay;
      $mesleklere_gonder = $m_satir;
      $getcix = 'ci=2';
}elseif ($_GET['ci'] == 3) {
//arkadaşlar
      $ad_style = 'ci=3&klx=1';
      $mesleklere_gonder = 'arkadaslar';
      $getcix = 'ci=3';
}elseif ($_GET['ci'] == 4) {
//bildirimler
      $ad_style = 'ci=4&klx=1';
      $mesleklere_gonder = 'bildirimler';
      $getcix = 'ci=4';
}elseif ($_GET['ci'] == 5) {
//istekler
      $ad_style = 'ci=5&klx=1';
      $getcix = 'ci=5';
      $mesleklere_gonder = 'istekler';
}elseif ($_GET['xp'] > 0 and $_GET['xp'] < 16) {
      $xp_satir = 'kategori-icerik?kp='.$_GET['xp'];
      $mesleklere_gonder = $xp_satir;
}elseif ($player_cek['uye_meslek_grup'] == 2) {
      $mesleklere_gonder = 'meslek-alani?m=2';
}elseif ($player_cek['uye_meslek_grup'] == 3) {
      $mesleklere_gonder = 'meslek-alani?m=3';
}elseif ($player_cek['uye_meslek_grup'] == 4) {
      $mesleklere_gonder = 'meslek-alani?m=4';
}elseif ($player_cek['uye_meslek_grup'] == 5) {
      $mesleklere_gonder = 'meslek-alani?m=5';
}elseif ($player_cek['uye_meslek_grup'] == 6) {
      $mesleklere_gonder = 'meslek-alani?m=6';
}elseif ($player_cek['uye_meslek_grup'] == 7) {
      $mesleklere_gonder = 'meslek-alani?m=7';
}elseif ($player_cek['uye_meslek_grup'] == 8) {
      $mesleklere_gonder = 'meslek-alani?m=8';
}elseif ($player_cek['uye_meslek_grup'] == 9) {
      $mesleklere_gonder = 'meslek-alani?m=9';
}elseif ($player_cek['uye_meslek_grup'] == 10) {
      $mesleklere_gonder = 'meslek-alani?m=10';
}elseif ($player_cek['uye_meslek_grup'] == 11) {
      $mesleklere_gonder = 'meslek-alani?m=11';
}elseif ($player_cek['uye_meslek_grup'] == 12) {
      $mesleklere_gonder = 'meslek-alani?m=12';
}elseif ($player_cek['uye_meslek_grup'] == 13) {
      $mesleklere_gonder = 'meslek-alani?m=13';
}elseif ($player_cek['uye_meslek_grup'] == 14) {
      $mesleklere_gonder = 'meslek-alani?m=14';
}elseif ($player_cek['uye_meslek_grup'] == 15) {
      $mesleklere_gonder = 'meslek-alani?m=15';
}elseif ($player_cek['uye_meslek_grup'] == 16) {
      $mesleklere_gonder = 'meslek-alani?m=16';
}elseif ($player_cek['uye_meslek_grup'] == 17) {
      $mesleklere_gonder = 'meslek-alani?m=17';
}elseif ($player_cek['uye_meslek_grup'] == 18) {
      $mesleklere_gonder = 'meslek-alani?m=18';
}elseif ($player_cek['uye_meslek_grup'] == 19) {
      $mesleklere_gonder = 'meslek-alani?m=19';
}elseif ($player_cek['uye_meslek_grup'] == 20) {
      $mesleklere_gonder = 'meslek-alani?m=20';
}elseif ($player_cek['uye_meslek_grup'] == 21) {
      $mesleklere_gonder = 'meslek-alani?m=21';
}elseif ($player_cek['uye_meslek_grup'] == 22) {
      $mesleklere_gonder = 'meslek-alani?m=22';
}elseif ($player_cek['uye_meslek_grup'] == 100) {
      $mesleklere_gonder = 'meslek-alani?m=100';
}else {
  $mesleklere_gonder = 'profil?meslek=yok';
}


if ($_GET['ci'] == 2) {
  $adx = $ad_style.'&klx=1';
}else {
  $adx = $mesleklere_gonder.'&klx=1';
}



?>