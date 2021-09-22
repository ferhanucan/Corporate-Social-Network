<?php include 'header.php';?>













<script type="text/javascript">

	function geri(){

		history.back()

	}

</script>



<?php 





$gelen=$_POST['idgonder'];


$sorgu1=$db->prepare("SELECT * from users  where id=$gelen");
$sorgu1->execute();
$sorgucek1=$sorgu1->fetch(PDO::FETCH_ASSOC); 

?>




<div>
	<div class="row">
		<div  style="width:270px;">
			<div class="profile-card-4 z-depth-3">
				<div >
					<div class="card-body text-center  rounded-top" style="background-color:transparent; margin-left:40px;">
						<a href="personelliste.php"></a><button  onClick="geri()"></button>
						<div class="user-box">
							
							<img style="height:70px; width:70px;" src="<?php echo $sorgucek1['uye_avatar_resim'] ?>" alt="user avatar">
						</div>
						<h3 class="mb-2" style="color:red;"><?php echo $sorgucek1['uye_ad']," ",$sorgucek1['uye_soyad'] ?></h3>
						<h4 class="text-green" style="color:red;"><?php echo $sorgucek1["uye_meslek"]; ?></h4>
						<?php  $dateOfBirth = $sorgucek1['uye_yas']." 00:01:11";
						$today = date("Y-m-d H:i:s");
						$diff = date_diff(date_create($dateOfBirth), date_create($today));
						$uye_yas = $diff->format('%y'); ?>
						<h4 class="text-green" style="color:red;">Yaş :<?php echo $uye_yas; ?></h4>
						
					</div>
					<div class="card-body" style="width:280px; margin-left:5px;">
						<ul class="list-group shadow-none">
							<li class="list-group-item">
								<div class="list-icon">
									<i class="fa fa-phone-square"></i>
								</div>
								<div class="list-details">
									<span><?php echo $sorgucek1['uye_telefon']; ?></span><br>
									<small><b>Telefon</b></small>
								</div>
							</li>
							<li class="list-group-item">
								<div class="list-icon">
									<i class="fa fa-envelope"></i>
								</div>
								<div class="list-details">
									<a href="mailto:webmaster@example.com"><?php echo $sorgucek1['uye_email'] ?></a><br>
									<small><b>E-mail</b></small>
								</div>
							</li>
							<li class="list-group-item">
								<div class="list-icon">
									<i class="fa fa-globe"></i>
								</div>
								<div class="list-details">
									<a href="kullanici.php?ara=<?php echo $sorgucek1['uye_profil_code']; ?>&ci=3">Personel Profili</a><br>
									<small><b>Profil Bağlantısı</b></small>
								</div>
							</li>
						</ul>

					</div>
					
					
				</div>
			</div>
		</div>

		<!-- sol taraf bitiş -->




		<div style="width:1100px;">
			<div>
				<div class="card-body">
					<ul class="nav nav-pills nav-pills-primary nav-justified"  >
						<li class="nav-item">
							<a href="javascript:void();" data-target="#profile" data-toggle="pill" class="nav-link active show"><span class="hidden-xs">Genel Bilgiler</span></a>
						</li>

						<li class="nav-item">
							<a href="javascript:void();" data-target="#diger" data-toggle="pill" class="nav-link"> <span class="hidden-xs"></span></a>
						</li>
						<li class="nav-item">
							<a href="javascript:void();" data-target="#egitim" data-toggle="pill" class="nav-link"> <span class="hidden-xs"></span></a>
						</li>
					</ul>






					<form action="personelguncelle.php" method="POST">
						<div class="tab-content ">



							<!-- Genel Bilgiler Başlangıç -->

							<div class="tab-pane active show" id="profile">




								<div class="row">
									<div class="col-md-3">


										<label for="disabledSelect" class="form-label">PERSONEL KODU</label><select id="disabledSelect"  style="  background-color:#E0FFFF; color:red; text-transform:uppercase; font-weight:bold;" id="id" name="id" style="height:40px; width:250px;" class="form-control">
											<option value="<?php echo $gelen ?>" selected><?php echo $gelen ?></option>

										</select>

										<label>TC</label><input style=" background-color:#E0FFFF;  text-transform:uppercase; font-weight:bold;" type="number" class="form-control" style="height:30px; width:250px;" name="uye_tc" id="uye_tc" value="<?php echo $sorgucek1['uye_tc'] ?>">


										<label for="first_name">ADI</label><input type="text"style="background-color:#E0FFFF;text-transform:uppercase;font-weight:bold;"class="form-control" style="height:30px; width:250px;" name="uye_ad" id="uye_ad" 
										value="<?php echo $sorgucek1['uye_ad'] ?>">


										<label>SOYADI</label><input type="text" style=" background-color:#E0FFFF;  text-transform:uppercase; font-weight:bold;"  class="form-control" style="height:30px; width:250px;"  name="uye_soyad" value="<?php echo $sorgucek1['uye_soyad']  ?>" id="uye_soyad">


										<label>DOĞUM TARİHİ</label><input type="text" onfocus="(this.type='date')" style=" background-color:#E0FFFF;  text-transform:uppercase; font-weight:bold;" class="form-control" style="height:30px; width:250px;" name="uye_yas" id="uye_yas" value="<?php echo $sorgucek1['uye_yas'] ?>">
										
										<label>MEDENİ HAL</label><select style=" background-color:#E0FFFF;  font-weight:bold; " id="uye_medenihal" name="uye_medenihal" style="height:80px; width:250px;" class="form-control">
											<option value="<?php echo $sorgucek1['uye_medenihal']; ?>"  selected><?php echo $sorgucek1['uye_medenihal']; ?></option>
											<option >EVLİ</option>
											<option >BEKAR</option>
											
										</select>

										
										





									</div>


									<div class="col-md-3">

										<label>DEPARTMAN</label><select style="color:red; font-weight:bold; background-color:#E0FFFF;" id="uye_departman" name="uye_departman" style="height:40px; width:250px;" class="form-control">
											<option value="<?php echo $sorgucek1['uye_departman']; ?>"  selected><?php echo $sorgucek1['uye_departman']; ?></option>
											<option value="MUHASEBE">MUHASEBE</option>
											<option value="İNSAN KAYNAKLARI">İNSAN KAYNAKLARI</option>
											<option value="PAZARLAMA">PAZARLAMA</option>
											<option value="AR-GE">AR-GE</option>
											<option value="ÜRETİM">ÜRETİM</option>
											<option value="YÖNETİM">YÖNETİM</option>
										</select>


										<label for="first_name">GÖREV</label><input type="text" style=" background-color:#E0FFFF;  text-transform:uppercase; font-weight:bold;"  class="form-control" style="height:30px; width:250px;" name="uye_meslek" id="uye_meslek" value="<?php echo $sorgucek1['uye_meslek'] ?>">



										<label>İŞE GİRİŞ TARİHİ</label><input type="text" onfocus="(this.type='date')" style=" background-color:#E0FFFF;  text-transform:uppercase; font-weight:bold;" class="form-control" style="height:30px; width:250px;" name="uye_isegiristarihi" id="uye_isegiristarihi" value="<?php echo $sorgucek1['uye_isegiristarihi'] ?>">


										<label>İŞTEN ÇIKIŞ TARİHİ</label><input type="text" onfocus="(this.type='date')" style=" background-color:#E0FFFF;  text-transform:uppercase; font-weight:bold;" class="form-control" style="height:30px; width:250px;" name="uye_istencikistarihi" id="uye_istencikistarihi" value="<?php echo $sorgucek1['uye_istencikistarihi'] ?>">

										<label for="first_name">TELEFON</label><input type="text" style=" background-color:#E0FFFF;  text-transform:uppercase; font-weight:bold;"  class="form-control" style="height:30px; width:250px;" name="uye_telefon" id="uye_telefon" value="<?php echo $sorgucek1['uye_telefon'] ?>">


										<label>E-MAİL</label><input type="text" style=" background-color:#E0FFFF;  text-transform:uppercase; font-weight:bold;"value="<?php echo $sorgucek1['uye_email'] ?>" class="form-control" style="height:30px; width:250px;"  name="uye_email" id="uye_email">

										


									</div>

									<div class="col-md-3">

										<label>KAN GRUBU</label><select style=" background-color:#E0FFFF;  font-weight:bold; " id="uye_kangrup" name="uye_kangrup" style="height:40px; width:250px;" class="form-control">
											<option value="<?php echo $sorgucek1['uye_kangrup']; ?>"  selected><?php echo $sorgucek1['uye_kangrup']; ?></option>
											<option >AB+</option>
											<option >AB-</option>
											<option >A+</option>
											<option >B+</option>
											<option >A-</option>
											<option >B-</option>
											<option >0+</option>
											<option >0-</option>
											
										</select>


										<label>ASKERLİK DURUMU</label><select style=" background-color:#E0FFFF;  font-weight:bold; " id="uye_askerlikdurum" name="uye_askerlikdurum" style="height:40px; width:250px;" class="form-control">
											<option value="<?php echo $sorgucek1['uye_askerlikdurum']; ?>"  selected><?php echo $sorgucek1['uye_askerlikdurum']; ?></option>
											<option >YAPTI</option>
											<option >TECİLLİ</option>
											<option >MUAF</option></select>
											
											



											<label>EHLİYET</label><input type="text" style=" background-color:#E0FFFF;  text-transform:uppercase; font-weight:bold;"value="<?php echo $sorgucek1['uye_ehliyet'] ?>" class="form-control" style="height:30px; width:250px;"  name="uye_ehliyet" id="uye_ehliyet">

											<label>SEYEHAT EDEBİLİR</label><select style=" background-color:#E0FFFF;  font-weight:bold; " id="uye_seyehat" name="uye_seyehat" style="height:40px; width:250px;" class="form-control">
												<option value="<?php echo $sorgucek1['uye_seyehat']; ?>"  selected><?php echo $sorgucek1['uye_seyehat']; ?></option>
												<option >EVET</option>
												<option >HAYIR</option></select>

												<label>SGK NUMARASI</label><input style=" background-color:#E0FFFF;  text-transform:uppercase; font-weight:bold;" type="number" class="form-control" style="height:30px; width:250px;" name="uye_sgkno" id="uye_sgkno" value="<?php echo $sorgucek1['uye_sgkno'] ?>">









											</div>

											<div class="col-md-3">


												<label>ADRES</label><textarea  rows="3" type="text" style=" background-color:#E0FFFF;  text-transform:uppercase; font-weight:bold;"value="<?php echo $sorgucek1['uye_adres'] ?>" class="form-control" style="height:30px; width:250px;"  name="uye_adres" id="uye_adres"><?php echo $sorgucek1['uye_adres'] ?></textarea>

												<label>İL</label><input type="text" style=" background-color:#E0FFFF;  text-transform:uppercase; font-weight:bold;"value="<?php echo $sorgucek1['uye_il'] ?>" class="form-control" style="height:30px; width:250px;"  name="uye_il" id="uye_il">

												<label>İLÇE</label><input type="text" style=" background-color:#E0FFFF;  text-transform:uppercase; font-weight:bold;"value="<?php echo $sorgucek1['uye_ilce'] ?>" class="form-control" style="height:30px; width:250px;"  name="uye_ilce" id="uye_ilce">

												<label>ÜLKE</label><input type="text" style=" background-color:#E0FFFF;  text-transform:uppercase; font-weight:bold;"value="<?php echo $sorgucek1['uye_ulke'] ?>" class="form-control" style="height:30px; width:250px;"  name="uye_ulke" id="uye_ulke">





											</div>



										</div>




									</div>
									<!-- Genel Bilgiler Bitiş -->










									<!-- Diğer Bilgiler Başlangıç -->



									<div class="tab-pane" id="diger">

										<div class="row">
											<div class="col-md-6">
												d
											</div>


											<div class="col-md-6">
												D
											</div>



										</div>



									</div>


									<!-- Diğer Bilgiler Bitiş -->





									<!-- egitim Bilgiler Başlangıç -->

									<div class="tab-pane " id="egitim">




										<div class="row">
											<div class="col-md-6">



												ddss





											</div>


											<div class="col-md-6">


												dsdsd


											</div>



										</div>




									</div>
									<!-- egitim Bilgiler Bitiş -->








								</div>
								<input type="submit" class="btn btn-success" style="margin-top:5px;" value="KAYDET" name="gonder" id="gonder">

							</form>

						</div>
					</div>
				</div>

			</div>
		</div>



		<?php 



		?>






		<?php include 'footer.php'; ?>
