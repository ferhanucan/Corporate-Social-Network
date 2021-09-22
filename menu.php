<?php
if ($inckont == 0) {
  header("Location:index.php"); 
  exit();
}elseif (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
  header("Location:index.php"); 
  exit();
}

$a_bildirim_say=$db->prepare("SELECT * from arkadas_istegi where istek_alan=:bldrm");
$a_bildirim_say->execute(array(
'bldrm' => $uyecodes));
$a_b_varmi=$a_bildirim_say->rowCount(); 

$bildirim_say=$db->prepare("SELECT * from bildirimler where bildirim_kimin=:kimin");
$bildirim_say->execute(array(
'kimin' => $uyecodes));
$b_varmi=$bildirim_say->rowCount(); 

$okunmayanlar=$db->prepare("SELECT * from mesajlar where mesaj_kimin=:kimin and mesaj_okundu=:okundu and mesaj_durum=:durum");
$okunmayanlar->execute(array(
'kimin' => $uyecodes,
'okundu' => '0',
'durum' => '0'));
$okunmayan=$okunmayanlar->rowCount();  
?>




<div class="containerr">
 <div class="row">
  <div class="col-md-12">
   <div id="content" class="content content-full-width">

    <div class="profile" >
     <div class="profile-header">

      <div class="profile-header-cover"></div>

      <div class="profile-header-content">

       <div class="profile-header-img">
        <img src="<?php echo $uye_islem['uye_avatar_resim']; ?>" alt="">
      </div>

      <div class="profile-header-info">
        <h4 class="m-t-10 m-b-5"><?php echo $uye_islem['uye_ad']," ",$uye_islem['uye_soyad']; ?></h4>
        <p class="m-b-10"><?php echo $uye_islem['uye_meslek']; ?></p>
        <a href="#" class="btn btn-sm btn-info mb-2">Profili Düzenle</a>
      </div>

    </div>
  
    <ul class="profile-header-tab nav nav-tabs">
     <li class="nav-item"><a href="profil.php" class="nav-link">GÖNDERİLER</a></li>
     <li class="nav-item"><a href="istekler.php" class="nav-link" >İSTEKLER</a></li>
     <li class="nav-item"><a href="bildirimler.php" class="nav-link">BİLDİRİMLER</a></li>
     <li class="nav-item"><a href="arkadaslar.php" class="nav-link">ARKADAŞLAR</a></li>
     <li class="nav-item"><a href="mesajlar.php" class="nav-link">MESAJLAR</a></li>
     <li class="nav-item"><a href="hakkinda.php" class="nav-link">HAKKINDA</a></li>
   </ul>
  

 </div>
</div>

</div>
</div>
</div>
</div>




