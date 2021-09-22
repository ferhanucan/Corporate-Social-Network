<?php 
ob_start();
session_start();

include '../tkpan/database/baglan.php';
date_default_timezone_set('Europe/Istanbul');

$mes_alici = trim(strip_tags($_GET['msj-a'])); 
$uye_getms = trim(strip_tags($_GET['msj-b']));
$mes_kodu = trim(strip_tags($_GET['msj-c'])); 

$uyecodes = $_SESSION['uye_code'];

if ($_SESSION['pg_sayfa'] > 0) {
    $mess_sayisi = $_SESSION['pg_sayfa']; 
}else {
    $mess_sayisi = 1;
}


if ($_SESSION['sessizin'] != 1 and strlen($uyecodes) != 30) {
    header('Location:../anasayfa?koruma=etkin');
    exit();
}


if ($_GET['msj-t']=="p") {
    $adres_satir = 'Location:../mesajlar?sy='.$mess_sayisi.'&lp=1&';
}else {
    $adres_satir = 'Location:../mesajlar?sy='.$mess_sayisi.'&lp=1&';
}


if ($_GET['msj-n']=="c" and $_GET['msj-t']=="p") {

    $uye_varmi = $db->prepare("SELECT * from users where uye_code=:procode");
    $uye_varmi->execute(array(
    'procode' => $mes_alici
    ));

    $kodvarmi=$uye_varmi->rowCount();

if ($kodvarmi > 0) {


if ($mes_alici && $uyecodes) {

        $mesajsor=$db->prepare("SELECT * from mesajlar where mesaj_kimin=:kimin and mesaj_alici=:alici and mesaj_code=:codex");
        $mesajsor->execute(array(
        'kimin' => $uyecodes,
        'alici' => $mes_alici,
        'codex' => $mes_kodu
        ));

        $sor=$mesajsor->rowCount();


        $konusmasor=$db->prepare("SELECT * from konusma where konusma_kimin=:kimin and konusma_alici=:alici");
        $konusmasor->execute(array(
        'kimin' => $uyecodes,
        'alici' => $mes_alici
        ));

        $kosor=$konusmasor->rowCount();


        if ($uye_getms!=$uyecodes) {

                    header($adres_satir.'hile=v5');
                    exit();

        }elseif ($sor > 0) {
            $mesaj_listele=$mesajsor->fetch(PDO::FETCH_ASSOC);
            $mesaj_id = $mesaj_listele['id'];

                $mesaj_sil=$db->prepare("DELETE from mesajlar where id=:msj_id");
                $mesaj_silindi=$mesaj_sil->execute(array(
                'msj_id' => $mesaj_id
                ));

                if ($mesaj_silindi) {

                    if ($kosor > 0) {

                        $konusma_sil=$db->prepare("DELETE from konusma where konusma_kimin=:kimin and konusma_alici=:alici");
                        $konusma_silindi=$konusma_sil->execute(array(
                        'kimin' => $uyecodes,
                        'alici' => $mes_alici
                        ));

                        if ($konusma_silindi) {
                            header($adres_satir.'mesajsil=tamam');
                            exit();
                        }else {
                            header($adres_satir.'mesajsil=tamam');
                            exit(); 
                        }
                    }else {
                            header($adres_satir.'mesajsil=tamam'); 
                            exit();
                        }

                }else {
                    header($adres_satir.'mesajsil=hata');
                    exit();
                }
            
        }else {
            header($adres_satir.'boylemesaj=yok'); 
            exit();
        }


} //&&bitiş


//uye varmi sorgusu
} else {

    header($adres_satir.'hile=v4');
    exit();
            // hile algılandı, sistemde paylasim kodu yok
}// kod varmı elsesi bitiş




}else {

    header($adres_satir.'hile=v6');
    exit();

    //guvenlik
}//GET U=E bitis


?>














