<?php 
ob_start();
session_start();

include '../tkpan/database/baglan.php';
date_default_timezone_set('Europe/Istanbul');



/* bildirim sil */
$uye_get = trim(strip_tags($_GET['puc']));
$uyecodes = $_SESSION['uye_code'];


if ($_SESSION['sessizin'] != 1 and strlen($uyecodes) != 30) {
    header('Location:../anasayfa.php?koruma=etkin');
    exit();
}


if ($_GET['b']=="s") {

    $bildirim_varmi = $db->prepare("SELECT * from bildirimler where bildirim_kimin=:kimin");
    $bildirim_varmi->execute(array(
    'kimin' => $uyecodes
    ));

    $kodvarmi=$bildirim_varmi->rowCount();

if ($kodvarmi > 0) {


        if ($uyecodes==$uye_get) {

                $sil=$db->prepare("DELETE from bildirimler where bildirim_kimin=:kimin");
                $delete=$sil->execute(array(
                'kimin' => $uyecodes
                ));

                if ($delete) {
                   header('Location:../bildirimler.php?bildirim-toplu-sil=tamam&bd=1'); 
                   exit();
                }else {
                    header('Location:../bildirimler.php?bildirim-toplu-sil=hata&bd=1'); 
                    exit();
                }


        } else {
            // kullanıcı id eşleşmiyor
            header('Location:../bildirimler.php?bildirim-id=yok&bd=1');
            exit();
        }

    }else {
        // kod sistemde yok
        header('Location:../bildirimler.php?bildirim-kod=yok&bd=1');
        exit();
    }

} else {
    header('Location:../bildirimler.php?hile=v6&bd=1');
    exit();
}



?>