<?php 
ob_start();
session_start();

include '../tkpan/database/baglan.php';
date_default_timezone_set('Europe/Istanbul');



/* işlemleri sil */
$uye_get = trim(strip_tags($_GET['puc']));
$uyecodes = $_SESSION['uye_code'];


if ($_SESSION['sessizin'] != 1 and strlen($uyecodes) != 30) {
    header('Location:../anasayfa?koruma=etkin');
    exit();
}


if ($_GET['is']=="si") {

    $bildirim_varmi = $db->prepare("SELECT * from islem_gecmisi where islem_kimin=:kimin");
    $bildirim_varmi->execute(array(
    'kimin' => $uyecodes
    ));

    $kodvarmi=$bildirim_varmi->rowCount();

if ($kodvarmi > 0) {


        if ($uyecodes==$uye_get) {

                $sil=$db->prepare("DELETE from islem_gecmisi where islem_kimin=:kimin");
                $delete=$sil->execute(array(
                'kimin' => $uyecodes
                ));

                if ($delete) {
                   header('Location:../islem-gecmisi?islemgecmisi=tamam&igex=1');
                   exit();
                }else {
                    header('Location:../islem-gecmisi?islemgecmisi=hata&igex=1');
                    exit();
                }


        } else {
            // kullanıcı id eşleşmiyor
            header('Location:../islem-gecmisi?islemgecmisi=hata&igex=1');
            exit();
        }

    }else {
        // kod sistemde yok
        header('Location:../islem-gecmisi?islemgecmisi=bos&igex=1');
        exit();
    }

} else {
    header('Location:../islem-gecmisi?yanlis=islem&igex=1');
    exit();
}



?>