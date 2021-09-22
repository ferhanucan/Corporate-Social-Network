<?php  
include 'tkpan/database/baglan.php';
date_default_timezone_set('Europe/Istanbul');


function yasakkelimeler($gelen){
	$argo = array('Argo', 'ARGO', 'argo', 'yasakkelime');
	$degisen = '...';
	$giden = str_replace($argo,$degisen,$gelen);
	return $giden; }




	if (isset($_POST['personel_kayit'])) {

		
		/*uye kodu */
		$bs1=rand(10000,99000);

		$bs2=rand(10000,99000);

		$bs3=rand(10000,99000);

		$bs4=rand(10000,99000);

		$bs5=rand(10000,99000);

		$bs6=rand(10000,99000);

		$benzersizad=$bs1.$bs2.$bs3.$bs4.$bs5.$bs6;
		$uye_code = $benzersizad;

		/*profil kodu */
		$prof1=rand(10000,99000);

		$prof2=rand(10000,99000);

		$prof3=rand(10000,99000);

		$prof4=rand(10000,99000);

		$prof5=rand(10000,99000);

		$prof6=rand(10000,99000);

		$prcod=$prof1.md5($prof2).md5($prof3).md5($prof4).md5($prof5).$prof6;
		$profil_code = $prcod;




		function keysuzgec($string)
		{
			$string = preg_replace("/\s+/", "", $string);
			$string = trim($string);
			return $string;
		}

		function tekbosluk($string)
		{
			$string = preg_replace("/\s+/", " ", $string);
			$string = trim($string);
			return $string;
		}

		$ad = trim(strip_tags(tekbosluk($_POST['ad'])));
		$soyad = trim(strip_tags(keysuzgec($_POST['soyad'])));
		$email = trim(strip_tags(keysuzgec($_POST['email'])));
		$telefon = $_POST['telefon'];
		$sifre = trim(strip_tags(keysuzgec($_POST['sifre'])));
		$resifre = trim(strip_tags(keysuzgec($_POST['resifre'])));
		$cinsiyet = trim(strip_tags(keysuzgec($_POST['cinsiyet'])));
		$tarih_gun = trim(strip_tags(keysuzgec($_POST['tarih_gun'])));
		$tarih_ay = trim(strip_tags(keysuzgec($_POST['tarih_ay'])));
		$tarih_yil = trim(strip_tags(keysuzgec($_POST['tarih_yil'])));
		$profil_onay = 0;
		$arkadas_sayisi = 0;
		$meslek = $_POST['uye_meslek'];
		$gizlilik = 1;
		$yayin_mute = 0;
		$paylasim_mute = 0;
		$uye_resim_yukle = 0;
		$uye_aktif = 1;
		$bozey = 0;
		$bilgiler = trim(strip_tags($_SESSION['uyebilgi']));
		$uye_departman=$_POST['uye_departman'];
		$uye_askerlikdurum=$_POST['uye_askerlikdurum'];
		$uye_tc=$_POST['uye_tc'];
		$uye_yetki=2;
		$uye_sgkno=$_POST['uye_sgkno'];
		$uye_isegiristarihi=$_POST['uye_isegiristarihi'];
		$uye_yas_goster=1;
		



		$ad = trim(strip_tags($_POST['ad'])); 
		$soyad = trim(strip_tags($_POST['soyad']));
		$uye_isim = $ad.' '.$soyad;

		function harfayar($string){
			$trKarakterlerDizisi = array('I'=>'i', 'İ'=>'i', 'Ü'=>'u', 'Ş'=>'s', 'Ç'=>'c', 'Ğ'=>'g', 'ı'=>'i', 'ü'=>'u', 'ş'=>'s', 'ç'=>'c', 'ğ'=>'g'); 
			$string = strtr($string, $trKarakterlerDizisi);
			$islemyap = mb_convert_case($string,  MB_CASE_LOWER, "UTF-8");
			return $islemyap;
		}

		$adsoyad = harfayar($ad)." ".harfayar($soyad); 
		$adsoyad2 = $ad." ".$soyad; 

		$dogum_tarihi = $tarih_yil.'-'.$tarih_ay.'-'.$tarih_gun;


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


		$kelime_avla1 = bosluksil($ad);
		$kelime_avla2 = preg_replace('/[^A-Za-z0-9şıöüğçİŞÖĞÜÇ ]/s', '', $kelime_avla1); 
		$kelime_avla3 = yasakkelimeler($kelime_avla2);
		$kelime_avla4 = kelimebul($kelime_avla3);

		$kelime_denetle1 = bosluksil($soyad);
		$kelime_denetle2 = preg_replace('/[^A-Za-z0-9şıöüğçİŞÖĞÜÇ ]/s', '', $kelime_denetle1); 
		$kelime_denetle3 = yasakkelimeler($kelime_denetle2);
		$kelime_denetle4 = kelimebul($kelime_denetle3);

		








		if ($cinsiyet == 1) {
			$cinsi ='Erkek';
			$cinsiyet_num = 1;
			$avatar_resim_yol ='yimg/profil/eprofil.png';
			$mini_resim_yol ='yimg/profil/eprofil.png';
		}elseif ($cinsiyet == 2) {
			$cinsi ='Kadın';
			$cinsiyet_num = 2;
			$avatar_resim_yol='yimg/profil/kprofil.png';
			$mini_resim_yol ='yimg/profil/kprofil.png';
		}else {
			$cinsi ='Erkek';
			$cinsiyet_num = 1;
			$avatar_resim_yol ='yimg/profil/eprofil.png';
			$mini_resim_yol ='yimg/profil/eprofil.png';
		}

		



		


		if (empty($ad) or empty($soyad) or empty($email) or empty($sifre) or empty($resifre) or empty($telefon) or empty($cinsiyet) or  empty($tarih_gun) or empty($tarih_ay) or empty($tarih_yil)){

			header('Location:personelkayit.php?formda=boslukvar');
			exit();
		}elseif ($sifre != $resifre) {
			header('Location:personelkayit.php?sifre=gecersiz');
			exit();
		}elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			header('Location:personelkayit.php?email=gecersiz');
			exit();
		}elseif ($cinsiyet < 1  or $cinsiyet > 2) {
			header('Location:personelkayit.php?uzunluk=gecersiz');
			exit();
		}else {
			$mailsor=$db->prepare("SELECT * from users where uye_email=:email");
			$mailsor->execute(array(
				'email' => $email));

			$mailsay=$mailsor->rowCount();
			if ($mailsay>0) {
				header('Location:personelkayit.php?email=sistemdevar');
				exit();
			}else {


				function dwx($etkiwar){
					$gelen_war= array('0','1','2','3','4','5','6','7','8','9');
					$degisen_war = array('as','er','df','ty','gh','jk','zx','cv','bn','qm');
					$giden_war = str_replace($gelen_war,$degisen_war,$etkiwar);
					return $giden_war; }

					$telsor=$db->prepare("SELECT * from users where uye_telefon=:telefon");
					$telsor->execute(array(
						'telefon' => dwx($telefon)));

					$telsay=$telsor->rowCount();
					if ($telsay>0) {
						header('Location:personelkayit.php?telefon=sistemdevar');
						exit();
					} else {

						$kaydet=$db->prepare("INSERT INTO users SET
							uye_ad=:ad,
							uye_soyad=:soyad,
							uye_isim=:yism,
							uye_sifre=:sifre,
							uye_email=:email,
							uye_telefon=:telefon,
							uye_yas=:yas,
							uye_cinsiyet=:cinsiyet,
							uye_cinsiyet_num=:cnum,
							uye_profil_onay=:onay,
							uye_meslek=:meslek,
							uye_gizlilik=:gizlilik,
							uye_boss=:bossy,
							uye_paylasim_mute=:paylasim_mute,
							uye_avatar_resim=:avatar,
							uye_mini_resim=:mini,
							uye_resim_yukle=:resyuk,
							uye_profil_code=:upcode,
							uye_code=:code,
							uye_aktif=:active,
							uye_yas_goster=:uye_yas_goster,
							uye_yetki=:uye_yetki,
							uye_tc=:uye_tc,
							uye_departman=:uye_departman,
							uye_askerlikdurum=:uye_askerlikdurum,
							uye_sgkno=:uye_sgkno,
							uye_isegiristarihi=:uye_isegiristarihi



							");
						$insert=$kaydet->execute(array(
							'ad'=> $ad,
							'soyad'=> $soyad,
							'yism'=> $uye_isim,
							'sifre'=> md5(sha1($sifre)).sha1(md5($sifre)),
							'email'=> $email,
							'telefon'=> dwx($telefon),
							'yas'=> $dogum_tarihi,
							'cinsiyet'=> $cinsi,
							'cnum'=> $cinsiyet_num,
							'onay'=> $profil_onay,
							'meslek'=> $meslek,
							'gizlilik'=> $gizlilik,
							'bossy'=> $bozey,
							'paylasim_mute'=> $paylasim_mute,
							'avatar'=> $avatar_resim_yol,
							'mini'=> $mini_resim_yol,
							'resyuk'=> $uye_resim_yukle,
							'upcode'=> $profil_code,
							'code'=> $uye_code,
							'active'=> $uye_aktif,
							'uye_yas_goster'=> $uye_yas_goster,
							'uye_yetki'=> $uye_yetki,
							'uye_tc'=> $uye_tc,
							'uye_departman'=> $uye_departman,
							'uye_askerlikdurum'=> $uye_askerlikdurum,
							'uye_sgkno'=> $uye_sgkno,
							'uye_isegiristarihi'=> $uye_isegiristarihi

						));
						if ($insert) {



							header('Location:personelkayit.php?basarili=kayit');


						}else {
							header('Location:personelkayit.php?gecersiz=kayit');
							exit();
						}


					}


				}
			}







		}else {
			header('Location:personelkayit.php?gecersiz=kayit');
			exit();
		}

		?>