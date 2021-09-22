<?php include 'header.php'; ?>


<?php if ($_SESSION['sessizin'] == 0) {
  header("Location:index.php"); 
  exit();
} ?>


<?php 

if (strlen($_GET['fotlist']) == 30) {

        $yazi_1 = strip_tags($_GET['fotlist']);
        $yazi_2 = stripslashes($yazi_1);
        $yazi_3 = trim($yazi_2);
        $yazi_4 = htmlspecialchars_decode($yazi_3, ENT_COMPAT);

        $yazi_5 = htmlentities($yazi_4);

        function replaceSpace($string)
        {
          $string = preg_replace("/\s+/", " ", $string);
          $string = trim($string);
          return $string;
        }

        $yazi_6 = replaceSpace($yazi_5);

        $foco = str_replace("\r\n",'', $yazi_6);

}else {

  header('Location:profil?boylepaylasim=yok');
  exit();  

}

$fotosor=$db->prepare("SELECT * from fotograf where foto_code=:ozelcodef");
$fotosor->execute(array(
'ozelcodef' => $foco
));

$f_sor=$fotosor->rowCount();

if ($f_sor > 0) {

$fod=$fotosor->fetch(PDO::FETCH_ASSOC);

$fuye = $fod['foto_uye_code'];

    $aranan_uye = $_GET['fotlist'];

    $uye_ara = $db->prepare("SELECT * from users where uye_code=:pco");
    $uye_ara->execute(array(
    'pco' => $fuye
    ));

    $uye_varmi=$uye_ara->rowCount();

    if ($uye_varmi > 0) {

    $player_cek=$uye_ara->fetch(PDO::FETCH_ASSOC);
    $sorulan_uye = $player_cek['uye_code'];

    //arkadaş sor
    $ark_kontrol = $db->prepare("SELECT * from arkadaslar where arkadas_sahibi=:sahibi and arkadas_kiminle=:kiminle");
    $ark_kontrol->execute(array(
    'sahibi' => $uyecodes,
    'kiminle'=> $sorulan_uye
    ));

    $ark_ters_kontrol = $db->prepare("SELECT * from arkadaslar where arkadas_sahibi=:sahibi and arkadas_kiminle=:kiminle");
    $ark_ters_kontrol->execute(array(
    'sahibi' => $foto_sahibi,
    'kiminle'=> $uyecodes
    ));

    $ark_varmi=$ark_kontrol->rowCount();
    $ark_ters=$ark_ters_kontrol->rowCount();

    if ($uyecodes != $player_cek['uye_code'] and $ark_varmi == 0 and $ark_ters == 0) {
        header('Location:profil?sadece-arkadasa-acik=gonderi');
        exit();
    }


    //engel sor
    if ($sorulan_uye && $uyecodes) {

        $engelsor=$db->prepare("SELECT * from engel where engel_gonderen=:gonderen and engel_alan=:alan");
        $engelsor->execute(array(
        'gonderen' => $uyecodes,
        'alan' => $sorulan_uye
        ));
        $sor=$engelsor->rowCount();

        $ters_engelsor=$db->prepare("SELECT * from engel where engel_gonderen=:gonderen and engel_alan=:alan");
        $ters_engelsor->execute(array(
        'gonderen' => $sorulan_uye,
        'alan' => $uyecodes
        ));
        $ters_sor=$ters_engelsor->rowCount();
        
        if ($sor > 0 and $ters_sor > 0) {

            header('Location:profil?engeltam=aktif'); 

          exit();
        }elseif ($sor > 0) {

            header('Location:profil?engels=aktif');
          
          exit();

        }elseif ($ters_sor > 0) {

            header('Location:profil?engelk=aktif');
          
          exit();
        }

    }


    }else {
      header('Location:profil?kullanici-sistemde=yok');
      exit();
    }
//engel sor bitis

}else {
//foto yok
  header('Location:profil?boylepaylasim=yok');
  exit();

}

?>


<?php include 'menu.php'; ?>


<div class="col-md-3 col-sm-12 col-xs-12">

<?php include 'profil-avatar.php'; ?>


</div>




<div class="col-md-6 col-sm-12 col-xs-12 ortbslk">



<?php include 'altmenu.php'; ?>




<?php include 'uyarikutusu.php'; ?>



<div class="py-bs">
<div class="pylsm1">

<div class="ht-pylsm-bslk">
 

<table class="tableclass">
  <thead>
    <tr>
        <th class="prof_th">
          <div class="minakarti">
          <a href="<?php if ($fod['foto_uye_code']==$uyecodes) { ?>profil?profil=senin&kp=1<?php }else{ ?>kullanici?ara=<?php echo $player_cek['uye_profil_code']; ?><?php } ?>">
            <div class="miniAvatar">
              <img class="minavatarimg" src="<?php echo $player_cek['uye_mini_resim']; ?>">
            </div> 
          </a> 
          </div>   
        </th>

        <th class="ka_sa">
          <div class="resvipc">
          <?php $ad = $player_cek['uye_ad']; $soyad = $player_cek['uye_soyad'];
          $name = $ad." ".$soyad; ?>
          <div class="text-pylsm-yazi"><a href="<?php if ($fod['foto_uye_code']==$uyecodes) { ?>profil?profil=senin&kp=1<?php }else{ ?>kullanici?ara=<?php echo $player_cek['uye_profil_code']; ?><?php } ?>"><?php echo $name; ?></a><?php if ($player_cek['uye_profil_onay'] == 1) { ?><i class="fa fa-check-circle-o onaytype onay-tooltip" aria-hidden="true" aria-hidden="true" data-toggle="tooltip" data-placement="right" data-original-title="Onaylı Profil"></i><?php } ?> - <span>
            <?php if ($player_cek['uye_meslek_grup'] > 0) { ?>
              <a href="meslek-alani?m=<?php echo $player_cek['uye_meslek_grup']; ?>"><?php echo $player_cek['uye_meslek']; ?></a>
            <?php } else {
              echo $player_cek['uye_meslek'];
            } ?>
          </span>
          </div>
          </div>

          <div class="resvimob">
          <?php $ad = $player_cek['uye_ad']; $soyad = $player_cek['uye_soyad'];
          $name = $ad." ".$soyad; ?>
          <div class="text-pylsm-yazi"><a href="<?php if ($fod['foto_uye_code']==$uyecodes) { ?>profil?profil=senin&kp=1<?php }else{ ?>kullanici?ara=<?php echo $player_cek['uye_profil_code']; ?><?php } ?>"><?php echo $name; ?></a><?php if ($player_cek['uye_profil_onay'] == 1) { ?><i class="fa fa-check-circle-o onaytype onay-tooltip" aria-hidden="true" aria-hidden="true" data-toggle="tooltip" data-placement="right" data-original-title="Onaylı Profil"></i><?php } ?>
          </div>
          </div>

          <div class="text-pylsm-st"><?php echo $fod['foto_saat']; ?> | <?php echo $fod['foto_tarih']; ?></div> 
        </th>

        <th class="dr_me">
        <?php if ($fod['foto_uye_code']==$uyecodes) { ?>
          <div class="paylasim-li ht-sag">
            Size ait
          </div>
        <?php } ?>


        </th>
    </tr>
  </thead>

</table>    


</div>

<div class="ht-foto-yazi-aln">
      <?php echo $fod['foto_text']; ?>
</div>

<?php

  $fo_code = $fod['foto_code'];
  $foto_atan_kisi = $uye_islem['uye_code'];

if ($fo_code && $foto_atan_kisi) {

    $oyvermismi=$db->prepare("SELECT * from fotograf_durum where foto_code=:fokodu and foto_oyveren_uye=:uyekodu");
    $oyvermismi->execute(array(
    'fokodu' => $fo_code,
    'uyekodu' => $foto_atan_kisi
    ));

    $oysor=$oyvermismi->rowCount();
    $oycek=$oyvermismi->fetch(PDO::FETCH_ASSOC);


} 
?>

<div class="ht-foto-aln">
<table class="tableclass">
  <thead>
    <tr>
      <th class="respan">
        
<div class="pop">
<img class="foto-pan-style" src="<?php echo $fod['foto_resim_yol']; ?>">
</div>

<div class="modal" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <img src="" class="imagepreview">
      </div>
    </div>
  </div>
</div>

      </th>
      <th class="respan2">
        <span class="begeni-style">Beğeni sayısı</span><br>
        <span class="begeni-style-alt"><?php echo number_format($fod['foto_begeni']); ?></span>
        <br>

  <?php if ($oysor > 0 and $oycek['foto_durum'] == 1) { ?>
  <div class="bediv">
    <i class="fa fa-check beclass"></i>
  </div>
  <?php } else { ?>
  <div class="hedvc">
  <a href="data/kullanici-fotodurum.php?foc=<?php echo $fod['foto_code']; ?>&ara=<?php echo $aranan_uye; ?>&fo=li&ftuyc=<?php echo $uyecodes; ?>&ku=fo">
    <i class="fa fa-heart-o heclass"></i>
  </a>
  </div>
  <?php } ?>


      </th>
    </tr>
  </thead>
</table>


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
