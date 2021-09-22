<?php 
ob_start();
session_start();

include '../tkpan/database/baglan.php';
date_default_timezone_set('Europe/Istanbul');

$uyecodes = $_SESSION['uye_code'];
$player_code = trim(strip_tags($_GET['ara']));
$plist = trim(strip_tags($_GET['pod']));



if ($_SESSION['ki_sayisi'] > 0) {
    $ki_sayisi = $_SESSION['ki_sayisi'];
}else {
    $ki_sayisi = 1;
}


if ($_SESSION['kuln_sayfa'] > 0) {
    $kuln_sayfa = $_SESSION['kuln_sayfa'];
}else {
    $kuln_sayfa = 1;
}


if ($_GET['kp']=="2") {
  $adres_satir = 'Location:../kategori-icerik.php?kp=2&sayfa='.$ki_sayisi.'&';
}elseif ($_GET['kp']=="3") {
  $adres_satir = 'Location:../kategori-icerik.php?kp=3&sayfa='.$ki_sayisi.'&';
}elseif ($_GET['kp']=="4") {
  $adres_satir = 'Location:../kategori-icerik.php?kp=4&sayfa='.$ki_sayisi.'&';
}elseif ($_GET['kp']=="5") {
  $adres_satir = 'Location:../kategori-icerik.php?kp=5&sayfa='.$ki_sayisi.'&'; 
}elseif ($_GET['kp']=="6") {
  $adres_satir = 'Location:../kategori-icerik.php?kp=6&sayfa='.$ki_sayisi.'&'; 
}elseif ($_GET['kp']=="7") {
  $adres_satir = 'Location:../kategori-icerik.php?kp=7&sayfa='.$ki_sayisi.'&'; 
}elseif ($_GET['kp']=="8") {
  $adres_satir = 'Location:../kategori-icerik.php?kp=8&sayfa='.$ki_sayisi.'&';   
}elseif ($_GET['kp']=="9") {
  $adres_satir = 'Location:../kategori-icerik.php?kp=9&sayfa='.$ki_sayisi.'&';   
}elseif ($_GET['kp']=="10") {
  $adres_satir = 'Location:../kategori-icerik.php?kp=10&sayfa='.$ki_sayisi.'&';                       
}elseif ($_GET['kp']=="11") {
  $adres_satir = 'Location:../kategori-icerik.php?kp=11&sayfa='.$ki_sayisi.'&';
}elseif ($_GET['kp']=="12") {
  $adres_satir = 'Location:../kategori-icerik.php?kp=12&sayfa='.$ki_sayisi.'&';
}elseif ($_GET['kp']=="13") {
  $adres_satir = 'Location:../kategori-icerik.php?kp=13&sayfa='.$ki_sayisi.'&';  
}elseif ($_GET['kp']=="14") {
  $adres_satir = 'Location:../kategori-icerik.php?kp=14&sayfa='.$ki_sayisi.'&';  
}elseif ($_GET['kp']=="15") {
  $adres_satir = 'Location:../kategori-icerik.php?kp=15&sayfa='.$ki_sayisi.'&';  
}elseif ($_GET['rp']=="1") {
  $adres_satir = 'Location:../kullanici?rp=1&href='.$player_code.'&sayfa='.$kuln_sayfa.'&'; 
}elseif ($_GET['ka']=="1") {
  $adres_satir = 'Location:../anasayfa.php?ka=1&'; 
}elseif ($_GET['pl']=="1") {
  $adres_satir = 'Location:../paylasim-listele.php?pl=1&paylist='.$plist.'&'; 
}else {
  $adres_satir = 'profil?';
}


if ($_SESSION['sessizin'] != 1 and strlen($uyecodes) != 30) {
    header($adres_satir .'koruma=etkin');
    exit();
}


$islem_saat = date('H:i:s');
$islem_tarih = date('d-m-Y');

if ($_GET['b']=="s") {

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


    $p_kodulistele = $db->prepare("SELECT * from paylasim where paylasim_ozelcode=:pocode");
    $p_kodulistele->execute(array(
    'pocode' => trim(strip_tags($_GET['pod']))
    ));

    $kodvarmi=$p_kodulistele->rowCount();

if ($kodvarmi > 0) { 
    $pcl=$p_kodulistele->fetch(PDO::FETCH_ASSOC);
    $paylasim_iyi = $pcl['paylasim_iyi'];
    $paylasim_kotu = $pcl['paylasim_kotu'];
    $paylasim_sahibi = $pcl['paylasim_code'];
    $paylasim_kategori = $pcl['paylasim_kategori'];
    //üye kodu
    $paylasim_code = $uyecodes;
    //icerik_durumdaki paylasim kodu
    $paylasim_ozelcode = trim(strip_tags($_GET['pod']));

    if ($paylasim_kategori == 1) {
        $ark_kontrol = $db->prepare("SELECT * from arkadaslar where arkadas_sahibi=:sahibi and arkadas_kiminle=:kiminle");
        $ark_kontrol->execute(array(
        'sahibi' => $uyecodes,
        'kiminle'=> $paylasim_sahibi
        ));

        $ark_ters_kontrol = $db->prepare("SELECT * from arkadaslar where arkadas_sahibi=:sahibi and arkadas_kiminle=:kiminle");
        $ark_ters_kontrol->execute(array(
        'sahibi' => $paylasim_sahibi,
        'kiminle'=> $uyecodes
        ));

        $arkadas_sor=$ark_kontrol->rowCount();
        $ark_ters=$ark_ters_kontrol->rowCount();

        if ($paylasim_sahibi != $uyecodes) {

            if ($arkadas_sor == 0 and $ark_ters == 0) {

                header($adres_satir.'durum=yetkisiyok');
                exit();

            }
        }

    }


    if ($uyecodes==trim(strip_tags($_GET['puc']))) {

if ($paylasim_code && $paylasim_ozelcode) {

        $durumsor=$db->prepare("SELECT * from icerik_durum where icerik_code=:paylasimcode and icerik_oyveren_uye=:uyekodu");
        $durumsor->execute(array(
        'paylasimcode' => $paylasim_ozelcode,
        'uyekodu' => $paylasim_code
        ));

        $sor=$durumsor->rowCount();

        if ($sor > 0) {

            header($adres_satir.'zatenoy=var');
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

                    $bil_durum = 1;

                    if ($paylasim_sahibi == $uyecodes) {
                            header($adres_satir.'icerik=begendim');
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
                            'kimin'=> $paylasim_sahibi,
                            'gonderen'=> $uyecodes,
                            'icerik'=> $paylasim_ozelcode,
                            'saat'=> $islem_saat,
                            'tarih'=> $islem_tarih,
                            'durum'=> $bil_durum,
                            'codex'=> $bilkod
                            ));

                        if ($bildirim_kayit) {
                            header($adres_satir.'icerik=begendim');
                            exit();
                        }else {
                            header($adres_satir.'durumkayit=hata');
                            exit();
                        }
                    }

                }else {

                    header($adres_satir.'durumkayit=hata');
                    exit();

                }//else bitiş

            }else {

                header($adres_satir.'durumkayit=hata');
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
            // hile algılandı, sistemde paylasim kodu yok

        }//else bitiş


//elseif

} elseif ($_GET['d']=="l") {

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
    

    $p_kodulistele = $db->prepare("SELECT * from paylasim where paylasim_ozelcode=:pocode");
    $p_kodulistele->execute(array(
    'pocode' => trim(strip_tags($_GET['pod']))
    ));

    $kodvarmi=$p_kodulistele->rowCount();

if ($kodvarmi > 0) { 
    $pcl=$p_kodulistele->fetch(PDO::FETCH_ASSOC);
    $paylasim_iyi = $pcl['paylasim_iyi'];
    $paylasim_kotu = $pcl['paylasim_kotu'];
    $paylasim_sahibi = $pcl['paylasim_code'];
    $paylasim_kategori = $pcl['paylasim_kategori'];

    //üye kodu
    $paylasim_code = $uyecodes;
    //icerik_durumdaki paylasim kodu
    $paylasim_ozelcode = trim(strip_tags($_GET['pod']));

    if ($paylasim_kategori == 1) {
        $ark_kontrol = $db->prepare("SELECT * from arkadaslar where arkadas_sahibi=:sahibi and arkadas_kiminle=:kiminle");
        $ark_kontrol->execute(array(
        'sahibi' => $uyecodes,
        'kiminle'=> $paylasim_sahibi
        ));

        $ark_ters_kontrol = $db->prepare("SELECT * from arkadaslar where arkadas_sahibi=:sahibi and arkadas_kiminle=:kiminle");
        $ark_ters_kontrol->execute(array(
        'sahibi' => $paylasim_sahibi,
        'kiminle'=> $uyecodes
        ));

        $arkadas_sor=$ark_kontrol->rowCount();
        $ark_ters=$ark_ters_kontrol->rowCount();

        if ($paylasim_sahibi != $uyecodes) {

            if ($arkadas_sor == 0 and $ark_ters == 0) {

                header($adres_satir.'durum=yetkisiyok');
                exit();

            }
        }
        
    }
    

    if ($uyecodes==trim(strip_tags($_GET['puc']))) {

if ($paylasim_code && $paylasim_ozelcode) {

        $durumsor=$db->prepare("SELECT * from icerik_durum where icerik_code=:paylasimcode and icerik_oyveren_uye=:uyekodu");
        $durumsor->execute(array(
        'paylasimcode' => $paylasim_ozelcode,
        'uyekodu' => $paylasim_code
        ));

        $sor=$durumsor->rowCount();

        if ($sor > 0) {

            header($adres_satir.'zatenoy=var');
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

                    $bil_durum = 2;
                    
                    if ($paylasim_sahibi == $uyecodes) {
                            header($adres_satir.'icerik=begenmedim');
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
                            'kimin'=> $paylasim_sahibi,
                            'gonderen'=> $uyecodes,
                            'icerik'=> $paylasim_ozelcode,
                            'saat'=> $islem_saat,
                            'tarih'=> $islem_tarih,
                            'durum'=> $bil_durum,
                            'codex'=> $bilkod
                            ));

                        if ($bildirim_kayit) {
                            header($adres_satir.'icerik=begenmedim');
                            exit();
                        }else {
                            header($adres_satir.'durumkayit=hata');
                            exit();
                        }
                    }

                    
                }else {

                    header($adres_satir.'durumkayit=hata');
                    exit();

                }//else bitiş

            }else {

                header($adres_satir.'durumkayit=hata');
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

    // hile algılandı, sistemde paylasim kodu yok

    }//else bitiş



} else {
    header($adres_satir.'hile=v6');
    exit();
    
    //guvenlik
}//else bitiş
/* paylaşım oy ver */
?>
