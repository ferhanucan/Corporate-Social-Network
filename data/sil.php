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

/* paylaşım sil */
$uyecodes = $_SESSION['uye_code'];


if ($_SESSION['sessizin'] != 1 and strlen($uyecodes) != 30) {
    header('Location:../anasayfa?koruma=etkin');
    exit();
}


if ($_GET['l']=="k") {


    $p_kodulistele = $db->prepare("SELECT * from paylasim where paylasim_ozelcode=:pocode and paylasim_code=:paycode");
    $p_kodulistele->execute(array(
    'pocode' => trim(strip_tags($_GET['pod'])),
    'paycode'=> $uyecodes
    ));

    $kodvarmi=$p_kodulistele->rowCount();

        if ($kodvarmi > 0) {

            $pcl=$p_kodulistele->fetch(PDO::FETCH_ASSOC);

            $paid = $pcl['paylasim_id'];

            $pa_uco = $pcl['paylasim_code'];

            $pa_res_varmi = $pcl['paylasim_resim_varmi'];

            $pa_resim = $pcl['paylasim_resim'];

            $alve = trim(strip_tags($_GET['pod']));


    if ($uyecodes==trim(strip_tags($_GET['puc']))) {

            $sil=$db->prepare("DELETE from paylasim where paylasim_id=:p_id");
            $delete=$sil->execute(array(
            'p_id' => $paid
            ));

            if ($delete) {

            $durum_sor = $db->prepare("SELECT * from icerik_durum where icerik_code=:icdurvarmi");
            $durum_sor->execute(array(
            'icdurvarmi' => $alve
            ));

            $durumlar_varmi=$durum_sor->rowCount();

            if ($durumlar_varmi > 0) {
                //durum beğeni varsa sil
                $paylasim_durum_sil=$db->prepare("DELETE from icerik_durum where icerik_code=:ic");
                $durumlar_silindi=$paylasim_durum_sil->execute(array(
                'ic' => $alve
                ));

                if ($durumlar_silindi) {
                    $skytvarmi = $db->prepare("SELECT * from sikayet where sikayet_paylasim=:sikayetvarmi");
                    $skytvarmi->execute(array(
                    'sikayetvarmi' => $alve
                    ));

                    $sikayet_varmi=$skytvarmi->rowCount();

                    if ($sikayet_varmi > 0) {
                        //sikayet varsa
                        $sikayet_sil=$db->prepare("DELETE from sikayet where sikayet_paylasim=:spyl");
                        $sikayetler=$sikayet_sil->execute(array(
                        'spyl' => $alve
                        ));

                        if ($sikayetler) {
                            if ($pa_res_varmi == 1) {
                                $resimsilunlink=$pa_resim;
                                unlink("../$resimsilunlink");
                                }
                            header('Location:../profil?sil=oldu&c=0&sayfa='.$pro_sayfa);
                        }else {
                            header('Location:../profil?sil=hata&c=0&sayfa='.$pro_sayfa);
                            exit();
                        }

                    }else {
                        //şikayet yoksa buradan
                            if ($pa_res_varmi == 1) {
                                $resimsilunlink=$pa_resim;
                                unlink("../$resimsilunlink");
                                }
                            header('Location:../profil?sil=oldu&c=0&sayfa='.$pro_sayfa);
                    }

                }else {
                    //durumlar silinemedi
                    header('Location:../profil?sil=hata&c=0&sayfa='.$pro_sayfa);
                    exit();
                }


            }else {
                //durum yoksa buradan
                    $skytvarmi = $db->prepare("SELECT * from sikayet where sikayet_paylasim=:sikayetvarmi");
                    $skytvarmi->execute(array(
                    'sikayetvarmi' => $alve
                    ));

                    $sikayet_varmi=$skytvarmi->rowCount();

                    if ($sikayet_varmi > 0) {
                        //sikayet varsa
                        $sikayet_sil=$db->prepare("DELETE from sikayet where sikayet_paylasim=:spyl");
                        $sikayetler=$sikayet_sil->execute(array(
                        'spyl' => $alve
                        ));

                        if ($sikayetler) {
                            if ($pa_res_varmi == 1) {
                                $resimsilunlink=$pa_resim;
                                unlink("../$resimsilunlink");
                                }
                            header('Location:../profil?sil=oldu&c=0&sayfa='.$pro_sayfa);
                        }else {
                            header('Location:../profil?sil=hata&c=0&sayfa='.$pro_sayfa);
                            exit();
                        }

                    }else {
                        //şikayet yoksa buradan
                            if ($pa_res_varmi == 1) {
                                $resimsilunlink=$pa_resim;
                                unlink("../$resimsilunlink");
                                }
                            header('Location:../profil?sil=oldu&c=0&sayfa='.$pro_sayfa);
                    }

            }//durum else bitiş







            } else {
                // paylaşımı silemezse
                header('Location:../profil?sil=hata&c=0&sayfa='.$pro_sayfa);
                exit();
            }



    } else {
        // kullanıcı id eşleşmiyor
        header('Location:../profil?id=yok&c=0&sayfa='.$pro_sayfa);
        exit();
    }


        }else {
            // kod sistemde yok
            header('Location:../profil?kod=yok&c=0&sayfa='.$pro_sayfa);
            exit();
        }



} else {
    header('Location:../profil?hile=v6&c=0&sayfa='.$pro_sayfa);
    exit();
}

/* /paylaşım sil */

?>