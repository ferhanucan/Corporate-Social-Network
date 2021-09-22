<?php 
ob_start();
session_start();

include '../tkpan/database/baglan.php';
date_default_timezone_set('Europe/Istanbul');


/* bildirim sil */
$uye_get = trim(strip_tags($_GET['puc']));
$uyecodes = $_SESSION['uye_code'];
$aranan_bildirim = trim(strip_tags($_GET['bxl']));
$bil_sayisi = $_SESSION['bil_sayisi'];


if (strlen($_GET['bxl']) != 185) {
    header('Location:../bildirimler.php?boylebildirim=yok&bd=1&sayfa='.$bil_sayisi);
    exit();  
}


if ($_SESSION['sessizin'] != 1 and strlen($uyecodes) != 30) {
    header('Location:../anasayfa?koruma=etkin');
    exit();
}


if ($_GET['b']=="s") {

    $bildirim_varmi = $db->prepare("SELECT * from bildirimler where bildirim_code=:boce and bildirim_kimin=:bkim");
    $bildirim_varmi->execute(array(
    'boce' => $aranan_bildirim,
    'bkim' => $uyecodes
    ));

    $kodvarmi=$bildirim_varmi->rowCount();

if ($kodvarmi > 0) {

            $bid=$bildirim_varmi->fetch(PDO::FETCH_ASSOC);

            $bilid = $bid['id'];


        if ($uyecodes==$uye_get) {

                $sil=$db->prepare("DELETE from bildirimler where id=:b_id");
                $delete=$sil->execute(array(
                'b_id' => $bilid
                ));

                if ($delete) {
                   header('Location:../bildirimler.php?bildirim-sil=tamam&bd=1&sayfa='.$bil_sayisi); 
                }else {
                    header('Location:../bildirimler.php?bildirim-sil=hata&bd=1&sayfa='.$bil_sayisi); 
                }



        } else {
            // kullanıcı id eşleşmiyor
            header('Location:../bildirimler.php?bildirim-id=yok&bd=1&sayfa='.$bil_sayisi);
            exit();
        }


    }else {
        // kod sistemde yok
        header('Location:../bildirimler.php?bildirim-kod=yok&bd=1&sayfa='.$bil_sayisi);
        exit();
    }



} else {
    header('Location:../bildirimler.php?hile=v6&bd=1&sayfa='.$bil_sayisi);
    exit();
}

/* /bildirim sil */


?>