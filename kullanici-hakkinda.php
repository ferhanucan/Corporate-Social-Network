<?php error_reporting(0) ?>
<?php include 'header.php'; ?>


<?php $pg_sayfa = 'kullanici-hakkinda'; ?>


<?php if ($_SESSION['sessizin'] == 0) {
  header("Location:index.php"); 
  exit();
} ?>


<?php include 'kullanici-kontrol.php'; ?>

<?php include 'kullanici-menu.php'; ?>


<div class="col-md-3 col-sm-12 col-xs-12">



</div>




<div class="col-md-6 col-sm-12 col-xs-12 ortbslk" style="margin-bottom:150px;">










  <div class="py-hak">
    <div class="pylsm1">



      <div class="ht-pylsm-bslk">


        <table class="tableclass">
          <thead>
            <tr>
              <th class="hakkinda-tablo">

                Kişisel Bilgiler
              </th>

            </tr>
          </thead>

        </table>

      </div>

      <div class="hak-meslek-alan">

        <table class="tableclass">
          <thead>
            <tr>
              <th class="">
                <?php 
                $dateOfBirth = $player_cek['uye_yas']." 00:01:11";
                $today = date("Y-m-d H:i:s");
                $diff = date_diff(date_create($dateOfBirth), date_create($today));
                $uye_yas = $diff->format('%y');

                $dogum_gunu_nezaman = new DateTime($player_cek['uye_yas']);
                $uye_dogum_gunu = $dogum_gunu_nezaman->format('d-m');
                $simdiki_zaman = date('d-m');


                $refler = $db->prepare("SELECT * from referans where referans_sahibi=:sahip");
                $refler->execute(array(
                  'sahip' => $player_cek['uye_code']
                ));

                $ref_sayisi=$refler->rowCount();


                $xk_kodulistele = $db->prepare("SELECT * from paylasim where paylasim_code=:pxscode");
                $xk_kodulistele->execute(array(
                  'pxscode'=> $player_cek['uye_code']
                ));

                $xk_row=$xk_kodulistele->rowCount();

                $arkadas_sayisi = $db->prepare("SELECT * from arkadaslar where arkadas_sahibi=:arksahip");
                $arkadas_sayisi->execute(array(
                  'arksahip'=> $player_cek['uye_code']
                ));

                $ark_row=$arkadas_sayisi->rowCount();

                ?>


                <h4 class="aciklamaText"><span>İsim :</span> <?php $ad = $player_cek['uye_ad']; $soyad = $player_cek['uye_soyad']; echo $ad." ".$soyad; ?><?php if ($player_cek['uye_profil_onay'] == 1) { ?><i class="fa fa-check-circle-o onaytype onay-tooltip" aria-hidden="true" aria-hidden="true" data-toggle="tooltip" data-placement="right" data-original-title="Onaylı Profil"></i><?php } ?></h4>       
                <h4 class="aciklamaText"><span>Meslek :</span> <?php echo $player_cek['uye_meslek']; ?></h4>
                <h4 class="aciklamaText"><span>Departman :</span> <?php echo $player_cek['uye_departman']; ?></h4>
                <h4 class="aciklamaText"><span>Cinsiyet :</span> <?php echo $player_cek['uye_cinsiyet']; ?></h4>
                <h4 class="aciklamaText"><span>Yaş :</span> <?php echo $uye_yas; ?> <?php if ($uye_dogum_gunu == $simdiki_zaman) { ?><span><i class="fa fa-gift dg-tooltip" aria-hidden="true" data-toggle="tooltip" data-placement="right" data-original-title="Bugün doğum günü"></i></span><?php } ?></h4>
                <h4 class="aciklamaText"><span>Şehir :</span> <?php echo $player_cek['uye_il']; ?></h4>
                <h4 class="aciklamaText"><span>İşe Giriş Tarihi :</span> <?php echo $player_cek['uye_isegiristarihi']; ?></h4>
                <h4 class="aciklamaText"><span>Medeni Hali :</span> <?php echo $player_cek['uye_medenihal']; ?></h4>
                <h4 class="aciklamaText"><span>Personel Kodu :</span> <?php echo $player_cek['id']; ?></h4>
                <h4 class="aciklamaText"><span>Arkadaş Sayısı :</span> <?php echo number_format($ark_row); ?></h4>  
                <h4 class="aciklamaText"><span>Paylaşım Sayısı :</span> <?php echo number_format($xk_row); ?></h4>
                <h4 class="aciklamaText"><span>E-Mail :</span> <?php echo $player_cek['uye_email']; ?></h4>
                <h4 class="aciklamaText"><span>Telefon Numarası :</span> <?php echo txw($player_cek['uye_telefon']); ?></h4>




              </th>

            </tr>
          </thead>

        </table>

      </div>


    </div>
  </div>





</div>





<div class="col-md-3 col-sm-12 col-xs-12">



</div>


<?php include 'footer.php'; ?>
