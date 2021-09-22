<?php include 'header.php'; ?>


<?php if ($_SESSION['sessizin'] == 0) {
  header("Location:index.php"); 
  exit();
} ?>


<?php 
  $goster = 10;
  $say=$db->prepare("SELECT * from fotograf where foto_uye_code=:foced");
  $say->execute(array(
   'foced' => $uyecodes));
  $toplamveri=$say->rowCount();
  $sayfa_sayisi = ceil($toplamveri / $goster);
  $sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;
  if ($sayfa < 1) {$sayfa = 1;}
  if ($sayfa > $sayfa_sayisi) {$sayfa = 1;}
  $listele = ($sayfa - 1) * $goster;
  $_SESSION['foto_sayfa'] = $sayfa;
?>


<?php include 'menu.php'; ?>


<div class="col-md-3 col-sm-12 col-xs-12">

<?php include 'profil-avatar.php'; ?>


</div>




<div class="col-md-6 col-sm-12 col-xs-12 ortbslk">



<?php include 'altmenu.php'; ?>




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


<div class="fotograflar-yer-alan">


<div class="bildirim-pnl">

<form method="POST" action="tkpan/paylasim/fotograf-paylas.php" enctype="multipart/form-data">

  <?php $_SESSION['uye_code']; ?>


<div class="foto-panel">



<div class="foto-ust-pnl">
 <table class="tableclass">
  <thead>
    <tr>

      <th class="rek_tablo_1">
        <span class="rekspan pc_inibig">Fotoğraf açıklaması (isteğe bağlı)</span><span class="rekspan mob_inibig">Fotoğraf açıklaması</span><span class="fotbl">30</span>
      </th>

      <th class="rek_tablo_2">
        <div class="fotbas"><span class="vidnopc">Karakter limiti doldu !</span><span class="vidnomob">Limit aşımı !</span></div>
        <div class="fotbuy"><span class="vidnopc">Karakter limitine ulaştınız.</span><span class="vidnomob">Limit doldu.</span></div>
      </th>

    </tr>
  </thead>
</table>   
</div>


<div class="foto-alan-pnl">  
  <input id="foto_baslik" type="text" class="form-control foto_area_type foto_text_lmt foto_text_type" name="foto_text" placeholder="Fotoğraf için açıklama"/>
</div>


<div class="fotopaylas">

  <div class="ht-panel-foto">
    <div class="text-models">
      <span class="tpspan">Yüklemek istediğiniz fotoğrafı seçin</span>
    </div>
  </div>

 <table class="tableclass">
  <thead>
    <tr>

    <th class="res-pay-th1">
    <div class="res-pay-style1">

        <div class="file-upload">
            <label for="fotost-file" class="file-upload__label"><i class="fa fa-camera" aria-hidden="true"></i><span class="vidnopc">  Fotoğraf Ekle</span></label>
            <input id="fotost-file" class="file-upload__input dosyaYukle" type="file" accept="image/*" name="foto_yukle">
        </div> 
        
    </div>
    </th>

    <th class="res-pay-th2">
      <div class="res-pay-style2">
        <div class="fores">
          <div id="ft-foto"></div>
        </div>

        <div class="foyaz">
          Fotoğraf yok
        </div>
      </div>
    </th>

    <th class="res-pay-th3">
      <div class="res-pay-style3">
        <button id="btn-fotost-file-reset" type="button">Kaldır</button>
      </div>
    </th>

    </tr>

  </thead>
</table>


 <table class="tableclass">
  <thead>
    <tr>

    <th class="yukleth">
        <div class="yuklebuton-style">
          <button class="yuklebuton" name="fotograf_paylas">Şimdi Yükle</button>
        </div>
    </th>

    </tr>

  </thead>
</table>
</div>
</div>    

</form>


<table class="tableclass">
  <thead>
    <tr>
      <th class="thfoto">
        <div class="fotobtnstyle">
          <div class="fotobuton"><i class="fa fa-camera bres" aria-hidden="true"></i> Fotoğraf ekle - <span class="foto-ackapat">Aç</span></div>
        </div>
      </th>
    </tr>
  </thead>
</table>


</div>

<div class="fotograf-duzen-ara">
</div>


<?php  
  $paylasim_listele = $db->prepare("SELECT * from fotograf where foto_uye_code=:fouy order by id DESC limit $listele, $goster");
  $paylasim_listele->execute(array(
    'fouy' => $_SESSION['uye_code']
    ));

    while($f_c=$paylasim_listele->fetch(PDO::FETCH_ASSOC)) { ?>

<?php $plink = $f_c['foto_code']; ?>

<div class="fotograf-duzen-orta">
<table class="tableclass">
  <thead>
    <tr>
      <th class="resbas">

<?php if (strlen($f_c['foto_text']) > 0) { ?>
    <span class="fotobaste"><?php echo $f_c['foto_text']; ?></span><br>
    <span class="foto-yz">Yükleme zamanı - <a href="fotograf-listele?fotlist=<?php echo $plink; ?>"><?php echo $f_c['foto_saat']; ?> | <?php echo $f_c['foto_tarih']; ?></a></span>
  <?php } else { ?>
    <span class="fotobaste">Yükleme zamanı - </span><span class="foto-yz"><a href="fotograf-listele?fotlist=<?php echo $plink; ?>"><?php echo $f_c['foto_saat']; ?> | <?php echo $f_c['foto_tarih']; ?></a></span>
  <?php } ?>

      </th>
      <th class="resbas2">
              <div class="dropdown ht-sag">
                <button class="btn-htran dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-chevron-down" aria-hidden="true"></i>
                </button>
                <ul class="dropdown-menu">
                  <li><a href="data/fotosil.php?foc=<?php echo $f_c['foto_code']; ?>&ftuyc=<?php echo $uyecodes; ?>&fo=si">Sil</a></li>
                </ul>
              </div>
      </th>
    </tr>
  </thead>
</table>
</div>

<?php

  $fo_code = $f_c['foto_code'];
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
<img class="foto-pan-style" src="<?php echo $f_c['foto_resim_yol']; ?>">
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
        <span class="begeni-style-alt"><?php echo number_format($f_c['foto_begeni']); ?></span>
        <br>

  <?php if ($oysor > 0 and $oycek['foto_durum'] == 1) { ?>
  <div class="bediv">
    <i class="fa fa-check beclass"></i>
  </div>
  <?php } else { ?>
  <div class="hedvc">
  <a href="data/fotodurum.php?foc=<?php echo $f_c['foto_code']; ?>&ftuyc=<?php echo $uyecodes; ?>&fo=be">
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



</div>


<?php if ($toplamveri > 0) { ?>
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
