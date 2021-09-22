<?php 
ob_start();
session_start();

include '../tkpan/database/baglan.php';
date_default_timezone_set('Europe/Istanbul');


$uye_get = trim(strip_tags($_GET['un']));
$uyecodes = $_SESSION['uye_code'];
$eklenen_uye = trim(strip_tags($_GET['href']));
$player_code = trim(strip_tags($_GET['href']));
$k_uye_kontrol = $_SESSION['uye_pro_code'];

if ($_GET['rp']=="1") {
    $adres_satir = 'Location:../kullanici?rp=1&href='.$player_code.'&';
}else {
    $adres_satir = 'Location:../profil?';
}


if ($_SESSION['sessizin'] != 1 and strlen($uyecodes) != 30) {
    header('Location:../anasayfa?koruma=etkin');
    exit();
}

if ($_GET['be']=="sl") {

    $uye_varmi = $db->prepare("SELECT * from users where uye_profil_code=:procode");
    $uye_varmi->execute(array(
    'procode' => $eklenen_uye
    ));

    $kodvarmi=$uye_varmi->rowCount();

if ($kodvarmi > 0) {
    $xx=$uye_varmi->fetch(PDO::FETCH_ASSOC);
    $eklenecek = $xx['uye_code'];

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



if ($uyecodes && $eklenecek) {

        $isteksor=$db->prepare("SELECT * from arkadas_istegi where istek_gonderen=:gonderen and istek_alan=:alan");
        $isteksor->execute(array(
        'gonderen' => $uyecodes,
        'alan' => $eklenecek
        ));

        $sor=$isteksor->rowCount();


        if ($uye_get!=$uyecodes) {

                    header($adres_satir.'hile=v5');
                    exit();

        }elseif ($engelli_uye == 1) {

                    header($adres_satir.'engelli=uye');
                    exit();

        }elseif ($k_uye_kontrol != $eklenecek) {

                    header($adres_satir.'hile=v5');
                    exit();

        }elseif ($sor > 0) {
            $istek_listele=$isteksor->fetch(PDO::FETCH_ASSOC);
            $istek_id = $istek_listele['id'];

                $istegi_sil=$db->prepare("DELETE from arkadas_istegi where id=:ist_id");
                $istek_silindi=$istegi_sil->execute(array(
                'ist_id' => $istek_id
                ));

                if ($istek_silindi) {
                    header($adres_satir.'isteksil=tamam');
                    exit();
                }else {
                    header($adres_satir.'isteksil=hata');
                    exit();
                }
            
        }else {
            header($adres_satir.'boyleistek=yok'); 
            exit();
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














