<?php 
ob_start();
session_start();

include '../tkpan/database/baglan.php';
date_default_timezone_set('Europe/Istanbul');

$uyecodes = $_SESSION['uye_code'];
$player_code = trim(strip_tags($_GET['ara']));
$plist = trim(strip_tags($_GET['foc']));


if ($_SESSION['sessizin'] != 1 and strlen($uyecodes) != 30) {
    header('Location:../anasayfa?koruma=etkin');
    exit();
}



if ($_SESSION['foto_sayfa'] > 0) {
    $ki_sayisi = $_SESSION['foto_sayfa'];
}else {
    $ki_sayisi = 1;
}


if ($_GET['xfo']=="1") {
    $adres_satir = 'Location:../kullanici-fotograflar?foto=2&href='.$player_code.'&sayfa='.$ki_sayisi.'&';
}elseif ($_GET['fo']=="li") {
  $adres_satir = 'Location:../fotograf-listele?foli=3&fotlist='.$plist.'&'; 
}else {
    $adres_satir = 'Location:../profil?';
}



$islem_saat = date('H:i:s');
$islem_tarih = date('d-m-Y');

if ($_GET['ku']=="fo") {

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


    $p_kodulistele = $db->prepare("SELECT * from fotograf where foto_code=:pocode");
    $p_kodulistele->execute(array(
    'pocode' => trim(strip_tags($_GET['foc']))
    ));

    $kodvarmi=$p_kodulistele->rowCount();

if ($kodvarmi > 0) { 
    $pcl=$p_kodulistele->fetch(PDO::FETCH_ASSOC);
    $foto_begeni = $pcl['foto_begeni'];
    $foto_sahibi = $pcl['foto_uye_code'];


    $foto_kodu = trim(strip_tags($_GET['foc']));

    if ($uyecodes != $foto_sahibi) {
    $ark_kontrol = $db->prepare("SELECT * from arkadaslar where arkadas_sahibi=:sahibi and arkadas_kiminle=:kiminle");
    $ark_kontrol->execute(array(
    'sahibi' => $uyecodes,
    'kiminle'=> $foto_sahibi
    ));

    $ark_ters_kontrol = $db->prepare("SELECT * from arkadaslar where arkadas_sahibi=:sahibi and arkadas_kiminle=:kiminle");
    $ark_ters_kontrol->execute(array(
    'sahibi' => $foto_sahibi,
    'kiminle'=> $uyecodes
    ));

    $arkadas_sor=$ark_kontrol->rowCount();
    $ark_ters=$ark_ters_kontrol->rowCount();

        if ($arkadas_sor == 0 and $ark_ters == 0) {

            header($adres_satir.'fotodurum=yetkisiyok');
            exit();

        }
    }



    if ($uyecodes==trim(strip_tags($_GET['ftuyc']))) {

if ($uyecodes && $foto_kodu) {

        $durumsor=$db->prepare("SELECT * from fotograf_durum where foto_code=:fotograflarcode and foto_oyveren_uye=:fotovey");
        $durumsor->execute(array(
        'fotograflarcode' => $foto_kodu,
        'fotovey' => $uyecodes
        ));

        $sor=$durumsor->rowCount();

        if ($sor > 0) {

            header($adres_satir.'fotodurum=begenivar');
            exit();

        } else {

            //p_degerli fotograflar kategorisine gidecek          
            $p_degerli = $foto_begeni + 1;

            //foto_durum a gidecek 
            $foto_durum = 1;

            $i_durum_kayit=$db->prepare("INSERT INTO fotograf_durum SET
                foto_code=:pcode,
                foto_oyveren_uye=:overen,
                foto_durum=:drm
                ");
            $kaydet=$i_durum_kayit->execute(array(
                'pcode'=> $foto_kodu,
                'overen'=> $uyecodes,
                'drm'=> $foto_durum  
                ));

            if ($kaydet) {

                $pd_guncelle=$db->prepare("UPDATE fotograf SET
                    foto_begeni=:iyi
                    WHERE foto_code=$foto_kodu");

                $guncelle=$pd_guncelle->execute(array(
                    'iyi'=> $p_degerli
                    ));

                if ($guncelle) {

                    $bil_durum = 20;

                    if ($foto_sahibi == $uyecodes) {
                            header($adres_satir.'fotodurum=begendim');
                            exit();
                    }else {
                        
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
                            'kimin'=> $foto_sahibi,
                            'gonderen'=> $uyecodes,
                            'icerik'=> $foto_kodu,
                            'saat'=> $islem_saat,
                            'tarih'=> $islem_tarih,
                            'durum'=> $bil_durum,
                            'codex'=> $bilkod
                            ));

                        if ($bildirim_kayit) {
                            header($adres_satir.'fotodurum=begendim');
                            exit();
                        }else {
                            header($adres_satir.'fotodurum=hata');
                            exit();
                        }
                    }

                }else {

                    header($adres_satir.'fotodurum=hata');
                    exit();

                }//else bitiş

            }else {

                header($adres_satir.'fotodurum=hata');
                exit();

            } //else bitiş


        }

}




    } else {
        header($adres_satir.'hile=v5');
        exit();

            // hile algılandı, sistemde üye kodu yok

        }//else bitiş


} else {
    header($adres_satir.'hile=v4');
    exit();

    // hile algılandı, sistemde fotograflar kodu yok

    }//else bitiş



} else {
    header($adres_satir.'hile=v6');
    exit();
    
    //guvenlik
}//else bitiş
/* paylaşım oy ver */
?>
