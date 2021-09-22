<?php include 'header.php'; ?>


<?php $pg_sayfa = 'kullanici-fotograflar'; ?>


<?php if ($_SESSION['sessizin'] == 0) {
  header("Location:index.php"); 
  exit();
} ?>


<?php include 'kullanici-kontrol.php'; ?>


<?php 
  $goster = 10;
  $say=$db->prepare("SELECT * from fotograf where foto_uye_code=:foced");
  $say->execute(array(
   'foced' => $sorulan_uye));
  $toplamveri=$say->rowCount();
  $sayfa_sayisi = ceil($toplamveri / $goster);
  $sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;
  if ($sayfa < 1) {$sayfa = 1;}
  if ($sayfa > $sayfa_sayisi) {$sayfa = 1;}
  $listele = ($sayfa - 1) * $goster;
  $_SESSION['foto_sayfa'] = $sayfa;
?>


<div class="col-md-3 col-sm-12 col-xs-12">

<?php include 'kullanici-avatar.php'; ?>

</div>




<div class="col-md-6 col-sm-12 col-xs-12 ortbslk">



<?php include 'kullanici-menu.php'; ?>




<?php include 'uyarikutusu.php'; ?>




<div class="foto-ust-panel-ds">


   
<table class="tableclass">
  <thead>
    <tr>
      <th class="fotograf-tablo">
        Fotoğraflar (<?php echo $toplamveri; ?>)
      </th>

    </tr>
  </thead>
</table>

</div>

<div class="foto-alt-panel-ds">


<div class="bildirim-yer-alan">

<?php  

  $arkadas_kontrol = $db->prepare("SELECT * from arkadaslar where arkadas_sahibi=:sahibi and arkadas_kiminle=:kiminle");
  $arkadas_kontrol->execute(array(
  'sahibi' => $uyecodes,
  'kiminle'=> $sorulan_uye
  ));

  $ark_ters_kontrol = $db->prepare("SELECT * from arkadaslar where arkadas_sahibi=:sahibi and arkadas_kiminle=:kiminle");
  $ark_ters_kontrol->execute(array(
  'sahibi' => $sorulan_uye,
  'kiminle'=> $uyecodes
  ));

  $arkadas_varmi_sor=$arkadas_kontrol->rowCount();
  $arkadas_ters_sor=$ark_ters_kontrol->rowCount();

  if ($arkadas_varmi_sor > 0 and $arkadas_ters_sor > 0) {

      $arkadas_var = 1;

  }else {
      $arkadas_var = 0;
  }
?>


<?php if ($arkadas_var == 1) { ?>

<?php  
  $paylasim_listele = $db->prepare("SELECT * from fotograf where foto_uye_code=:fouy order by id DESC limit $listele, $goster");
  $paylasim_listele->execute(array(
    'fouy' => $sorulan_uye
    ));

    while($fotocek=$paylasim_listele->fetch(PDO::FETCH_ASSOC)) { ?>

<?php $plink = $fotocek['foto_code']; ?>

<div class="fotograf-duzen-orta">
<table class="tableclass">
  <thead>
    <tr>

      <th class="resbas3">

<?php if (strlen($fotocek['foto_text']) > 0) { ?>
    <span class="fotobaste"><?php echo $fotocek['foto_text']; ?></span><br>
    <span class="foto-yz">Yükleme zamanı - <a href="fotograf-listele?fotlist=<?php echo $plink; ?>"><?php echo $fotocek['foto_saat']; ?> | <?php echo $fotocek['foto_tarih']; ?></a></span>
<?php } else { ?>
    <span class="fotobaste">Yükleme zamanı - <span class="foto-yz"><a href="fotograf-listele?fotlist=<?php echo $plink; ?>"><?php echo $fotocek['foto_saat']; ?> | <?php echo $fotocek['foto_tarih']; ?></a></span></span>
<?php } ?>

      </th>

    </tr>
  </thead>
</table>
</div>

<?php

  $fo_code = $fotocek['foto_code'];
  $foto_atan_kisi = $uye_islem['uye_code'];

if ($fo_code && $foto_atan_kisi) {

    $oyvermismi=$db->prepare("SELECT * from fotograf_durum where foto_code=:fokodu and foto_oyveren_uye=:uyekodu");
    $oyvermismi->execute(array(
    'fokodu' => $fo_code,
    'uyekodu' => $foto_atan_kisi
    ));

    $oysor=$oyvermismi->rowCount();
    $oycek=$oyvermismi->fetch(PDO::FETCH_ASSOC);


} 
?>

<div class="ht-foto-aln">
<table class="tableclass">
  <thead>
    <tr>
      <th class="respan">

<div class="pop">
<img class="foto-pan-style" src="<?php echo $fotocek['foto_resim_yol']; ?>">
</div>

<div class="modal" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <img src="" class="imagepreview">
      </div>
    </div>
  </div>
</div>

      </th>
      <th class="respan2">
        <span class="begeni-style">Beğeni sayısı</span><br>
        <span class="begeni-style-alt"><?php echo number_format($fotocek['foto_begeni']); ?></span>
        <br>

  <?php if ($oysor > 0 and $oycek['foto_durum'] == 1) { ?>
  <div class="bediv">
    <i class="fa fa-check beclass"></i>
  </div>
  <?php } else { ?>
  <div class="hedvc">
  <a href="data/kullanici-fotodurum.php?foc=<?php echo $fotocek['foto_code']; ?>&ara=<?php echo $aranan_uye; ?>&xfo=1&ftuyc=<?php echo $uyecodes; ?>&ku=fo">
    <i class="fa fa-heart-o heclass"></i>
  </a>
  </div>
  <?php } ?>


      </th>
    </tr>
  </thead>
</table>


</div>


<div class="fotograf-duzen-ara">
</div>

<?php } ?>

<?php } elseif ($toplamveri > 0 and $arkadas_var == 0) { ?>
<div class="b-panel-ds">
    <div class="bildirim-mini-panel">
      <div class="bildirim-mini-alan">
        <ul class="media-list">
          <li class="media">
            <div class="media-body">
              <div class="uyari-paylasim-text">
                  <span>Bildirim: </span>Fotoğrafları sadece arkadaşları görebilir !
                </div>
              </div>

            </li>
        </ul>
      </div>
    </div>
</div>
<?php } ?>


</div>


<?php if ($toplamveri > 0) { ?>

<?php if ($arkadas_var == 1) { ?>
  <div class="foto-pg-style">
    <div class="sayfalama-panel">
      <div class="sayfalama-panel-alan">
        <div class="sayfalama">

            
        <?php if ($sayfa > 1) { ?>
          <a href="fotograflar?sayfa=1" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="İlk Sayfa"><i class="fa fa-step-backward"></i></a>
          <a href="fotograflar?sayfa=<?=$sayfa - 1?>" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Önceki Sayfa"><i class="fa fa-chevron-left"></i></a>
        <?php } ?>
        

        <?php if ($sayfa != $sayfa_sayisi) { ?>
          <a href="fotograflar?sayfa=<?=$sayfa + 1?>" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Sonraki Sayfa"><i class="fa fa-chevron-right"></i></a>
          <a href="fotograflar?sayfa=<?=$sayfa_sayisi?>" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Son Sayfa"><i class="fa fa-step-forward"></i></a>
        <?php } ?>


        
        </div>
      </div>
    </div>
  </div>
<?php } ?>

<?php }else { ?>

  <div class="uyari-pb">
    <div class="bildirim-mini-panel">
      <div class="bildirim-mini-alan">
        <ul class="media-list">
          <li class="media">
            <div class="media-body">
              <div class="uyari-paylasim-text">
                  <span>Bildirim: </span>Henüz fotoğraf yok !
                </div>
              </div>

            </li>
        </ul>
      </div>
    </div>
  </div>

<?php } ?>


</div>


<?php include 'copfoot-pc.php'; ?>


</div>





<div class="col-md-3 col-sm-12 col-xs-12">


<?php include 'sag-kategori.php'; ?>

<?php include 'copfoot-mobil.php'; ?>

</div>


<?php include 'footer.php'; ?>
