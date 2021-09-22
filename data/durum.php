<?php 
ob_start();
session_start();

include '../tkpan/database/baglan.php';
date_default_timezone_set('Europe/Istanbul');

if ($_SESSION['pro_sayfa'] > 0) {
    $pro_sayfa = $_SESSION['pro_sayfa'];
}else {
    $pro_sayfa = 1;
}

$uyecodes = $_SESSION['uye_code'];
/* paylaşım oy ver */


if ($_SESSION['sessizin'] != 1 and strlen($uyecodes) != 30) {
    header('Location:../anasayfa.php?koruma=etkin');
    exit();
}


if ($_GET['b']=="s") {

    $p_kodulistele = $db->prepare("SELECT * from paylasim where paylasim_ozelcode=:pocode and paylasim_code=:paycode");
    $p_kodulistele->execute(array(
    'pocode' => trim(strip_tags($_GET['pod'])),
    'paycode'=> $uyecodes
    ));

    $kodvarmi=$p_kodulistele->rowCount();

if ($kodvarmi > 0) { 
    $pcl=$p_kodulistele->fetch(PDO::FETCH_ASSOC);
    $paylasim_iyi = $pcl['paylasim_iyi'];
    $paylasim_kotu = $pcl['paylasim_kotu'];
    //üye kodu
    $paylasim_code = $uyecodes;
    //icerik_durumdaki paylasim kodu
    $paylasim_ozelcode = trim(strip_tags($_GET['pod']));


    if ($uyecodes==trim(strip_tags($_GET['puc']))) {

if ($paylasim_code && $paylasim_ozelcode) {

        $durumsor=$db->prepare("SELECT * from icerik_durum where icerik_code=:paylasimcode and icerik_oyveren_uye=:uyekodu");
        $durumsor->execute(array(
        'paylasimcode' => $paylasim_ozelcode,
        'uyekodu' => $paylasim_code
        ));

        $sor=$durumsor->rowCount();

        if ($sor > 0) {

            header('Location:../profil.php?c=0&zatenoy=var&sayfa='.$pro_sayfa); 
            exit();

        } else {

            //p_degerli paylasim kategorisine gidecek          
            $p_degerli = $paylasim_iyi + 1;

            //icerik_durum a gidecek 
            $p_iyi = 1;
            $p_kotu = 0;
            $p_spam = 0;

            $i_durum_kayit=$db->prepare("INSERT INTO icerik_durum SET
                icerik_code=:pcode,
                icerik_oyveren_uye=:overen,
                icerik_degerli=:degerli,
                icerik_kotu=:kotu,
                icerik_spam=:spam
                ");
            $kaydet=$i_durum_kayit->execute(array(
                'pcode'=> $paylasim_ozelcode,
                'overen'=> $paylasim_code,
                'degerli'=> $p_iyi,
                'kotu'=> $p_kotu,
                'spam'=> $p_spam   
                ));

            if ($kaydet) {

                $p_id_bul = $db->prepare("SELECT * from paylasim where paylasim_ozelcode=:p_ocode");
                $p_id_bul->execute(array(
                'p_ocode' => $paylasim_ozelcode
                ));

                $p_id_cek=$p_id_bul->fetch(PDO::FETCH_ASSOC);

                $pids = $p_id_cek['paylasim_id'];

                $pd_guncelle=$db->prepare("UPDATE paylasim SET
                    paylasim_iyi=:iyi
                    WHERE paylasim_id=$pids");

                $guncelle=$pd_guncelle->execute(array(
                    'iyi'=> $p_degerli
                    ));

                if ($guncelle) {
                    header('Location:../profil.php?c=0&icerik=begendim&sayfa='.$pro_sayfa); 

                }else {
                    header('Location:../profil.php?c=0&durumkayit=hata&sayfa='.$pro_sayfa); 
                }//else bitiş

            }else {
                header('Location:../profil.php?c=0&durumkayit=hata&sayfa='.$pro_sayfa); 
                exit();
            } //else bitiş

        }

}




    } else {
            header('Location:../profil.php?c=0&hile=v5&sayfa='.$pro_sayfa); 
            exit();
            // hile algılandı, sistemde üye kodu yok
        }//else bitiş


} else {

        header('Location:../profil.php?c=0&hile=v4&sayfa='.$pro_sayfa); 
        exit();
            // hile algılandı, sistemde paylasim kodu yok
        }//else bitiş


//elseif

} elseif ($_GET['d']=="l") {

    $p_kodulistele = $db->prepare("SELECT * from paylasim where paylasim_ozelcode=:pocode");
    $p_kodulistele->execute(array(
    'pocode' => $_GET['pod']
    ));

    $kodvarmi=$p_kodulistele->rowCount();

if ($kodvarmi > 0) { 
    $pcl=$p_kodulistele->fetch(PDO::FETCH_ASSOC);
    $paylasim_iyi = $pcl['paylasim_iyi'];
    $paylasim_kotu = $pcl['paylasim_kotu'];
    //üye kodu
    $paylasim_code = $uyecodes;
    //icerik_durumdaki paylasim kodu
    $paylasim_ozelcode = $_GET['pod'];


    if ($uyecodes==$_GET['puc']) {

if ($paylasim_code && $paylasim_ozelcode) {

        $durumsor=$db->prepare("SELECT * from icerik_durum where icerik_code=:paylasimcode and icerik_oyveren_uye=:uyekodu");
        $durumsor->execute(array(
        'paylasimcode' => $paylasim_ozelcode,
        'uyekodu' => $paylasim_code
        ));

        $sor=$durumsor->rowCount();

        if ($sor > 0) {

            header('Location:../profil.php?c=0&zatenoy=var&sayfa='.$pro_sayfa); 
            exit();

        } else {

            //p_degerli paylasim kategorisine gidecek          
            $p_kotu_icerik = $paylasim_kotu + 1;

            //icerik_durum a gidecek 
            $p_iyi = 0;
            $p_kotu = 1;
            $p_spam = 0;

            $i_durum_kayit=$db->prepare("INSERT INTO icerik_durum SET
                icerik_code=:pcode,
                icerik_oyveren_uye=:overen,
                icerik_degerli=:degerli,
                icerik_kotu=:kotu,
                icerik_spam=:spam
                ");
            $kaydet=$i_durum_kayit->execute(array(
                'pcode'=> $paylasim_ozelcode,
                'overen'=> $paylasim_code,
                'degerli'=> $p_iyi,
                'kotu'=> $p_kotu,
                'spam'=> $p_spam   
                ));

            if ($kaydet) {

                $p_id_bul = $db->prepare("SELECT * from paylasim where paylasim_ozelcode=:p_ocode");
                $p_id_bul->execute(array(
                'p_ocode' => $paylasim_ozelcode
                ));

                $p_id_cek=$p_id_bul->fetch(PDO::FETCH_ASSOC);

                $pids = $p_id_cek['paylasim_id'];

                $pd_guncelle=$db->prepare("UPDATE paylasim SET
                    paylasim_kotu=:kotu
                    WHERE paylasim_id=$pids");

                $guncelle=$pd_guncelle->execute(array(
                    'kotu'=> $p_kotu_icerik
                    ));

                if ($guncelle) {

                    header('Location:../profil.php?c=0&icerik=begenmedim&sayfa='.$pro_sayfa); 

                }else {

                    header('Location:../profil.php?c=0&durumkayit=hata&sayfa='.$pro_sayfa); 
                    
                }//else bitiş

            }else {
                header('Location:../profil.php?c=0&durumkayit=hata&sayfa='.$pro_sayfa); 
                exit();
            } //else bitiş


        }

}




    } else {
            header('Location:../profil.php?c=0&hile=v5&sayfa='.$pro_sayfa); 
            exit();
            // hile algılandı, sistemde üye kodu yok
        }//else bitiş


} else {
        header('Location:../profil.php?c=0&hile=v4&sayfa='.$pro_sayfa); 
        exit();
            // hile algılandı, sistemde paylasim kodu yok
        }//else bitiş



} else {
    header('Location:../profil.php?c=0&hile=v6&sayfa='.$pro_sayfa);
    exit();
    //guvenlik
}//else bitiş
/* paylaşım oy ver */
?>
