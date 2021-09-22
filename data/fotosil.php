<?php 
ob_start();
session_start();

include '../tkpan/database/baglan.php';
date_default_timezone_set('Europe/Istanbul');


if ($_SESSION['foto_sayfa'] > 0) {
    $pro_sayfa = $_SESSION['foto_sayfa'];
}else {
    $pro_sayfa = 1;
}

/* paylaşım sil */
$uyecodes = $_SESSION['uye_code'];


if ($_SESSION['sessizin'] != 1 and strlen($uyecodes) != 30) {
    header('Location:../anasayfa?koruma=etkin');
    exit();
}


if ($_GET['fo']=="si") {


    $p_kodulistele = $db->prepare("SELECT * from fotograf where foto_code=:pocode and foto_uye_code=:fouyco");
    $p_kodulistele->execute(array(
    'pocode' => trim(strip_tags($_GET['foc'])),
    'fouyco' => $uyecodes
    ));

    $kodvarmi=$p_kodulistele->rowCount();

        if ($kodvarmi > 0) {

            $pcl=$p_kodulistele->fetch(PDO::FETCH_ASSOC);

            $foid = $pcl['id'];

            $foto_resim_yol = $pcl['foto_resim_yol'];

            $alve = trim(strip_tags($_GET['foc']));


    if ($uyecodes==$_GET['ftuyc']) {

            $sil=$db->prepare("DELETE from fotograf where id=:f_id");
            $delete=$sil->execute(array(
            'f_id' => $foid
            ));

            if ($delete) {

    $durumvarmi = $db->prepare("SELECT * from fotograf_durum where foto_code=:durumcevap");
    $durumvarmi->execute(array(
    'durumcevap' => $alve
    ));

    $durumsor=$durumvarmi->rowCount();

    if ($durumsor > 0) {
        
                $paylasim_durum_sil=$db->prepare("DELETE from fotograf_durum where foto_code=:fc");
                $durumlar_silindi=$paylasim_durum_sil->execute(array(
                'fc' => $alve
                ));


                if ($durumlar_silindi) {
                    
 
                    unlink("../$foto_resim_yol");
                                    
                    header('Location:../fotograflar?foto=1&fotosil=oldu&sayfa='.$pro_sayfa);
                    exit();

                        
                }else {
                    header('Location:../fotograflar?foto=1&fotosil=hata&sayfa='.$pro_sayfa);
                    exit();
                } 
            }else {
                    unlink("../$foto_resim_yol");
                                    
                    header('Location:../fotograflar?foto=1&fotosil=oldu&sayfa='.$pro_sayfa);
                    exit(); 
            }




            } else {
                header('Location:../fotograflar?foto=1&fotosil=hata&sayfa='.$pro_sayfa);
                exit();
            }


    } else {
        // kullanıcı id eşleşmiyor
        header('Location:../fotograflar?foto=1&id=yok&sayfa='.$pro_sayfa);
        exit();
    }


}else {
    // kod sistemde yok
    header('Location:../fotograflar?foto=1&kod=yok&sayfa='.$pro_sayfa);
    exit();
}



} else {
    header('Location:../fotograflar?foto=1&hile=v6&sayfa='.$pro_sayfa);
    exit();
}

/* /paylaşım sil */

?>