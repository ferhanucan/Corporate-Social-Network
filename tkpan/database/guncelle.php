<?php 
ob_start();
session_start();

include 'baglan.php';

include 'argofiltre.php';


if (isset($_POST['hguncelle'])) {

        $uye_code = $_SESSION['uye_code'];

        $il = trim(strip_tags($_POST['il']));
        $meslek = trim(strip_tags($_POST['meslek-alani']));
        $meslek_detay = trim(strip_tags($_POST['meslek-detay']));
        $is_grup = trim(strip_tags($_POST['is-grup']));


if ($_SESSION['sessizin'] != 1 and strlen($uye_code) != 30) {
    header('Location:../anasayfa?koruma=etkin');
    exit();
}  


$meskox = 100;
$uyeizin=$db->prepare("SELECT * from users where uye_code=:uyeninkodu and uye_meslek_grup=:mesalan");
$uyeizin->execute(array(
'uyeninkodu' => $uye_code,
'mesalan' => $meskox
));
$uye_ziso=$uyeizin->rowCount();

if ($uye_ziso > 0) {
    header('Location:../../hakkinda?guncelleme=kilitli');
    exit();
}


function kelimebul($string){
$trKarakterlerDizisi = array('I'=>'ı', 'İ'=>'i', 'Ü'=>'ü', 'Ş'=>'ş', 'Ç'=>'ç', 'Ğ'=>'ğ'); 
$string = strtr($string, $trKarakterlerDizisi);
$islemyap = mb_convert_case($string,  MB_CASE_LOWER, "UTF-8");
return $islemyap;
}

function bosluksil($string)
{
    $string = preg_replace("/\s+/", " ", $string);
    $string = trim($string);
    return $string;
}


    $kelime_avla1 = bosluksil($meslek_detay);
    $kelime_avla2 = preg_replace('/[^A-Za-z0-9şıöüğçİŞÖĞÜÇ ]/s', '', $kelime_avla1); 
    $kelime_avla3 = yasakkelimeler($kelime_avla2);
    $kelime_avla4 = kelimebul($kelime_avla3);


include 'yasakkelime.php';


if (in_array($kelime_avla4, $yasak_kelimeler)) {
    header('Location:../../hakkinda?yasak=kelimevar');
    exit();
}   



        if ($is_grup == 1) {
            $is_durum ='Çalışmıyor';
            $is_num=1;
        }elseif($is_grup == 2) {
            $is_durum ='Çalışıyor';
            $is_num=2;
        }elseif($is_grup == 3) {
            $is_durum ='İş arıyor';
            $is_num=3;
        }


        if ($meslek == 1) {
             $meslek_ad ='Seçilmedi';
        }elseif ($meslek == 2) {
             $meslek_ad ='Eğitim';
        }elseif ($meslek == 3) {
             $meslek_ad ='Moda';
        }elseif ($meslek == 4) {
             $meslek_ad ='Oyun';
        }elseif ($meslek == 5) {
             $meslek_ad ='Spor';
        }elseif ($meslek == 6) {
             $meslek_ad ='Sağlık';
        }elseif ($meslek == 7) {
             $meslek_ad ='Magazin';
        }elseif ($meslek == 8) {
             $meslek_ad ='Sanayi';
        }elseif ($meslek == 9) {
             $meslek_ad ='Bilim';
        }elseif ($meslek == 10) {
             $meslek_ad ='Bilişim';
        }elseif ($meslek == 11) {
             $meslek_ad ='Teknoloji';
        }elseif ($meslek == 12) {
             $meslek_ad ='Seyahat';
        }elseif ($meslek == 13) {
             $meslek_ad ='Dekorasyon';
        }elseif ($meslek == 14) {
             $meslek_ad ='Ticaret';
        }elseif ($meslek == 15) {
             $meslek_ad ='Eğlence';
        }elseif ($meslek == 16) {
             $meslek_ad ='Müzisyen';
        }elseif ($meslek == 17) {
             $meslek_ad ='Televizyon';
        }elseif ($meslek == 18) {
             $meslek_ad ='Sanat';
        }elseif ($meslek == 19) {
             $meslek_ad ='Finans';
        }elseif ($meslek == 20) {
             $meslek_ad ='Güvenlik';
        }elseif ($meslek == 21) {
             $meslek_ad ='Öğrenci';
        }elseif ($meslek == 22) {
             $meslek_ad ='Diğer';
        }



        if ($il == 1) {
             $ilsec ='Adana';
        }elseif ($il == 2) {
             $ilsec ='Adıyaman';
        }elseif ($il == 3) {
             $ilsec ='Afyonkarahisar';
        }elseif ($il == 4) {
             $ilsec ='Ağrı';
        }elseif ($il == 5) {
             $ilsec ='Amasya';
        }elseif ($il == 6) {
             $ilsec ='Ankara';
        }elseif ($il == 7) {
             $ilsec ='Antalya';
        }elseif ($il == 8) {
             $ilsec ='Artvin';
        }elseif ($il == 9) {
             $ilsec ='Aydın';
        }elseif ($il == 10) {
             $ilsec ='Balıkesir';
        }elseif ($il == 11) {
             $ilsec ='Bilecik';
        }elseif ($il == 12) {
             $ilsec ='Bingöl';
        }elseif ($il == 13) {
             $ilsec ='Bitlis';
        }elseif ($il == 14) {
             $ilsec ='Bolu';
        }elseif ($il == 15) {
             $ilsec ='Burdur';
        }elseif ($il == 16) {
             $ilsec ='Bursa';
        }elseif ($il == 17) {
             $ilsec ='Çanakkale';
        }elseif ($il == 18) {
             $ilsec ='Çankırı';
        }elseif ($il == 19) {
             $ilsec ='Çorum';
        }elseif ($il == 20) {
             $ilsec ='Denizli';
        }elseif ($il == 21) {
             $ilsec ='Diyarbakır';
        }elseif ($il == 22) {
             $ilsec ='Edirne';
        }elseif ($il == 23) {
             $ilsec ='Elazığ';
        }elseif ($il == 24) {
             $ilsec ='Erzincan';
        }elseif ($il == 25) {
             $ilsec ='Erzurum';
        }elseif ($il == 26) {
             $ilsec ='Eskişehir';
        }elseif ($il == 27) {
             $ilsec ='Gaziantep';
        }elseif ($il == 28) {
             $ilsec ='Giresun';
        }elseif ($il == 29) {
             $ilsec ='Gümüşhane';
        }elseif ($il == 30) {
             $ilsec ='Hakkari';
        }elseif ($il == 31) {
             $ilsec ='Hatay';
        }elseif ($il == 32) {
             $ilsec ='Isparta';
        }elseif ($il == 33) {
             $ilsec ='Mersin';
        }elseif ($il == 34) {
             $ilsec ='İstanbul';
        }elseif ($il == 35) {
             $ilsec ='İzmir';
        }elseif ($il == 36) {
             $ilsec ='Kars';
        }elseif ($il == 37) {
             $ilsec ='Kastamonu';
        }elseif ($il == 38) {
             $ilsec ='Kayseri';
        }elseif ($il == 39) {
             $ilsec ='Kırklareli';
        }elseif ($il == 40) {
             $ilsec ='Kırşehir';
        }elseif ($il == 41) {
             $ilsec ='Kocaeli';
        }elseif ($il == 42) {
             $ilsec ='Konya';
        }elseif ($il == 43) {
             $ilsec ='Kütahya';
        }elseif ($il == 44) {
             $ilsec ='Malatya';
        }elseif ($il == 45) {
             $ilsec ='Manisa';
        }elseif ($il == 46) {
             $ilsec ='Kahramanmaraş';
        }elseif ($il == 47) {
             $ilsec ='Mardin';
        }elseif ($il == 48) {
             $ilsec ='Muğla';
        }elseif ($il == 49) {
             $ilsec ='Muş';
        }elseif ($il == 50) {
             $ilsec ='Nevşehir';
        }elseif ($il == 51) {
             $ilsec ='Niğde';
        }elseif ($il == 52) {
             $ilsec ='Ordu';
        }elseif ($il == 53) {
             $ilsec ='Rize';
        }elseif ($il == 54) {
             $ilsec ='Sakarya';
        }elseif ($il == 55) {
             $ilsec ='Samsun';
        }elseif ($il == 56) {
             $ilsec ='Siirt';
        }elseif ($il == 57) {
             $ilsec ='Sinop';
        }elseif ($il == 58) {
             $ilsec ='Sivas';
        }elseif ($il == 59) {
             $ilsec ='Tekirdağ';
        }elseif ($il == 60) {
             $ilsec ='Tokat';
        }elseif ($il == 61) {
             $ilsec ='Trabzon';
        }elseif ($il == 62) {
             $ilsec ='Tunceli';
        }elseif ($il == 63) {
             $ilsec ='Şanlıurfa';
        }elseif ($il == 64) {
             $ilsec ='Uşak';
        }elseif ($il == 65) {
             $ilsec ='Van';
        }elseif ($il == 66) {
             $ilsec ='Yozgat';
        }elseif ($il == 67) {
             $ilsec ='Zonguldak';
        }elseif ($il == 68) {
             $ilsec ='Aksaray';
        }elseif ($il == 69) {
             $ilsec ='Bayburt';
        }elseif ($il == 70) {
             $ilsec ='Karaman';
        }elseif ($il == 71) {
             $ilsec ='Kırıkkale';
        }elseif ($il == 72) {
             $ilsec ='Batman';
        }elseif ($il == 73) {
             $ilsec ='Şırnak';
        }elseif ($il == 74) {
             $ilsec ='Bartın';
        }elseif ($il == 75) {
             $ilsec ='Ardahan';
        }elseif ($il == 76) {
             $ilsec ='Iğdır';
        }elseif ($il == 77) {
             $ilsec ='Yalova';
        }elseif ($il == 78) {
             $ilsec ='Karabük';
        }elseif ($il == 79) {
             $ilsec ='Kilis';
        }elseif ($il == 80) {
             $ilsec ='Osmaniye';
        }elseif ($il == 81) {
             $ilsec ='Düzce';
        }


        if (empty($ilsec) or empty($il) or empty($meslek_ad) or empty($meslek) or empty($meslek_detay)) {

            header('Location:../../hakkinda?hakkinda=boslukvar');
            exit();
        }elseif (strlen(utf8_decode($meslek_detay)) < 3 or strlen(utf8_decode($meslek_detay)) > 30) {
            header('Location:../../hakkinda?hakuz=gecersiz');
            exit();
        }elseif ($il < 1 or $meslek < 1 or $il > 81 or $meslek > 22 or $is_grup < 1 or $is_grup > 3) {
            header('Location:../../hakkinda?hakuz=hata');
            exit();
        }else {

                $hakguncelle=$db->prepare("UPDATE users SET
                    uye_meslek=:meslek,
                    uye_meslek_detay=:meslek_detay,
                    uye_meslek_grup=:grup,
                    uye_il=:il,
                    uye_il_numara=:ilno,
                    uye_is_grup=:is_num,
                    uye_is_durum=:is_durum
                    WHERE uye_code=$uye_code");

                $guncelle=$hakguncelle->execute(array(
                    'meslek'=> $meslek_ad,
                    'meslek_detay'=> yasakkelimeler($meslek_detay),
                    'grup'=> $meslek,
                    'il'=> $ilsec,
                    'ilno'=> $il,
                    'is_num'=> $is_num,
                    'is_durum'=> $is_durum
                    ));
                    

                if ($guncelle) {
                    header('Location:../../hakkinda?guncelleme=basarili');
                    exit();
                } else {
                    header('Location:../../hakkinda?guncelleme=hata');
                    exit();
                    }

                }



} else {
    header('Location:../../hakkinda?guncelleme=hata');
    exit();
}

?>