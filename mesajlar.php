<?php error_reporting(0); ?>

<?php include 'header.php'; ?>


<?php if ($_SESSION['sessizin'] == 0) {
  header("Location:index.php"); 
  exit();
} ?>



<?php 
    $goster = 10;
    $say=$db->prepare("SELECT * from mesajlar where mesaj_kimin=:kimin");
    $say->execute(array(
     'kimin' => $uyecodes));
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


   
<table class="biltab">
  <thead>
    <tr>

      <th class="bild-t-1">
          <div class="bil-tablo-style">
            Mesajlar (<?php echo $toplamveri; ?>)
          </div>
      </th>

      <th class="bild-t-2">
          <div class="bil-tablo-style-2">

            <?php if ($okunmayan == 0) { ?>
              Okunmayan mesaj yok
            <?php }elseif ($okunmayan > 0) { ?>
              (<?php echo $okunmayan; ?>) Mesaj okunmadı
            <?php } ?>

          </div>
      </th>

    </tr>
  </thead>
</table>


<div class="mesaj-yer-alan">


<?php  


$mesaj_sor=$db->prepare("SELECT * from mesajlar where mesaj_kimin=:kimin ORDER BY mesaj_zaman DESC limit $listele, $goster");
$mesaj_sor->execute(array(
  'kimin' => $uyecodes
  ));


while($m_cek=$mesaj_sor->fetch(PDO::FETCH_ASSOC)) { ?>  

<?php  

$ark_listesi = $m_cek['mesaj_alici'];
$arkadas_listele=$db->prepare("SELECT * from users where uye_code=:code");
$arkadas_listele->execute(array(
'code' => $ark_listesi
));

$ark=$arkadas_listele->fetch(PDO::FETCH_ASSOC);

$ad = $ark['uye_ad'];
$soyad = $ark['uye_soyad'];

$adsoyad = $ad." ".$soyad;

$mesaj_icerik = $m_cek['mesaj_icerik'];
$mesaj_code = $m_cek['mesaj_code'];
$mesaj_durum = $m_cek['mesaj_durum'];
$mesaj_okundu = $m_cek['mesaj_okundu'];

if ($mesaj_durum == 1 and $mesaj_okundu == 0) {
  $mesaj_type = 'gonderilen';
  $sembol_mek = 'fa fa-comment-o';
  $sembol_icerik = 'Gönderildi';
  $m_saat = $m_cek['mesaj_saat'];
  
  if (date('d-m-Y') == $m_cek['mesaj_tarih']) { $m_tarih = 'Bugün'; } else { $m_tarih = $m_cek['mesaj_tarih']; }

}elseif ($mesaj_durum == 0 and $mesaj_okundu == 0) {
  $sembol_mek = 'fa fa-envelope-o';
  $sembol_icerik = 'Okunmadı';
  $mesaj_type = 'okunmadi';
  $m_saat = $m_cek['mesaj_saat'];

  if (date('d-m-Y') == $m_cek['mesaj_tarih']) { $m_tarih = 'Bugün'; } else { $m_tarih = $m_cek['mesaj_tarih']; }

}elseif ($mesaj_durum == 1 and $mesaj_okundu == 1) {
  $sembol_mek = 'fa fa-envelope-open-o';
  $mesaj_type = 'okundu';
  $sembol_icerik = 'Görüldü';
  $m_saat = $m_cek['mesaj_okundu_saat'];

  if (date('d-m-Y') == $m_cek['mesaj_okundu_tarih']) { $m_tarih = 'Bugün'; } else { $m_tarih = $m_cek['mesaj_okundu_tarih']; }

}elseif ($mesaj_durum == 2 and $mesaj_okundu == 1) {
  $sembol_mek = 'fa fa-envelope-open-o';
  $mesaj_type = 'okundu';
  $sembol_icerik = 'Okudum';
  $m_saat = $m_cek['mesaj_okundu_saat'];
  
  if (date('d-m-Y') == $m_cek['mesaj_okundu_tarih']) { $m_tarih = 'Bugün'; } else { $m_tarih = $m_cek['mesaj_okundu_tarih']; }

}

if ($mesaj_durum == 1) {
  $mesaj_sem = 'fa fa-reply';

}elseif ($mesaj_durum == 0 or $mesaj_durum == 2) {

  $mesaj_sem = 'fa fa-share';
}

$_SESSION['mess_sayisi'] = $sayfa;
?>


<?php  
//online
$online_uye_durumu=$db->prepare("SELECT * from online where online_uyecode=:on_uy");
$online_uye_durumu->execute(array(
'on_uy' => $ark_listesi
));
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
?>



<div class="mesaj-pnl">
<a href="konusma.php?msj-a=<?php echo $ark_listesi; ?>&msj-b=<?php echo $uyecodes; ?>&msj-c=<?php echo $mesaj_code; ?>&msj=d&msj-x=eax">

<div class="mesaj-alt <?php echo $mesaj_type; ?>">

<div class="messkione">
<table class="tableclass">
  <thead>
    <tr>
      <th class="mes1_th">
          <div class="minakarti">
            <div class="miniAvatar">
              <img class="minavatarimg" src="<?php if (@getimagesize($ark['uye_mini_resim'])) { ?><?php echo $ark['uye_mini_resim']; ?><?php }else { ?>yimg/profil/disabledprofil.jpg<?php } ?>">
            </div>  
          </div>
        </th>

            <th class="mes2_th">
          <div class="dismessage1">
          <?php if (@getimagesize($ark['uye_mini_resim'])) { ?>
          <div class="text-pylsm-yazi"><?php echo $adsoyad; ?><?php if ($ark['uye_profil_onay'] == 1) { ?><i class="fa fa-check-circle-o onaytype onay-tooltip" aria-hidden="true" aria-hidden="true" data-toggle="tooltip" data-placement="right" data-original-title="Onaylı Profil"></i><?php } ?> - <span><?php echo $ark['uye_meslek']; ?></span></div>
          <div class="text-pylsm-st"><i class="<?php echo $mesaj_sem; ?>" aria-hidden="true"></i><?php echo ' '.$mesaj_icerik; ?></div>
          <?php }else { ?><div class="text-blocked-yazi">Bu hesap kapatılmıştır !</div><?php } ?>
          </div>

          <div class="dismessage2">
          <?php if (@getimagesize($ark['uye_mini_resim'])) { ?>
          <div class="text-pylsm-yazi"><?php echo $adsoyad; ?><?php if ($ark['uye_profil_onay'] == 1) { ?><i class="fa fa-check-circle-o onaytype onay-tooltip" aria-hidden="true" aria-hidden="true" data-toggle="tooltip" data-placement="right" data-original-title="Onaylı Profil"></i><?php } ?>
          </div>
          <div class="text-pylsm-st"><i class="<?php echo $mesaj_sem; ?>" aria-hidden="true"></i><?php echo ' '.$mesaj_icerik; ?></div>
          <?php }else { ?><div class="text-blocked-yazi">Bu hesap kapatılmıştır !</div><?php } ?>
          </div>
            </th>


            <th class="mes3_th">
              <div class="ht-sag">
                <div class="text-mesaj-tar"><?php echo $m_saat; ?> | <?php echo $m_tarih ?></div>
                <div class="text-mesaj-bild"><span><?php echo $sembol_icerik; ?></span><i class="<?php echo $sembol_mek; ?>" aria-hidden="true"></i></div>
              </div>
            </th>

    </tr>
  </thead>

</table>
</div>

<div class="messkitwo">
<table class="tableclass">
  <thead>
    <tr>
      <th class="mes1_th">
          <div class="minakarti">
            <div class="miniAvatar">
              <img class="minavatarimg" src="<?php if (@getimagesize($ark['uye_mini_resim'])) { ?><?php echo $ark['uye_mini_resim']; ?><?php }else { ?>yimg/profil/disabledprofil.jpg<?php } ?>">
            </div>  
          </div>
        </th>

            <th class="mes2_th">
          <?php if (@getimagesize($ark['uye_mini_resim'])) { ?>
          <div class="text-pylsm-yazi"><?php if (strlen($adsoyad) > 20) { echo substr($adsoyad, 0,10).'...'; }else { echo $adsoyad; } ?><?php if ($ark['uye_profil_onay'] == 1) { ?><i class="fa fa-check-circle-o onaytype onay-tooltip" aria-hidden="true" aria-hidden="true" data-toggle="tooltip" data-placement="right" data-original-title="Onaylı Profil"></i><?php } ?> - <span><?php echo $ark['uye_meslek']; ?></span></div>
          <div class="text-mob-mesbil"><?php echo $sembol_icerik; ?><i class="<?php echo $sembol_mek; ?>" aria-hidden="true"></i> <?php echo $m_saat; ?> | <?php echo $m_tarih ?></div>


          <?php }else { ?><div class="text-blocked-yazi">Bu hesap kapatılmıştır !</div><?php } ?>
            </th>

    </tr>
  </thead>

</table>
</div>



</div>
</a>
</div>

<?php } ?>


</div>


<?php if ($toplamveri > 0) { ?>
  <div class="sayfalama-style">
    <div class="sayfalama-panel">
      <div class="sayfalama-panel-alan">
        <div class="sayfalama">
            
        <?php if ($sayfa > 1) { ?>
          <a href="bildirimler.php?sayfa=1" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="İlk Sayfa"><i class="fa fa-step-backward"></i></a>
          <a href="bildirimler.php?sayfa=<?=$sayfa - 1?>" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Önceki Sayfa"><i class="fa fa-chevron-left"></i></a>
        <?php } ?>
        

        <?php if ($sayfa != $sayfa_sayisi) { ?>
          <a href="bildirimler.php?sayfa=<?=$sayfa + 1?>" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Sonraki Sayfa"><i class="fa fa-chevron-right"></i></a>
          <a href="bildirimler.php?sayfa=<?=$sayfa_sayisi?>" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Son Sayfa"><i class="fa fa-step-forward"></i></a>
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
                  <span>Bildirim: </span>Henüz mesaj yok !
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
