<?php error_reporting(0); ?>
<?php include 'header.php'; ?>


<?php $profil_pg = 'profil_hakkinda'; ?>


<?php if ($_SESSION['sessizin'] == 0) {
  header("Location:index.php"); 
  exit();
} ?>


<?php include 'menu.php'; ?>


<div class="col-md-3 col-sm-12 col-xs-12">




</div>




<div class="col-md-6 col-sm-12 col-xs-12 ortbslk" style="margin-bottom:150px;">


  <div class="hakkinda-ust-panel-ds">


    <table class="tableclass">
      <thead>
        <tr>
          <th class="panel-hakkinda-tablo">

            Kişisel Bilgiler
          </th>

        </tr>
      </thead>

    </table>

  </div>

  <div class="hakkinda-alt-panel-ds">

    <div class="hak-meslek-alan">

      <table class="tableclass">
        <thead>
          <tr>
            <th class="">
              <?php 
              $dateOfBirth = $uye_islem['uye_yas']." 00:01:11";
              $today = date("Y-m-d H:i:s");
              $diff = date_diff(date_create($dateOfBirth), date_create($today));
              $uye_yas = $diff->format('%y');

              $dogum_gunu_nezaman = new DateTime($uye_islem['uye_yas']);
              $uye_dogum_gunu = $dogum_gunu_nezaman->format('d-m');
              $simdiki_zaman = date('d-m');


              $xs_kodulistele = $db->prepare("SELECT * from paylasim where paylasim_code=:pxscode");
              $xs_kodulistele->execute(array(
                'pxscode'=> $uyecodes
              ));

              $xs_row=$xs_kodulistele->rowCount();

              $arkadas_sayisi = $db->prepare("SELECT * from arkadaslar where arkadas_sahibi=:arksahip");
              $arkadas_sayisi->execute(array(
                'arksahip'=> $uyecodes
              ));

              $ark_row=$arkadas_sayisi->rowCount();

              function txw($etkisayi){
                $gelen_sayi= array('as','er','df','ty','gh','jk','zx','cv','bn','qm');
                $degisen_sayi = array('0','1','2','3','4','5','6','7','8','9');
                $giden_sayi = str_replace($gelen_sayi,$degisen_sayi,$etkisayi);
                return $giden_sayi; }
                ?>



                <h4 class="aciklamaText"><span>İsim :</span> <?php $ad = $uye_islem['uye_ad']; $soyad = $uye_islem['uye_soyad'];
                echo $ad." ".$soyad; ?><?php if ($uye_islem['uye_profil_onay'] == 1) { ?><i class="fa fa-check-circle-o onaytype onay-tooltip" aria-hidden="true" aria-hidden="true" data-toggle="tooltip" data-placement="right"></i><?php } ?></h4>
                <h4 class="aciklamaText"><span>Meslek :</span> <?php echo $uye_islem['uye_meslek']; ?></h4>
                <h4 class="aciklamaText"><span>Departman :</span> <?php echo $uye_islem['uye_departman']; ?></h4>
                
                <h4 class="aciklamaText"><span>Cinsiyet :</span> <?php echo $uye_islem['uye_cinsiyet']; ?></h4>
                <h4 class="aciklamaText"><span>Yaş :</span> <?php echo $uye_yas; ?> <?php if ($uye_dogum_gunu == $simdiki_zaman) { ?><span><i class="fa fa-gift dg-tooltip" aria-hidden="true" data-toggle="tooltip" data-placement="right" data-original-title="Bugün doğum günü"></i></span><?php } ?></h4>
                <h4 class="aciklamaText"><span>Şehir :</span> <?php echo $uye_islem['uye_il']; ?></h4>
                <h4 class="aciklamaText"><span>İşe Giriş Tarihi :</span> <?php echo $uye_islem['uye_isegiristarihi']; ?></h4>
                <h4 class="aciklamaText"><span>Medeni Hali :</span> <?php echo $uye_islem['uye_medenihal']; ?></h4>
                <h4 class="aciklamaText"><span>Personel Kodu :</span> <?php echo $uye_islem['id']; ?></h4>
                <h4 class="aciklamaText"><span>E-Mail :</span> <?php echo $uye_islem['uye_email']; ?></h4>
                <h4 class="aciklamaText"><span>Telefon Numarası :</span> <?php echo txw($uye_islem['uye_telefon']); ?></h4>


              </th>

              <th>

                
                
                <h4 class="aciklamaText"><span>Arkadaş Sayısı :</span> <?php echo number_format($ark_row); ?></h4>  
                <h4 class="aciklamaText"><span>Paylaşım Sayısı :</span> <?php echo number_format($xs_row); ?></h4>
                

              </th>

            </tr>
          </thead>

        </table>










      </div>

    </div>

  </div>

  <div class="col-md-3 col-sm-12 col-xs-12">



  </div>


  <?php include 'footer.php'; ?>
