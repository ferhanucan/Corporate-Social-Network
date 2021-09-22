<?php 
ob_start();
session_start();

include '../tkpan/database/baglan.php';
date_default_timezone_set('Europe/Istanbul');


$mes_alici = trim(strip_tags($_GET['msj-a']));
$uye_getms = trim(strip_tags($_GET['msj-b']));
$mes_kodu = trim(strip_tags($_GET['msj-c']));

$uyecodes = $_SESSION['uye_code'];


if ($_SESSION['sessizin'] != 1 and strlen($uyecodes) != 30) {
    header('Location:../anasayfa?koruma=etkin');
    exit();
}


if ($_GET['kp']=="2") {
    $adres_kp = 'xp=2';
}elseif ($_GET['kp']=="3") {
    $adres_kp = 'xp=3';
}elseif ($_GET['kp']=="4") {
    $adres_kp = 'xp=4';
}elseif ($_GET['kp']=="5") {
    $adres_kp = 'xp=5';
}elseif ($_GET['kp']=="6") {
    $adres_kp = 'xp=6';
}elseif ($_GET['kp']=="7") {
    $adres_kp = 'xp=7';
}elseif ($_GET['kp']=="8") {
    $adres_kp = 'xp=8';
}elseif ($_GET['kp']=="9") {
    $adres_kp = 'xp=9';
}elseif ($_GET['kp']=="10") {
    $adres_kp = 'xp=10';
}elseif ($_GET['kp']=="11") {
    $adres_kp = 'xp=11';
}elseif ($_GET['kp']=="12") {
    $adres_kp = 'xp=12';
}elseif ($_GET['kp']=="13") {
    $adres_kp = 'xp=13';
}elseif ($_GET['kp']=="14") {
    $adres_kp = 'xp=14';
}elseif ($_GET['kp']=="15") {
    $adres_kp = 'xp=15';
}elseif ($_GET['kp']=="0") {
    $adres_kp = 'xp=0';
}elseif ($_GET['ci']=="1") {
    $adres_kp = 'ci=1';
}elseif ($_GET['ci']=="2") {
    $adres_kp = 'ci=2';
}elseif ($_GET['ci']=="3") {
    $adres_kp = 'ci=3';
}elseif ($_GET['ci']=="4") {
    $adres_kp = 'ci=4';
}elseif ($_GET['ci']=="5") {
    $adres_kp = 'ci=5';
}else {
    $adres_kp = 'xp=0'; 
}


if ($_SESSION['bil_sayisi'] > 0) {
    $bsayf = $_SESSION['bil_sayisi']; 
}else {
    $bsayf = 1; 
}


if ($_GET['msj-k']=="v" and $_GET['msj-z']=="e") {
    if ($mes_alici > 0 and $uye_getms > 0 and $mes_kodu > 0) {
        $get_guvenlik = 1;
    }else {
        $get_guvenlik = 0;
    }
}elseif ($_GET['msj-g']=="n" and $_GET['msj-u']=="a") {
     if ($mes_alici > 0) {
        $get_guvenlik = 1;
    }else {
        $get_guvenlik = 0;
    }   
}elseif ($_GET['msj-j']=="c" and $_GET['msj-s']=="a") {
     if ($mes_alici > 0) {
        $get_guvenlik = 1;
    }else {
        $get_guvenlik = 0;
    }   
}



if ($_GET['klx']=="1") {
    $kull_adres = 'Location:../kullanici';
    $mt = 'mt=1';
}elseif ($_GET['klx']=="2") {
    $kull_adres = 'Location:../kullanici-mesaj';
    $mt = 'mt=2';
}elseif ($_GET['klx']=="3") {
    $kull_adres = 'Location:../kullanici-hakkinda';
    $mt = 'mt=3';
}elseif ($_GET['klx']=="4") {
    $kull_adres = 'Location:../bize-bildir';
    $mt = 'mt=4';
}



//arkadaş sor

$ark_kontrol = $db->prepare("SELECT * from arkadaslar where arkadas_sahibi=:sahibi and arkadas_kiminle=:kiminle");
$ark_kontrol->execute(array(
'sahibi' => $uyecodes,
'kiminle'=> $mes_alici
));

$uyeyi_bul = $db->prepare("SELECT * from users where uye_code=:ucode");
$uyeyi_bul->execute(array(
'ucode' => $mes_alici
));

$arkadas_sor=$ark_kontrol->rowCount();
$alici_bulunan_uye=$uyeyi_bul->rowCount();

if ($arkadas_sor > 0 and $alici_bulunan_uye > 0) {

    $arkadas_cek=$ark_kontrol->fetch(PDO::FETCH_ASSOC); 
    $alici_uye_cek=$uyeyi_bul->fetch(PDO::FETCH_ASSOC); 

    $arkadas_var = 1;
    $ark_durum = $arkadas_cek['arkadas_durum'];
    $ark_id = $arkadas_cek['id'];
    $alici_bulunan_procode = $alici_uye_cek['uye_profil_code'];
    $mesaj_engeli_ac = 1;

}else {
    $arkadas_var = 0;
}

//arkadaş sor bitiş


if ($_GET['msj-k']=="v" and $_GET['msj-z']=="e") {
    $adres_satir = 'Location:../konusma?msj-a='.$mes_alici.'&msj-b='.$uyecodes.'&msj-c='.$mes_kodu.'&msj=d&msj-x=eax&xt=7&';
}elseif ($_GET['msj-g']=="n" and $_GET['msj-u']=="a" and $arkadas_var == 1) {
    $adres_satir = $kull_adres.'?'.$mt.'&href='.$alici_bulunan_procode.'&'.$adres_kp.'&';
}elseif ($_GET['msj-j']=="c" and $_GET['msj-s']=="a") {
    $adres_satir = 'Location:../bildirimler?bd=1&bme='.$bsayf.'&';
}else {
    $adres_satir ='Location:../mesajlar?ct=1&';
}


if ($_GET['msj-k']=="v" and $_GET['msj-z']=="e" or $_GET['msj-g']=="n" and $_GET['msj-u']=="a" or $_GET['msj-j']=="c" and $_GET['msj-s']=="a") {


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

    $me_saat = date('H:i:s');
    $me_tarih = date('d-m-Y');

    $engelsor=$db->prepare("SELECT * from engel where engel_gonderen=:gonderen and engel_alan=:alan");
    $engelsor->execute(array(
    'gonderen' => $uyecodes,
    'alan' => $mes_alici
    ));
    $sor=$engelsor->rowCount();

    $ters_engelsor=$db->prepare("SELECT * from engel where engel_gonderen=:gonderen and engel_alan=:alan");
    $ters_engelsor->execute(array(
    'gonderen' => $mes_alici,
    'alan' => $uyecodes
    ));
    $ters_sor=$ters_engelsor->rowCount();

    if ($sor > 0 and $ters_sor > 0) {

        $engelli_uye = 1;
          
    }elseif ($sor > 0) {

        $engelli_uye = 1;
            

    }elseif ($ters_sor > 0) {

        $engelli_uye = 1;
          
    }
    //engel bitiş

if ($engelli_uye == 1) {
        
    header($adres_satir.'engelli=uye');
    exit();

}elseif ($uye_getms!=$uyecodes) {

    header($adres_satir.'hile=v5');
    exit();

}elseif ($get_guvenlik == 0) {

    header($adres_satir.'mesajadres=hata');
    exit();

}elseif ($ark_durum == 1) {

    header($adres_satir.'zatenmesaj=engelyok');
    exit();

}elseif ($arkadas_var == 0) {

    header($adres_satir.'zatenarkadas=degilsiniz');
    exit();

}else {

    $mesaj_block=$db->prepare("UPDATE arkadaslar SET
        arkadas_durum=:durum                  
        WHERE id=$ark_id");
    $block_kayit=$mesaj_block->execute(array(
        'durum'=> $mesaj_engeli_ac               
        ));

    if ($block_kayit) {

        $bil_durum = 6;
        $bos_icerik = 0;

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
            'kimin'=> $mes_alici,
            'gonderen'=> $uyecodes,
            'icerik'=> $bos_icerik,
            'saat'=> $me_saat,
            'tarih'=> $me_tarih,
            'durum'=> $bil_durum,
            'codex'=> $bilkod
            ));

        if ($bildirim_kayit) {
            header($adres_satir.'mesajengeliac=tamam');
            exit();
        }else {
            header($adres_satir.'mesajengeliac=tamam');
            exit();
        }

    }else {

    header($adres_satir.'mesajengeliac=hata');
    exit();

    }

}//else bitiş



}else {

    header($adres_satir.'hile=v6');
    exit();

    //guvenlik
}//GET U=E bitis


?>














