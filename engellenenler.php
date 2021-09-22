<?php include 'header.php'; ?>


<?php if ($_SESSION['sessizin'] == 0) {
  header("Location:index.php"); 
  exit();
} ?>


<?php 
    $goster = 10;
    $say=$db->prepare("SELECT * from engel where engel_gonderen=:gonderen");
    $say->execute(array(
     'gonderen' => $uyecodes));
    $toplamveri=$say->rowCount();
    $sayfa_sayisi = ceil($toplamveri / $goster);
    $sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;
    if ($sayfa < 1) {$sayfa = 1;}
    if ($sayfa > $sayfa_sayisi) {$sayfa = 1;}
    $listele = ($sayfa - 1) * $goster;
?>

<?php include 'menu.php'; ?>

<div class="col-md-3 col-sm-12 col-xs-12">

<?php include 'profil-avatar.php'; ?>


</div>




<div class="col-md-6 col-sm-12 col-xs-12 ortbslk">


<?php include 'altmenu.php'; ?>



<?php include 'uyarikutusu.php'; ?>



<div class="py-hak">
<div class="pylsm1">



<div class="ht-pylsm-bslk">
   
<table class="tableclass">
  <thead>
    <tr>
      <th class="hakkinda-tablo">
          
            Engellediğim kullanıcılar (<?php echo $toplamveri; ?>)
      </th>

    </tr>
  </thead>

</table>

</div>

<div class="bildirim-yer-alan">




<?php  


  $engel_sor=$db->prepare("SELECT * from engel where engel_gonderen=:gonderen ORDER BY rand() limit $listele, $goster");
  $engel_sor->execute(array(
  'gonderen' => $uyecodes
  ));


while($engel_cek=$engel_sor->fetch(PDO::FETCH_ASSOC)) { ?>  

<?php  
  $engel_listesi = $engel_cek['engel_alan'];
  $arkadas_listele=$db->prepare("SELECT * from users where uye_code=:code");
  $arkadas_listele->execute(array(
  'code' => $engel_listesi
  ));
  $ark=$arkadas_listele->fetch(PDO::FETCH_ASSOC);

?>

<?php  

$ad = $ark['uye_ad'];
$soyad = $ark['uye_soyad'];

$adsoyad = $ad." ".$soyad;

?>

<?php  
  $uy_listele = $db->prepare("SELECT * from users where uye_code=:uycode");
  $uy_listele->execute(array(
    'uycode' => $ark['uye_code']
    ));
  $uy_li=$uy_listele->fetch(PDO::FETCH_ASSOC);
?>


<div class="bildirim-pnl">


<div class="bildirim-alt">
          
<table class="tableclass">
  <thead>
    <tr>
      <th class="engelth1">
        <div class="minakarti">
          <div class="miniAvatar">
            <img class="minavatarimg" src="<?php echo $ark['uye_mini_resim']; ?>">
          </div>  
        </div>  
      </th>

      <th class="engelth2">
        <div class="pctype">
        <div class="text-pylsm-yazi"><?php echo $adsoyad; ?><?php if ($uy_li['uye_profil_onay'] == 1) { ?><i class="fa fa-check-circle-o onaytype onay-tooltip" aria-hidden="true" aria-hidden="true" data-toggle="tooltip" data-placement="right" data-original-title="Onaylı Profil"></i><?php } ?> - <span><?php { echo $ark['uye_meslek']; } ?></span></div>
        <div class="text-pylsm-st"><?php echo $engel_cek['engel_tarih_saat']; ?></div> 
        </div>

        <div class="mobtype">
        <div class="text-pylsm-yazi"><?php echo $adsoyad; ?><?php if ($uy_li['uye_profil_onay'] == 1) { ?><i class="fa fa-check-circle-o onaytype onay-tooltip" aria-hidden="true" aria-hidden="true" data-toggle="tooltip" data-placement="right" data-original-title="Onaylı Profil"></i><?php } ?></div>
        <div class="text-pylsm-st"><?php echo $engel_cek['engel_tarih_saat']; ?></div> 
        </div>

      </th>

      <th class="engelth3">
        <div class="ht-sag">
          <div class="pctype">
          <a href="data/engel-ac.php?href=<?php echo $engel_listesi; ?>&un=<?php echo $uyecodes; ?>&en=<?php echo $sayfa; ?>"><button class="ek-buti">Engeli aç</button></a>
          </div>

          <div class="mobtype">
          <a href="data/engel-ac.php?href=<?php echo $engel_listesi; ?>&un=<?php echo $uyecodes; ?>&en=<?php echo $sayfa; ?>"><button class="ek-buti"><i class="fa fa-unlock" aria-hidden="true"></i></button></a>
          </div>
        </div>
      </th>

    </tr>
  </thead>
</table>

</div>

</div>

<?php } ?>


<?php if ($toplamveri > 0) { ?>
  <div class="sayfalama-style">
    <div class="sayfalama-panel">
      <div class="sayfalama-panel-alan">
        <div class="sayfalama">
            
        <?php if ($sayfa > 1) { ?>
          <a href="engellenenler?sayfa=1" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="İlk Sayfa"><i class="fa fa-step-backward"></i></a>
          <a href="engellenenler?sayfa=<?=$sayfa - 1?>" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Önceki Sayfa"><i class="fa fa-chevron-left"></i></a>
        <?php } ?>
        

        <?php if ($sayfa != $sayfa_sayisi) { ?>
          <a href="engellenenler?sayfa=<?=$sayfa + 1?>" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Sonraki Sayfa"><i class="fa fa-chevron-right"></i></a>
          <a href="engellenenler?sayfa=<?=$sayfa_sayisi?>" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Son Sayfa"><i class="fa fa-step-forward"></i></a>
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
                  <span>Bildirim: </span>Henüz engellediğiniz kullanıcı yok !
                </div>
              </div>

            </li>
        </ul>
      </div>
    </div>
  </div>

<?php } ?>







</div>



</div>
</div>


<?php include 'copfoot-pc.php'; ?>


</div>





<div class="col-md-3 col-sm-12 col-xs-12">


<?php include 'sag-kategori.php'; ?>

<?php include 'copfoot-mobil.php'; ?>

</div>


<?php include 'footer.php'; ?>
