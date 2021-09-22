<?php
ob_start();
session_start();
error_reporting(0);
include 'tkpan/database/baglan.php';
date_default_timezone_set('Europe/Istanbul');

$inckont = 1;

$_SESSION['uye_code'];
$activ=1;


$uyesor=$db->prepare("SELECT * from users where uye_code=:code and uye_aktif=:uakx");
$uyesor->execute(array(
  'code' => $_SESSION['uye_code'],
  'uakx' => $activ
));

$uyesay=$uyesor->rowCount();

if ($uyesay==0) {

  $page_session_izin = 0;
  $_SESSION['sessizin'] = 0;

}elseif (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
  header("Location:index.php"); 
  exit();
}elseif (isset($_GET['sayfa']) or strlen($_GET['sayfa']) > 0) {
  if (!ctype_digit($_GET['sayfa'])) {
    header('Location:profil.php?sayfanumarasi=rakamolmali');
    exit();
  }
}elseif ($uyesay > 0) {

  $page_session_izin = 1;
  $_SESSION['sessizin'] = 1;

}else {

  $page_session_izin = 0;
  $_SESSION['sessizin'] = 0;

}

$uye_islem=$uyesor->fetch(PDO::FETCH_ASSOC);

if ($uye_islem['uye_boss'] != 1) {
  $izin_id = '1';
  $giris_izin_varmi=$db->prepare("SELECT * from izinler where izin_id=:izid");
  $giris_izin_varmi->execute(array(
    'izid' => $izin_id
  ));

  $giris_izin_cek=$giris_izin_varmi->fetch(PDO::FETCH_ASSOC); 
  $giris_izin = $giris_izin_cek['izin_giris'];

  if ($giris_izin != 1) {
    $page_session_izin = 0;
    header('Location:login/cikis.php?girisyasak=1');
    exit();
  }
}


$uyecodes = $uye_islem['uye_code']; 

$korunan1 = $_SERVER['REQUEST_URI'];
$korunan2 = $_SERVER['SERVER_NAME'];

$hedefler = array('chr(', 'chr=', 'chr%20', '%20chr', 'wget%20', '%20wget', 'wget(',
  'cmd=', '%20cmd', 'cmd%20', 'rush=', '%20rush', 'rush%20',
  'union%20', '%20union', 'union(', 'union=', 'echr(', '%20echr', 'echr%20', 'echr=',
  'esystem(', 'esystem%20', 'cp%20', '%20cp', 'cp(', 'mdir%20', '%20mdir', 'mdir(',
  'mcd%20', 'mrd%20', 'rm%20', '%20mcd', '%20mrd', '%20rm',
  'mcd(', 'mrd(', 'rm(', 'mcd=', 'mrd=', 'mv%20', 'rmdir%20', 'mv(', 'rmdir(',
  'chmod(', 'chmod%20', '%20chmod', 'chmod(', 'chmod=', 'chown%20', 'chgrp%20', 'chown(', 'chgrp(',
  'locate%20', 'grep%20', 'locate(', 'grep(', 'diff%20', 'kill%20', 'kill(', 'killall',
  'passwd%20', '%20passwd', 'passwd(', 'telnet%20', 'vi(', 'vi%20',
  'insert%20into', 'select%20', 'nigga(', '%20nigga', 'nigga%20', 'fopen', 'fwrite', '%20like', 'like%20',
  '$_request', '$_get', '$request', '$get', '.system', 'HTTP_PHP', '&aim', '%20getenv', 'getenv%20',
  'new_password', '&icq','/etc/password','/etc/shadow', '/etc/groups', '/etc/gshadow',
  'HTTP_USER_AGENT', 'HTTP_HOST', '/bin/ps', 'wget%20', 'uname\x20-a', '/usr/bin/id',
  '/bin/echo', '/bin/kill', '/bin/', '/chgrp', '/chown', '/usr/bin', 'g\+\+', 'bin/python',
  'bin/tclsh', 'bin/nasm', 'perl%20', 'traceroute%20', 'ping%20', '.pl', '/usr/X11R6/bin/xterm', 'lsof%20',
  '/bin/mail', '.conf', 'motd%20', 'HTTP/1.', '.inc.php', 'config.php', 'cgi-', '.eml',
  'file\://', 'window.open', '<SCRIPT>', 'javascript\://','img src', 'img%20src','.jsp','ftp.exe',
  'xp_enumdsn', 'xp_availablemedia', 'xp_filelist', 'xp_cmdshell', 'nc.exe', '.htpasswd',
  'servlet', '/etc/passwd', 'wwwacl', '~root', '~ftp', '.js', '.jsp', 'admin_', '.history',
  'bash_history', '.bash_history', '~nobody', 'server-info', 'server-status', 'reboot%20', 'halt%20',
  'powerdown%20', '/home/ftp', '/home/www', 'secure_site, ok', 'chunked', 'org.apache', '/servlet/con',
  '<script', '/robot.txt' ,'/perl' ,'mod_gzip_status', 'db_mysql.inc', '.inc', 'select%20from',
  'select from', 'drop%20', '.system', 'getenv', 'http_', '_php', 'php_', 'phpinfo()', '<?php', '?>', 'sql=', '.htaccess');

$yakala1 = str_replace($hedefler, '*', $korunan1);
$yakala2 = str_replace($hedefler, '*', $korunan2);

if ($korunan1 != $yakala1) {
  header('Location:login/cikis.php');
  exit();
}elseif  ($korunan2 != $yakala2){
  header('Location:login/cikis.php');
  exit();
}


if ($_SESSION['sessizin'] == 1) {

//online
  $online_sorgula=$db->prepare("SELECT * from online where online_uyecode=:on_code");
  $online_sorgula->execute(array(
    'on_code' => $_SESSION['uye_code']
  ));

  $online_say=$online_sorgula->rowCount();
  $zaman = date('Y-m-d H:i:s',strtotime('+2 minutes'));
  $saat = date('H:i');
  $tarih = date('d-m-Y');

  $online_cek=$online_sorgula->fetch(PDO::FETCH_ASSOC);

  if ($online_say > 0) {

    if (date('Y-m-d H:i:s') >= $online_cek['online_zaman']) {

      $online_id = $online_cek['id'];

      $online_kaydet=$db->prepare("UPDATE online SET
        online_saat=:saat,
        online_tarih=:tarih,
        online_zaman=:zaman
        WHERE id=$online_id");
      $update=$online_kaydet->execute(array(
        'saat'=> $saat,
        'tarih'=> $tarih,
        'zaman'=> $zaman
      ));

    }

  }else {
    $online_bas=$db->prepare("INSERT INTO online SET
      online_uyecode=:oucod,
      online_saat=:saat,
      online_tarih=:tarih,
      online_zaman=:zaman
      ");
    $online_kayit=$online_bas->execute(array(
      'oucod'=> $_SESSION['uye_code'],
      'saat'=> $saat,
      'tarih'=> $tarih,
      'zaman'=> $zaman
    ));

  }

//online bitiş
}

?>


<!DOCTYPE html>
<html lang="tr">
<head>


  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">	

  <title>İNSAN KAYNAKLARI YÖNETİMİ</title>	



  <meta name="theme-color" content="#187cb1">

  <meta name="msapplication-navbutton-color" content="#187cb1">

  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="#187cb1">


  <link rel="shortcut icon" href="yimg/favicon.png" type="image/x-icon" />
  <link rel="apple-touch-icon" href="yimg/favicon.png">


  <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <link rel="stylesheet" href="assets/css/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="general/font-awesome/css/font-awesome.min.css">

  <link href='https://fonts.googleapis.com/css?family=Oswald:300' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" />


  <link rel="stylesheet" href="css/fontlar.css">
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/avatar.css">
  <link rel="stylesheet" href="css/panel.css">
  <link rel="stylesheet" href="css/buttons.css">
  <link rel="stylesheet" href="css/option.css">
  <link rel="stylesheet" href="css/baslik.css">
  <link rel="stylesheet" href="css/paylasim.css">
  <link rel="stylesheet" href="css/totilp.css">
  <link rel="stylesheet" href="css/ripes.css">
  <link rel="stylesheet" href="css/mesaj.css">


  <script src="general/jquery/jquery.min.js"></script>
  <script type="text/javascript" src="js/resimstyle.js"></script>

  




  <link rel="stylesheet" href="css/style.css">

  <script src="js/jquery.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Coda" />
  <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Kelly+Slab" />
  <link href='https://css.gg/user.css' rel='stylesheet'>
  <link rel="icon" href="assets/img/brand/favicon.png" type="image/png">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <link rel="stylesheet" href="assets/vendor/nucleo/css/nucleo.css" type="text/css">
  <link rel="stylesheet" href="assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">
  <link rel="stylesheet" href="assets/css/argon.css?v=1.2.0" type="text/css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/4.9.95/css/materialdesignicons.css" rel="stylesheet">
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  




</head>


<body class="row">

  <!-- EN ÜST NAVBAR BAŞLANGIÇ--------------------------------------------------------------------- -->
  <nav class="navbarr navbar-top navbar-expand navbar-dark bg-primary border-bottom" style="height:70px;" >
    <div class="container-fluid">
      <div class="collapse navbar-collapse" id="navbarSupportedContent" style="height:70px;">

        <nav class="navbarr navbar-top navbar-expand navbar-dark bg- border-bottom" style="height:50px;" >
         <div style="margin-top:10px; margin-left:5px;">

          <a href="anasayfa.php" class="btn2">Anasayfa</a>


          <!-- Yönetici Girişi İçin Menü -->
          <?php if ($_SESSION['sessizin'] == 1 and $_SESSION['uye_yetki']==1 ) { ?>


            <a class="btn2" href="personelyonetimi.php">Personel Yönetimi</a>
            <!--<a class="btn2" href="personel_ise_alim_yonetimi.php">İşe Alım Yönetimi</a>-->


          <?php } ?>

          
          <!-- Çalışan  Girişi İçin Menü -->



          <?php if ($_SESSION['sessizin'] == 1 and $_SESSION['uye_yetki']==2 ) { ?>
            <a href="personel_izin_talep_olustur.php"    class="btn2">İzin Talep Formu</a>

          <?php } ?>





          
          <?php if ($_SESSION['sessizin'] == 0) { ?>
            <a href="login/giris.php" class="btn2">Giriş Yap</a>
          <?php } ?>

        </div>

      </nav>
      


      <!-- Sitede arama başlangıç -->
      <?php if ($_SESSION['sessizin'] == 1 and $_SESSION['uye_yetki']==2 or $_SESSION['uye_yetki']==1  ) { ?>

        <form method="GET" action="arama.php" style="margin-left:200px;">
         <table class="tableclass">
          <thead>
            <tr>


              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                  </svg></span>
                </div>
                <input type="text" id="arama-islemi" name="ara" class="form-control" placeholder="Ara"  aria-describedby="basic-addon1">
              </div>
            </tr>

          </thead>
        </table>
      </form>

    <?php } ?>



    <!-- Sitede arama bitiş -->









    <ul class="navbar-nav align-items-center  ml-md-auto ">




      <!-- mesajlar başlangıç -->

      <?php 
      $goster = 10;
      $say=$db->prepare("SELECT * from mesajlar where mesaj_kimin=:kimin");
      $say->execute(array(
       'kimin' => $uyecodes));
      $toplamveri=$say->rowCount();
      $sayfa_sayisi = ceil($toplamveri / $goster);
      $sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;
      if ($sayfa < 1) {$sayfa = 1;}
      if ($sayfa > $sayfa_sayisi) {$sayfa = 1;}
      $listele = ($sayfa - 1) * $goster;
      $gorunen_buton = 4;
      ?>


      <?php if ($_SESSION['sessizin'] == 1 and $uye_islem['uye_yetki']==1 or $uye_islem['uye_yetki']==2) { ?>
        <li class="nav-item dropdown">

          <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <svg xmlns="http://www.w3.org/2000/svg" style="margin-bottom:3px;" width="16" height="16" fill="currentColor" class="bi bi-chat-fill" viewBox="0 0 16 16">
              <path d="M8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6-.097 1.016-.417 2.13-.771 2.966-.079.186.074.394.273.362 2.256-.37 3.597-.938 4.18-1.234A9.06 9.06 0 0 0 8 15z"/>
            </svg><span  class="badge badge-danger" style="margin-left:1px;"><?php echo $toplamveri; ?></span>
          </a>
          <div class="dropdown-menu dropdown-menu-xl  dropdown-menu-right  py-0 overflow-hidden">
            <!-- Dropdown header -->
            <div class="px-3 py-3">
              <h6 class="text-sm text-muted m-0"><strong class="text-primary"><?php echo $toplamveri; ?></strong> Konuşmanız Var</h6>
            </div>
            <!-- List group -->
            <div class="list-group list-group-flush">

              <div class="mesaj-yer-alan">


                <?php  


                $mesaj_sor=$db->prepare("SELECT * from mesajlar where mesaj_kimin=:kimin ORDER BY mesaj_zaman DESC limit $listele, $goster");
                $mesaj_sor->execute(array(
                  'kimin' => $uyecodes
                ));


                while($m_cek=$mesaj_sor->fetch(PDO::FETCH_ASSOC)) { ?>  

                  <?php  

                  $ark_listesi = $m_cek['mesaj_alici'];
                  $arkadas_listele=$db->prepare("SELECT * from users where uye_code=:code");
                  $arkadas_listele->execute(array(
                    'code' => $ark_listesi
                  ));

                  $ark=$arkadas_listele->fetch(PDO::FETCH_ASSOC);

                  $ad = $ark['uye_ad'];
                  $soyad = $ark['uye_soyad'];

                  $adsoyad = $ad." ".$soyad;

                  $mesaj_icerik = $m_cek['mesaj_icerik'];
                  $mesaj_code = $m_cek['mesaj_code'];
                  $mesaj_durum = $m_cek['mesaj_durum'];
                  $mesaj_okundu = $m_cek['mesaj_okundu'];

                  if ($mesaj_durum == 1 and $mesaj_okundu == 0) {
                    $mesaj_type = 'gonderilen';
                    $sembol_mek = 'fa fa-comment-o';
                    $sembol_icerik = 'Gönderildi';
                    $m_saat = $m_cek['mesaj_saat'];

                    if (date('d-m-Y') == $m_cek['mesaj_tarih']) { $m_tarih = 'Bugün'; } else { $m_tarih = $m_cek['mesaj_tarih']; }

                  }elseif ($mesaj_durum == 0 and $mesaj_okundu == 0) {
                    $sembol_mek = 'fa fa-envelope-o';
                    $sembol_icerik = 'Okunmadı';
                    $mesaj_type = 'okunmadi';
                    $m_saat = $m_cek['mesaj_saat'];

                    if (date('d-m-Y') == $m_cek['mesaj_tarih']) { $m_tarih = 'Bugün'; } else { $m_tarih = $m_cek['mesaj_tarih']; }

                  }elseif ($mesaj_durum == 1 and $mesaj_okundu == 1) {
                    $sembol_mek = 'fa fa-envelope-open-o';
                    $mesaj_type = 'okundu';
                    $sembol_icerik = 'Görüldü';
                    $m_saat = $m_cek['mesaj_okundu_saat'];

                    if (date('d-m-Y') == $m_cek['mesaj_okundu_tarih']) { $m_tarih = 'Bugün'; } else { $m_tarih = $m_cek['mesaj_okundu_tarih']; }

                  }elseif ($mesaj_durum == 2 and $mesaj_okundu == 1) {
                    $sembol_mek = 'fa fa-envelope-open-o';
                    $mesaj_type = 'okundu';
                    $sembol_icerik = 'Okudum';
                    $m_saat = $m_cek['mesaj_okundu_saat'];

                    if (date('d-m-Y') == $m_cek['mesaj_okundu_tarih']) { $m_tarih = 'Bugün'; } else { $m_tarih = $m_cek['mesaj_okundu_tarih']; }

                  }

                  if ($mesaj_durum == 1) {
                    $mesaj_sem = 'fa fa-reply';

                  }elseif ($mesaj_durum == 0 or $mesaj_durum == 2) {

                    $mesaj_sem = 'fa fa-share';
                  }

                  $_SESSION['mess_sayisi'] = $sayfa;
                  ?>


                  <?php  
//online
                  $online_uye_durumu=$db->prepare("SELECT * from online where online_uyecode=:on_uy");
                  $online_uye_durumu->execute(array(
                    'on_uy' => $ark_listesi
                  ));
                  $online_uye_cek=$online_uye_durumu->fetch(PDO::FETCH_ASSOC);
                  if (date('Y-m-d H:i:s') <= $online_uye_cek['online_zaman']) {
                    $uye_onlinemi = 1;
                  }else {
                    $uye_onlinemi = 0;
                    $uo_saat = $online_uye_cek['online_saat'];

                    if (date('d-m-Y') == $online_uye_cek['online_tarih']) { 
                      $uo_tarih = 'Bugün'; } else { 
                        $uo_tarih = $online_uye_cek['online_tarih']; 
                      }
                      $uyox = $uo_saat." | ".$uo_tarih;
                    }
                    ?>



                    <div class="mesaj-pnl">
                      <a href="konusma.php?msj-a=<?php echo $ark_listesi; ?>&msj-b=<?php echo $uyecodes; ?>&msj-c=<?php echo $mesaj_code; ?>&msj=d&msj-x=eax">

                        <div class="mesaj-alt <?php echo $mesaj_type; ?>">

                          <div class="messkione">
                            <table class="tableclass">
                              <thead>
                                <tr>
                                  <th class="mes1_th">
                                    <div class="minakarti">
                                      <div class="miniAvatar">
                                        <img class="minavatarimg" src="<?php if (@getimagesize($ark['uye_mini_resim'])) { ?><?php echo $ark['uye_mini_resim']; ?><?php }else { ?>yimg/profil/disabledprofil.jpg<?php } ?>">
                                      </div>  
                                    </div>
                                  </th>

                                  <th class="mes2_th">
                                    <div class="dismessage1">
                                      <?php if (@getimagesize($ark['uye_mini_resim'])) { ?>
                                        <div class="text-pylsm-yazi"><?php echo $adsoyad; ?><?php if ($ark['uye_profil_onay'] == 1) { ?><i class="fa fa-check-circle-o onaytype onay-tooltip" aria-hidden="true" aria-hidden="true" data-toggle="tooltip" data-placement="right"></i><?php } ?> - <span><?php echo $ark['uye_meslek']; ?></span>
                                        </b></div>
                                        <div class="text-pylsm-st"><i class="<?php echo $mesaj_sem; ?>" aria-hidden="true"></i><?php echo ' '.$mesaj_icerik; ?></div>
                                      <?php }else { ?><div class="text-blocked-yazi">Bu hesap kapatılmıştır !</div><?php } ?>
                                    </div>

                                    <div class="dismessage2">
                                      <?php if (@getimagesize($ark['uye_mini_resim'])) { ?>
                                        <div class="text-pylsm-yazi"><?php echo $adsoyad; ?><?php if ($ark['uye_profil_onay'] == 1) { ?><i class="fa fa-check-circle-o onaytype onay-tooltip" aria-hidden="true" aria-hidden="true" data-toggle="tooltip" data-placement="right" data-original-title="Onaylı Profil"></i><?php } ?>
                                      </div>
                                      <div class="text-pylsm-st"><i class="<?php echo $mesaj_sem; ?>" aria-hidden="true"></i><?php echo ' '.$mesaj_icerik; ?></div>
                                    <?php }else { ?><div class="text-blocked-yazi">Bu hesap kapatılmıştır !</div><?php } ?>
                                  </div>
                                </th>


                                <th class="mes3_th">
                                  <div class="ht-sag">
                                    <div class="text-mesaj-tar"><?php echo $m_saat; ?> | <?php echo $m_tarih ?></div>
                                    <div class="text-mesaj-bild"><span><?php echo $sembol_icerik; ?></span><i class="<?php echo $sembol_mek; ?>" aria-hidden="true"></i></div>
                                  </div>
                                </th>

                              </tr>
                            </thead>

                          </table>
                        </div>

                        <div class="messkitwo">
                          <table class="tableclass">
                            <thead>
                              <tr>
                                <th class="mes1_th">
                                  <div class="minakarti">
                                    <div class="miniAvatar">
                                      <img class="minavatarimg" src="<?php if (@getimagesize($ark['uye_mini_resim'])) { ?><?php echo $ark['uye_mini_resim']; ?><?php }else { ?>yimg/profil/disabledprofil.jpg<?php } ?>">
                                    </div>  
                                  </div>
                                </th>

                                <th class="mes2_th">
                                  <?php if (@getimagesize($ark['uye_mini_resim'])) { ?>
                                    <div class="text-pylsm-yazi"><?php if (strlen($adsoyad) > 20) { echo substr($adsoyad, 0,10).'...'; }else { echo $adsoyad; } ?><?php if ($ark['uye_profil_onay'] == 1) { ?><i class="fa fa-check-circle-o onaytype onay-tooltip" aria-hidden="true" aria-hidden="true" data-toggle="tooltip" data-placement="right" data-original-title="Onaylı Profil"></i><?php } ?> - <span><?php echo $ark['uye_meslek']; ?></span></div>
                                    <div class="text-mob-mesbil"><?php echo $sembol_icerik; ?><i class="<?php echo $sembol_mek; ?>" aria-hidden="true"></i> <?php echo $m_saat; ?> | <?php echo $m_tarih ?></div>


                                  <?php }else { ?><div class="text-blocked-yazi">Bu hesap kapatılmıştır !</div><?php } ?>
                                </th>

                              </tr>
                            </thead>

                          </table>
                        </div>



                      </div>
                    </a>
                  </div>

                <?php } ?>


              </div>





            </div>

            <a href="mesajlar.php" class="dropdown-item text-center text-primary font-weight-bold py-3">Tüm Mesajlar</a>
          </div>
        </li>
      <?php } ?>













      <!-- mesajlar bitiş -->


      <!-- bildirimler başlangıç -->
      <?php 
      $goster = 10;
      $bsay=$db->prepare("SELECT * from bildirimler where bildirim_kimin=:kimin");
      $bsay->execute(array(
       'kimin' => $uyecodes));
      $toplamveri=$bsay->rowCount();
      $sayfa_sayisi = ceil($toplamveri / $goster);
      $sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;
      if ($sayfa < 1) {$sayfa = 1;}
      if ($sayfa > $sayfa_sayisi) {$sayfa = 1;}
      $listele = ($sayfa - 1) * $goster;

      ?>

      <?php if ($_SESSION['sessizin'] == 1 and $uye_islem['uye_yetki']==1 or $uye_islem['uye_yetki']==2) { ?>
        <li class="nav-item dropdown">

          <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ni ni-bell-55"></i><span  class="badge badge-success"><?php echo $toplamveri; ?></span>
          </a>
          <div class="dropdown-menu dropdown-menu-xl  dropdown-menu-right  py-0 overflow-hidden">
            <!-- Dropdown header -->
            <div class="px-3 py-3">


             <h6 class="text-sm text-muted m-0"><strong class="text-primary"><?php echo $toplamveri; ?></strong> Bildiriminiz var</h6>

           </div>
           <!-- List group -->
           <div class="list-group list-group-flush">









            <div class="bildirim-yer-alan">




              <?php 
              $bildirim_sor=$db->prepare("SELECT * from bildirimler where bildirim_kimin=:kimin ORDER BY bildirim_zaman DESC limit $listele, $goster");
              $bildirim_sor->execute(array(
                'kimin' => $uyecodes
              ));


              while($b_cek=$bildirim_sor->fetch(PDO::FETCH_ASSOC)) { ?>  

                <?php  

                $ark_listesi = $b_cek['bildirim_gonderen'];
                $arkadas_listele=$db->prepare("SELECT * from users where uye_code=:code");
                $arkadas_listele->execute(array(
                  'code' => $ark_listesi
                ));

                $ark=$arkadas_listele->fetch(PDO::FETCH_ASSOC);

                $_SESSION['bil_sayisi'] = $sayfa; 

                $ad = $ark['uye_ad'];
                $soyad = $ark['uye_soyad'];

                $adsoyad = $ad." ".$soyad;

                $mes_alici = $ark_listesi;


                if (date('d-m-Y') == $b_cek['bildirim_tarih']) { 
                  $bild_tarih = 'Bugün'; } else { 
                    $bild_tarih = $b_cek['bildirim_tarih']; 
                  }

                  ?>



                  <div class="bildirim-pnl">

                    <div class="bildirim-alt">

                      <table class="tableclass">
                        <thead>
                          <tr>
                            <th class="bild1_th">
                              <div class="minakarti">
                                <a href="kullanici?ara=<?php echo $ark['uye_profil_code']; ?>&ci=4">
                                  <div class="miniAvatar">
                                    <img class="minavatarimg" src="<?php if (@getimagesize($ark['uye_mini_resim'])) { ?><?php echo $ark['uye_mini_resim']; ?><?php }else { ?>yimg/profil/disabledprofil.jpg<?php } ?>">
                                  </div>
                                </a> 
                              </div>  
                            </th>

                            <th class="bild2_th">
                              <?php if (@getimagesize($ark['uye_mini_resim'])) { ?>
                                <div class="txtonelimed">
                                  <div class="text-pylsm-yazi"><a href="kullanici?ara=<?php echo $ark['uye_profil_code']; ?>&ci=4"><?php echo $adsoyad; ?></a><?php if ($ark['uye_profil_onay'] == 1) { ?><i class="fa fa-check-circle-o onaytype onay-tooltip" aria-hidden="true" aria-hidden="true" data-toggle="tooltip" data-placement="right"></i><?php } ?> - <span>
                                    <?php if ($ark['uye_meslek_grup'] > 0) { ?>
                                      <a href="meslek-alani?m=<?php echo $ark['uye_meslek_grup']; ?>"><?php echo $ark['uye_meslek']; ?></a>
                                    <?php }else {
                                      echo $ark['uye_meslek'];
                                    } ?>
                                  </span>
                                </div>
                              </div>

                              <div class="txttwolimed">
                                <div class="text-pylsm-yazi"><a href="kullanici?ara=<?php echo $ark['uye_profil_code']; ?>&ci=4"><?php if (strlen($adsoyad) > 20) { echo substr($adsoyad, 0,10).'...'; }else { echo $adsoyad; } ?></a><?php if ($ark['uye_profil_onay'] == 1) { ?><i class="fa fa-check-circle-o onaytype onay-tooltip" aria-hidden="true" aria-hidden="true" data-toggle="tooltip" data-placement="right"></i><?php } ?>
                              </div>
                            </div>

                            <div class="txtnoted">
                              <div class="text-pylsm-yazi"><a href="kullanici?ara=<?php echo $ark['uye_profil_code']; ?>&ci=4"><?php if (strlen($adsoyad) > 20) { echo substr($adsoyad, 0,16).'...'; }else { echo $adsoyad; } ?></a><?php if ($ark['uye_profil_onay'] == 1) { ?><i class="fa fa-check-circle-o onaytype onay-tooltip" aria-hidden="true" aria-hidden="true" data-toggle="tooltip" data-placement="right"></i><?php } ?>
                            </div>
                          </div>

                          <div class="text-pylsm-st"><?php echo $b_cek['bildirim_saat']; ?> | <?php echo $bild_tarih; ?></div> 
                        <?php }else { ?><div class="text-blocked-yazi">Bu hesap kapatılmıştır !</div><?php } ?>
                      </th>

                      <?php  

                      $bildirim_icerik = $b_cek['bildirim_icerik'];
                      $bildirim_code = $b_cek['bildirim_code'];

                      if ($b_cek['bildirim_durum'] == 1 or $b_cek['bildirim_durum'] == 2) {
                        $bildirim_isor=$db->prepare("SELECT * from paylasim where paylasim_ozelcode=:ozelcode and paylasim_code=:paycode");
                        $bildirim_isor->execute(array(
                          'ozelcode' => $bildirim_icerik,
                          'paycode' => $uyecodes
                        ));

                        $icerik_varmi=$bildirim_isor->rowCount();
                        if ($icerik_varmi > 0) {
                          $bilic=$bildirim_isor->fetch(PDO::FETCH_ASSOC);
                          $bildirim_text = substr($bilic['paylasim_text'], 0,15).' ...';
                        }


                      }

                      $prokodu = $ark['uye_profil_code'];



                      $mesaj_engsor=$db->prepare("SELECT * from arkadaslar where arkadas_sahibi=:sahibi and arkadas_kiminle=:kiminle");
                      $mesaj_engsor->execute(array(
                        'sahibi' => $uyecodes,
                        'kiminle' => $mes_alici
                      ));
                      $me_en_sor=$mesaj_engsor->fetch(PDO::FETCH_ASSOC);


                      $engel_xsor=$db->prepare("SELECT * from engel where engel_gonderen=:gonderen and engel_alan=:alan");
                      $engel_xsor->execute(array(
                        'gonderen' => $uyecodes,
                        'alan' => $ark_listesi
                      ));

                      $engel_varmi_sor=$engel_xsor->rowCount();

                      if ($engel_varmi_sor > 0) {
                        $engel_durum = 1;
                      }else {
                        $engel_durum = 0;
                      }

                      ?>


                      <th class="bild3_th">
                        <?php $bildirim_durum = $b_cek['bildirim_durum']; ?>
                        <?php 
                        if ($bildirim_durum == 1) { ?>
                          <a href="paylasim-listele.php?paylist=<?php echo $bildirim_icerik; ?>">
                            <div class="begeni-bildirim">Bu paylaşımı beğendi</div>
                          </a>

                          <div class="text-pylsm-st"><?php echo $bildirim_text; ?></div>

                        <?php } 
                        elseif ($bildirim_durum == 2) { ?>
                          <a href="paylasim-listele.php?paylist=<?php echo $bildirim_icerik; ?>">
                            <div class="begenmedi-bildirim">Bu paylaşımı beğenmedi</div>
                          </a>

                          <div class="text-pylsm-st"><?php echo $bildirim_text; ?></div>

                        <?php }  
                        elseif ($bildirim_durum == 3) { ?>

                          <div class="engel-bildirim">Profil engeli aldınız !</div>
                          <?php $_SESSION['uye_karsi_engel'] = $prokodu; ?>
                          <a href="data/engel.php?href=<?php echo $prokodu; ?>&un=<?php echo $uye_islem['uye_code']; ?>&bd=1&u=e">
                            <?php if ($engel_durum == 0) { ?>
                              <div class="text-pylsm-st">Buradan sizde engel atabilirsiniz.</div>
                            <?php } ?>
                          </a>

                        <?php }  
                        elseif ($bildirim_durum == 4) { ?>

                          <div class="arkadas-bildirim">Arkadaş oldunuz</div>


                        <?php }  
                        elseif ($bildirim_durum == 5) { ?>

                          <div class="mesaj_engel-bildirim">Mesaj engeli aldınız !</div>
                          <a href="data/mesaj-engel.php?msj-a=<?php echo $mes_alici; ?>&msj-b=<?php echo $uyecodes; ?>&msj-t=x&msj-e=l">
                            <?php if ($me_en_sor['arkadas_durum'] == 1) { ?>
                              <div class="text-pylsm-st">Buradan sizde engel atabilirsiniz.</div>
                            <?php } ?>
                          </a>


                        <?php }  
                        elseif ($bildirim_durum == 6) { ?>

                          <div class="mesaj_ac-bildirim">Mesaj engelini kaldırdı !</div>
                          <a href="data/mesaj-ac.php?msj-a=<?php echo $mes_alici; ?>&msj-b=<?php echo $uyecodes; ?>&msj-j=c&msj-s=a">
                            <?php if ($me_en_sor['arkadas_durum'] == 0) { ?>
                              <div class="text-pylsm-st">Buradan sizde kaldırabilirsiniz.</div>
                            <?php } ?>
                          </a>


                        <?php }  
                        elseif ($bildirim_durum == 7) { ?>

                          <div class="profil-ac-bildirim">Profil engelini kaldırdı !</div>
                          <a href="data/engel-ac.php?href=<?php echo $ark_listesi; ?>&un=<?php echo $uyecodes; ?>&en=<?php echo $sayfa; ?>&p-l=p">
                            <?php if ($engel_durum == 1) { ?>
                              <div class="text-pylsm-st">Buradan sizde kaldırabilirsiniz.</div>
                            <?php } ?>
                          </a>


                        <?php }
                        elseif ($bildirim_durum == 20) { ?>

                          <a href="fotograf-listele.php?fotlist=<?php echo $bildirim_icerik; ?>">
                            <div class="begeni-bildirim">Bu fotoğrafı beğendi</div>
                          </a>

                        <?php } 
                        elseif ($bildirim_durum == 30) { ?>
                          <a href="yayin-listele?yaylist=<?php echo $bildirim_icerik; ?>">
                            <div class="yayin-bildirim">Bu yayını bitirdi</div>
                          </a>

                          <div class="text-pylsm-st"><?php echo $bildirim_icerik; ?></div>

                        <?php } 
                        elseif ($bildirim_durum == 35) { ?>
                          <a href="yayin-listele?yaylist=<?php echo $bildirim_icerik; ?>">
                            <div class="yayin-bildirim">Bu yayında çekiliş yapıldı</div>
                          </a>

                          <div class="text-pylsm-st"><?php echo $bildirim_icerik; ?></div>

                        <?php } 
                        elseif ($bildirim_durum == 40) { ?>

                          <div class="ref-bildirim">Yeni bir referans</div>

                          <div class="text-pylsm-st">+1 drc eklendi</div>

                        <?php } ?>
                      </th>


                      <th class="bild4_th">
                        <div class="ht-sag">


                          <a href="data/bildirim-sil.php?bxl=<?php echo $bildirim_code; ?>&puc=<?php echo $uye_islem['uye_code']; ?>&b=s"><button class="ek-buti"><i class="fa fa-trash" aria-hidden="true"></i></button></a>


                        </div>
                      </th>



                    </tr>
                  </thead>

                </table>

              </div>

            </div>

          <?php } ?>


        </div>




      </div>

      <a href="bildirimler.php" class="dropdown-item text-center text-primary font-weight-bold py-3">Tüm Bildirimler</a>
    </div>

  </li>

<?php } ?>
<!-- bildirimler bitiş -->





</ul>


<ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
  <li class="nav-item dropdown">
    <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <div class="media align-items-center">
        <span class="avatar avatar-sm rounded-circle">
          <?php if ($_SESSION['sessizin'] == 1 and $_SESSION['uye_yetki']==2 or  $_SESSION['uye_yetki']==1 ) { ?>
            <img alt="Image placeholder" src="<?php echo $uye_islem['uye_mini_resim'] ?>">
          <?php } ?>

        </span>
        <div class="media-body  ml-2  d-none d-lg-block">
          <span class="mb-0 text-sm  font-weight-bold"><?php echo $uye_islem['uye_ad']," ",$uye_islem['uye_soyad'];  ?></span>
        </div>
      </div>
    </a>
    <div class="dropdown-menu  dropdown-menu-right ">
      <div class="dropdown-header noti-title">
        <h6 class="text-overflow m-0">Hoş Geldiniz</h6>
      </div>

      <?php if ($_SESSION['sessizin'] == 1 and $uye_islem['uye_yetki']==1 or $uye_islem['uye_yetki']==2) { ?>
        <a href="profil.php" class="dropdown-item">
          <i class="ni ni-single-02"></i>
          <span>Profilim</span>
        </a>
      <?php } ?>


      <?php if ($_SESSION['sessizin'] == 1 and  $uye_islem['uye_yetki']==1 or $uye_islem['uye_yetki']==2) { ?>
        <a href="ayarlar.php" class="dropdown-item">
          <i class="ni ni-settings-gear-65"></i>
          <span>Ayarlar</span>
        </a>
      <?php } ?>




      <?php if ($_SESSION['sessizin'] == 1) { ?>
        <div class="dropdown-divider"></div>
        <a href="login/cikis.php" class="dropdown-item">
          <i class="ni ni-user-run"></i>
          <span>Çıkış Yap</span>
        </a>
      <?php } ?>
    </div>
  </li>
</ul>
</div>
</div>
</nav>

<!-- alt panel başlangıç -->


