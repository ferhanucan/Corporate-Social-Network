<?php
ob_start();
session_start();

include '../../tkpan/database/baglan.php';
date_default_timezone_set('Europe/Istanbul');

if (isset($_POST['passrest'])) {


$son_reset_zamani = date('Y-m-d H:i:s');
$yenitarih = strtotime('+10 minutes',strtotime($son_reset_zamani));
$zaman_limit = date("Y-m-d H:i:s" ,$yenitarih);



function keysuzgec($string)
{
    $string = preg_replace("/\s+/", "", $string);
    $string = trim($string);
    return $string;
}

        $email = trim(strip_tags(keysuzgec($_POST['eposta'])));
        $telefon = trim(strip_tags(keysuzgec($_POST['telnum'])));
        $bilgiler = trim(strip_tags($_SESSION['uyebilgi']));


$t_operator = substr($telefon, 0, 4); 
$son7sayi = substr($telefon, 4, 7); 

$izinli_opertorler = array("0530", "0531", "0532", "0533", "0534", "0535", "0536", "0537", "0538", "0539", "0540", "0541", "0542", "0543", "0544", "0545", "0546", "0547", "0548", "0549", "0550", "0551", "0552", "0553", "0554", "0555", "0556", "0557", "0558", "0559", "0560", "0501", "0505", "0506", "0507");

$yasak_numaralar = array("0000000", "1111111", "2222222", "3333333", "4444444", "5555555", "6666666", "7777777", "8888888", "9999999");

        if (empty($email) or empty($telefon)){
            header('Location:../sifremi-unuttum.php?resetpw=pwbos');
            exit();
        }elseif (strlen($telefon) != 11 or strlen($email) < 12 or strlen($email) > 35){
            header('Location:../sifremi-unuttum.php?resetpw=pwdet');
            exit();
        }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header('Location:../sifremi-unuttum.php?resetpw=pwdet');
            exit();
        }elseif (!in_array($t_operator, $izinli_opertorler)) {
            header('Location:../sifremi-unuttum.php?resetpw=pwdet');
            exit();
        }elseif (in_array($son7sayi, $yasak_numaralar)) {
            header('Location:../sifremi-unuttum.php?resetpw=pwdet');
            exit();
        }elseif (!ctype_digit($telefon)) {
            header('Location:../sifremi-unuttum.php?resetpw=pwdet');
            exit();
        }

function dwx($etkiwar){
$gelen_war= array('0','1','2','3','4','5','6','7','8','9');
$degisen_war = array('as','er','df','ty','gh','jk','zx','cv','bn','qm');
$giden_war = str_replace($gelen_war,$degisen_war,$etkiwar);
return $giden_war; }

            $profilsor=$db->prepare("SELECT * from users where uye_email=:xmas and uye_telefon=:telefon");
            $profilsor->execute(array(
            'xmas' => $email,
            'telefon' => dwx($telefon)
        	));

            $profilsay=$profilsor->rowCount();
            if ($profilsay == 0) {
                header('Location:../sifremi-unuttum.php?resetpw=pwrep');
                exit();
            }else {

$pro_cek=$profilsor->fetch(PDO::FETCH_ASSOC);

    $kayitvarmi=$db->prepare("SELECT * from password_reset where reset_kimin=:reskim");
    $kayitvarmi->execute(array(
       'reskim' => $pro_cek['uye_code']
    ));

    $kayitsay=$kayitvarmi->rowCount();
    if ($kayitsay > 0) {

    	$olan_cek=$kayitvarmi->fetch(PDO::FETCH_ASSOC);
    	$res_idnum = $olan_cek['reset_id'];
    	$reset_zaman = $olan_cek['reset_zaman'];
    	
    $simdiki_zaman = date('Y-m-d H:i:s');

    if ($simdiki_zaman >= $reset_zaman) {
        $kayit_durum = 1;
    }else {
        header('Location:../sifremi-unuttum.php?resetpw=kodaktif');
        exit();
    }

    }else {
    	$kayit_durum = 0;
    }


        $victy1=rand(10000,99000);

        $victy2=rand(10000,99000);

        $victy3=rand(10000,99000);

        $victy4=rand(10000,99000);

        $victy5=rand(10000,99000);

        $tpvic=$victy1.$victy2.$victy3.$victy4.$victy5;
        $reset_code = $tpvic;


	   	$konu = 'Şifre sıfırlama talebi';

	    $eposta = $email;
	    $ad = $pro_cek['uye_ad'];

	      $mesaj = '
<!DOCTYPE html>
<html>
<head>
<title>Dokuzrenk.com</title>
</head>


<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<div style="margin:0 auto;max-width:700px;">

<div style="background-color:#111">
<table style="width:100%; height:80px;" align="center" cellspacing="0" cellpadding="0">
	<tbody>
		<tr>
			<td style="text-align:center;">
				<div style="font-size: 26px; font-weight: bold; color:#ddd; font-family:Roboto,sans-serif;">
				Dokuzrenk.com
				</div>
	        </td>
		</tr>

</tbody>
</table>
</div>



<table style="width:100%;" align="center" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td>

		<table style="padding:10px 30px 10px 30px;" width="100%">
			<tbody>

					<tr>
						<td style="word-break:break-word; height:80px;">
							<div style="padding:10px; color:#414141; font-family:Open Sans,sans-serif; font-size:24px; font-weight:600; line-height:19px; text-align:center;">
								Sayın <span style="color:#c97d03;">'.$ad.',</span>
							</div>
						</td>
					</tr>


					<tr>
						<td style="word-break:break-word; height:80px;">
							<div style="padding:10px; color:#414141;font-family:Open Sans,sans-serif;font-size:14px;font-weight:600;line-height:19px;text-align:center;">
							Şifrenizi alttaki linke tıklayarak sıfırlayabilirsiniz.
							</div>
						</td>
					</tr>



					<tr>

						<td style="word-break:break-word; height:100px;">
							<div style="padding:10px; font-family:Open Sans,sans-serif;font-size:14px;font-weight:600;line-height:24px; background-color: #d2ddf1;border-radius: 4px;">
							<p style="text-align:center;color:#115300"><a href="https://www.dokuzrenk.com/login/passets.php?rst=1&keynum='.$reset_code.'&sfx=1">https://www.dokuzrenk.com/login/passets.php?rst=1&keynum='.$reset_code.'&sfx=1</a></p>
							</div>
						</td>

        			</tr>



					<tr>
						<td style="word-break:break-word; height:80px;">
							<div style="padding:20px; color:#414141;font-family:Open Sans,sans-serif;font-size:12px;font-weight:600;line-height:19px;text-align:center;">
							Keyifli vakitler dileriz, bu maile cevap atmanıza gerek yoktur.
							</div>
						</td>
        			</tr>

			</tbody>
		</table>


</td>
</tr>
</tbody>
</table>


<div style="background-color: #111;">
<table style="width:100%; height:60px;" align="center" cellspacing="0" cellpadding="0">
	<tbody>
		<tr>
			<td>
				<div style="text-align:center; font-size: 12px; font-weight: 400; color:#ddd; font-family:Roboto,sans-serif;">
				© Dokuzrenk.com All rights reserved.
				</div>
	        </td>
		</tr>
	</tbody>
</table>
</div>

</div>


</body>
</html>
';


$tanimyap = 1;
include 'class.phpmailer.php';
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->Host = 'smtp.dokuzrenk.com';
$mail->Port = 587;
$mail->Username = 'destek@dokuzrenk.com';
$mail->Password = 'Ox8D9Qrx';
$mail->SetFrom($mail->Username, 'Dokuzrenk.com');
$mail->AddAddress($eposta, $ad);
$mail->CharSet = 'UTF-8';
$mail->Subject = $konu;
$mail->MsgHTML($mesaj);
if($mail->Send()) {

	if ($kayit_durum == 1) {

		$resdurm = 1;
        $resco_yenile=$db->prepare("UPDATE password_reset SET
        	reset_zaman=:rezaman,
            reset_code=:coderes,
            reset_durum=:rsdur
            WHERE reset_id=$res_idnum");

        $resco_up=$resco_yenile->execute(array(
        	'rezaman'=> $zaman_limit,
            'coderes'=> $reset_code,
            'rsdur'=> $resdurm
            ));

        if ($resco_up) {
            $bilgibas=$db->prepare("INSERT INTO sifre_degistirme_analiz SET
                s_uye_code=:uscode,
                s_bilgi=:sbilgi
                ");

            $bilgi_kayit=$bilgibas->execute(array(
                'uscode'=> $pro_cek['uye_code'],
                'sbilgi'=> $bilgiler
            ));

            if ($bilgi_kayit) {
			    header('Location:../sifremi-unuttum.php?resetpw=pwoldu');
			    exit();
            }else {
			    header('Location:../sifremi-unuttum.php?resetpw=pwdet');
			    exit();
            }
        }else {
			header('Location:../sifremi-unuttum.php?resetpw=pwdet');
			exit();
        }

	}else {

		$resdurm = 1;
        $reset_bas=$db->prepare("INSERT INTO password_reset SET
            reset_kimin=:resetkimin,
            reset_zaman=:rezaman,
            reset_code=:resetcode,
            reset_durum=:rsdur
            ");

        $reset_kayit=$reset_bas->execute(array(
            'resetkimin'=> $pro_cek['uye_code'],
        	'rezaman'=> $zaman_limit,
            'resetcode'=> $reset_code,
            'rsdur'=> $resdurm
        ));

        if ($reset_kayit) {
            $bilgibas=$db->prepare("INSERT INTO sifre_degistirme_analiz SET
                s_uye_code=:uscode,
                s_bilgi=:sbilgi
                ");

            $bilgi_kayit=$bilgibas->execute(array(
                'uscode'=> $pro_cek['uye_code'],
                'sbilgi'=> $bilgiler
            ));

            if ($bilgi_kayit) {
			    header('Location:../sifremi-unuttum.php?resetpw=pwoldu');
			    exit();
            }else {
			    header('Location:../sifremi-unuttum.php?resetpw=pwdet');
			    exit();
            }

        }else {
		    header('Location:../sifremi-unuttum.php?resetpw=pwdet');
		    exit();
        }
	}//yeni kayıt oluştur else bitiş


}else {
    header('Location:../sifremi-unuttum.php?resetpw=netdet');
    exit();
}


}// sistemde uye varsa elsesi

}else {
    header('Location:../sifremi-unuttum.php');
    exit();
}



?>