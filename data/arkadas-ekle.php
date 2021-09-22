<?php 
ob_start();
session_start();

include '../tkpan/database/baglan.php';
date_default_timezone_set('Europe/Istanbul');


$uye_get = trim(strip_tags($_GET['un']));
$uyecodes = $_SESSION['uye_code'];
$eklenen_uye = trim(strip_tags($_GET['href']));
$player_code = trim(strip_tags($_GET['href']));
$istek_durum = 1;
$pro_code_control = $_SESSION['uye_pro_code'];



if ($_GET['rp']=="1") {
  $adres_satir = 'Location:../kullanici.php?rp=1&href='.$player_code.'&'; 
}else {
  $adres_satir = 'Location:../profil.php?';
}


if ($_SESSION['sessizin'] != 1 and strlen($uyecodes) != 30) {
    header('Location:../anasayfa.php?koruma=etkin');
    exit();
}


//korumacı
if ($pro_code_control != $eklenen_uye) {
    header($adres_satir.'hile=v7');
    exit();
}


if ($_GET['a']=="i") {

    $uye_varmi = $db->prepare("SELECT * from users where uye_profil_code=:upc");
    $uye_varmi->execute(array(
    'upc' => $eklenen_uye
    ));

    $kodvarmi=$uye_varmi->rowCount();

if ($kodvarmi > 0) {
    $xx=$uye_varmi->fetch(PDO::FETCH_ASSOC);
    $eklenecek = $xx['uye_code'];
    $eklenen_uye_gizlilik = $xx['uye_gizlilik'];


    $istek_atan = $db->prepare("SELECT * from users where uye_code=:uc");
    $istek_atan->execute(array(
    'uc' => $uyecodes
    ));

    $bilgi_cek=$istek_atan->fetch(PDO::FETCH_ASSOC);


    $ad = $bilgi_cek['uye_ad'];
    $soyad = $bilgi_cek['uye_soyad'];
    $adsoyad = $ad." ".$soyad; 

    $e_profil_code = $bilgi_cek['uye_profil_code'];
    $e_meslek = $bilgi_cek['uye_meslek'];
    $e_meslek_grup = $bilgi_cek['uye_meslek_grup'];
    $e_profil_onay = $bilgi_cek['uye_profil_onay'];
    $e_cinsiyet = $bilgi_cek['uye_cinsiyet_num'];
    $eklenme_saat = date('H:i');
    $eklenme_tarih = date('d-m-Y');



//arkadaş sor

$ark_kontrol = $db->prepare("SELECT * from arkadaslar where arkadas_sahibi=:sahibi and arkadas_kiminle=:kiminle");
$ark_kontrol->execute(array(
'sahibi' => $uyecodes,
'kiminle'=> $eklenecek
));

$ark_ters_kontrol = $db->prepare("SELECT * from arkadaslar where arkadas_sahibi=:sahibi and arkadas_kiminle=:kiminle");
$ark_ters_kontrol->execute(array(
'sahibi' => $eklenecek,
'kiminle'=> $uyecodes
));

$arkadas_sor=$ark_kontrol->rowCount();
$ark_ters=$ark_ters_kontrol->rowCount();

if ($arkadas_sor > 0 and $ark_ters > 0) {

    $arkadas_var = 1;

}else {
    $arkadas_var = 0;
}

//arkadaş sor bitiş


//engel varmi sor

        $engelsor=$db->prepare("SELECT * from engel where engel_gonderen=:gonderen and engel_alan=:alan");
        $engelsor->execute(array(
        'gonderen' => $uyecodes,
        'alan' => $eklenecek
        ));
        $sor=$engelsor->rowCount();

        $ters_engelsor=$db->prepare("SELECT * from engel where engel_gonderen=:gonderen and engel_alan=:alan");
        $ters_engelsor->execute(array(
        'gonderen' => $eklenecek,
        'alan' => $uyecodes
        ));
        $ters_sor=$ters_engelsor->rowCount();

        if ($sor > 0 and $ters_sor > 0) {

            $engelli_uye = 1;
          
        }elseif ($sor > 0) {

            $engelli_uye = 1;
            

        }elseif ($ters_sor > 0) {

            $engelli_uye = 1;
          
        }


//engel varmi sor bitiş 






if ($eklenecek && $uyecodes) {

        $isteksor=$db->prepare("SELECT * from arkadas_istegi where istek_gonderen=:gonderen and istek_alan=:alan");
        $isteksor->execute(array(
        'gonderen' => $uyecodes,
        'alan' => $eklenecek
        ));

        $sor=$isteksor->rowCount();

        if ($sor > 0) {

                    header('Location:../profil.php?zatenistek=var'); 
                    exit();
            
            // engellemişsin zaten

        }elseif ($eklenen_uye_gizlilik == 2) {

                    header($adres_satir.'arkadas=istegikapali');
                    exit();

        }elseif ($arkadas_var == 1) {

                    header($adres_satir.'arkadas=zatenekli');
                    exit();

        }elseif ($engelli_uye == 1) {

                    header($adres_satir.'engelli=uye');
                    exit();

        }elseif ($uye_get!=$uyecodes) {

                    header($adres_satir.'hile=v5');
                    exit();

        }else {
                    $istekbas=$db->prepare("INSERT INTO arkadas_istegi SET
                        istek_gonderen=:gonderen,
                        istek_alan=:alan,
                        istek_durum=:durum,
                        istek_adsoyad=:adsoyad,
                        istek_profil_code=:profil_code,
                        istek_meslek=:meslek,
                        istek_meslek_grup=:meslek_grup,
                        istek_profil_onay=:profil_onay,
                        istek_saat=:saat,
                        istek_tarih=:tarih,
                        istek_cinsiyet=:cinsiyet

                        ");
                    $istek_kayit=$istekbas->execute(array(
                        'gonderen'=> $uyecodes,
                        'alan'=> $eklenecek,
                        'durum'=> $istek_durum,
                        'adsoyad'=> $adsoyad,
                        'profil_code'=> $e_profil_code,
                        'meslek'=> $e_meslek,
                        'meslek_grup'=> $e_meslek_grup,
                        'profil_onay'=> $e_profil_onay,
                        'saat'=> $eklenme_saat,
                        'tarih'=> $eklenme_tarih,
                        'cinsiyet'=> $e_cinsiyet

                        ));
                    if($istek_kayit) {

                        header($adres_satir.'istek=tamam');
                        exit();

                    }else {

                        header($adres_satir.'istek=hata');
                        exit();

                    }
        }


} //&&bitiş


//uye varmi sorgusu
} else {

    header($adres_satir.'hile=v4');
    exit();
            // hile algılandı, sistemde paylasim kodu yok
}// kod varmı elsesi bitiş




}else {

    header($adres_satir.'hile=v6');
    exit();

    //guvenlik
}//GET U=E bitis


?>














