<?php 
ob_start();
session_start();
include 'baglan.php';



if (isset($_POST['uye_giris'])) {


	

	function keysuzgec($string)
	{
		$string = preg_replace("/\s+/", "", $string);
		$string = trim($string);
		return $string;
	}

	$x_metin  = trim(strip_tags(keysuzgec($_POST['metin'])));
	$x_sifre  = trim(strip_tags(keysuzgec($_POST['sifre'])));
	$uye_yetki=$_POST['uye_yetki'];



	




	if (empty($x_metin) or empty($x_sifre)) {

		header('Location:../../login/giris.php?bosluk=var');
		exit();

	}elseif (strlen(utf8_decode($x_metin)) < 11 or strlen(utf8_decode($x_sifre)) < 6 or strlen(utf8_decode($x_metin)) > 35 or strlen(utf8_decode($x_sifre)) > 20) {
		header('Location:../../login/giris.php?uzunluk=gecersiz');
		exit();
	}else {

		$sor_metin=trim(strip_tags(keysuzgec($_POST['metin'])));
		$sor_telnum=trim(strip_tags(keysuzgec($_POST['metin'])));
		$sor_sifre=md5(sha1($x_sifre)).sha1(md5($x_sifre));
		$uye_yetki=$_POST['uye_yetki'];


		if ($sor_metin or $sor_telnum && $sor_sifre) {

			

			function dwx($etkiwar){
				$gelen_war= array('0','1','2','3','4','5','6','7','8','9');
				$degisen_war = array('as','er','df','ty','gh','jk','zx','cv','bn','qm');
				$giden_war = str_replace($gelen_war,$degisen_war,$etkiwar);
				return $giden_war; }
				$numsifrele = dwx($sor_telnum);

				$uyesor=$db->prepare("SELECT * from users where uye_telefon=:telefon and uye_sifre=:sifre");
				$uyesor->execute(array(
					'telefon' => $numsifrele,
					'sifre' => $sor_sifre
				));

				$say=$uyesor->rowCount();

		if ($say>0) { //sıfırdan büyükse yani veri kayıtlarında varsa indexe gönder

			$aktifmi=$uyesor->fetch(PDO::FETCH_ASSOC);

			if ($aktifmi['uye_boss'] != 1) {
				$izin_id = '1';
				$giris_izin_varmi=$db->prepare("SELECT * from izinler where izin_id=:izid");
				$giris_izin_varmi->execute(array(
					'izid' => $izin_id
				));
				$giris_izin_cek=$giris_izin_varmi->fetch(PDO::FETCH_ASSOC); 
				$giris_izin = $giris_izin_cek['izin_giris'];

				if ($giris_izin != 1) {
					header('Location:../../login/giris.php?kisabir=bakimvar');
					exit();  
				}else {
					if ($aktifmi['uye_aktif'] == 1) {

						$uyekodbul=$db->prepare("SELECT * from users where uye_telefon=:telefon");
						$uyekodbul->execute(array(
							'telefon' => $numsifrele
						));

						$_SESSION=$uyekodbul->fetch(PDO::FETCH_ASSOC);
						$_SESSION['uye_code'];
						$_SESSION['uye_yetki'];

						header('Location:../../profil.php');
						exit();
					}else {
						header('Location:../../login/giris.php?uye=kapali');
						exit();
					}
				}
			}else {


				if ($aktifmi['uye_aktif'] == 1) {

					$uyekodbul=$db->prepare("SELECT * from users where uye_telefon=:telefon");
					$uyekodbul->execute(array(
						'telefon' => $numsifrele
					));

					$_SESSION=$uyekodbul->fetch(PDO::FETCH_ASSOC);
					$_SESSION['uye_code'];
					$_SESSION['uye_yetki'];

					header('Location:../../profil.php');
					exit();
				}else {
					header('Location:../../login/giris.php?uye=kapali');
					exit();
				}

			}

		} else { //yoksa email sorgula

			$izin_id = '1';
			$giris_izin_varmi=$db->prepare("SELECT * from izinler where izin_id=:izid");
			$giris_izin_varmi->execute(array(
				'izid' => $izin_id
			));
			$giris_izin_cek=$giris_izin_varmi->fetch(PDO::FETCH_ASSOC); 
			$giris_izin = $giris_izin_cek['izin_giris'];

			if ($giris_izin != 1) {
				header('Location:../../login/giris.php?kisabir=bakimvar');
				exit();  
			}

			$uyesor=$db->prepare("SELECT * from users where uye_email=:email and uye_sifre=:sifre");
			$uyesor->execute(array(
				'email' => $sor_metin,
				'sifre' => $sor_sifre
			));

			$say=$uyesor->rowCount();

			if ($say>0) { //email varmı sor

				$aktifmi=$uyesor->fetch(PDO::FETCH_ASSOC);

				if ($aktifmi['uye_aktif'] == 1) {

					$uyekodbul=$db->prepare("SELECT * from users where uye_email=:email");
					$uyekodbul->execute(array(
						'email' => $sor_metin
					));

					$_SESSION=$uyekodbul->fetch(PDO::FETCH_ASSOC);
					$_SESSION['uye_code'];
					$_SESSION['uye_yetki'];

					header('Location:../../anasayfa.php');
					exit();
				}else {
					header('Location:../../login/giris.php?uye=kapali');
					exit();
				}
				



			}else { //yoksa uyarı ver

				header('Location:../../login/giris.php?uye=yok');
				exit();

			}


		} //telefon sorgusu bitiş
















	} //uye varmı ? kontrol



} 

}





else {
	header('Location:../../login/giris.php?uye=yok');
	exit();
}

?>