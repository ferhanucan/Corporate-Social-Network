<?php 
ob_start();
session_start();

include '../database/baglan.php';
date_default_timezone_set('Europe/Istanbul');

include 'filtre.php';

ini_set('memory_limit','256M');
ini_set('post_max_size', '20M');
ini_set('max_execution_time', 600);

if (isset($_POST['fotograf_paylas'])) {

        $pc1=rand(10000,99000);    

        $pc2=rand(10000,99000);

        $pc3=rand(10000,99000);

        $pc4=rand(10000,99000);

        $pc5=rand(10000,99000);

        $pc6=rand(10000,99000);

        $benzersiz_pcode= $pc1.$pc2.$pc3.$pc4.$pc5.$pc6;
        $foto_kodu = $benzersiz_pcode;


        $uye_kodu = $_SESSION['uye_code'];


if ($_SESSION['sessizin'] != 1 and strlen($uye_kodu) != 30) {
    header('Location:../anasayfa?koruma=etkin');
    exit();
}  


        $yazi_1 = strip_tags($_POST['foto_text']);
        $yazi_2 = stripslashes($yazi_1);
        $yazi_3 = trim($yazi_2);
        $yazi_4 = htmlspecialchars_decode($yazi_3, ENT_COMPAT);

        $yazi_5 = htmlentities($yazi_4);

        function replaceSpace($string)
        {
          $string = preg_replace("/\s+/", " ", $string);
          $string = trim($string);
          return $string;
        }

        $yazi_6 = replaceSpace($yazi_5);

        $yazi = str_replace(array("\r\n", "\n\r", "\r", "\n"), "", $yazi_6);


        $saat = date('H:i');
        $tarih = date('d-m-Y');
        $foto_begeni = 0;

        $foto_adi = $_FILES['foto_yukle']["name"];
        

        if (strlen(utf8_decode($yazi_1)) > 30) {
            header('Location:../../fotograflar?uzunluk=gecersiz');
            $yukle_koruma = 0;
            exit();
        }elseif ($_SESSION['sonfoto'] === $foto_adi) {
            header('Location:../../fotograflar?foto=zatenyukledin');
            $yukle_koruma = 0;
            exit();
        }else {
            $yukle_koruma = 1;
        }


if ($_FILES['foto_yukle']["size"] > 0) { //resim varsa


    $resimyolu = '../../yimg/galeri';

    $tmp_name = $_FILES['foto_yukle']["tmp_name"];

    $name = $_FILES['foto_yukle']["name"];


    $izinli_uzantilar = array("jpeg", "pjpeg",  "x-png", "png", "jpg");
    $jpg_array = array("jpeg", "pjpeg", "jpg");
    $png_array = array("x-png", "png");

    function uzanti($name) {
    $uzanti = pathinfo($name);
    $uzanti = $uzanti["extension"];
    return $uzanti;
    }
    $uzanti = uzanti($name);

    if (!in_array($uzanti, $izinli_uzantilar)) {
        header('Location:../../fotograflar?fotoformat=gecersiz');
        exit();
    }elseif (round($_FILES['foto_yukle']["size"] / 1024) > 8192) {
        header('Location:../../fotograflar?foto=buyuk');
        exit();
    }elseif ($yukle_koruma != 1) {
        header('Location:../../fotograflar?fotoyukle=olmadi');
        exit();
    }else {
        $foto_yukle_var = 1;
    }

        if (in_array($uzanti, $izinli_uzantilar) === true) {

            $benzersizsayi1=rand(10000,99000);

            $benzersizsayi2=rand(10000,99000);

            $benzersizsayi3=rand(10000,99000);

            $benzersizsayi4=rand(10000,99000);

            $benzersizad=$benzersizsayi1.$benzersizsayi2.$benzersizsayi3.$benzersizsayi4;


            if (move_uploaded_file($tmp_name, $resimyolu."/".$name)) {

                $dosya = $resimyolu."/".$name;

                list($resim_genislik, $resim_yukseklik) = getimagesize($dosya);

                $oran = 1;

                $dikey = $oran * $resim_yukseklik;
                $yatay = $oran * $resim_genislik;



                $hedef = imagecreatetruecolor($yatay, $dikey);



                if (in_array($uzanti, $png_array) === true) {

                    $kaynak = imagecreatefrompng($dosya);

                }elseif (in_array($uzanti, $jpg_array) === true) {

                    $kaynak = imagecreatefromjpeg($dosya);

                }else {
                    header('Location:../../fotograflar?fotoformat=gecersiz');
                    exit();
                }

                
                //dst_x, dst_y, src_x, src_y = ilk resim üstten ve soldan sıfırlıyoruz src 2. resim sol ve üst değerleri x üst y sol demek
                imagecopyresampled($hedef, $kaynak, 0, 0, 0, 0, $yatay, $dikey, $resim_genislik, $resim_yukseklik);


                $yeni_resim_yol=$resimyolu."/{$benzersizad}.jpg";
                $foto_resim_yol="yimg/galeri/{$benzersizad}.jpg";


                imagejpeg($hedef,$yeni_resim_yol,60);

                imagedestroy($hedef);
                
                if (unlink($dosya)) {

                        $paylas=$db->prepare("INSERT INTO fotograf SET
                            foto_uye_code=:upocod,
                            foto_code=:foc,
                            foto_text=:yazi,
                            foto_begeni=:fotobeg,
                            foto_resim_yol=:foresyol,
                            foto_saat=:saat,
                            foto_tarih=:tarih
                            
                            ");
                        $kaydet=$paylas->execute(array(
                            'upocod'=> $uye_kodu,
                            'foc'=> $foto_kodu,
                            'yazi'=> mt($yazi),
                            'fotobeg'=> $foto_begeni,
                            'foresyol'=> $foto_resim_yol,
                            'saat'=> $saat,
                            'tarih'=> $tarih
                            
                            ));
                        if ($kaydet) {
                            
                                $_SESSION['sonfoto'] = $name;
                                header('Location:../../fotograflar.php?yukle=tamam');
                            } else {
                                header('Location:../../fotograflar?yukle=olmadi');
                                exit();
                            }


                    
                }else { //unlink
                    header('Location:../../fotograflar?yukle=olmadi');
                    exit();
                }

            }else { //move
                header('Location:../../fotograflar?yukle=olmadi');
                exit();
            }
        //jpg ve png bitiş
        }else { //izinli uzanti
            header('Location:../../fotograflar?yukle=olmadi');
            exit();
        }
}else {
    //resim yoksa
    header('Location:../../fotograflar?yukle=fotoyok');
    exit();
}

//güvenlik
}else {
    header('Location:../../fotograflar?yukle=olmadi');
    exit();
}

?>