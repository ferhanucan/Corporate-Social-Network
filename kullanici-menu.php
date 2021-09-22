<?php
if ($inckont == 0) {
  header("Location:index.php"); 
  exit();
}elseif (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
  header("Location:index.php"); 
  exit();
} ?>




<div class="containerr">
 <div class="row">

   <div id="content" class="content content-full-width">

    <div class="profile" style="">
     <div class="profile-header">

      <div class="profile-header-cover"></div>

      <div class="profile-header-content">

       <div class="profile-header-img">
        <img src="<?php echo $player_cek['uye_avatar_resim']; ?>" alt="">
      </div>

      <div class="profile-header-info">
        <h4 class="m-t-10 m-b-5"><?php echo $player_cek['uye_ad']," ",$player_cek['uye_soyad']; ?></h4><br>
        <p class="m-b-10"><?php echo $player_cek['uye_meslek']; ?></p>

      
      </div>

    </div>


    <?php $pro_isim = $player_cek['uye_ad']." ".$player_cek['uye_soyad']; ?>


    <?php 
              //istek var mı ?
    if ($uyecodes && $player_cek['uye_code']) {
      $istek_kontrol = $db->prepare("SELECT * from arkadas_istegi where istek_gonderen=:gonderen and istek_alan=:alan");
      $istek_kontrol->execute(array(
        'gonderen' => $uyecodes,
        'alan'=> $player_cek['uye_code']
      ));

      $istek_at=$istek_kontrol->fetch(PDO::FETCH_ASSOC);

      $istek_at_sor=$istek_kontrol->rowCount();
              //ters sorgula
      if ($istek_at_sor == 0) {

        $istek_gelmismi = $db->prepare("SELECT * from arkadas_istegi where istek_gonderen=:gonderen and istek_alan=:alan");
        $istek_gelmismi->execute(array(
          'gonderen' => $player_cek['uye_code'],
          'alan'=> $uyecodes
        ));

        $istek_bak=$istek_gelmismi->fetch(PDO::FETCH_ASSOC);

      }

              //arkadas mı ?
      $arkadas_kontrol = $db->prepare("SELECT * from arkadaslar where arkadas_sahibi=:sahibi and arkadas_kiminle=:kiminle");
      $arkadas_kontrol->execute(array(
        'sahibi' => $uyecodes,
        'kiminle'=> $player_cek['uye_code']
      ));

      $arkadas_varmi_sor=$arkadas_kontrol->rowCount();

      if ($arkadas_varmi_sor > 0) {

        $arkadas_var = 1;
        $ark_drm_cek=$arkadas_kontrol->fetch(PDO::FETCH_ASSOC);
        $ark_durum = $ark_drm_cek['arkadas_durum'];
        $mes_alici = $player_cek['uye_code'];

      }else {
        $arkadas_var = 0;
      }

    } ?>

    <ul class="profile-header-tab nav nav-tabs">

      <?php if ($player_cek['uye_code']!=$uyecodes and $istek_at['istek_durum'] != 1 and $arkadas_var == 0 and $istek_bak['istek_durum'] == 1) { ?>

        <li><a href="data/arkadas-onayla.php?href=<?php echo $istek_bak['istek_profil_code']; ?>&un=<?php echo $uye_islem['uye_code']; ?>&ek=15&i=o" class="onaybuton"><span  class="badge bg-success" style="height:20px;">ONAYLA</span></a></li>

        <li><a href="data/istek-sil.php?href=<?php echo $istek_bak['istek_profil_code']; ?>&un=<?php echo $uye_islem['uye_code']; ?>&ek=15&i=s" class="silbuton"><span class="badge bg-danger" style="height:20px;">SİL</span></a></li>

      <?php }elseif ($player_cek['uye_code']!=$uyecodes and $istek_at['istek_durum'] == 1 and $arkadas_var == 0 and $istek_bak['istek_durum'] != 1) { ?>
        <?php $_SESSION['uye_pro_code'] = $player_cek['uye_code']; ?>
        <li class="adcurs"><a class="dibuton"><span>BEKLEMEDE</span></a></li>

      <?php }elseif ($player_cek['uye_code']!=$uyecodes and $istek_at['istek_durum'] != 1 and $arkadas_var == 0 and $istek_bak['istek_durum'] != 1 and $player_cek['uye_gizlilik'] == 1) { ?>
        <?php $_SESSION['uye_pro_code'] = $player_cek['uye_profil_code']; ?>
        <li><a href="data/arkadas-ekle.php?href=<?php echo $player_cek['uye_profil_code']; ?>&un=<?php echo $uye_islem['uye_code']; ?>&rp=1&a=i" class="arbuton"><span>ARKADAŞ EKLE</span></a></li>

      <?php }elseif ($player_cek['uye_code']!=$uyecodes and $istek_at['istek_durum'] != 1 and $istek_bak['istek_durum'] != 1 and $arkadas_var == 1) { ?>

        <li class="adcurs"><a href="kullanici.php?ara=<?php echo $player_cek['uye_profil_code']; ?>&<?php echo $ad_style; ?>"><div class="adbuton"><span style="color:green;">ARKADAŞIN</span></div></a></li>
        
        <li><a href="kullanici-mesaj.php?ara=<?php echo $player_cek['uye_profil_code']; ?>&<?php echo $ad_style; ?>" class="arbuton"><span>MESAJ YAZ</span></a></li>

      <?php } ?>

      <?php if ($pg_sayfa == 'kullanici-hakkinda') {?>
        <li><a href="kullanici.php?ara=<?php echo $player_cek['uye_profil_code']; ?>&<?php echo $ad_style; ?>" class="arbuton"><span>PROFİL</span></a></li>
      <?php }elseif ($pg_sayfa == 'kullanici-anasayfa') { ?>
        <li><a href="kullanici-hakkinda.php?ara=<?php echo $player_cek['uye_profil_code']; ?>&<?php echo $ad_style; ?>" class="arbuton"><span>HAKKINDA</span></a></li>
      <?php }elseif ($pg_sayfa == 'kullanici-mesajlar') { ?>
        <li><a href="kullanici-hakkinda.php?ara=<?php echo $player_cek['uye_profil_code']; ?>&<?php echo $ad_style; ?>" class="arbuton"><span>HAKKINDA</span></a></li>
      <?php }else { ?>
        <li><a href="kullanici-hakkinda.php?ara=<?php echo $player_cek['uye_profil_code']; ?>&<?php echo $ad_style; ?>" class="arbuton"><span>HAKKINDA</span></a></li>
      <?php } ?>

      <!-- -->






    </ul>

  </div>
</div>

</div>

</div>
</div>
















