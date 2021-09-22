<?php error_reporting(0); ?>

<?php include 'header.php'; ?>

<?php $profil_pg = 'profil_bildirim'; ?>


<?php if ($_SESSION['sessizin'] == 0) {
  header("Location:index.php"); 
  exit();
} ?>


<?php 
    $goster = 10;
    $bsay=$db->prepare("SELECT * from bildirimler where bildirim_kimin=:kimin");
    $bsay->execute(array(
     'kimin' => $uyecodes));
    $toplamveri=$bsay->rowCount();
    $sayfa_sayisi = ceil($toplamveri / $goster);
    $sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;
    if ($sayfa < 1) {$sayfa = 1;}
    if ($sayfa > $sayfa_sayisi) {$sayfa = 1;}
    $listele = ($sayfa - 1) * $goster;

?>

<?php if ($_SESSION['sessizin'] == 1) {
include 'menu.php'; 
} ?>


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
            Bildirimler (<?php echo $toplamveri; ?>)
          </div>
      </th>

      <th class="bild-t-2">
          <div class="bil-tablo-style-2">

            <?php if ($toplamveri > 0) { ?> 

            
            <?php } ?>


          </div>
      </th>

    </tr>
  </thead>

</table>


<div class="bildirim-yer-alan">

<?php 
  $bildirim_sor=$db->prepare("SELECT * from bildirimler where bildirim_kimin=:kimin ORDER BY bildirim_zaman DESC limit $listele, $goster");
  $bildirim_sor->execute(array(
  'kimin' => $uyecodes
  ));


while($b_cek=$bildirim_sor->fetch(PDO::FETCH_ASSOC)) { ?>  

<?php  

$ark_listesi = $b_cek['bildirim_gonderen'];
$arkadas_listele=$db->prepare("SELECT * from users where uye_code=:code");
$arkadas_listele->execute(array(
'code' => $ark_listesi
));

$ark=$arkadas_listele->fetch(PDO::FETCH_ASSOC);

$_SESSION['bil_sayisi'] = $sayfa; 

$ad = $ark['uye_ad'];
$soyad = $ark['uye_soyad'];

$adsoyad = $ad." ".$soyad;

$mes_alici = $ark_listesi;


if (date('d-m-Y') == $b_cek['bildirim_tarih']) { 
  $bild_tarih = 'Bugün'; } else { 
  $bild_tarih = $b_cek['bildirim_tarih']; 
}

?>



<div class="bildirim-pnl">

<div class="bildirim-alt">
          
<table class="tableclass">
  <thead>
    <tr>
      <th class="bild1_th">
          <div class="minakarti">
            <a href="kullanici.php?ara=<?php echo $ark['uye_profil_code']; ?>&ci=4">
              <div class="miniAvatar">
                <img class="minavatarimg" src="<?php if (@getimagesize($ark['uye_mini_resim'])) { ?><?php echo $ark['uye_mini_resim']; ?><?php }else { ?>yimg/profil/disabledprofil.jpg<?php } ?>">
              </div>
            </a> 
          </div>  
            </th>

            <th class="bild2_th">
          <?php if (@getimagesize($ark['uye_mini_resim'])) { ?>
          <div class="txtonelimed">
          <div class="text-pylsm-yazi"><a href="kullanici.php?ara=<?php echo $ark['uye_profil_code']; ?>&ci=4"><?php echo $adsoyad; ?></a><?php if ($ark['uye_profil_onay'] == 1) { ?><i class="fa fa-check-circle-o onaytype onay-tooltip" aria-hidden="true" aria-hidden="true" data-toggle="tooltip" data-placement="right"></i><?php } ?> - <span>
            <?php if ($ark['uye_meslek_grup'] > 0) { ?>
              <a href="meslek-alani.php?m=<?php echo $ark['uye_meslek_grup']; ?>"><?php echo $ark['uye_meslek']; ?></a>
            <?php }else {
              echo $ark['uye_meslek'];
            } ?>
            </span>
          </div>
          </div>

          <div class="txttwolimed">
          <div class="text-pylsm-yazi"><a href="kullanici.php?ara=<?php echo $ark['uye_profil_code']; ?>&ci=4"><?php if (strlen($adsoyad) > 20) { echo substr($adsoyad, 0,10).'...'; }else { echo $adsoyad; } ?></a><?php if ($ark['uye_profil_onay'] == 1) { ?><i class="fa fa-check-circle-o onaytype onay-tooltip" aria-hidden="true" aria-hidden="true" data-toggle="tooltip" data-placement="right" data-origi></i><?php } ?>
          </div>
          </div>

          <div class="txtnoted">
          <div class="text-pylsm-yazi"><a href="kullanici.php?ara=<?php echo $ark['uye_profil_code']; ?>&ci=4"><?php if (strlen($adsoyad) > 20) { echo substr($adsoyad, 0,16).'...'; }else { echo $adsoyad; } ?></a><?php if ($ark['uye_profil_onay'] == 1) { ?><i class="fa fa-check-circle-o onaytype onay-tooltip" aria-hidden="true" aria-hidden="true" data-toggle="tooltip" data-placement="right"></i><?php } ?>
          </div>
          </div>

          <div class="text-pylsm-st"><?php echo $b_cek['bildirim_saat']; ?> | <?php echo $bild_tarih; ?></div> 
          <?php }else { ?><div class="text-blocked-yazi">Bu hesap kapatılmıştır !</div><?php } ?>
            </th>

<?php  

$bildirim_icerik = $b_cek['bildirim_icerik'];
$bildirim_code = $b_cek['bildirim_code'];

if ($b_cek['bildirim_durum'] == 1 or $b_cek['bildirim_durum'] == 2) {
    $bildirim_isor=$db->prepare("SELECT * from paylasim where paylasim_ozelcode=:ozelcode and paylasim_code=:paycode");
    $bildirim_isor->execute(array(
    'ozelcode' => $bildirim_icerik,
    'paycode' => $uyecodes
    ));

    $icerik_varmi=$bildirim_isor->rowCount();
if ($icerik_varmi > 0) {
    $bilic=$bildirim_isor->fetch(PDO::FETCH_ASSOC);
    $bildirim_text = substr($bilic['paylasim_text'], 0,15).' ...';
    }


}

    $prokodu = $ark['uye_profil_code'];


 
  $mesaj_engsor=$db->prepare("SELECT * from arkadaslar where arkadas_sahibi=:sahibi and arkadas_kiminle=:kiminle");
  $mesaj_engsor->execute(array(
  'sahibi' => $uyecodes,
  'kiminle' => $mes_alici
  ));
  $me_en_sor=$mesaj_engsor->fetch(PDO::FETCH_ASSOC);
                  

  $engel_xsor=$db->prepare("SELECT * from engel where engel_gonderen=:gonderen and engel_alan=:alan");
  $engel_xsor->execute(array(
  'gonderen' => $uyecodes,
  'alan' => $ark_listesi
  ));

  $engel_varmi_sor=$engel_xsor->rowCount();

  if ($engel_varmi_sor > 0) {
      $engel_durum = 1;
  }else {
      $engel_durum = 0;
  }

?>


            <th class="bild3_th">
              <?php $bildirim_durum = $b_cek['bildirim_durum']; ?>
              <?php 
              if ($bildirim_durum == 1) { ?>
              <a href="paylasim-listele?paylist=<?php echo $bildirim_icerik; ?>">
              <div class="begeni-bildirim">Bu paylaşımı beğendi</div>
              </a>

              <div class="text-pylsm-st"><?php echo $bildirim_text; ?></div>

              <?php } 
              elseif ($bildirim_durum == 2) { ?>
              <a href="paylasim-listele?paylist=<?php echo $bildirim_icerik; ?>">
              <div class="begenmedi-bildirim">Bu paylaşımı beğenmedi</div>
              </a>

              <div class="text-pylsm-st"><?php echo $bildirim_text; ?></div>

              <?php }  
              elseif ($bildirim_durum == 3) { ?>
              
              <div class="engel-bildirim">Profil engeli aldınız !</div>
              <?php $_SESSION['uye_karsi_engel'] = $prokodu; ?>
              <a href="data/engel.php?href=<?php echo $prokodu; ?>&un=<?php echo $uye_islem['uye_code']; ?>&bd=1&u=e">
                <?php if ($engel_durum == 0) { ?>
                  <div class="text-pylsm-st">Buradan sizde engel atabilirsiniz.</div>
                <?php } ?>
              </a>

              <?php }  
              elseif ($bildirim_durum == 4) { ?>
              
              <div class="arkadas-bildirim">Arkadaş oldunuz</div>
              

              <?php }  
              elseif ($bildirim_durum == 5) { ?>

              <div class="mesaj_engel-bildirim">Mesaj engeli aldınız !</div>
              <a href="data/mesaj-engel.php?msj-a=<?php echo $mes_alici; ?>&msj-b=<?php echo $uyecodes; ?>&msj-t=x&msj-e=l">
                <?php if ($me_en_sor['arkadas_durum'] == 1) { ?>
                  <div class="text-pylsm-st">Buradan sizde engel atabilirsiniz.</div>
                <?php } ?>
              </a>
              

              <?php }  
              elseif ($bildirim_durum == 6) { ?>

              <div class="mesaj_ac-bildirim">Mesaj engelini kaldırdı !</div>
              <a href="data/mesaj-ac.php?msj-a=<?php echo $mes_alici; ?>&msj-b=<?php echo $uyecodes; ?>&msj-j=c&msj-s=a">
                <?php if ($me_en_sor['arkadas_durum'] == 0) { ?>
                  <div class="text-pylsm-st">Buradan sizde kaldırabilirsiniz.</div>
                <?php } ?>
              </a>
              

              <?php }  
              elseif ($bildirim_durum == 7) { ?>

              <div class="profil-ac-bildirim">Profil engelini kaldırdı !</div>
              <a href="data/engel-ac.php?href=<?php echo $ark_listesi; ?>&un=<?php echo $uyecodes; ?>&en=<?php echo $sayfa; ?>&p-l=p">
                <?php if ($engel_durum == 1) { ?>
                  <div class="text-pylsm-st">Buradan sizde kaldırabilirsiniz.</div>
                <?php } ?>
              </a>
              

              <?php }
              elseif ($bildirim_durum == 20) { ?>

              <a href="fotograf-listele.php?fotlist=<?php echo $bildirim_icerik; ?>">
              <div class="begeni-bildirim">Bu fotoğrafı beğendi</div>
              </a>
              
              <?php } 
              elseif ($bildirim_durum == 30) { ?>
              <a href="yayin-listele?yaylist=<?php echo $bildirim_icerik; ?>">
              <div class="yayin-bildirim">Bu yayını bitirdi</div>
              </a>

              <div class="text-pylsm-st"><?php echo $bildirim_icerik; ?></div>

              <?php } 
              elseif ($bildirim_durum == 35) { ?>
              <a href="yayin-listele?yaylist=<?php echo $bildirim_icerik; ?>">
              <div class="yayin-bildirim">Bu yayında çekiliş yapıldı</div>
              </a>

              <div class="text-pylsm-st"><?php echo $bildirim_icerik; ?></div>

              <?php } 
              elseif ($bildirim_durum == 40) { ?>

              <div class="ref-bildirim">Yeni bir referans</div>

              <div class="text-pylsm-st">+1 drc eklendi</div>

              <?php } ?>
            </th>


            <th class="bild4_th">
              <div class="ht-sag">

                
                <a href="data/bildirim-sil.php?bxl=<?php echo $bildirim_code; ?>&puc=<?php echo $uye_islem['uye_code']; ?>&b=s"><button class="btn btn-danger">SİL</button></a>
                

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
          <a href="bildirimler?sayfa=1" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="İlk Sayfa"><i class="fa fa-step-backward"></i></a>
          <a href="bildirimler?sayfa=<?=$sayfa - 1?>" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Önceki Sayfa"><i class="fa fa-chevron-left"></i></a>
        <?php } ?>
        

        <?php if ($sayfa != $sayfa_sayisi) { ?>
          <a href="bildirimler?sayfa=<?=$sayfa + 1?>" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Sonraki Sayfa"><i class="fa fa-chevron-right"></i></a>
          <a href="bildirimler?sayfa=<?=$sayfa_sayisi?>" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Son Sayfa"><i class="fa fa-step-forward"></i></a>
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
                  <span>Bildirim: </span>Henüz bildirim yok !
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
