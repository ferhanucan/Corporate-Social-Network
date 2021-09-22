<?php include 'header.php'; ?>


<?php if ($_SESSION['sessizin'] == 0) {
  header("Location:index.php"); 
  exit();
} ?>

<?php 

if(strlen($_GET['ara']) > 0 and strlen($_GET['ara']) < 31) {

        $yazi_1 = strip_tags($_GET['ara']);
        $yazi_2 = stripslashes($yazi_1);
        $yazi_3 = trim($yazi_2);
        $yazi_4 = htmlspecialchars_decode($yazi_3, ENT_COMPAT);
        $yazi_6 = preg_replace('/[^A-Za-z şıöüğçİŞÖĞÜÇ]/s', '', $yazi_4); 

        function replaceSpace($string)
        {
          $string = preg_replace("/\s+/", " ", $string);
          $string = trim($string);
          return $string;
        }

        $yazi_7 = replaceSpace($yazi_6);

        $aranan = str_replace("\r\n",'', $yazi_7);

    

}else{
  Header("Location:arkadaslar.php?arama=bos&ark=1");
  exit();
}

$goster = 10;
$say=$db->prepare("SELECT * from users where uye_ad LIKE :arama_ad or uye_soyad LIKE :arama_ad or uye_isim LIKE :arama_ad");
$say->execute(array(':arama_ad' => '%'.$aranan.'%'));
$toplamveri=$say->rowCount();
$sayfa_sayisi = ceil($toplamveri / $goster);
$sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;
if ($sayfa < 1) {$sayfa = 1;}
if ($sayfa > $sayfa_sayisi) {$sayfa = 1;}
$listele = ($sayfa - 1) * $goster;

$arama_yap=$db->prepare("SELECT * from users where uye_ad LIKE :arama_ad or uye_soyad LIKE :arama_ad or uye_isim LIKE :arama_ad limit $listele, $goster");
$arama_yap->execute(array(':arama_ad' => '%'.$aranan.'%'));
$aramayapildi= '1';
$arama_varmi=$arama_yap->rowCount();

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
          
            Aranan isim : <?php echo $aranan; ?> (<?php echo $toplamveri; ?>)
      </th>

    </tr>
  </thead>

</table>



<div class="bildirim-yer-alan">


<?php  
while($aramacek=$arama_yap->fetch(PDO::FETCH_ASSOC)) { ?>



<?php  
  $arkadas_sor=$db->prepare("SELECT * from arkadaslar where arkadas_sahibi=:sahibi and arkadas_kiminle=:arkm");
  $arkadas_sor->execute(array(
  'sahibi' => $uyecodes,
  'arkm' => $aramacek['uye_code']
  ));

  $arkadasmi=$arkadas_sor->rowCount();

if ($uyecodes == $aramacek['uye_code']) {
  $arkadas_varmi = 1;
}elseif ($arkadasmi > 0) {
  $arkadas_varmi = 2;
}else {
  $arkadas_varmi = 0;
}

?>

<?php  

$ad = $aramacek['uye_ad'];
$soyad = $aramacek['uye_soyad'];

$adsoyad = $ad." ".$soyad;

?>

<?php  
//online
$online_uye_durumu=$db->prepare("SELECT * from online where online_uyecode=:on_uy");
$online_uye_durumu->execute(array(
'on_uy' => $aramacek['uye_code']
));
$sor_oz=$online_uye_durumu->rowCount();
if ($sor_oz > 0) {
$online_uye_cek=$online_uye_durumu->fetch(PDO::FETCH_ASSOC);
if (date('Y-m-d H:i:s') <= $online_uye_cek['online_zaman']) {
  $uye_onlinemi = 1;
}else {
  $uye_onlinemi = 0;
  $uo_saat = $online_uye_cek['online_saat'];
  
  if (date('d-m-Y') == $online_uye_cek['online_tarih']) { 
    $uo_tarih = 'Bugün'; } else { 
    $uo_tarih = $online_uye_cek['online_tarih']; 
  }
  $uyox = $uo_saat." | ".$uo_tarih;
}
}else {
  $uyox = 'Giriş yapmamış';
}


?>


<?php  
  $uy_listele = $db->prepare("SELECT * from users where uye_code=:uycode");
  $uy_listele->execute(array(
    'uycode' => $aramacek['uye_code']
    ));
  $uy_li=$uy_listele->fetch(PDO::FETCH_ASSOC);
?>


<div class="bildirim-pnl">


<div class="bildirim-alt">
          
<table class="tableclass">
  <thead>
    <tr>
      <th class="ark_th_1">
          <div class="minakarti">
            <a href="kullanici.php?ara=<?php echo $aramacek['uye_profil_code']; ?>&ci=3">
              <div class="miniAvatar">
                <img class="minavatarimg" src="<?php echo $aramacek['uye_mini_resim']; ?>">
              </div>
            </a>
          </div>  
            </th>

            <th class="ark_th_2 tablo-norm">
          <div class="text-pylsm-yazi"><a href="<?php if ($aramacek['uye_code']==$uyecodes) { ?>profil.php?profil=senin&kp=1<?php }else{ ?>kullanici.php?ara=<?php echo $aramacek['uye_profil_code']; ?><?php } ?>&ci=3"><?php echo $adsoyad; ?></a><?php if ($uy_li['uye_profil_onay'] == 1) { ?><i class="fa fa-check-circle-o onaytype onay-tooltip" aria-hidden="true" aria-hidden="true" data-toggle="tooltip" data-placement="right"></i><?php } ?> - <span>
            <?php if ($aramacek['uye_meslek_grup'] > 0) { ?>
              <a href="meslek-alani?m=<?php echo $aramacek['uye_meslek_grup']; ?>"><?php echo $aramacek['uye_meslek']; ?></a>
            <?php } else {
              echo $aramacek['uye_meslek'];
            } ?>
          </span>

          </div>

          <div class="text-pylsm-st"><?php if ($arkadas_varmi == 1) { ?>Senin profilin<?php }elseif ($arkadas_varmi == 2) { ?>Arkadaşın<?php } ?></div> 
            </th>

            <th class="ark_th_2 tablo-hids">
          <div class="text-pylsm-yazi"><a href="kullanici?ara=<?php echo $aramacek['uye_profil_code']; ?>&ci=3"><?php echo $adsoyad; ?></a><?php if ($uy_li['uye_profil_onay'] == 1) { ?><i class="fa fa-check-circle-o onaytype onay-tooltip" aria-hidden="true" aria-hidden="true" data-toggle="tooltip" data-placement="right" data-original-title="Onaylı Profil"></i><?php } ?> - <span>
            <?php if ($aramacek['uye_meslek_grup'] > 0) { ?>
              <a href="meslek-alani?m=<?php echo $aramacek['uye_meslek_grup']; ?>"><?php echo $aramacek['uye_meslek']; ?></a>
            <?php } else {
              echo $aramacek['uye_meslek'];
            } ?>
          </span>
          </div>

         
            </th>

            <th class="ark_th_3">
              <div class="ht-sag">
                <a href="kullanici.php?href=<?php echo $aramacek['uye_profil_code']; ?>"><button class="ek-buti">Görüntüle</button></a>
              </div>
            </th>

    </tr>
  </thead>

</table>

</div>

</div>

<?php } ?>



</div>



<?php if ($arama_varmi > 0) { ?>
  <div class="sayfalama-style">
    <div class="sayfalama-panel">
      <div class="sayfalama-panel-alan">
        <div class="sayfalama">
            
        <?php if ($sayfa > 1) { ?>
          <a href="arama?sayfa=1&ara=<?=$aranan?>" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="İlk Sayfa"><i class="fa fa-step-backward"></i></a>
          <a href="arama?sayfa=<?=$sayfa - 1?>&ara=<?=$aranan?>" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Önceki Sayfa"><i class="fa fa-chevron-left"></i></a>
        <?php } ?>
        

        <?php if ($sayfa != $sayfa_sayisi) { ?>
          <a href="arama?sayfa=<?=$sayfa + 1?>&ara=<?=$aranan?>" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Sonraki Sayfa"><i class="fa fa-chevron-right"></i></a>
          <a href="arama?sayfa=<?=$sayfa_sayisi?>&ara=<?=$aranan?>" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Son Sayfa"><i class="fa fa-step-forward"></i></a>
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
                  <span>Bildirim: </span>Aradığınız isimde kullanıcı yok !
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
