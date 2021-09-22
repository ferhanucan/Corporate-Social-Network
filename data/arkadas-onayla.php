<?php 
ob_start();
session_start();

include '../tkpan/database/baglan.php';
date_default_timezone_set('Europe/Istanbul');


$uye_get = trim(strip_tags($_GET['un']));
$uyecodes = $_SESSION['uye_code'];
$eklenen_uye = trim(strip_tags($_GET['href']));
$player_code = trim(strip_tags($_GET['href']));
$arkadas_durum = 1;


if ($_GET['rp']=="1") {
    $adres_satir = 'Location:../kullanici.php?rp=1&href='.$player_code.'&';
}elseif ($_GET['ek']=="1") {
    $adres_satir = 'Location:../istekler.php?ek=1&';
}elseif ($_GET['ek']=="15") {
    $adres_satir = 'Location:../kullanici.php?ek=15&href='.$player_code.'&';
}else {
    $adres_satir = 'Location:../profil.php?';
}


if ($_SESSION['sessizin'] != 1 and strlen($uyecodes) != 30) {
    header('Location:../anasayfa.php?koruma=etkin');
    exit();
}


if ($_GET['i']=="o") {

    $bc0=rand(10000,99000);

    $bc1=rand(10000,99000);

    $bc2=rand(10000,99000);

    $bc3=rand(10000,99000);

    $bc4=rand(10000,99000);

    $bc5=rand(10000,99000);

    $bc6=rand(10000,99000);

    $bc7=rand(10000,99000);

    $bc8=rand(10000,99000);

    $bc9=rand(10000,99000);

    $benzersiz_bode = $bc0.md5($bc1).md5($bc2).$bc3.md5($bc4).$bc5.md5($bc6).$bc7.md5($bc8).$bc9;
    $bilkod = $benzersiz_bode;


    $uye_varmi = $db->prepare("SELECT * from users where uye_profil_code=:procode");
    $uye_varmi->execute(array(
    'procode' => $eklenen_uye
    ));

    $kodvarmi=$uye_varmi->rowCount();

if ($kodvarmi > 0) {
    $xx=$uye_varmi->fetch(PDO::FETCH_ASSOC);
    $eklenecek = $xx['uye_code'];

    $eklenme_saat = date('H:i');
    $eklenme_tarih = date('d-m-Y');


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
        'gonderen' => $eklenecek,
        'alan' => $uyecodes
        ));

        $arkadas_istek_sor=$isteksor->rowCount();


        if ($uye_get!=$uyecodes) {

                    header($adres_satir.'hile=v5');
                    exit();

        }elseif ($engelli_uye == 1) {

                    header($adres_satir.'engelli=uye');
                    exit();

        }elseif ($arkadas_istek_sor > 0) {
            $istek_listele=$isteksor->fetch(PDO::FETCH_ASSOC);
            $istek_id = $istek_listele['id'];

                    //arkadası kaydet
                    $arkadas_bas=$db->prepare("INSERT INTO arkadaslar SET
                        arkadas_sahibi=:sahibi,
                        arkadas_kiminle=:kiminle,
                        arkadas_durum=:durum,
                        arkadas_saat=:saat,
                        arkadas_tarih=:tarih

                        ");
                    $arkadas_kayit=$arkadas_bas->execute(array(
                        'sahibi'=> $uyecodes,
                        'kiminle'=> $eklenecek,
                        'durum'=> $arkadas_durum,                       
                        'saat'=> $eklenme_saat,
                        'tarih'=> $eklenme_tarih

                        ));

                    if($arkadas_kayit) {

                    //arkadası kaydet
                    $arkadas_ters_bas=$db->prepare("INSERT INTO arkadaslar SET
                        arkadas_sahibi=:sahibi,
                        arkadas_kiminle=:kiminle,
                        arkadas_durum=:durum,
                        arkadas_saat=:saat,
                        arkadas_tarih=:tarih

                        ");
                    $arkadas_ters_kayit=$arkadas_ters_bas->execute(array(
                        'sahibi'=> $eklenecek,
                        'kiminle'=> $uyecodes,
                        'durum'=> $arkadas_durum,                       
                        'saat'=> $eklenme_saat,
                        'tarih'=> $eklenme_tarih

                        ));
                        if($arkadas_ters_kayit) {



                                            //arkadas ekledikten sonra gelen istegi sil
                                            $istegi_sil=$db->prepare("DELETE from arkadas_istegi where id=:ist_id");
                                            $istek_silindi=$istegi_sil->execute(array(
                                            'ist_id' => $istek_id
                                            ));

                                            if ($istek_silindi) {
                        
                                                $bil_durum = 4;
                                                $bos_icerik = 0;

                                                $bildirim_bas=$db->prepare("INSERT INTO bildirimler SET
                                                    bildirim_kimin=:kimin,
                                                    bildirim_gonderen=:gonderen,
                                                    bildirim_icerik=:icerik,
                                                    bildirim_saat=:saat,
                                                    bildirim_tarih=:tarih,
                                                    bildirim_durum=:durum,
                                                    bildirim_code=:codex
                                                    ");
                                                $bildirim_kayit=$bildirim_bas->execute(array(
                                                    'kimin'=> $uyecodes,
                                                    'gonderen'=> $eklenecek,
                                                    'icerik'=> $bos_icerik,
                                                    'saat'=> $eklenme_saat,
                                                    'tarih'=> $eklenme_tarih,
                                                    'durum'=> $bil_durum,
                                                    'codex'=> $bilkod
                                                    ));

                                                if ($bildirim_kayit) {
                        
                                                    //ters bas
                                                    $bildirim_ters_bas=$db->prepare("INSERT INTO bildirimler SET
                                                        bildirim_kimin=:kimin,
                                                        bildirim_gonderen=:gonderen,
                                                        bildirim_icerik=:icerik,
                                                        bildirim_saat=:saat,
                                                        bildirim_tarih=:tarih,
                                                        bildirim_durum=:durum,
                                                        bildirim_code=:codex
                                                        ");
                                                    $bildirim_ters_kayit=$bildirim_ters_bas->execute(array(
                                                        'kimin'=> $eklenecek,
                                                        'gonderen'=> $uyecodes,
                                                        'icerik'=> $bos_icerik,
                                                        'saat'=> $eklenme_saat,
                                                        'tarih'=> $eklenme_tarih,
                                                        'durum'=> $bil_durum,
                                                        'codex'=> $bilkod
                                                        ));

                                                    if ($bildirim_ters_kayit) {
                                                        header($adres_satir.'arkadas=tamam');
                                                    }else {
                                                        header($adres_satir.'arkadas=hata');
                                                    }

                                                    //ilk bildirim sonucu
                                                }else {
                                                    header($adres_satir.'arkadas=hata');
                                                    exit();
                                                }

                                                //istek silindi sonucu
                                            }else {
                                                header($adres_satir.'arkadas=hata');
                                                exit();
                                            }


                            //ters ark kayıt
                        }else {
                            header($adres_satir.'arkadas=hata');
                            exit();
                        }


                        //ark kayıt
                    }else {
                        header($adres_satir.'arkadas=hata');
                        exit();
                    }
                    
            
            // eklemişsin zaten

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














