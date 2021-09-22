<?php
if ($inckont == 0) {
  header("Location:index.php"); 
  exit();
}elseif (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
  header("Location:index.php"); 
  exit();
} ?>

<div class="avatar-tablo">
<div class="profilkarti">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">


<div class="col-lg-12 col-md-12 col-sm-6 col-xs-6 numstyp1">
<div class="avpad" onContextMenu="return false">
<div id="proResim">
  <a href="kullanici?ara=<?php echo $player_cek['uye_profil_code']; ?>">
      <img class="cerceve" src="<?php echo $player_cek['uye_avatar_resim']; ?>">
  </a>    
</div>
</div>
</div>


<?php  
    $yayin_limit = 1;
    $yayinvarmi=$db->prepare("SELECT * from yayin where yayin_uyecode=:yode ORDER BY id DESC LIMIT $yayin_limit");
    $yayinvarmi->execute(array(
    'yode' => $player_cek['uye_code']
    ));
    $yayinsay=$yayinvarmi->rowCount();

    if ($yayinsay > 0) {
      $yayin_cek=$yayinvarmi->fetch(PDO::FETCH_ASSOC); 
      if ($yayin_cek['yayin_durum'] == 1) {
        $yayindurum = 'Devam ediyor';
      }else {
        $yayindurum = 'Sona erdi';
      }

      if ($yayin_cek['yayin_cekilis'] == 1) {
        if ($yayin_cek['yayin_cekilis_sayisi'] == 2) {
            $cekilis_durum = '1 kişiye';
        }elseif ($yayin_cek['yayin_cekilis_sayisi'] == 3) {
            $cekilis_durum = '5 kişiye';
        }elseif ($yayin_cek['yayin_cekilis_sayisi'] == 4) {
            $cekilis_durum = '10 kişiye';
        }else {
          $cekilis_durum = 'Yok';
        }

      }else {
        $cekilis_durum = 'Yok';
      }


    }

  
?>

<div class="col-lg-12 col-md-12 col-sm-6 col-xs-6 numstyp2">
  <div class="avpad2 avpad-style">
    <h1 class="avatarname">
      Son yayınım
    </h1>

 

<?php if ($yayinsay > 0) { ?> 

    <h4 class="avatardetay avatar-wd"><span>Yayın : </span><?php echo $yayin_cek['yayin_baslik']; ?></h4>
    <h4 class="avatardetay"><?php if ($_SESSION['sessizin'] == 1) { ?><span>Kodu : </span><a href="yayin-listele?yaylist=<?php echo $yayin_cek['yayin_code']; ?>"><?php echo $yayin_cek['yayin_code']; ?></a><?php }else { ?><span>Kodu : </span><?php echo $yayin_cek['yayin_code']; ?><?php } ?></h4>
    <h4 class="avatardetay"><span>Takip : </span><?php echo $yayin_cek['yayin_takip_sayisi']; ?></h4>
    <h4 class="avatardetay"><span>Hediye : </span><?php echo $cekilis_durum; ?></h4>
    <h4 class="avatardetay"><span>Durum : </span><?php echo $yayindurum; ?></h4>

    <?php }else { ?> 

    <h4 class="avatardetay"><span>Mevcut yayın yok</span></h4>
    <h4 class="avatardetay">Yayın oluşturulmadı</h4>

<?php } ?>

  </div>
</div>

</div>
</div>
</div>
