<?php 
ob_start();
session_start();

include '../tkpan/database/baglan.php';
date_default_timezone_set('Europe/Istanbul');


$uye_get = trim(strip_tags($_GET['un']));
$uyecodes = $_SESSION['uye_code'];
$silinen_uye = trim(strip_tags($_GET['href']));
$player_code = trim(strip_tags($_GET['href']));


if ($_GET['rp']=="1") {
    $adres_satir = 'Location:../kullanici?rp=1&href='.$player_code.'&';
}elseif ($_GET['ek']=="15") {
    $adres_satir = 'Location:../kullanici?ek=15&href='.$player_code.'&';
}else {
    $adres_satir = 'Location:../profil?';
}


if ($_SESSION['sessizin'] != 1 and strlen($uyecodes) != 30) {
    header('Location:../anasayfa?koruma=etkin');
    exit();
}

if ($_GET['a']=="s") {

    $uye_varmi = $db->prepare("SELECT * from users where uye_profil_code=:procode");
    $uye_varmi->execute(array(
    'procode' => $silinen_uye
    ));

    $kodvarmi=$uye_varmi->rowCount();

if ($kodvarmi > 0) {


    $xx=$uye_varmi->fetch(PDO::FETCH_ASSOC);
    $silinen = $xx['uye_code'];


//engel varmi sor

        $engelsor=$db->prepare("SELECT * from engel where engel_gonderen=:gonderen and engel_alan=:alan");
        $engelsor->execute(array(
        'gonderen' => $uyecodes,
        'alan' => $silinen
        ));
        $sor=$engelsor->rowCount();

        $ters_engelsor=$db->prepare("SELECT * from engel where engel_gonderen=:gonderen and engel_alan=:alan");
        $ters_engelsor->execute(array(
        'gonderen' => $silinen,
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



if ($silinen && $uyecodes) {

        $arkadas_sor=$db->prepare("SELECT * from arkadaslar where arkadas_sahibi=:sahibi and arkadas_kiminle=:kiminle");
        $arkadas_sor->execute(array(
        'sahibi' => $uyecodes,
        'kiminle' => $silinen
        ));


        $arkisor=$arkadas_sor->rowCount();


        if ($uye_get!=$uyecodes) {

                    header($adres_satir.'hile=v5');
                    exit();

        }elseif ($engelli_uye == 1) {

                    header($adres_satir.'engelli=uye');
                    exit();

        }elseif ($arkisor > 0) {

        $arkadas_ters_sor=$db->prepare("SELECT * from arkadaslar where arkadas_sahibi=:sahibi and arkadas_kiminle=:kiminle");
        $arkadas_ters_sor->execute(array(
        'sahibi' => $silinen,
        'kiminle' => $uyecodes
        ));

            $arkadas_listele=$arkadas_sor->fetch(PDO::FETCH_ASSOC);
            $arkadas_id = $arkadas_listele['id'];

            $arkadas_ters_listele=$arkadas_ters_sor->fetch(PDO::FETCH_ASSOC);
            $arkadas_ters_id = $arkadas_ters_listele['id'];

                $arkadas_sil=$db->prepare("DELETE from arkadaslar where id=:ark_id");
                $arkadas_silindi=$arkadas_sil->execute(array(
                'ark_id' => $arkadas_id
                ));

                if ($arkadas_silindi) {

                    $arkadas_ters_sil=$db->prepare("DELETE from arkadaslar where id=:ark_ters_id");
                    $arkadas_ters_silindi=$arkadas_ters_sil->execute(array(
                    'ark_ters_id' => $arkadas_ters_id
                    ));

                    if ($arkadas_ters_silindi) {

                        header($adres_satir.'arkadas-sil=tamam');

                    }else {
                        header($adres_satir.'arkadas-sil=hata');
                        exit();
                    }

                }else {
                    header($adres_satir.'arkadas-sil=hata');
                    exit();
                }
            
        }else {
            header($adres_satir.'boyle-arkadas=yok'); 
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














