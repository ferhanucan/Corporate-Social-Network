<?php include 'header.php'; ?>

<?php if ($_SESSION['sessizin'] == 0) {
	header("Location:index.php"); 
	exit();
} ?>

<?php 

if (!ctype_digit($_GET['d'])) {
	header('Location:profil.php?departman=alanyok');
	exit();
}elseif (strlen($_GET['d']) < 1 or strlen($_GET['d']) > 3) {
	header('Location:profil.php?departman=alanyok');
	exit();
}elseif($_GET['d']=="2") { 
	$grup_no = 2;
	$dep_gurup = 'İnsan Kaynakları';
}elseif($_GET['d']=="3") {
	$grup_no = 3;
	$dep_gurup = 'Üretim';
}elseif($_GET['d']=="4") {
	$grup_no = 4;
	$dep_gurup = 'AR-GE';
}elseif($_GET['d']=="5") {
	$grup_no = 5;
	$dep_gurup = 'Muhasebe';
}elseif($_GET['d']=="6") {
	$grup_no = 6;
	$dep_gurup = 'Pazarlama';
}elseif($_GET['d']=="7") {
	$grup_no = 7;
	$dep_gurup = 'Yönetim';
}else {
	header('Location:profil.php?departman=yok');
	exit();
} ?>



<div class="col-md-12 col-sm-12 col-xs-12 ortbslk row" style="margin-bottom:220px; margin-left:50px;">


	<div class="col-xs-12">
		<div class="pme-pad">
			<div class="pme-box-text">Seçtiğiniz Departman Grubu -<?php echo $dep_gurup ?>-<br>
				<span>Seçtiğiniz Departman Grubuna Göre Çalışma Arkadaşlarınız Listelenmiştir</span></div>
			</div>
		</div>

		<?php
		if ($grup_no == 22) {
			$goster = 10;
			$say=$db->prepare("SELECT * FROM users WHERE uye_departman_grup=:grup or uye_departman_grup=:digergrup");
			$say->execute(array(
				'grup' => $grup_no,
				'digergrup' => $digergrup
			));
			$toplamveri=$say->rowCount();
			$sayfa_sayisi = ceil($toplamveri / $goster);
			$sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;
			if ($sayfa < 1) {$sayfa = 1;}
			if ($sayfa > $sayfa_sayisi) {$sayfa = 1;}
			$listele = ($sayfa - 1) * $goster;


			$kullanici_listele = $db->prepare("SELECT * FROM users WHERE uye_departman_grup=:grup or uye_departman_grup=:digergrup  LIMIT $listele, $goster");
			$kullanici_listele->execute(array(
				'grup' => $grup_no,
				'digergrup' => $digergrup
			));
		}else {
			$goster = 10;
			$say=$db->prepare("SELECT * FROM users WHERE uye_departman_grup=:grup");
			$say->execute(array(
				'grup' => $grup_no
			));
			$toplamveri=$say->rowCount();
			$sayfa_sayisi = ceil($toplamveri / $goster);
			$sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;
			if ($sayfa < 1) {$sayfa = 1;}
			if ($sayfa > $sayfa_sayisi) {$sayfa = 1;}
			$listele = ($sayfa - 1) * $goster;


			$kullanici_listele = $db->prepare("SELECT * FROM users WHERE uye_departman_grup=:grup  LIMIT $listele, $goster");
			$kullanici_listele->execute(array(
				'grup' => $grup_no
			));
		}


		$engeldurum = 1;
		if ($engeldurum && $uyecodes) {
			$engelsor=$db->prepare("SELECT * from engel where engel_gonderen=:gonderen and engel_durum=:durum");
			$engelsor->execute(array(
				'gonderen' => $uyecodes,
				'durum' => $engeldurum
			));
			$engel_varmi=$engelsor->rowCount();
			if ($engel_varmi > 0) {
				$engel_cek=$engelsor->fetch(PDO::FETCH_ASSOC);
			}
		}

		while($liste=$kullanici_listele->fetch(PDO::FETCH_ASSOC)) { ?>

			<?php if ($engel_cek['engel_alan'] != $liste['uye_code']) { ?>

				<?php $ad = $liste['uye_ad']; $soyad = $liste['uye_soyad']; ?>

				<?php $adsoyad = $ad." ".$soyad; ?>









				<div class="col-md-3">
					<div class="contact-box center-version">
						<a href="">
							<img alt="image" class="img-circle" src="<?php echo $liste['uye_avatar_resim']; ?>">
							<h3 class="m-b-xs"><strong><?php echo $adsoyad; ?><?php if ($liste['uye_profil_onay'] == 1) { ?><i class="fa fa-check-circle-o onaytype onay-tooltip" aria-hidden="true" aria-hidden="true" data-toggle="tooltip" data-placement="right"></i><?php } ?></strong></h3>

							<div class="font-bold"><?php echo $liste['uye_departman']; ?> DEPARTMANI</div>
							<div class="font-bold"><?php echo $liste['uye_meslek']; ?></div>
							

						</a>
						<?php if ($liste['uye_code']==$uyecodes) { ?>

						<?php }  else { ?>


							<div class="contact-box-footer">
								<div class="m-t-xs btn-group">

								
									<a class="btn btn-xs btn-white" href="kullanici-mesaj.php?ara=<?php echo $liste['uye_profil_code']; ?>&<?php echo $ad_style; ?>"><i class="fa fa-envelope"></i></a>
									<a class="btn btn-xs btn-white" href="<?php if ($liste['uye_code']==$uyecodes) { ?>profil.php?profil=senin&kp=1<?php }else{ ?>kullanici.php?ara=<?php echo $liste['uye_profil_code']; ?>&ci=1<?php } ?>"><i class="fa fa-user"></i></a>


								</div>
							</div>


						<?php } ?>

					</div>
				</div>









			<?php } ?>

		<?php } ?>




		



	</div>



	<?php include 'footer.php'; ?>
