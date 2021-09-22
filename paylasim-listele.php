<?php include 'header.php'; ?>

<?php 



if (strlen($_GET['paylist']) == 153) {

        $yazi_1 = strip_tags($_GET['paylist']);
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

        $puc = str_replace("\r\n",'', $yazi_6);

}else {

  header('Location:profil?boylepaylasim=yok');
  exit();  

}

$yetki_mode = '1';
$yetkisor=$db->prepare("SELECT * from sec_panel where sec_uyepanel=:secuypan and sec_yetki=:syet");
$yetkisor->execute(array(
'secuypan' => $uyecodes,
'syet' => $yetki_mode
));


$panyetsor=$yetkisor->rowCount();

if ($panyetsor > 0) {

$sec_uye_yetki=$db->prepare("SELECT * from sec_uye where sec_uyecode=:uycosec and sec_moderator=:modesec and sec_profil_kontrol=:sprof");
$sec_uye_yetki->execute(array(
'uycosec' => $uyecodes,
'modesec' => $yetki_mode,
'sprof' => $yetki_mode
));

$mode_yetki=$sec_uye_yetki->rowCount();
  if ($mode_yetki > 0) {
    $yetki_izin = 1;
  }else {
    $yetki_izin = 0;
  }
}


$paylasimsor=$db->prepare("SELECT * from paylasim where paylasim_ozelcode=:ozelcode");
$paylasimsor->execute(array(
'ozelcode' => $puc
));

$p_sor=$paylasimsor->rowCount();

if ($p_sor > 0) {

$mod=$paylasimsor->fetch(PDO::FETCH_ASSOC);

$ppc = $mod['paylasim_profil_code'];


//engel sor
    $aranan_uye = $_GET['paylist'];

    $uye_ara = $db->prepare("SELECT * from users where uye_profil_code=:pco");
    $uye_ara->execute(array(
    'pco' => $ppc
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

    $ark_varmi=$ark_kontrol->rowCount();

  if ($yetki_izin != 1) {
    if ($uyecodes != $player_cek['uye_code'] and $ark_varmi == 0 and $mod['paylasim_kategori'] == 1) {
        header('Location:profil?sadece-arkadasa-acik=gonderi'); 
        exit();
    }else {
      $izin_var = 1;
    }
  }else {
      $izin_var = 1;
  }

  if ($izin_var != 1) {
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

  header('Location:profil?boylepaylasim=yok');
  exit();

}

?>



<?php if ($_SESSION['sessizin'] == 1) {
include 'menu.php'; 
} ?>

<div class="col-md-3 col-sm-12 col-xs-12">


<?php if ($_SESSION['sessizin'] == 1) {
include 'profil-avatar.php'; 
} ?>


</div>




<div class="col-md-6 col-sm-12 col-xs-12 ortbslk">

<?php 
if ($_SESSION['sessizin'] == 0) { ?>

  <div class="kad-pb">
    <div class="asay-panel">
      <div class="asay-panel-alan">


 <table class="tableclass">
  <thead>
    <tr>

      <th class="asay-td">

            <div class="pme-box-text">
              Paylaşım listeleniyor <br>
              <span>Daha fazla detay için giriş yapmanız gerekiyor</span>
            </div>

      </th>

    </tr>
  </thead>

</table>            


      </div>
    </div>
  </div>
<?php } ?>


<?php if ($_SESSION['sessizin'] == 1) {
include 'altmenu.php';

include 'uyarikutusu.php';
} ?>



<?php if ($_SESSION['sessizin'] == 0) { ?>
<?php 
if ($_GET['koruma']=='etkin') { ?>  

<script type="text/javascript">
    function urlbas(page, url) {
        if (typeof (history.pushState) != "undefined") {
            var obj = { Page: page, Url: url };
            history.pushState(obj, obj.Page, obj.Url);
        } else {
            window.location.href = 'anasayfa';
        }
    }
    $(function () {

        $("#idxbux").click(function () {
            urlbas('Page1', 'anasayfa');
            document.getElementById("allpge").style.display = "none";
        });

    });
</script>

  <div id="allpge" class="uyari-pb">
    <div class="uyari-panel">
      <div class="uyari-panel-alan">
        <ul class="media-list">
          <li class="media">
            <div class="media-body">
              <div class="nolik-paylasim-text">
                  <span>Uyarı: </span>Geçersiz işlem yaptınız !
                </div>
              </div>
                <div class="media-right">
                 
                <button id="idxbux" class="ht-uyari">Tamam</button>
                
                </div>
            </li>
        </ul>
      </div>
    </div>
  </div>
<?php } ?>
<?php } ?>


<?php  
  $uy_listele = $db->prepare("SELECT * from users where uye_code=:uycode");
  $uy_listele->execute(array(
    'uycode' => $mod['paylasim_code']
    ));
  $uy_li=$uy_listele->fetch(PDO::FETCH_ASSOC);
?>

<?php
  $moda_pay_code = $mod['paylasim_ozelcode'];
  $paylasan_kisi = $uye_islem['uye_code'];

if ($moda_pay_code && $paylasan_kisi) {

    $oyvermismi=$db->prepare("SELECT * from icerik_durum where icerik_code=:paylasimcode and icerik_oyveren_uye=:uyekodu");
    $oyvermismi->execute(array(
    'paylasimcode' => $moda_pay_code,
    'uyekodu' => $paylasan_kisi
    ));

    $oysor=$oyvermismi->rowCount();
  $oycek=$oyvermismi->fetch(PDO::FETCH_ASSOC);


} 
?>

<div class="py-bs">
<div class="pylsm1">

<div class="ht-pylsm-bslk">
 

<table class="tableclass">
  <thead>
    <tr>
        <th class="prof_th">
          <div class="minakarti">
          <a href="<?php if ($mod['paylasim_code']==$uyecodes) { ?>profil?profil=senin&kp=1<?php }else{ ?>kullanici?ara=<?php echo $mod['paylasim_profil_code']; ?><?php } ?>">
            <div class="miniAvatar">
              <img class="minavatarimg" src="<?php echo $uy_li['uye_mini_resim']; ?>">
            </div> 
          </a> 
          </div>   
        </th>

        <th class="ka_sa">
          <div class="resvipc">
          <div class="text-pylsm-yazi"><a href="<?php if ($mod['paylasim_code']==$uyecodes) { ?>profil?profil=senin&kp=1<?php }else{ ?>kullanici?ara=<?php echo $mod['paylasim_profil_code']; ?><?php } ?>"><?php echo $mod['paylasim_adsoyad']; ?></a><?php if ($player_cek['uye_profil_onay'] == 1) { ?><i class="fa fa-check-circle-o onaytype onay-tooltip" aria-hidden="true" aria-hidden="true" data-toggle="tooltip" data-placement="right" data-original-title="Onaylı Profil"></i><?php } ?> - <span>
            <?php if ($mod['paylasim_meslek_grup'] > 0 and $_SESSION['sessizin'] == 1) { ?>
              <a href="meslek-alani?m=<?php echo $mod['paylasim_meslek_grup']; ?>"><?php echo $mod['paylasim_meslekadi']; ?></a>
            <?php } else {
              echo $mod['paylasim_meslekadi'];
            } ?>
          </span>
          </div>
          </div>


          <div class="resvimob">
          <div class="text-pylsm-yazi"><a href="<?php if ($mod['paylasim_code']==$uyecodes) { ?>profil?profil=senin&kp=1<?php }else{ ?>kullanici?ara=<?php echo $mod['paylasim_profil_code']; ?><?php } ?>"><?php echo $mod['paylasim_adsoyad']; ?></a><?php if ($player_cek['uye_profil_onay'] == 1) { ?><i class="fa fa-check-circle-o onaytype onay-tooltip" aria-hidden="true" aria-hidden="true" data-toggle="tooltip" data-placement="right" data-original-title="Onaylı Profil"></i><?php } ?>
          </div>
          </div>

          <span class="katic-style <?php if ($oysor > 0) { if ($oycek['icerik_degerli'] == 1) { ?>durum_iyi<?php }elseif ($oycek['icerik_kotu']==1) { ?>durum_kotu <?php }; }; ?>"><?php if ($oysor > 0) { if ($oycek['icerik_degerli'] == 1) { ?>Beğendiniz<?php }elseif ($oycek['icerik_kotu'] == 1) { ?>Beğenmediniz<?php } }; ?> <?php if ($oysor <= 0) { ?>Değerlendirilmedi<?php } ?></span>

        </th>

        <th class="dr_me">
        <?php if ($mod['paylasim_code']==$uyecodes) { ?>
          <div class="paylasim-li ht-sag">
            Size ait
          </div>
        <?php }elseif ($_SESSION['sessizin'] == 1) { ?>

            <div class="dropdown ht-sag">
                <button class="btn-htran dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-chevron-down" aria-hidden="true"></i>
                </button>
                <ul class="dropdown-menu">


                  <li><a class="cursx" data-href="data/sikayet.php?paco=<?php echo $mod['paylasim_ozelcode']; ?>&hm=<?php echo $uye_islem['uye_code']; ?>&pl=1&s=e" data-toggle="modal" data-name="<?php echo substr($mod['paylasim_text'], 0, 20).'...'; ?>" data-target="#ensipanel" data-name2="Paylaşımı şikayet etmek">Şikayet Et</a></li>

                  <li><a class="cursx" data-href="data/engel.php?href=<?php echo $mod['paylasim_profil_code']; ?>&un=<?php echo $uye_islem['uye_code']; ?>&pl=1&u=e" data-toggle="modal" data-name="<?php echo substr($mod['paylasim_adsoyad'], 0, 20); ?>" data-target="#ensipanel" data-name2="Kullanıcıyı engellemek">Engelle</a></li>
                </ul>
            </div>

        <?php } ?>


        </th>
    </tr>
  </thead>

</table>    


</div>

<div class="ht-pylsm-aln">
       <?php echo nl2br($mod['paylasim_text']); ?>
</div>


<?php if ($mod['paylasim_resim_varmi'] == 1) { ?>
<?php if (@getimagesize($mod['paylasim_resim'])) { ?>
<div class="ht-resim-aln">
<div class="pop">
<img class="paylasim-resim-style" src="<?php echo $mod['paylasim_resim']; ?>">
</div>
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
<?php }else { ?><div class="ht-resim-aln">Resim görüntülenemiyor !</div><?php } ?>
<?php }elseif ($mod['paylasim_video_varmi'] == 1) { ?>
<div class="ht-resim-aln">
<iframe width="100%" height="315" src="https://www.youtube.com/embed/<?php echo $mod['paylasim_video']; ?>?rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
</div>
<?php } ?>


<div class="ht-pylsm-alt">


<table class="tableclass">
  <thead>
    <tr>
<th class="ps-alt-w1">
<?php if ($_SESSION['sessizin'] == 1){ ?>
<ul class="media-list">
  <li class="media">

    <div class="media-left mlb">
    <a class="btn btn-default blue-tooltip" href="data/katedurum.php?pod=<?php echo $mod['paylasim_ozelcode']; ?>&puc=<?php echo $uye_islem['uye_code']; ?>&pl=1&b=s" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Değerli içerik">
      <i class="fa fa-heart-o <?php if ($oysor > 0) { if ($oycek['icerik_degerli'] == 1) { ?>durum_iyi<?php }; }; ?>"><span class="faspan"><?php echo (number_format($mod['paylasim_iyi'])); ?></span></i>
    </a>
    </div>

    <div class="media-body mlb">
    <a class="btn btn-default red-tooltip" href="data/katedurum.php?pod=<?php echo $mod['paylasim_ozelcode']; ?>&puc=<?php echo $uye_islem['uye_code']; ?>&pl=1&d=l" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Kötü içerik">
      <i class="fa fa-meh-o  <?php if ($oysor > 0) { if ($oycek['icerik_kotu'] == 1) { ?>durum_kotu<?php }; }; ?>"><span class="faspan"><?php echo (number_format($mod['paylasim_kotu'])); ?></span></i>
    </a>
    </div>

  </li>
</ul>
<?php }elseif ($_SESSION['sessizin'] == 0) { ?>
<ul class="media-list">
  <li class="media">

    <div class="media-left mlb">
    <a class="btn btn-default blue-tooltip" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Değerli içerik">
      <i class="fa fa-heart-o <?php if ($oysor > 0) { if ($oycek['icerik_degerli'] == 1) { ?>durum_iyi<?php }; }; ?>"><span class="faspan"><?php echo (number_format($mod['paylasim_iyi'])); ?></span></i>
    </a>
    </div>

    <div class="media-body mlb">
    <a class="btn btn-default red-tooltip" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Kötü içerik">
      <i class="fa fa-meh-o  <?php if ($oysor > 0) { if ($oycek['icerik_kotu'] == 1) { ?>durum_kotu<?php }; }; ?>"><span class="faspan"><?php echo (number_format($mod['paylasim_kotu'])); ?></span></i>
    </a>
    </div>

  </li>
</ul>
<?php } ?>
</th>

<th class="ps-alt-w2">
    <div class="text-pylsm-st"><?php echo $mod['paylasim_saat']; ?> | <?php echo $mod['paylasim_tarih']; ?></div>
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


    <div class="modal2" id="ensipanel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content2">
            
                <div class="mod-ust">
                    <button type="button" class="closepanel" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <div class="modal-title mod-tittext" id="myModalLabel"><span class="debug2"></span> istediğine emin misin ? <br> <div class="debug txsky"></div> </div>
                    
                </div>
                
                <div class="mod-alt">

                <table class="tableclass">
                  <thead>
                    <tr>
                      <th class="mod-th-1">
                        <button type="button" class="btn btn-default butsetg" data-dismiss="modal">Vazgeç</button>
                      </th>
                      <th class="mod-th-2">
                        <a href="url-yazdir" class="btn btn-success btn-cek butsetg">Onayla</a>
                      </th>
                    </tr>
                  </thead>
                </table>

                </div>
            </div>
        </div>
    </div> 


<script type="text/javascript">

$('#ensipanel').on('show.bs.modal', function(e) {
    $(this).find('.btn-cek').attr('href', $(e.relatedTarget).data('href'));
            
    $('.url-yazdir').find('.btn-cek').attr('href');
    $('.debug').html($(e.relatedTarget).data('name'));
    $('.debug2').html($(e.relatedTarget).data('name2'));
});  
  
</script>



<?php if ($_SESSION['sessizin'] == 0) { ?>
<div class="poumod">
  <div class="poumod-sayfakapat"></div>
  <div class="poumod-alan">
    <div class="poumod-ust"> 
      <table width="100%">
        <thead>
          <tr>
            <th width="90%">
              <div class="poutextbaslik">Kullanıcı hesabın var mı ?</div>
            </th>
            <th width="10%">
              <div class="kapat-poumod">&#10006;</div>
            </th>
          </tr>
        </thead>
      </table>
      
      
    </div>
    <div class="poumod-alt">
      <table class="tableclass">
        <thead>
          <tr>
            <th class="mod-th-1">
              <a href="login/kayit.php"><button class="bunkayt">Kayıt ol</button></a>
            </th>
            <th class="mod-th-2">
              <a href="login/giris.php"><button class="bungirs">Giriş yap</button></a>
            </th>
          </tr>
        </thead>
      </table>
    </div>

  </div>
</div>



<script type="text/javascript">

$(document).ready(function(){
  $(".kapat-poumod, .poumod-sayfakapat").click(function(){
    $(".poumod").css({"display":"none"});
  });
});
  
</script>

<?php } ?>




<?php include 'footer.php'; ?>
