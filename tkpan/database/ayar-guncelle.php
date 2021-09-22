<?php 
ob_start();
session_start();

include 'baglan.php';
date_default_timezone_set('Europe/Istanbul');

if (isset($_POST['gizlilik-degistir'])) {


        $uye_code = $_SESSION['uye_code'];
        $gizlilik = trim(strip_tags($_POST['gizlilik']));


if ($_SESSION['sessizin'] != 1 and strlen($uye_code) != 30) {
    header('Location:../anasayfa?koruma=etkin');
    exit();
}      

        if (empty($gizlilik)) {

            header('Location:../../ayarlar?gizlilik=boslukvar');
            exit();
        }elseif (strlen($gizlilik) != 1) {
            header('Location:../../ayarlar?gizlilik-uzunluk=hata');
            exit();
        }elseif (!ctype_digit($gizlilik)) {
            header('Location:../../ayarlar?gizlilik-uzunluk=hata');
            exit();
        }elseif ($gizlilik < 1 or $gizlilik > 2) {
            header('Location:../../ayarlar?gizlilik-uzunluk=hata');
            exit();
        }else {


                $ayalar=$db->prepare("UPDATE users SET
                    uye_gizlilik=:gizlilik
                    WHERE uye_code=$uye_code");

                $guncelle=$ayalar->execute(array(
                    'gizlilik'=> $gizlilik
                    ));
                    

                if ($guncelle) {
                    header('Location:../../ayarlar?gizlilik=basarili');
                } else {
                    header('Location:../../ayarlar?gizlilik=hata');
                    exit();
                    }

                }


}elseif (isset($_POST['sifre-degistir'])) {

    $uye_code = $_SESSION['uye_code'];


if ($_SESSION['sessizin'] != 1 and strlen($uye_code) != 30) {
    header('Location:../anasayfa?koruma=etkin');
    exit();
}      


function keysuzgec($string)
{
    $string = preg_replace("/\s+/", "", $string);
    $string = trim($string);
    return $string;
}

    $yeni_sifre = trim(strip_tags(keysuzgec($_POST['sifre'])));
    $re_yeni_sifre = trim(strip_tags(keysuzgec($_POST['resifre'])));
    $bilgiler = trim(strip_tags($_SESSION['uyebilgi']));


    if (empty($yeni_sifre) or empty($re_yeni_sifre)) {

        header('Location:../../ayarlar?bosluk=var');
        exit();
    }elseif (strlen(utf8_decode($yeni_sifre)) < 6 or strlen(utf8_decode($yeni_sifre)) > 20 or strlen(utf8_decode($re_yeni_sifre)) < 6 or strlen(utf8_decode($re_yeni_sifre)) > 20) {
            header('Location:../../ayarlar?sifre-uzunluk=gecersiz');
            exit();
    }elseif ($yeni_sifre != $re_yeni_sifre) {
            header('Location:../../ayarlar?sifre=gecersiz');
            exit();
    }else {


    $sifre_aktif=md5(sha1($yeni_sifre)).sha1(md5($yeni_sifre));    

    
    if ($uye_code) {

        $kodsor=$db->prepare("SELECT * from users where uye_code=:code");
        $kodsor->execute(array(
        'code' => $uye_code
        ));

        $vsay=$kodsor->rowCount();

        if ($vsay > 0) {

                $sifre_yenile=$db->prepare("UPDATE users SET
                    uye_sifre=:sifre
                    WHERE uye_code=$uye_code");

                $yenile=$sifre_yenile->execute(array(
                    'sifre'=> $sifre_aktif
                    ));
                    

                if ($yenile) {

                    $bilgibas=$db->prepare("INSERT INTO sifre_degistirme_analiz SET
                        s_uye_code=:uscode,
                        s_bilgi=:sbilgi
                        ");

                    $bilgi_kayit=$bilgibas->execute(array(
                        'uscode'=> $uye_code,
                        'sbilgi'=> $bilgiler
                    ));

                    if ($bilgi_kayit) {
                        header('Location:../../ayarlar?sifre=degisti');
                    }else {
                        header('Location:../../ayarlar?sifre=degisti');
                    }

                } else {
                    header('Location:../../ayarlar?sifre=degismedi');
                    exit();
                }

            }else {
                header('Location:../../ayarlar?guvenlikkodu=hatali');
                exit();
            }

        }


    }//else bitiş



}else {
    header('Location:../../ayarlar?sifre=degismedi');
} 
?>