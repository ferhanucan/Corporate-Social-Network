<?php 
ob_start();
session_start();

include '../database/baglan.php';
date_default_timezone_set('Europe/Istanbul');

include 'mesajfiltre.php';


if (isset($_POST['mesaj_at'])) {

        $mc1=rand(10000,99000);    

        $mc2=rand(10000,99000);

        $mc3=rand(10000,99000);

        $mc4=rand(10000,99000);

        $mc5=rand(10000,99000);

        $mc6=rand(10000,99000);

        $mc7=rand(10000,99000);

        $mc8=rand(10000,99000);

        $mc9=rand(10000,99000);

        $benzersiz_mcode= $mc1.md5($mc2).$mc3.md5($mc4).$mc5.md5($mc6).$mc7.md5($mc8).$mc9;
        $mtx_code = $benzersiz_mcode;

        $alici_uye_kodu = $_SESSION['alici_uye_code'];
        $alici_pro_code = $_SESSION['alici_profil_code'];
        $uyecodes = $_SESSION['uye_code'];
        $mesaj_adresi = $_SESSION['mesaj_adresi'];
        $mes_kodu = $_SESSION['alici_mesaj_kodu'];


if ($_SESSION['sessizin'] != 1 and strlen($uyecodes) != 30) {
    header('Location:../anasayfa?koruma=etkin');
    exit();
}  


        $yazi_1 = strip_tags($_POST['mesaj']);
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

        $mesaj = str_replace("\r\n",'', $yazi_6);

        
        $icerik_onizleme = substr($yazi_3, 0,37).' ...';

        $mesaj_durum = 0;
        $mesaj_okundu = 0;
        $mesaj_gonderen_okundu = 0;
        $mesaj_gonderen_durum = 1;
        $mesaj_saat = date('H:i');
        $mesaj_tarih = date('d-m-Y');
        $mesaj_okundu_saat = 0;
        $mesaj_okundu_tarih = 0;

        $konusma_durum = 1;

               //mesaj at

//engel varmi sor

        $engelsor=$db->prepare("SELECT * from engel where engel_gonderen=:gonderen and engel_alan=:alan");
        $engelsor->execute(array(
        'gonderen' => $uyecodes,
        'alan' => $alici_uye_kodu
        ));

        $ters_engelsor=$db->prepare("SELECT * from engel where engel_gonderen=:gonderen and engel_alan=:alan");
        $ters_engelsor->execute(array(
        'gonderen' => $alici_uye_kodu,
        'alan' => $uyecodes
        ));

        $sor=$engelsor->rowCount();

        $ters_sor=$ters_engelsor->rowCount();

        if ($sor > 0 and $ters_sor > 0) {

            $engelli_uye = 1;
          
        }elseif ($sor > 0) {

            $engelli_uye = 1;
            

        }elseif ($ters_sor > 0) {

            $engelli_uye = 1;
          
        }

//engel varmi sor bitiş

//arkadaş sor

$ark_kontrol = $db->prepare("SELECT * from arkadaslar where arkadas_sahibi=:sahibi and arkadas_kiminle=:kiminle");
$ark_kontrol->execute(array(
'sahibi' => $uyecodes,
'kiminle'=> $alici_uye_kodu
));

$ark_ters_kontrol = $db->prepare("SELECT * from arkadaslar where arkadas_sahibi=:sahibi and arkadas_kiminle=:kiminle");
$ark_ters_kontrol->execute(array(
'sahibi' => $alici_uye_kodu,
'kiminle'=> $uyecodes
));

$arkadas_cek=$ark_kontrol->fetch(PDO::FETCH_ASSOC); 
$arkadas_ters_cek=$ark_ters_kontrol->fetch(PDO::FETCH_ASSOC); 

$arkadas_sor=$ark_kontrol->rowCount();
$arkadas_ters_sor=$ark_ters_kontrol->rowCount();

  if ($arkadas_sor > 0 and $arkadas_ters_sor > 0) {

      $arkadas_var = 1;
      $ark_durum = $arkadas_cek['arkadas_durum'];
      $ark_ters_durum = $arkadas_ters_cek['arkadas_durum'];

  }else {
      $arkadas_var = 0;
  }

//arkadaş sor bitiş

        if (empty($yazi_1)) {
            if ($mesaj_adresi == 'g7412') {
                 header('Location:../../konusma?msj-a='.$alici_uye_kodu.'&msj-b='.$uyecodes.'&msj-c='.$mes_kodu.'&msj=d&msj-x=eax&mesajbos=birakma&xt=7');
                 exit();
            }elseif ($mesaj_adresi == 'x9371') {
                header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajbos=birakma&mt=2');
                exit();
            }else {
                header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajbos=birakma&mt=2');
                exit();
            }
            
        }elseif (strlen(utf8_decode($yazi_1)) < 2 or strlen(utf8_decode($yazi_1)) > 200) {
            if ($mesaj_adresi == 'g7412') {
                 header('Location:../../konusma?msj-a='.$alici_uye_kodu.'&msj-b='.$uyecodes.'&msj-c='.$mes_kodu.'&msj=d&msj-x=eax&mesajuzunluk=gecersiz&xt=7');
                 exit();
            }elseif ($mesaj_adresi == 'x9371') {
                header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajuzunluk=gecersiz&mt=2');
                exit();
            }else {
                header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajuzunluk=gecersiz&mt=2');
                exit();
            }

        }elseif ($_SESSION['sonyazi'] == $mesaj) {
            if ($mesaj_adresi == 'g7412') {
                 header('Location:../../konusma.php?msj-a='.$alici_uye_kodu.'&msj-b='.$uyecodes.'&msj-c='.$mes_kodu.'&msj=d&msj-x=eax&mesajacele=etme&xt=7');
                 exit();
            }elseif ($mesaj_adresi == 'x9371') {
                header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajacele=etme&mt=2');
                exit();
            }else {
                header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajacele=etme&mt=2');
                exit();
            }

        }elseif ($engelli_uye == 1) {
            if ($mesaj_adresi == 'g7412') {
                 header('Location:../../konusma.php?msj-a='.$alici_uye_kodu.'&msj-b='.$uyecodes.'&msj-c='.$mes_kodu.'&msj=d&msj-x=eax&engelli=uye&xt=7');
                 exit();
            }elseif ($mesaj_adresi == 'x9371') {
                header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&engelli=uye&mt=2');
                exit();
            }else {
                header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&engelli=uye&mt=2');
                exit();
            }

        }elseif ($ark_durum == 0) {
            if ($mesaj_adresi == 'g7412') {
                 header('Location:../../konusma?msj-a='.$alici_uye_kodu.'&msj-b='.$uyecodes.'&msj-c='.$mes_kodu.'&msj=d&msj-x=eax&mesaj=istemiyor&xt=7');
                 exit();
            }elseif ($mesaj_adresi == 'x9371') {
                header('Location:../../kullanici-mesaj?href='.$alici_pro_code.'&mesajengel=atmissin&mt=2');
                exit();
            }else {
                header('Location:../../kullanici-mesaj?href='.$alici_pro_code.'&mesajengel=atmissin&mt=2');
                exit();
            }

        }elseif ($ark_ters_durum == 0) {
            if ($mesaj_adresi == 'g7412') {
                 header('Location:../../konusma.php?msj-a='.$alici_uye_kodu.'&msj-b='.$uyecodes.'&msj-c='.$mes_kodu.'&msj=d&msj-x=eax&mesaj=istemiyor&xt=7');
                 exit();
            }elseif ($mesaj_adresi == 'x9371') {
                header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesaj=istemiyor&mt=2');
                exit();
            }else {
                header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesaj=istemiyor&mt=2');
                exit();
            }

        }elseif ($arkadas_var == 0) {
            if ($mesaj_adresi == 'g7412') {
                 header('Location:../../konusma.php?msj-a='.$alici_uye_kodu.'&msj-b='.$uyecodes.'&msj-c='.$mes_kodu.'&msj=d&msj-x=eax&arkadas=degilsiniz&xt=7');
                 exit();
            }elseif ($mesaj_adresi == 'x9371') {
                header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&arkadas=degilsiniz&mt=2');
                exit();
            }else {
                header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&arkadas=degilsiniz&mt=2');
                exit();
            }

        }


    //uye mesaj kontrol
if ($alici_uye_kodu && $uyecodes) {

        $mesajsor=$db->prepare("SELECT * from mesajlar where mesaj_kimin=:kimin and mesaj_alici=:alici");
        $mesajsor->execute(array(
        'kimin' => $uyecodes,
        'alici' => $alici_uye_kodu
        ));

        $alici_mesajsor=$db->prepare("SELECT * from mesajlar where mesaj_kimin=:kimin and mesaj_alici=:alici");
        $alici_mesajsor->execute(array(
        'kimin' => $alici_uye_kodu,
        'alici' => $uyecodes
        ));

        $sor=$mesajsor->rowCount();
        $mesajcek=$mesajsor->fetch(PDO::FETCH_ASSOC);
        $mesaj_id = $mesajcek['id'];

        //gönderen kişi id

        $alici_sor=$alici_mesajsor->rowCount();
        $alici_mesajcek=$alici_mesajsor->fetch(PDO::FETCH_ASSOC);
        $alici_mesaj_id = $alici_mesajcek['id'];
        //alan kişi id

    if ($sor == 0 and $alici_sor == 0) {
        //gönderen ve alıcıda liste yok
        $x_bas = 1;
        $mesaj_code = $mtx_code;
    }elseif ($sor > 0 and $alici_sor > 0) {
        //gönderen ve alıcıda liste var
        $x_bas = 2;
        $mesaj_code = $mtx_code;
    }elseif ($sor == 0 and $alici_sor > 0) {
        //gönderende liste yok alıcıda var
        $x_bas = 3;
        if ($alici_mesajcek['mesaj_code'] > 0) {
            $mesaj_code = $alici_mesajcek['mesaj_code'];
        }else {
            $mesaj_code = $mtx_code;
        }

    }elseif ($sor > 0 and $alici_sor == 0) {
        //gönderende liste var alıcıda yok
        $x_bas = 4;
        if ($mesajcek['mesaj_code'] > 0) {
            $mesaj_code = $mesajcek['mesaj_code'];
        }else {
            $mesaj_code = $mtx_code;
        }
    }

/* metin bastır */
$kayityazi1 = replaceSpace(mt($yazi_3));
$kayityazi2 = str_replace("\r\n",'', $kayityazi1);


$kayituserbilgi = $db->prepare("SELECT * from users where uye_code=:ucobi1");
$kayituserbilgi->execute(array(
'ucobi1' => $uyecodes
));

$uyebilg=$kayituserbilgi->fetch(PDO::FETCH_ASSOC); 

$kayitalicibilgi = $db->prepare("SELECT * from users where uye_code=:ucobi2");
$kayitalicibilgi->execute(array(
'ucobi2' => $alici_uye_kodu
));

$abilg=$kayitalicibilgi->fetch(PDO::FETCH_ASSOC); 


$gonderen_adsoyad = $uyebilg['uye_ad'].' '.$uyebilg['uye_soyad'];
$alici_adsoyad = $abilg['uye_ad'].' '.$abilg['uye_soyad'];



$dosya_ismi = $gonderen_adsoyad.' - '.$uyebilg['uye_referans_code'].' - '.$alici_adsoyad.' - '.$abilg['uye_referans_code'];

if(file_exists('metin-kayit/'.$dosya_ismi.'.txt')) {
$myfile = fopen('metin-kayit/'.$dosya_ismi.'.txt', "a");
$txt = 'Gönderen : '.$gonderen_adsoyad.' / Alıcı : '.$alici_adsoyad.' (Saat : '.$mesaj_saat.' Tarih : '.$mesaj_tarih.') Gönderen Referans : '.$uyebilg['uye_referans_code'].' / Alıcı Referans : '.$abilg['uye_referans_code'].' 

'.$kayityazi2.' 
-----------------
';
fwrite($myfile, $txt);
fclose($myfile);
} else {
$dosya = fopen('metin-kayit/'.$dosya_ismi.'.txt', 'w');
$txt = 'Gönderen : '.$gonderen_adsoyad.' / Alıcı : '.$alici_adsoyad.' (Saat : '.$mesaj_saat.' Tarih : '.$mesaj_tarih.') Gönderen Referans : '.$uyebilg['uye_referans_code'].' / Alıcı Referans : '.$abilg['uye_referans_code'].' 

'.$kayityazi2.' 
-----------------
';
fwrite($dosya, $txt);
fclose($dosya);
}
/* /metin bastır */

}//&&bitis


if ($x_bas == 1) {
//gönderen ve alıcıda liste yok

    //ilk konusmaları kaydet
    $konus=$db->prepare("INSERT INTO konusma SET
        konusma_kimin=:kimin,
        konusma_alici=:alici,
        konusma_icerik=:icerik,
        konusma_durum=:durum,
        konusma_saat=:saat,
        konusma_tarih=:tarih                        
        ");
    $konus_kaydet=$konus->execute(array(
        'kimin'=> $uyecodes,
        'alici'=> $alici_uye_kodu,
        'icerik'=> mt($mesaj),
        'durum'=> $konusma_durum,
        'saat'=> $mesaj_saat,
        'tarih'=> $mesaj_tarih                
        ));
    if ($konus_kaydet) {
    //alıcıya mesajı kaydet
    $konus_a=$db->prepare("INSERT INTO konusma SET
        konusma_kimin=:kimin,
        konusma_alici=:alici,
        konusma_icerik=:icerik,
        konusma_durum=:durum,
        konusma_saat=:saat,
        konusma_tarih=:tarih                      
        ");
    $konus_a_kaydet=$konus_a->execute(array(
        'kimin'=> $alici_uye_kodu,
        'alici'=> $uyecodes,
        'icerik'=> mt($mesaj),
        'durum'=> $mesaj_durum,
        'saat'=> $mesaj_saat,
        'tarih'=> $mesaj_tarih                 
        ));
    if ($konus_a_kaydet) {
    //konusmalar basıldı, şimdi listeye aktar, gönderenden başla
    $mesaj=$db->prepare("INSERT INTO mesajlar SET
        mesaj_kimin=:kimin,
        mesaj_alici=:alici,
        mesaj_icerik=:icerik,
        mesaj_durum=:durum,
        mesaj_okundu=:okundu,
        mesaj_saat=:saat,
        mesaj_tarih=:tarih,
        mesaj_okundu_saat=:mosat,
        mesaj_okundu_tarih=:motar,
        mesaj_code=:mesajkodu                      
        ");
    $mesaj_kaydet=$mesaj->execute(array(
        'kimin'=> $uyecodes,
        'alici'=> $alici_uye_kodu,
        'icerik'=> mt($icerik_onizleme),
        'durum'=> $mesaj_gonderen_durum,
        'okundu'=> $mesaj_gonderen_okundu,
        'saat'=> $mesaj_saat,
        'tarih'=> $mesaj_tarih,
        'mosat'=> $mesaj_okundu_saat,
        'motar'=> $mesaj_okundu_tarih,
        'mesajkodu'=> $mesaj_code                 
        ));
    if ($mesaj_kaydet) {
    //alıcının listesine mesajı bildir
    $mesaj_a=$db->prepare("INSERT INTO mesajlar SET
        mesaj_kimin=:kimin,
        mesaj_alici=:alici,
        mesaj_icerik=:icerik,
        mesaj_durum=:durum,
        mesaj_okundu=:okundu,
        mesaj_saat=:saat,
        mesaj_tarih=:tarih,
        mesaj_okundu_saat=:mosat,
        mesaj_okundu_tarih=:motar,
        mesaj_code=:mesajkodu                      
        ");
    $mesaj_a_kaydet=$mesaj_a->execute(array(
        'kimin'=> $alici_uye_kodu,
        'alici'=> $uyecodes,
        'icerik'=> mt($icerik_onizleme),
        'durum'=> $mesaj_durum,
        'okundu'=> $mesaj_okundu,
        'saat'=> $mesaj_saat,
        'tarih'=> $mesaj_tarih,
        'mosat'=> $mesaj_okundu_saat,
        'motar'=> $mesaj_okundu_tarih,
        'mesajkodu'=> $mesaj_code                 
        ));
    if($mesaj_a_kaydet) {
        $_SESSION['sonyazi'] = $mesaj;
        if ($mesaj_adresi == 'g7412') {
            header('Location:../../konusma.php?msj-a='.$alici_uye_kodu.'&msj-b='.$uyecodes.'&msj-c='.$mes_kodu.'&msj=d&msj-x=eax&mesajat=tamam&xt=7');
            exit();
        }elseif ($mesaj_adresi == 'x9371') {
            header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajat=tamam&mt=2');
            exit();
        }else {
            header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajat=tamam&mt=2');
            exit();
        }

    }else{
        if ($mesaj_adresi == 'g7412') {
            header('Location:../../konusma.php?msj-a='.$alici_uye_kodu.'&msj-b='.$uyecodes.'&msj-c='.$mes_kodu.'&msj=d&msj-x=eax&mesajat=hata&xt=7');
            exit();
        }elseif ($mesaj_adresi == 'x9371') {
            header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajat=hata&mt=2');
            exit();
        }else {
            header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajat=hata&mt=2');
            exit();
        }
    }

    }else{
        if ($mesaj_adresi == 'g7412') {
            header('Location:../../konusma.php?msj-a='.$alici_uye_kodu.'&msj-b='.$uyecodes.'&msj-c='.$mes_kodu.'&msj=d&msj-x=eax&mesajat=hata&xt=7');
            exit();
        }elseif ($mesaj_adresi == 'x9371') {
            header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajat=hata&mt=2');
            exit();
        }else {
            header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajat=hata&mt=2');
            exit();
        }
    }

    }else{
        if ($mesaj_adresi == 'g7412') {
            header('Location:../../konusma.php?msj-a='.$alici_uye_kodu.'&msj-b='.$uyecodes.'&msj-c='.$mes_kodu.'&msj=d&msj-x=eax&mesajat=hata&xt=7');
            exit();
        }elseif ($mesaj_adresi == 'x9371') {
            header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajat=hata&mt=2');
            exit();
        }else {
            header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajat=hata&mt=2');
            exit();
        }
    }

    }else{
        if ($mesaj_adresi == 'g7412') {
            header('Location:../../konusma.php?msj-a='.$alici_uye_kodu.'&msj-b='.$uyecodes.'&msj-c='.$mes_kodu.'&msj=d&msj-x=eax&mesajat=hata&xt=7');
            exit();
        }elseif ($mesaj_adresi == 'x9371') {
            header('Location:../../kullanici-mesaj.phphref='.$alici_pro_code.'&mesajat=hata&mt=2');
            exit();
        }else {
            header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajat=hata&mt=2');
            exit();
        }
    }

}elseif ($x_bas == 2) {
//gönderen ve alıcıda liste var

    //ilk konusmaları kaydet
    $konus=$db->prepare("INSERT INTO konusma SET
        konusma_kimin=:kimin,
        konusma_alici=:alici,
        konusma_icerik=:icerik,
        konusma_durum=:durum,
        konusma_saat=:saat,
        konusma_tarih=:tarih                        
        ");
    $konus_kaydet=$konus->execute(array(
        'kimin'=> $uyecodes,
        'alici'=> $alici_uye_kodu,
        'icerik'=> mt($mesaj),
        'durum'=> $konusma_durum,
        'saat'=> $mesaj_saat,
        'tarih'=> $mesaj_tarih                
        ));
    if ($konus_kaydet) {
    //alıcıya mesajı kaydet
    $konus_a=$db->prepare("INSERT INTO konusma SET
        konusma_kimin=:kimin,
        konusma_alici=:alici,
        konusma_icerik=:icerik,
        konusma_durum=:durum,
        konusma_saat=:saat,
        konusma_tarih=:tarih                      
        ");
    $konus_a_kaydet=$konus_a->execute(array(
        'kimin'=> $alici_uye_kodu,
        'alici'=> $uyecodes,
        'icerik'=> mt($mesaj),
        'durum'=> $mesaj_durum,
        'saat'=> $mesaj_saat,
        'tarih'=> $mesaj_tarih                 
        ));
    if ($konus_a_kaydet) {
    //konusmalar basıldı, şimdi listeye aktar, gönderenden başla
    $mesaj=$db->prepare("UPDATE mesajlar SET
        mesaj_icerik=:icerik,
        mesaj_durum=:durum,
        mesaj_okundu=:okundu,
        mesaj_saat=:saat,
        mesaj_tarih=:tarih,
        mesaj_okundu_saat=:mosat,
        mesaj_okundu_tarih=:motar                    
        WHERE id=$mesaj_id");
    $mesaj_kaydet=$mesaj->execute(array(
        'icerik'=> mt($icerik_onizleme),
        'durum'=> $mesaj_gonderen_durum,
        'okundu'=> $mesaj_gonderen_okundu,
        'saat'=> $mesaj_saat,
        'tarih'=> $mesaj_tarih,
        'mosat'=> $mesaj_okundu_saat,
        'motar'=> $mesaj_okundu_tarih                
        ));
    if ($mesaj_kaydet) {
    //alıcının listesine mesajı bildir
    $mesaj_a=$db->prepare("UPDATE mesajlar SET
        mesaj_icerik=:icerik,
        mesaj_durum=:durum,
        mesaj_okundu=:okundu,
        mesaj_saat=:saat,
        mesaj_tarih=:tarih,
        mesaj_okundu_saat=:mosat,
        mesaj_okundu_tarih=:motar                     
        WHERE id=$alici_mesaj_id");
    $mesaj_a_kaydet=$mesaj_a->execute(array(
        'icerik'=> mt($icerik_onizleme),
        'durum'=> $mesaj_durum,
        'okundu'=> $mesaj_okundu,
        'saat'=> $mesaj_saat,
        'tarih'=> $mesaj_tarih,
        'mosat'=> $mesaj_okundu_saat,
        'motar'=> $mesaj_okundu_tarih               
        ));
    if($mesaj_a_kaydet) {
        $_SESSION['sonyazi'] = $mesaj;
        if ($mesaj_adresi == 'g7412') {
            header('Location:../../konusma.php?msj-a='.$alici_uye_kodu.'&msj-b='.$uyecodes.'&msj-c='.$mes_kodu.'&msj=d&msj-x=eax&mesajat=tamam&xt=7');
            exit();
        }elseif ($mesaj_adresi == 'x9371') {
            header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajat=tamam&mt=2');
            exit();
        }else {
            header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajat=tamam&mt=2');
            exit();
        }

    }else{
        if ($mesaj_adresi == 'g7412') {
            header('Location:../../konusma.php?msj-a='.$alici_uye_kodu.'&msj-b='.$uyecodes.'&msj-c='.$mes_kodu.'&msj=d&msj-x=eax&mesajat=hata&xt=7');
            exit();
        }elseif ($mesaj_adresi == 'x9371') {
            header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajat=hata&mt=2');
            exit();
        }else {
            header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajat=hata&mt=2');
            exit();
        }
    }

    }else{
        if ($mesaj_adresi == 'g7412') {
            header('Location:../../konusma.php?msj-a='.$alici_uye_kodu.'&msj-b='.$uyecodes.'&msj-c='.$mes_kodu.'&msj=d&msj-x=eax&mesajat=hata&xt=7');
            exit();
        }elseif ($mesaj_adresi == 'x9371') {
            header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajat=hata&mt=2');
            exit();
        }else {
            header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajat=hata&mt=2');
            exit();
        }
    }

    }else{
        if ($mesaj_adresi == 'g7412') {
            header('Location:../../konusma.php?msj-a='.$alici_uye_kodu.'&msj-b='.$uyecodes.'&msj-c='.$mes_kodu.'&msj=d&msj-x=eax&mesajat=hata&xt=7');
            exit();
        }elseif ($mesaj_adresi == 'x9371') {
            header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajat=hata&mt=2');
            exit();
        }else {
            header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajat=hata&mt=2');
            exit();
        }
    }

    }else{
        if ($mesaj_adresi == 'g7412') {
            header('Location:../../konusma.php?msj-a='.$alici_uye_kodu.'&msj-b='.$uyecodes.'&msj-c='.$mes_kodu.'&msj=d&msj-x=eax&mesajat=hata&xt=7');
            exit();
        }elseif ($mesaj_adresi == 'x9371') {
            header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajat=hata&mt=2');
            exit();
        }else {
            header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajat=hata&mt=2');
            exit();
        }
    }

}elseif ($x_bas == 3) {
//gönderende liste yok alıcıda var

    //ilk konusmaları kaydet
    $konus=$db->prepare("INSERT INTO konusma SET
        konusma_kimin=:kimin,
        konusma_alici=:alici,
        konusma_icerik=:icerik,
        konusma_durum=:durum,
        konusma_saat=:saat,
        konusma_tarih=:tarih                        
        ");
    $konus_kaydet=$konus->execute(array(
        'kimin'=> $uyecodes,
        'alici'=> $alici_uye_kodu,
        'icerik'=> mt($mesaj),
        'durum'=> $konusma_durum,
        'saat'=> $mesaj_saat,
        'tarih'=> $mesaj_tarih                
        ));
    if ($konus_kaydet) {
    //alıcıya mesajı kaydet
    $konus_a=$db->prepare("INSERT INTO konusma SET
        konusma_kimin=:kimin,
        konusma_alici=:alici,
        konusma_icerik=:icerik,
        konusma_durum=:durum,
        konusma_saat=:saat,
        konusma_tarih=:tarih                      
        ");
    $konus_a_kaydet=$konus_a->execute(array(
        'kimin'=> $alici_uye_kodu,
        'alici'=> $uyecodes,
        'icerik'=> mt($mesaj),
        'durum'=> $mesaj_durum,
        'saat'=> $mesaj_saat,
        'tarih'=> $mesaj_tarih                 
        ));
    if ($konus_a_kaydet) {
    //konusmalar basıldı, şimdi listeye aktar, gönderenden başla
    $mesaj=$db->prepare("INSERT INTO mesajlar SET
        mesaj_kimin=:kimin,
        mesaj_alici=:alici,
        mesaj_icerik=:icerik,
        mesaj_durum=:durum,
        mesaj_okundu=:okundu,
        mesaj_saat=:saat,
        mesaj_tarih=:tarih,
        mesaj_okundu_saat=:mosat,
        mesaj_okundu_tarih=:motar,
        mesaj_code=:mesajkodu                      
        ");
    $mesaj_kaydet=$mesaj->execute(array(
        'kimin'=> $uyecodes,
        'alici'=> $alici_uye_kodu,
        'icerik'=> mt($icerik_onizleme),
        'durum'=> $mesaj_gonderen_durum,
        'okundu'=> $mesaj_gonderen_okundu,
        'saat'=> $mesaj_saat,
        'tarih'=> $mesaj_tarih,
        'mosat'=> $mesaj_okundu_saat,
        'motar'=> $mesaj_okundu_tarih,
        'mesajkodu'=> $mesaj_code                 
        ));
    if ($mesaj_kaydet) {
    //alıcının listesine mesajı bildir
    $mesaj_a=$db->prepare("UPDATE mesajlar SET
        mesaj_icerik=:icerik,
        mesaj_durum=:durum,
        mesaj_okundu=:okundu,
        mesaj_saat=:saat,
        mesaj_tarih=:tarih,
        mesaj_okundu_saat=:mosat,
        mesaj_okundu_tarih=:motar                    
        WHERE id=$alici_mesaj_id");
    $mesaj_a_kaydet=$mesaj_a->execute(array(
        'icerik'=> mt($icerik_onizleme),
        'durum'=> $mesaj_durum,
        'okundu'=> $mesaj_okundu,
        'saat'=> $mesaj_saat,
        'tarih'=> $mesaj_tarih,
        'mosat'=> $mesaj_okundu_saat,
        'motar'=> $mesaj_okundu_tarih                
        ));
    if($mesaj_a_kaydet) {
        $_SESSION['sonyazi'] = $mesaj;
        if ($mesaj_adresi == 'g7412') {
            header('Location:../../konusma.php?msj-a='.$alici_uye_kodu.'&msj-b='.$uyecodes.'&msj-c='.$mes_kodu.'&msj=d&msj-x=eax&mesajat=tamam&xt=7');
            exit();
        }elseif ($mesaj_adresi == 'x9371') {
            header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajat=tamam&mt=2');
            exit();
        }else {
            header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajat=tamam&mt=2');
            exit();
        }

    }else{
        if ($mesaj_adresi == 'g7412') {
            header('Location:../../konusma.php?msj-a='.$alici_uye_kodu.'&msj-b='.$uyecodes.'&msj-c='.$mes_kodu.'&msj=d&msj-x=eax&mesajat=hata&xt=7');
            exit();
        }elseif ($mesaj_adresi == 'x9371') {
            header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajat=hata&mt=2');
            exit();
        }else {
            header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajat=hata&mt=2');
            exit();
        }
    }

    }else{
        if ($mesaj_adresi == 'g7412') {
            header('Location:../../konusma.php?msj-a='.$alici_uye_kodu.'&msj-b='.$uyecodes.'&msj-c='.$mes_kodu.'&msj=d&msj-x=eax&mesajat=hata&xt=7');
            exit();
        }elseif ($mesaj_adresi == 'x9371') {
            header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajat=hata&mt=2');
            exit();
        }else {
            header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajat=hata&mt=2');
            exit();
        }
    }

    }else{
        if ($mesaj_adresi == 'g7412') {
            header('Location:../../konusma?msj-a='.$alici_uye_kodu.'&msj-b='.$uyecodes.'&msj-c='.$mes_kodu.'&msj=d&msj-x=eax&mesajat=hata&xt=7');
            exit();
        }elseif ($mesaj_adresi == 'x9371') {
            header('Location:../../kullanici-mesaj?href='.$alici_pro_code.'&mesajat=hata&mt=2');
            exit();
        }else {
            header('Location:../../kullanici-mesaj?href='.$alici_pro_code.'&mesajat=hata&mt=2');
            exit();
        }
    }

    }else{
        if ($mesaj_adresi == 'g7412') {
            header('Location:../../konusma.php?msj-a='.$alici_uye_kodu.'&msj-b='.$uyecodes.'&msj-c='.$mes_kodu.'&msj=d&msj-x=eax&mesajat=hata&xt=7');
            exit();
        }elseif ($mesaj_adresi == 'x9371') {
            header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajat=hata&mt=2');
            exit();
        }else {
            header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajat=hata&mt=2');
            exit();
        }
    }

}elseif ($x_bas == 4) {
//gönderende liste var alıcıda yok

    //ilk konusmaları kaydet
    $konus=$db->prepare("INSERT INTO konusma SET
        konusma_kimin=:kimin,
        konusma_alici=:alici,
        konusma_icerik=:icerik,
        konusma_durum=:durum,
        konusma_saat=:saat,
        konusma_tarih=:tarih                        
        ");
    $konus_kaydet=$konus->execute(array(
        'kimin'=> $uyecodes,
        'alici'=> $alici_uye_kodu,
        'icerik'=> mt($mesaj),
        'durum'=> $konusma_durum,
        'saat'=> $mesaj_saat,
        'tarih'=> $mesaj_tarih                
        ));
    if ($konus_kaydet) {
    //alıcıya mesajı kaydet
    $konus_a=$db->prepare("INSERT INTO konusma SET
        konusma_kimin=:kimin,
        konusma_alici=:alici,
        konusma_icerik=:icerik,
        konusma_durum=:durum,
        konusma_saat=:saat,
        konusma_tarih=:tarih                      
        ");
    $konus_a_kaydet=$konus_a->execute(array(
        'kimin'=> $alici_uye_kodu,
        'alici'=> $uyecodes,
        'icerik'=> mt($mesaj),
        'durum'=> $mesaj_durum,
        'saat'=> $mesaj_saat,
        'tarih'=> $mesaj_tarih                 
        ));
    if ($konus_a_kaydet) {
    //konusmalar basıldı, şimdi listeye aktar, gönderenden başla
    $mesaj=$db->prepare("UPDATE mesajlar SET
        mesaj_icerik=:icerik,
        mesaj_durum=:durum,
        mesaj_okundu=:okundu,
        mesaj_saat=:saat,
        mesaj_tarih=:tarih,
        mesaj_okundu_saat=:mosat,
        mesaj_okundu_tarih=:motar                     
        WHERE id=$mesaj_id");
    $mesaj_kaydet=$mesaj->execute(array(
        'icerik'=> mt($icerik_onizleme),
        'durum'=> $mesaj_gonderen_durum,
        'okundu'=> $mesaj_gonderen_okundu,
        'saat'=> $mesaj_saat,
        'tarih'=> $mesaj_tarih,
        'mosat'=> $mesaj_okundu_saat,
        'motar'=> $mesaj_okundu_tarih                 
        ));
    if ($mesaj_kaydet) {
    //alıcının listesine mesajı bildir
    $mesaj_a=$db->prepare("INSERT INTO mesajlar SET
        mesaj_kimin=:kimin,
        mesaj_alici=:alici,
        mesaj_icerik=:icerik,
        mesaj_durum=:durum,
        mesaj_okundu=:okundu,
        mesaj_saat=:saat,
        mesaj_tarih=:tarih,
        mesaj_okundu_saat=:mosat,
        mesaj_okundu_tarih=:motar,
        mesaj_code=:mesajkodu                      
        ");
    $mesaj_a_kaydet=$mesaj_a->execute(array(
        'kimin'=> $alici_uye_kodu,
        'alici'=> $uyecodes,
        'icerik'=> mt($icerik_onizleme),
        'durum'=> $mesaj_durum,
        'okundu'=> $mesaj_okundu,
        'saat'=> $mesaj_saat,
        'tarih'=> $mesaj_tarih,
        'mosat'=> $mesaj_okundu_saat,
        'motar'=> $mesaj_okundu_tarih,
        'mesajkodu'=> $mesaj_code                 
        ));
    if($mesaj_a_kaydet) {
        $_SESSION['sonyazi'] = $mesaj;
        if ($mesaj_adresi == 'g7412') {
            header('Location:../../konusma.php?msj-a='.$alici_uye_kodu.'&msj-b='.$uyecodes.'&msj-c='.$mes_kodu.'&msj=d&msj-x=eax&mesajat=tamam&xt=7');
            exit();
        }elseif ($mesaj_adresi == 'x9371') {
            header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajat=tamam&mt=2');
            exit();
        }else {
            header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajat=tamam&mt=2');
            exit();
        }

    }else{
        if ($mesaj_adresi == 'g7412') {
            header('Location:../../konusma.php?msj-a='.$alici_uye_kodu.'&msj-b='.$uyecodes.'&msj-c='.$mes_kodu.'&msj=d&msj-x=eax&mesajat=hata&xt=7');
            exit();
        }elseif ($mesaj_adresi == 'x9371') {
            header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajat=hata&mt=2');
            exit();
        }else {
            header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajat=hata&mt=2');
            exit();
        }
    }

    }else{
        if ($mesaj_adresi == 'g7412') {
            header('Location:../../konusma.php?msj-a='.$alici_uye_kodu.'&msj-b='.$uyecodes.'&msj-c='.$mes_kodu.'&msj=d&msj-x=eax&mesajat=hata&xt=7');
            exit();
        }elseif ($mesaj_adresi == 'x9371') {
            header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajat=hata&mt=2');
            exit();
        }else {
            header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajat=hata&mt=2');
            exit();
        }
    }

    }else{
        if ($mesaj_adresi == 'g7412') {
            header('Location:../../konusma.php?msj-a='.$alici_uye_kodu.'&msj-b='.$uyecodes.'&msj-c='.$mes_kodu.'&msj=d&msj-x=eax&mesajat=hata&xt=7');
            exit();
        }elseif ($mesaj_adresi == 'x9371') {
            header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajat=hata&mt=2');
            exit();
        }else {
            header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajat=hata&mt=2');
            exit();
        }
    }

    }else{
        if ($mesaj_adresi == 'g7412') {
            header('Location:../../konusma.php?msj-a='.$alici_uye_kodu.'&msj-b='.$uyecodes.'&msj-c='.$mes_kodu.'&msj=d&msj-x=eax&mesajat=hata&xt=7');
            exit();
        }elseif ($mesaj_adresi == 'x9371') {
            header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajat=hata&mt=2');
            exit();
        }else {
            header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajat=hata&mt=2');
            exit();
        }
    }

}






}else {
    header('Location:../../kullanici-mesaj.php?href='.$alici_pro_code.'&mesajat=hata&mt=2');
    exit();
}

?>