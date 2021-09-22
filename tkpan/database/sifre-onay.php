<?php  
ob_start();
session_start();

include 'baglan.php';
date_default_timezone_set('Europe/Istanbul');

if (isset($_POST['sifre-onayla'])) {

    $sess_reset_uye = $_SESSION['kim_re'];
    $sess_reset_code = $_SESSION['num_re'];
    $get_degeri = 'hgcvx2v5xk6tbz9kerc6gd845';


function keysuzgec($string)
{
    $string = preg_replace("/\s+/", "", $string);
    $string = trim($string);
    return $string;
}

    $norm_reset_uye = trim(strip_tags(keysuzgec($_POST['r6kd5s8xn3'])));
    $norm_reset_code = trim(strip_tags(keysuzgec($_POST['u9ykd56s9x'])));
    $norm_get_koruma = trim(strip_tags(keysuzgec($_POST['c82pc2sm4d'])));

    $yeni_sifre = trim(strip_tags(keysuzgec($_POST['sifre'])));
    $re_yeni_sifre = trim(strip_tags(keysuzgec($_POST['resifre'])));



    if (empty($yeni_sifre) or empty($re_yeni_sifre) or empty($norm_reset_uye) or empty($norm_reset_code) or empty($norm_get_koruma)) {
        header('Location:../../login/sifremi-unuttum.php?sifreizin=yok');
        exit();
    }elseif (strlen($sess_reset_uye) != 30 or strlen($norm_reset_uye) != 30 or strlen($norm_get_koruma) != 25 or strlen($norm_reset_code) != 25 or strlen($sess_reset_code) != 25 or strlen($yeni_sifre) < 6 or strlen($yeni_sifre) > 20 or strlen($re_yeni_sifre) < 6 or  strlen($re_yeni_sifre) > 20) {
        header('Location:../../login/sifremi-unuttum.php?sifreizin=yok');
        exit();
    }elseif ($norm_get_koruma != $get_degeri or $sess_reset_uye != $norm_reset_uye or $sess_reset_code != $norm_reset_code) {
        header('Location:../../login/sifremi-unuttum.php?sifreizin=yok');
        exit();
    }elseif ($yeni_sifre != $re_yeni_sifre) {
        header('Location:../../login/sifremi-unuttum.php?sifreizin=eslesmedi');
        exit();
    }else {


    $sifre_aktif=md5(sha1($yeni_sifre)).sha1(md5($yeni_sifre));    

    
    if ($sess_reset_uye && $sess_reset_code) {

    $resetud = 1;
    $reset_ara = $db->prepare("SELECT * from password_reset where reset_code=:cores and reset_kimin=:kirest and reset_durum=:resd");
    $reset_ara->execute(array(
    'cores' => $sess_reset_code,
    'kirest' => $sess_reset_uye,
    'resd' => $resetud
    ));

    $reset_varmi=$reset_ara->rowCount();

    if ($reset_varmi > 0) {
        $reset_cek=$reset_ara->fetch(PDO::FETCH_ASSOC);
        $reset_zaman = $reset_cek['reset_zaman'];
        $id_reset = $reset_cek['reset_id'];

        $simdiki_zaman = date('Y-m-d H:i:s');

        if ($simdiki_zaman >= $reset_zaman) {
            $reset_izin = 0;
            header('Location:../../login/sifremi-unuttum.php?resetpw=suredoldu');
            exit();
        }elseif ($simdiki_zaman < $reset_zaman) {
            $reset_izin = 1;
        }else {
            $reset_izin = 0;
            header('Location:../../login/sifremi-unuttum.php?sifreizin=yok');
            exit();
        }

        
    }else {
        header('Location:../../login/sifremi-unuttum.php?sifreizin=yok');
        exit();
    }


        $kodsor=$db->prepare("SELECT * from users where uye_code=:code");
        $kodsor->execute(array(
        'code' => $sess_reset_uye
        ));

        $vsay=$kodsor->rowCount();

        if ($vsay > 0 and $reset_izin == 1) {

                $uyecek=$kodsor->fetch(PDO::FETCH_ASSOC);
                $uye_id = $uyecek['id'];

                $sifre_yenile=$db->prepare("UPDATE users SET
                    uye_sifre=:sifre
                    WHERE id=$uye_id");

                $yenile=$sifre_yenile->execute(array(
                    'sifre'=> $sifre_aktif
                    ));
                    

                if ($yenile) {

                $gundures = 2;
                $reset_durum_bas=$db->prepare("UPDATE password_reset SET
                    reset_durum=:durest
                    WHERE reset_id=$id_reset");

                $res_dur_gun=$reset_durum_bas->execute(array(
                    'durest'=> $gundures
                    ));

                if ($res_dur_gun) {
                    header('Location:../../login/giris.php?sifreislem=tamam');
                    exit();
                }else {
                    header('Location:../../login/sifremi-unuttum.php?sifreizin=yok');
                    exit();
                }


                } else {
                    header('Location:../../login/sifremi-unuttum.php?sifreizin=yok');
                    exit();
                }

            }else {
                header('Location:../../login/sifremi-unuttum.php?sifreizin=yok');
                exit();
            }

        }//ciftli sorgu else bitiş


    }//else bitiş



}else {
    header('Location:../../login/sifremi-unuttum.php');
    exit();
} 
?>