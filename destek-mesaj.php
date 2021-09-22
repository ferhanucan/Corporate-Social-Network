<?php include 'header.php'; ?>


<?php if ($_SESSION['sessizin'] == 0) {
  header("Location:index.php"); 
  exit();
} ?>




<?php 

if (!ctype_digit($_GET['dmk'])) {
  header('Location:destek-talepleri?destekmesaji=bulunamadi&dstk=3');
  exit();
}elseif (strlen($_GET['dmk']) != 30) {
  header('Location:destek-talepleri?destekmesaji=bulunamadi&dstk=3');
  exit();
}else {


$say=$db->prepare("SELECT * from destek_talep where talep_kimin=:taode and talep_kod=:takox");
$say->execute(array(
  'taode' => $uyecodes,
  'takox'=> $_GET['dmk']
));

$toplamveri=$say->rowCount();
if ($toplamveri == 0) {
  header('Location:destek-talepleri?destekmesaji=bulunamadi&dstk=3');
  exit();
}else {
  $talep_cek = $say->fetch(PDO::FETCH_ASSOC);
  $talsonmej = $talep_cek['talep_sonmesaj'];
  $destek_mesaj_kodu = $_GET['dmk'];
}

} 

?>



<div class="col-md-1 col-sm-12 col-xs-12">
</div>

<div class="col-md-10 col-sm-12 col-xs-12">

<?php include 'uyarikutusu.php'; ?>

<div class="destek-tablo">
<table class="tableclass">
  <thead>
    <tr>

      <th width="50%">
        <a href="destek-olustur">
            <button class="yardim_buton">Destek mesajı gönder</button>
        </a>
      </th>

      <th width="50%">
        <a href="yardim">
            <button class="yardim_buton">Yardım</button>
        </a>
      </th>

    </tr>
  </thead>
</table>
</div>

<div class="yardim-panel">
<div class="yar-pan-heading"><a href="destek-talepleri"><i class="fa fa-mail-reply replyback"></i>Geri dön</a></div>
<div class="des-body-text">




<div class="reklam-panel-alt-stil">

<div class="ht-dest-pan">


<div class="pcwuc">
<table class="tableclass">
  <thead>
    <tr>
      <th width="50%">
          <div class="text-destek-mess"><?php echo $talep_cek['talep_konu']; ?> - <span><?php if ($talsonmej == 0) { ?>Son yazan : <b class="">Ben</b><?php }elseif ($talsonmej == 1) { ?>Son yazan : <b class="decebir">Destek ekibi</b><?php } ?></span></div>
      </th>
      <th width="50%" class="ht-sag">
      	<?php if ($talep_cek['talep_durum'] == 1) { ?>
        	<div class="text-destek-acik">Açık</div>
    	<?php }else { ?>
        	<div class="text-destek-kapali">Kapalı</div>
    	<?php } ?>
      </th>
    </tr>
  </thead>
</table>
 </div> 


<div class="mobwuc">
<table class="tableclass">
  <thead>
    <tr>
      <th width="50%">
          <div class="text-destek-mess"><?php echo $talep_cek['talep_konu']; ?></div>
      </th>
      <th width="50%" class="ht-sag">
        <?php if ($talep_cek['talep_durum'] == 1) { ?>
          <div class="text-destek-acik">Açık</div>
      <?php }else { ?>
          <div class="text-destek-kapali">Kapalı</div>
      <?php } ?>
      </th>
    </tr>
  </thead>
</table>
 </div> 


</div>

</div>


<?php





  $destekleri_listele = $db->prepare("SELECT * from destekler where destek_isteyen=:desityn and destek_kod=:deskodux order by destek_zaman ASC");
  $destekleri_listele->execute(array(
    'desityn' => $uyecodes,
    'deskodux' => $destek_mesaj_kodu
    ));

    while($destek_cek=$destekleri_listele->fetch(PDO::FETCH_ASSOC)) { ?>


<div class="reklam-panel-alt-stil">
<div class="jbt">

<div class="pctype">
<div class="<?php if ($destek_cek['destek_kimin'] == 0) { ?>des-cev-pan-1<?php }else { ?>des-cev-pan-2<?php } ?>">
<table class="tableclass">
  <thead>
    <tr>
      <th width="50%">
<?php if ($destek_cek['destek_kimin'] == 0) { ?>
     <div class="destek-isim-text"><span>Gönderen : </span>
        <?php $ad = $uye_islem['uye_ad']; $soyad = $uye_islem['uye_soyad'];
          echo $ad." ".$soyad; ?><?php if ($uye_islem['uye_profil_onay'] == 1) { ?><i class="fa fa-check-circle-o desonaytp onay-tooltip" aria-hidden="true" aria-hidden="true" data-toggle="tooltip" data-placement="right" data-original-title="Onaylı Profil"></i><?php } ?>
    </div>
<?php }else { ?>
    <div class="destek-sistem-text"><span>Cevaplayan : </span>Destek ekibi<i class="fa fa-star supptype" aria-hidden="true"></i></div>
<?php } ?>
      </th>
      <th width="50%" class="text-right text-dest-zaman">
        <?php 

          $destek_z1 = new DateTime($destek_cek['destek_zaman']);
          $destek_z2 = $destek_z1->format('H:i | d.m.Y'); 

          echo $destek_z2; 

        ?>
      </th>
    </tr>
  </thead>
</table>
</div>
</div>


<div class="mobtype">
<div class="<?php if ($destek_cek['destek_kimin'] == 0) { ?>des-cev-pan-1<?php }else { ?>des-cev-pan-2<?php } ?>">
<table class="tableclass">
  <thead>
    <tr>
      <th width="50%">
<?php if ($destek_cek['destek_kimin'] == 0) { ?>
     <div class="destek-isim-text">
        <?php $ad = $uye_islem['uye_ad']; $soyad = $uye_islem['uye_soyad'];
          echo $ad." ".$soyad; ?><?php if ($uye_islem['uye_profil_onay'] == 1) { ?><i class="fa fa-check-circle-o desonaytp onay-tooltip" aria-hidden="true" aria-hidden="true" data-toggle="tooltip" data-placement="right" data-original-title="Onaylı Profil"></i><?php } ?>
    </div>
<?php }else { ?>
    <div class="destek-sistem-text"><span>Destek ekibi</span><i class="fa fa-star supptype" aria-hidden="true"></i></div>
<?php } ?>
      </th>
      <th width="50%" class="text-right text-dest-zaman">
        <?php 

          $destek_z1 = new DateTime($destek_cek['destek_zaman']);
          $destek_z2 = $destek_z1->format('H:i | d.m.Y'); 

          echo $destek_z2; 

        ?>
      </th>
    </tr>
  </thead>
</table>
</div>
</div>




<div class="tumdespan tumdesstyle tumstext">
                        
<?php echo $destek_cek['destek_mesaj']; ?>
            
</div>

</div>
</div>


<?php } ?>

<?php  

if ($talsonmej == 0) { ?>
  <div class="uyari-paylasim-text"><span>Bildirim: </span>Mesajınız inceleniyor, cevap yazma paneli talebinize geri dönüş yapıldığında açılır !</div>
<?php }elseif ($talep_cek['talep_durum'] == 0) { ?>
  <div class="uyari-paylasim-text"><span>Bildirim: </span>Destek konusu kapanmıştır !</div>
<?php }else { ?>

<form method="POST" action="data/destek-gonder.php">


  <?php $_SESSION['uye_code']; ?>
  <input type="hidden" name="dg843xas" value="<?php echo $destek_mesaj_kodu; ?>">
  <input type="hidden" name="ax5321c" value="k12n6ck8t769yd67xz4s">

<div class="jbt">

<div class="ht-panel-ust">
  <div class="text-profil">
    Cevap yazabilirsiniz.
  </div>

</div>
<div class="ht-orta">
    
      <textarea rows="3" id="saydir" class="form-control dest-area tarea setng dezx" name="cevap-metin" placeholder="Göndermek için bir mesaj yazın..."></textarea>
  
</div>

<div class="ht-panel-alt">

<ul class="media-list">
  <li class="media">
    <div class="media-left">
      <div class="medeng">
        <span class="sayitakip">1000</span>
      </div>
    </div>
    <div class="media-body">
      <div class="medeng">
        <b class="birinciyazi">Karakter limiti doldu !</b>
        <b class="ikinciyazi">Karakter limitine ulaştınız.</b>
      </div>      
    </div>
    <div class="media-right">
      <button class="ht-sha buttonclas" name="destek-cevapla">Gönder</button>
    </div>
  </li>
</ul>

</div>

</div>

</form> 
<?php } ?>





</div>
</div>

<div class="yar-pan-footer">
    
</div>

<?php include 'copfoot-pc.php'; ?>

</div>

<div class="col-md-1 col-sm-12 col-xs-12">
</div>

<?php include 'copfoot-mobil.php'; ?>

<?php include 'footer.php'; ?>