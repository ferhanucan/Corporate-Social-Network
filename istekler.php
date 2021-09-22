<?php error_reporting(0); ?>
<?php include 'header.php'; ?>


<?php if ($_SESSION['sessizin'] == 0) {
  header("Location:index.php"); 
  exit();
} ?>


<?php 
  $goster = 20;
  $say=$db->prepare("SELECT * from arkadas_istegi where istek_alan=:alan");
  $say->execute(array(
   'alan' => $uyecodes));
  $toplamveri=$say->rowCount();
  $sayfa_sayisi = ceil($toplamveri / $goster);
  $sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;
  if ($sayfa < 1) {$sayfa = 1;}
  if ($sayfa > $sayfa_sayisi) {$sayfa = 1;}
  $listele = ($sayfa - 1) * $goster;
  $gorunen_buton = 4;
?>

<?php include 'menu.php'; ?>


<div class="col-md-3 col-sm-12 col-xs-12">




</div>




<div class="col-md-6 col-sm-12 col-xs-12 ortbslk" style="margin-bottom:250px;">












<div class="py-hak">
<div class="pylsm1">



   
<table class="tableclass">
  <thead>
    <tr>
      <th class="hakkinda-tablo">
          
            Arkadaşlık istekleri (<?php echo $toplamveri; ?>)
      </th>

    </tr>
  </thead>
</table>



<div class="bildirim-yer-alan">

<?php  


  $isteksor=$db->prepare("SELECT * from arkadas_istegi where istek_alan=:alan and istek_durum=:durum ORDER BY id DESC limit $listele, $goster");
  $isteksor->execute(array(
  'alan' => $uyecodes,
  'durum' => 1
  ));


while($istek_cek=$isteksor->fetch(PDO::FETCH_ASSOC)) { ?>   


<?php  
  $uy_listele = $db->prepare("SELECT * from users where uye_code=:uycode");
  $uy_listele->execute(array(
    'uycode' => $istek_cek['istek_gonderen']
    ));
  $uy_li=$uy_listele->fetch(PDO::FETCH_ASSOC);
?>


<div class="bildirim-pnl">


<div class="bildirim-alt">
          
<table class="tableclass">
  <thead>
    <tr>
      <th class="bsl1_th">
          <div class="minakarti">
            <a href="kullanici?ara=<?php echo $istek_cek['istek_profil_code']; ?>&ci=5">
              <div class="miniAvatar">
                <img class="minavatarimg" src="<?php echo $uy_li['uye_mini_resim']; ?>">
              </div>
            </a> 
          </div>  
            </th>

            <th class="bsl2_th">
          <div class="txtonelimed">
          <div class="text-pylsm-yazi"><a href="kullanici.php?ara=<?php echo $istek_cek['istek_profil_code']; ?>&ci=5"><?php echo $istek_cek['istek_adsoyad']; ?></a><?php if ($uy_li['uye_profil_onay'] == 1) { ?><i class="fa fa-check-circle-o onaytype onay-tooltip" aria-hidden="true" aria-hidden="true" data-toggle="tooltip" data-placement="right" ></i><?php } ?> - <span>
            <?php if ($istek_cek['istek_meslek_grup'] > 0) { ?>
              <a href="meslek-alani.php?m=<?php echo $istek_cek['istek_meslek_grup']; ?>"><?php echo $istek_cek['istek_meslek']; ?></a>
            <?php } else {
              echo $istek_cek['istek_meslek'];
            } ?>
          </span>
          </div>
          </div>

          <div class="txttwolimed">
          <div class="text-pylsm-yazi"><a href="kullanici.php?ara=<?php echo $istek_cek['istek_profil_code']; ?>&ci=5"><?php if (strlen($istek_cek['istek_adsoyad']) > 20) { echo substr($istek_cek['istek_adsoyad'], 0,16).'...'; }else { echo $istek_cek['istek_adsoyad']; } ?></a><?php if ($uy_li['uye_profil_onay'] == 1) { ?><i class="fa fa-check-circle-o onaytype onay-tooltip" aria-hidden="true" aria-hidden="true" data-toggle="tooltip" data-placement="right" ></i><?php } ?> <span>

          </span>
          </div>
          </div>

          <div class="text-pylsm-st"><?php echo $istek_cek['istek_saat']; ?> | <?php echo $istek_cek['istek_tarih']; ?></div> 
            </th>

            <th class="bsl3_th">
              <div class="ht-sag">
              <div class="fributst">
                <a href="data/arkadas-onayla.php?href=<?php echo $istek_cek['istek_profil_code']; ?>&un=<?php echo $uye_islem['uye_code']; ?>&ek=1&i=o"><button class="btn btn-success">ONAYLA</button></a>
              </div>
              
              <div class="fributnex ekpads">
                <a href="data/arkadas-onayla.php?href=<?php echo $istek_cek['istek_profil_code']; ?>&un=<?php echo $uye_islem['uye_code']; ?>&ek=1&i=o"><button class="ek-buti"><i class="fa fa-check"></i></button></a>
              </div>
              </div>
            </th>
            <th class="bsl4_th">
              <div class="ht-sag">
              <div class="fributst">
                <a href="data/istek-sil.php?href=<?php echo $istek_cek['istek_profil_code']; ?>&un=<?php echo $uye_islem['uye_code']; ?>&ek=1&i=s"><button class="btn btn-danger">SİL</button></a>
              </div>

              <div class="fributnex">
                <a href="data/istek-sil.php?href=<?php echo $istek_cek['istek_profil_code']; ?>&un=<?php echo $uye_islem['uye_code']; ?>&ek=1&i=s"><button class="sil-buti"><i class="fa fa-close"></i></button></a>
              </div>
              </div>
            </th>

    </tr>
  </thead>

</table>

</div>

</div>

<?php } ?>


</div>


<?php if ($toplamveri > 0) { ?>
  <div class="sayfalama-style">
    <div class="sayfalama-panel">
      <div class="sayfalama-panel-alan">
        <div class="sayfalama">
            
        <?php if ($sayfa > 1) { ?>
          <a href="istekler?sayfa=1" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="İlk Sayfa"><i class="fa fa-step-backward"></i></a>
          <a href="istekler?sayfa=<?=$sayfa - 1?>" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Önceki Sayfa"><i class="fa fa-chevron-left"></i></a>
        <?php } ?>
        

        <?php if ($sayfa != $sayfa_sayisi) { ?>
          <a href="istekler?sayfa=<?=$sayfa + 1?>" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Sonraki Sayfa"><i class="fa fa-chevron-right"></i></a>
          <a href="istekler?sayfa=<?=$sayfa_sayisi?>" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Son Sayfa"><i class="fa fa-step-forward"></i></a>
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
                  <span>Bildirim: </span>Henüz istek yok !
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





<div class="col-md-3 col-sm-12 col-xs-12">



</div>


<?php include 'footer.php'; ?>
