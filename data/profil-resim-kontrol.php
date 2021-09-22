<?php

ob_start();
session_start();

include '../tkpan/database/baglan.php';
date_default_timezone_set('Europe/Istanbul');


include('profil-resim-fonksiyon.php');
/*defined settings - start*/
ini_set("memory_limit", "99M");
ini_set('post_max_size', '20M');
ini_set('max_execution_time', 600);
define('IMAGE_SMALL_DIR', '../yimg/profil/kucuk/');
define('IMAGE_SMALL_SIZE', 50);
define('IMAGE_MEDIUM_DIR', '../yimg/profil/buyuk/');
define('IMAGE_MEDIUM_SIZE', 250);
define('IMAGE_MEDIUM_NOW', 'yimg/profil/buyuk/');
/*defined settings - end*/

if(isset($_FILES['image_upload_file'])){
	$uyecodes = $_SESSION['uye_code'];

if ($_SESSION['sessizin'] != 1 and strlen($uyecodes) != 30) {
    header('Location:../anasayfa?koruma=etkin');
    exit();
}

	$output['status']=FALSE;
	set_time_limit(0);
	$allowedImageType = array("image/gif",   "image/jpeg",   "image/pjpeg",   "image/png",   "image/x-png",    "image/jpg");

	$namex = $_FILES['image_upload_file']["name"];

    $izinli_uzantilar = array("jpeg", "pjpeg",  "x-png", "png", "jpg", "gif");

    function uzanti($namex) {
    $uzanti = pathinfo($namex);
    $uzanti = $uzanti["extension"];
    return $uzanti;
    }

    $uzanti = uzanti($namex);
	
	if ($_FILES['image_upload_file']["error"] > 0) {
		$output['error']= "Resim yüklenemedi";
    	
	}elseif (!in_array($uzanti, $izinli_uzantilar)) {
        $output['error']= "Resimler Jpg veya Png formatında olmalıdır";
        
    }elseif (!in_array($_FILES['image_upload_file']["type"], $allowedImageType)) {
		$output['error']= "Resim uzantıları Jpg veya Png olmalıdır";
    	
	}elseif (round($_FILES['image_upload_file']["size"] / 1024) > 8192) {
		$output['error']= "Resim boyutu en fazla 8 Megabyte(MB) olmalıdır";
    	
	}elseif ($_FILES['image_upload_file']["size"] == 0) {
        $output['error']= "Resim seçilmedi";
        
    }else {

        $mc1=rand(10000,99000);    

        $mc2=rand(10000,99000);

        $mc3=rand(10000,99000);

        $mc4=rand(10000,99000);

        $mc5=rand(10000,99000);

        $mc6=rand(10000,99000);

        $benzersiz_islemcode= $mc4.$mc6.$mc3.$mc1.$mc2.$mc5;
        $resim_nick = $benzersiz_islemcode;

		/*create directory with 777 permission if not exist - start*/
		createDir(IMAGE_SMALL_DIR);
		createDir(IMAGE_MEDIUM_DIR);
		/*create directory with 777 permission if not exist - end*/
		$path[0] = $_FILES['image_upload_file']['tmp_name'];
		$file = pathinfo($_FILES['image_upload_file']['name']);
		$fileType = $file["extension"];
		$desiredExt='jpg';
		$fileNameNew = $resim_nick.".$desiredExt";
		$path[1] = IMAGE_MEDIUM_DIR . $fileNameNew;
		$path[2] = IMAGE_SMALL_DIR . $fileNameNew;
		$bas = IMAGE_MEDIUM_NOW . $fileNameNew;

		
		if (createThumb($path[0], $path[1], $fileType, IMAGE_MEDIUM_SIZE, IMAGE_MEDIUM_SIZE,IMAGE_MEDIUM_SIZE)) {
			
			if (createThumb($path[1], $path[2],"$desiredExt", IMAGE_SMALL_SIZE, IMAGE_SMALL_SIZE,IMAGE_SMALL_SIZE)) {
				$output['status']=TRUE;
				$output['image_medium']= $path[1];
				$output['image_small']= $path[2];
				$output['image_now']= $bas;
			}
		}



			    $uyesor=$db->prepare("SELECT * from users where uye_code=:code");
			    $uyesor->execute(array(
			    'code' => $uyecodes
			    ));
			    $uye_cek=$uyesor->fetch(PDO::FETCH_ASSOC); 
			    $uye_av_resim = $uye_cek['uye_avatar_resim'];
			    $uye_mi_resim = $uye_cek['uye_mini_resim'];
			    $uye_resim_yukle = $uye_cek['uye_resim_yukle'];

			if ($uye_resim_yukle == 1) {
                unlink("../$uye_av_resim");
                unlink("../$uye_mi_resim");			
            }
            	$uye_resim_durum = 1;
				$resim_yol_b = 'yimg/profil/buyuk/'.$fileNameNew;
				$resim_yol_k = 'yimg/profil/kucuk/'.$fileNameNew;
	            $uye_resim_guncelle=$db->prepare("UPDATE users SET
	                uye_avatar_resim=:avresim,
	                uye_mini_resim=:minresim,
	                uye_resim_yukle=:resyuk
	                WHERE uye_code=$uyecodes");
	            $resim_guncelle=$uye_resim_guncelle->execute(array(
	                'avresim'=> $resim_yol_b,
	                'minresim'=> $resim_yol_k,
	                'resyuk'=> $uye_resim_durum      
	            ));

	}
	echo json_encode($output);
}else {
    $output['error']= "Resim seçilmedi";
    echo json_encode($output);
}
?>	