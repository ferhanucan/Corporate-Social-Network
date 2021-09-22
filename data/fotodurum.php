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

$uyecodes = $_SESSION['uye_code'];


if ($_SESSION['sessizin'] != 1 and strlen($uyecodes) != 30) {
    header('Location:../anasayfa?koruma=etkin');
    exit();
}

/* paylaşım oy ver */

if ($_GET['fo']=="be") {

    $p_kodulistele = $db->prepare("SELECT * from fotograf where foto_code=:pocode and foto_uye_code=:fouyco");
    $p_kodulistele->execute(array(
    'pocode' => trim(strip_tags($_GET['foc'])),
    'fouyco' => $uyecodes
    ));

    $kodvarmi=$p_kodulistele->rowCount();

if ($kodvarmi > 0) { 
    $pcl=$p_kodulistele->fetch(PDO::FETCH_ASSOC);
    $foto_begeni_sayisi = $pcl['foto_begeni'];
    //üye kodu
    $oyveren_uye = $uyecodes;
    //icerik_durumdaki paylasim kodu
    $foto_code = trim(strip_tags($_GET['foc']));


    if ($uyecodes==trim(strip_tags($_GET['ftuyc']))) {

if ($oyveren_uye && $foto_code) {

        $durumsor=$db->prepare("SELECT * from fotograf_durum where foto_code=:foco and foto_oyveren_uye=:fouye");
        $durumsor->execute(array(
        'foco' => $foto_code,
        'fouye' => $oyveren_uye
        ));

        $sor=$durumsor->rowCount();

        if ($sor > 0) {

            header('Location:../fotograflar?foto=1&fotobegeni=var&sayfa='.$pro_sayfa); 
            exit();

        } else {

            //begeni foto kategorisine gidecek          
            $foto_begeni_guncelle = $foto_begeni_sayisi + 1;

            //foto_durum a gidecek 
            $foto_durum = 1;

            $i_durum_kayit=$db->prepare("INSERT INTO fotograf_durum SET
                foto_code=:pcode,
                foto_oyveren_uye=:overen,
                foto_durum=:drm
                ");
            $kaydet=$i_durum_kayit->execute(array(
                'pcode'=> $foto_code,
                'overen'=> $oyveren_uye,
                'drm'=> $foto_durum  
                ));

            if ($kaydet) {

                $pd_guncelle=$db->prepare("UPDATE fotograf SET
                    foto_begeni=:iyi
                    WHERE foto_code=$foto_code");

                $guncelle=$pd_guncelle->execute(array(
                    'iyi'=> $foto_begeni_guncelle
                    ));

                if ($guncelle) {
                    header('Location:../fotograflar?foto=1&fotobegeni=begendim&sayfa='.$pro_sayfa); 
                    exit();

                }else {
                    header('Location:../fotograflar?foto=1&fotobegeni=hata&sayfa='.$pro_sayfa); 
                    exit();
                }//else bitiş

            }else {
                header('Location:../fotograflar?foto=1&fotobegeni=hata&sayfa='.$pro_sayfa); 
                exit();
            } //else bitiş

        }

}




    } else {
            header('Location:../fotograflar?foto=1&hile=v5&sayfa='.$pro_sayfa); 
            exit();
            // hile algılandı, sistemde üye kodu yok
        }//else bitiş


} else {

        header('Location:../fotograflar?foto=1&hile=v4&sayfa='.$pro_sayfa); 
        exit();
            // hile algılandı, sistemde paylasim kodu yok
        }//else bitiş


//elseif

} else {
    header('Location:../fotograflar?foto=1&hile=v6&sayfa='.$pro_sayfa);
    exit();
    //guvenlik
}//else bitiş
/* paylaşım oy ver */
?>
