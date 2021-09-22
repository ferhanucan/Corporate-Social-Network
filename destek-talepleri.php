<?php include 'header.php'; ?>


<?php if ($_SESSION['sessizin'] == 0) {
  header("Location:index.php"); 
  exit();
} ?>


<?php include 'menu.php'; ?>


<?php 

  $goster = 10;
  $say=$db->prepare("SELECT * from destek_talep where talep_kimin=:tode");
  $say->execute(array(
  'tode' => $uyecodes));

  $toplamveri=$say->rowCount();
  $sayfa_sayisi = ceil($toplamveri / $goster);
  $sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;
  if ($sayfa < 1) {$sayfa = 1;}
  if ($sayfa > $sayfa_sayisi) {$sayfa = 1;}
  $listele = ($sayfa - 1) * $goster;

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
            <button class="yardim_buton">Destek talebi gönder</button>
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
<div class="yar-pan-heading">Tüm destek talepleri</div>

<?php if ($toplamveri > 0) { ?>
<div class="des-body-text">

<?php

  $talep_listele = $db->prepare("SELECT * from destek_talep where talep_kimin=:takimin order by talep_zaman DESC limit $listele, $goster");
  $talep_listele->execute(array(
    'takimin' => $uyecodes
    ));

    while($ta_cek=$talep_listele->fetch(PDO::FETCH_ASSOC)) { ?>

<?php $sonyazan = $ta_cek['talep_sonmesaj']; ?>

<a href="destek-mesaj?dmk=<?php echo $ta_cek['talep_kod']; ?>">
<div class="des-stl-pb">


<div class="hovdes-pan">

<div class="pcwuc">
<table class="tableclass">
  <thead>
    <tr>
      <th width="50%">
        	<div class="text-destek-mess"><?php echo $ta_cek['talep_konu']; ?> - <span><?php if ($sonyazan == 0) { ?>Son yazan : <b class="">Ben</b><?php }elseif ($sonyazan == 1) { ?>Son yazan : <b class="decebir">Destek ekibi</b><?php } ?></span></div>
      </th>
      <th width="50%" class="text-right">

<?php 

  $destek_z1 = new DateTime($ta_cek['talep_zaman']);
  $destek_z2 = $destek_z1->format('H:i | d.m.Y'); 

?>
        
      	<?php if ($ta_cek['talep_durum'] == 1) { ?>
        	<div class="text-destek-acik"><span><?php echo $destek_z2; ?></span>Açık</div>
    	<?php }else { ?>
        	<div class="text-destek-kapali"><span><?php echo $destek_z2; ?></span>Kapalı</div>
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
          <div class="text-destek-mess"><?php echo $ta_cek['talep_konu']; ?></div>
           <div class="text-destek-mess"><span><?php if ($sonyazan == 0) { ?>Son yazan : <b class="">Ben</b><?php }elseif ($sonyazan == 1) { ?>Son yazan : <b class="decebir">Destek ekibi</b><?php } ?></span></div>
      </th>
      <th width="50%" class="text-right">

<?php 

  $destek_z1 = new DateTime($ta_cek['talep_zaman']);
  $destek_z2 = $destek_z1->format('H:i | d.m.Y'); 

?>
        
        <?php if ($ta_cek['talep_durum'] == 1) { ?>
          <div class="text-destek-acik">Açık</div>
          <div class="text-destek-acik"><span><?php echo $destek_z2; ?></span></div>
      <?php }else { ?>
          <div class="text-destek-kapali">Kapalı</div>
          <div class="text-destek-kapali"><span><?php echo $destek_z2; ?></span></div>
      <?php } ?>

      </th>
    </tr>
  </thead>
</table>
</div>



</div>

</div>
</a>

<?php } ?>

</div>
<?php }else { ?>

<div class="dubosl">
	<div class="uyari-paylasim-text"><span>Bildirim: </span>Henüz destek talebi yok !</div>
</div>

<?php } ?>

</div>

<div class="yar-pan-footer">
    
</div>

<?php include 'copfoot-pc.php'; ?>

</div>

<div class="col-md-1 col-sm-12 col-xs-12">
</div>

<?php include 'copfoot-mobil.php'; ?>

<?php include 'footer.php'; ?>