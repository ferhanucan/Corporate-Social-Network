<?php 
ob_start();
session_start();

include '../database/baglan.php';
date_default_timezone_set('Europe/Istanbul');

include 'filtre.php';


ini_set('memory_limit','256M');
ini_set('post_max_size', '20M');
ini_set('max_execution_time', 600);


if (isset($_POST['paylasim_yap'])) {

    $pc1=rand(10000,99000);    

    $pc2=rand(10000,99000);

    $pc3=rand(10000,99000);

    $pc4=rand(10000,99000);

    $pc5=rand(10000,99000);

    $pc6=rand(10000,99000);

    $pc7=rand(10000,99000);

    $pc8=rand(10000,99000);

    $pc9=rand(10000,99000);

    $benzersiz_pcode= $pc1.md5($pc2).$pc3.md5($pc4).$pc5.md5($pc6).$pc7.md5($pc8).$pc9;
    $pakod = $benzersiz_pcode;


    $paylasim_kodu = $_SESSION['uye_code'];


    if ($_SESSION['sessizin'] != 1 and strlen($paylasim_kodu) != 30) {
        header('Location:../anasayfa.php?koruma=etkin');
        exit();
    }  


    $uyecodecek=$db->prepare("SELECT * from users where uye_code=:code");
    $uyecodecek->execute(array(
        'code' => $paylasim_kodu
    ));

    $uye_islem=$uyecodecek->fetch(PDO::FETCH_ASSOC);

    $ad = $uye_islem['uye_ad']; $soyad = $uye_islem['uye_soyad'];
    $paylasim_adsoyad = $ad." ".$soyad; 

    
    $paylasim_meslek = $uye_islem['uye_meslek'];
    $meslek_grup = $uye_islem['uye_meslek_grup'];
    $paylasim_profil_kodu = $uye_islem['uye_profil_code'];
    $kategori = trim(strip_tags($_POST['kategori']));
    $videoid = trim(strip_tags($_POST['videoid']));
    $paylasim_iyi = 0;
    $paylasim_kotu = 0;
    $paylasim_spam = 0;
    $paylasim_saat = date('H:i:s');
    $paylasim_tarih = date('d-m-Y');

    $yazi_1 = strip_tags($_POST['yazi']);
    $yazi_2 = stripslashes($yazi_1);
    $yazi_3 = trim($yazi_2);
    $yazi_4 = htmlspecialchars_decode($yazi_3, ENT_COMPAT);

    $yazi_5 = htmlentities($yazi_4);

    $yazi = preg_replace("/[\r\n]+/", "\r\n", $yazi_5);

    if ($kategori == 1) {
       $paylasim_yeri ='Profil';
   }elseif ($kategori == 2) {
       $paylasim_yeri ='Haber';
   }elseif ($kategori == 3) {
       $paylasim_yeri ='Spor';
   }elseif ($kategori == 4) {
       $paylasim_yeri ='Magazin';
   }elseif ($kategori == 5) {
       $paylasim_yeri ='Moda';
   }elseif ($kategori == 6) {
       $paylasim_yeri ='Oyun';
   }elseif ($kategori == 7) {
       $paylasim_yeri ='Eğitim';
   }elseif ($kategori == 8) {
       $paylasim_yeri ='Sağlık';
   }elseif ($kategori == 9) {
       $paylasim_yeri ='Televizyon';
   }elseif ($kategori == 10) {
       $paylasim_yeri ='Bilim';
   }elseif ($kategori == 11) {
       $paylasim_yeri ='Müzik';
   }elseif ($kategori == 12) {
       $paylasim_yeri ='Teknoloji';
   }elseif ($kategori == 13) {
       $paylasim_yeri ='Bilişim';
   }elseif ($kategori == 14) {
       $paylasim_yeri ='Mutfak';
   }elseif ($kategori == 15) {
       $paylasim_yeri ='Tasarım';
   }


   if (empty($yazi_1) or empty($kategori)) {
    header('Location:../../profil.php?bos=birakma');
    $paylasim_koruma = 0;
    exit();
}elseif (strlen(utf8_decode($yazi_1)) < 1 or strlen(utf8_decode($yazi_1)) > 250 or $kategori < 1 or $kategori > 15) {
    header('Location:../../profil.php?uzunluk=gecersiz');
    $paylasim_koruma = 0;
    exit();
}elseif ($_SESSION['sonyazi'] === $yazi_1) {
    header('Location:../../profil.php?acele=etme');
    $paylasim_koruma = 0;
    exit();
}else {
    $paylasim_koruma = 1;
}



if ($_FILES['paylasim_resim']["size"] > 0) { //resim varsa


    $resimyolu = '../../yimg/paylasim';

    $tmp_name = $_FILES['paylasim_resim']["tmp_name"];

    $name = $_FILES['paylasim_resim']["name"];


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
        header('Location:../../profil.php?format=gecersiz');
        exit();
    }elseif (round($_FILES['paylasim_resim']["size"] / 1024) > 8192) {
        header('Location:../../profil.php?resim=buyuk');
        exit();
    }elseif ($paylasim_koruma != 1) {
        header('Location:../../profil.php?paylasim=olmadi');
        exit();
    }else {
        $paylasim_resim_var = 1;
        $paylasim_video_varmi = 0;
        $paylasim_video = 'Video-yok';
    }

    if (in_array($uzanti, $izinli_uzantilar) === true) {

        $benzersizsayi1=rand(20000,32000);

        $benzersizsayi2=rand(20000,32000);

        $benzersizsayi3=rand(20000,32000);

        $benzersizsayi4=rand(20000,32000);

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
                header('Location:../../profil.php?format=gecersiz');
                exit();
            }

            
                //dst_x, dst_y, src_x, src_y = ilk resim üstten ve soldan sıfırlıyoruz src 2. resim sol ve üst değerleri x üst y sol demek
            imagecopyresampled($hedef, $kaynak, 0, 0, 0, 0, $yatay, $dikey, $resim_genislik, $resim_yukseklik);


            $yeni_resim_yol=$resimyolu."/{$benzersizad}.jpg";
            $reklam_resim_yol="yimg/paylasim/{$benzersizad}.jpg";


            imagejpeg($hedef,$yeni_resim_yol,60);

            imagedestroy($hedef);
            
            if (unlink($dosya)) {


                $paylas=$db->prepare("INSERT INTO paylasim SET
                    paylasim_code=:pcode,
                    paylasim_ozelcode=:poc,
                    paylasim_profil_code=:ppc,
                    paylasim_adsoyad=:adsoyad,
                    paylasim_meslekadi=:meslekadi,
                    paylasim_meslek_grup=:meslek_grup,
                    paylasim_text=:yazi,
                    paylasim_resim=:presim,
                    paylasim_resim_varmi=:presvarmi,
                    paylasim_video=:pvideo,
                    paylasim_video_varmi=:pvidvarmi,
                    paylasim_saat=:saat,
                    paylasim_tarih=:tarih,
                    paylasim_yeri=:yeri,
                    paylasim_kategori=:kategori,
                    paylasim_iyi=:iyi,
                    paylasim_kotu=:kotu,
                    paylasim_spam=:spam
                    
                    ");
                $kaydet=$paylas->execute(array(
                    'pcode'=> $paylasim_kodu,
                    'poc'=> $pakod,
                    'ppc'=> $paylasim_profil_kodu,
                    'adsoyad'=> $paylasim_adsoyad,
                    'meslekadi'=> $paylasim_meslek,
                    'meslek_grup'=> $meslek_grup,
                    'yazi'=> mt($yazi),
                    'presim'=> $reklam_resim_yol,
                    'presvarmi'=> $paylasim_resim_var,
                    'pvideo'=> $paylasim_video,
                    'pvidvarmi'=> $paylasim_video_varmi,
                    'saat'=> $paylasim_saat,
                    'tarih'=> $paylasim_tarih,
                    'yeri'=> $paylasim_yeri,
                    'kategori'=> $kategori,
                    'iyi'=> $paylasim_iyi,
                    'kotu'=> $paylasim_kotu,
                    'spam'=> $paylasim_spam
                    
                ));
                if ($kaydet) {

                    $_SESSION['sonyazi'] = $yazi_1;

                    /* metin bastır */
                    function replaceSpace($string) {
                        $string = preg_replace("/\s+/", " ", $string);
                        $string = trim($string);
                        return $string;
                    }

                    $kayityazi1 = replaceSpace(mt($yazi_3));
                    $kayityazi2 = str_replace("\r\n",'', $kayityazi1);



                    $dosya_ismi = $paylasim_adsoyad.' - '.$uye_islem['uye_referans_code'];

                    if(file_exists('paylasim-kayit/'.$dosya_ismi.'.txt')) {
                        $myfile = fopen('paylasim-kayit/'.$dosya_ismi.'.txt', "a");
                        $txt = 'Paylaşım sahibi : '.$paylasim_adsoyad.' (Saat : '.$paylasim_saat.' Tarih : '.$paylasim_tarih.') Referans : '.$uye_islem['uye_referans_code'].' / Meslek : '.$paylasim_meslek.'
                        Kategori : '.$paylasim_yeri.'
                        Yazı : '.$kayityazi2.' 
                        Resim : '.$reklam_resim_yol.'
                        Video : Video-yok
                        -----------------
                        ';
                        fwrite($myfile, $txt);
                        fclose($myfile);
                    } else {
                        $myfile = fopen('paylasim-kayit/'.$dosya_ismi.'.txt', "w");
                        $txt = 'Paylaşım sahibi : '.$paylasim_adsoyad.' (Saat : '.$paylasim_saat.' Tarih : '.$paylasim_tarih.') Referans : '.$uye_islem['uye_referans_code'].' / Meslek : '.$paylasim_meslek.'
                        Kategori : '.$paylasim_yeri.'
                        Yazı : '.$kayityazi2.' 
                        Resim : '.$reklam_resim_yol.'
                        Video : Video-yok
                        -----------------
                        ';
                        fwrite($myfile, $txt);
                        fclose($myfile);
                    }
                    /* /metin bastır */

                    header('Location:../../anasayfa.php?paylasim=tamam');
                    exit();

                } else {
                    header('Location:../../profil.php?paylasim=olmadi');
                    exit();
                }


                
                }else { //unlink
                    header('Location:../../profil.php?paylasim=olmadi');
                    exit();
                }

            }else { //move
                header('Location:../../profil.php?paylasim=olmadi');
                exit();
            }
        //jpg ve png bitiş
        }else { //izinli uzanti
            header('Location:../../profil.php?paylasim=olmadi');
            exit();
        }

}else { //resim yoksa
    $paylasim_resim_var = 0;
    $reklam_resim_yol = 'Resim-yok';
    
    if (strlen($videoid) == 11) {
        $paylasim_video_varmi = 1;
        $paylasim_video = $videoid;
    }else {
        $paylasim_video_varmi = 0;
        $paylasim_video = 'Video-yok';   
    }


    $paylas=$db->prepare("INSERT INTO paylasim SET
        paylasim_code=:pcode,
        paylasim_ozelcode=:poc,
        paylasim_profil_code=:ppc,
        paylasim_adsoyad=:adsoyad,
        paylasim_meslekadi=:meslekadi,
        paylasim_meslek_grup=:meslek_grup,
        paylasim_text=:yazi,
        paylasim_resim=:presim,
        paylasim_resim_varmi=:presvarmi,
        paylasim_video=:pvideo,
        paylasim_video_varmi=:pvidvarmi,
        paylasim_saat=:saat,
        paylasim_tarih=:tarih,
        paylasim_yeri=:yeri,
        paylasim_kategori=:kategori,
        paylasim_iyi=:iyi,
        paylasim_kotu=:kotu,
        paylasim_spam=:spam
        
        ");
    $kaydet=$paylas->execute(array(
        'pcode'=> $paylasim_kodu,
        'poc'=> $pakod,
        'ppc'=> $paylasim_profil_kodu,
        'adsoyad'=> $paylasim_adsoyad,
        'meslekadi'=> $paylasim_meslek,
        'meslek_grup'=> $meslek_grup,
        'yazi'=> mt($yazi),
        'presim'=> $reklam_resim_yol,
        'presvarmi'=> $paylasim_resim_var,
        'pvideo'=> $paylasim_video,
        'pvidvarmi'=> $paylasim_video_varmi,
        'saat'=> $paylasim_saat,
        'tarih'=> $paylasim_tarih,
        'yeri'=> $paylasim_yeri,
        'kategori'=> $kategori,
        'iyi'=> $paylasim_iyi,
        'kotu'=> $paylasim_kotu,
        'spam'=> $paylasim_spam
        
    ));
    if ($kaydet) {

        $_SESSION['sonyazi'] = $yazi_1;

        /* metin bastır */
        function replaceSpace($string) {
            $string = preg_replace("/\s+/", " ", $string);
            $string = trim($string);
            return $string;
        }

        $kayityazi1 = replaceSpace(mt($yazi_3));
        $kayityazi2 = str_replace("\r\n",'', $kayityazi1);



        $dosya_ismi = $paylasim_adsoyad.' - '.$uye_islem['uye_referans_code'];

        if(file_exists('paylasim-kayit/'.$dosya_ismi.'.txt')) {
            $myfile = fopen('paylasim-kayit/'.$dosya_ismi.'.txt', "a");
            $txt = 'Paylaşım sahibi : '.$paylasim_adsoyad.' (Saat : '.$paylasim_saat.' Tarih : '.$paylasim_tarih.') Referans : '.$uye_islem['uye_referans_code'].' / Meslek : '.$paylasim_meslek.'
            Kategori : '.$paylasim_yeri.'
            Yazı : '.$kayityazi2.' 
            Resim : Resim-yok
            Video : '.$paylasim_video.'
            -----------------
            ';
            fwrite($myfile, $txt);
            fclose($myfile);
        } else {
            $myfile = fopen('paylasim-kayit/'.$dosya_ismi.'.txt', "w");
            $txt = 'Paylaşım sahibi : '.$paylasim_adsoyad.' (Saat : '.$paylasim_saat.' Tarih : '.$paylasim_tarih.') Referans : '.$uye_islem['uye_referans_code'].' / Meslek : '.$paylasim_meslek.'
            Kategori : '.$paylasim_yeri.'
            Yazı : '.$kayityazi2.' 
            Resim : Resim-yok
            Video : '.$paylasim_video.'
            -----------------
            ';
            fwrite($myfile, $txt);
            fclose($myfile);
        }
        /* /metin bastır */

        header('Location:../../anasayfa.php?paylasim=tamam');
        exit();

    } else {
        header('Location:../../profil.php?paylasim=olmadi');
        exit();
    }

}







}else {
    header('Location:../../profil.php?paylasim=olmadi');
    exit();
}

?>