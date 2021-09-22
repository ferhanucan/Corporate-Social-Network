<?php error_reporting(0); ?>
<?php include 'header.php'; ?>

<?php $pg_sayfa = 'kullanici-anasayfa'; ?>



<?php include 'kullanici-kontrol.php'; ?>

 


 <?php if ($_SESSION['sessizin'] == 1) {
 include 'kullanici-menu.php';
   } ?>





<div class="col-md-3 col-sm-12 col-xs-12" style="margin-bottom:100px;">

 

</div>



<div class="col-md-6 col-sm-12 col-xs-12 ortbslk" style="margin-bottom:250px;">


<?php

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

$goster = 30;
$say=$db->prepare("SELECT * from paylasim where paylasim_code=:pcode");
$say->execute(array(
  'pcode' => $player_cek['uye_code']));

$toplamveri=$say->rowCount();
$sayfa_sayisi = ceil($toplamveri / $goster);
$sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;
if ($sayfa < 1) {$sayfa = 1;}
if ($sayfa > $sayfa_sayisi) {$sayfa = 1;}
$listele = ($sayfa - 1) * $goster;

$_SESSION['kuln_sayfa'] = $sayfa;

$kat_say=$say->fetch(PDO::FETCH_ASSOC); 


$paylasim_listele = $db->prepare("SELECT * from paylasim where paylasim_code=:pcode order by paylasim_id DESC limit $listele, $goster");
$paylasim_listele->execute(array(
  'pcode' => $player_cek['uye_code']
));

while($k_p=$paylasim_listele->fetch(PDO::FETCH_ASSOC)) { ?>

  <?php if ($arkadas_var == 1 or $yetki_izin == 1) { $klm = 0; }else { $klm = 1; } ?>

  <?php if ($k_p['paylasim_spam'] < 50 and $k_p['paylasim_kategori'] > $klm) { ?>
    <?php $_SESSION['uye_code']; ?>

    <?php  
    $uy_listele = $db->prepare("SELECT * from users where uye_code=:uycode");
    $uy_listele->execute(array(
      'uycode' => $player_cek['uye_code']
    ));
    $uy_li=$uy_listele->fetch(PDO::FETCH_ASSOC);
    ?>


    <?php if($k_p['paylasim_kategori'] == 1) {
      $grup_no = 1;
      $kategori_ismi = 'Profil';
      $kategori_link='#';
    }elseif($k_p['paylasim_kategori'] == 2) { 
      $grup_no = 2;
      $kategori_ismi = 'Haber';
      $kategori_link='kategori-icerik?kp=2';
    }elseif($k_p['paylasim_kategori'] == 3) {
      $grup_no = 3;
      $kategori_ismi = 'Spor';
      $kategori_link='kategori-icerik?kp=3';
    }elseif($k_p['paylasim_kategori'] == 4) {
      $grup_no = 4;
      $kategori_ismi = 'Magazin';
      $kategori_link='kategori-icerik?kp=4';
    }elseif($k_p['paylasim_kategori'] == 5) {
      $grup_no = 5;
      $kategori_ismi = 'Moda';
      $kategori_link='kategori-icerik?kp=5';
    }elseif($k_p['paylasim_kategori'] == 6) {
      $grup_no = 6;
      $kategori_ismi = 'Oyun';
      $kategori_link='kategori-icerik?kp=6';
    }elseif($k_p['paylasim_kategori'] == 7) {
      $grup_no = 7;
      $kategori_ismi = 'Eğitim';
      $kategori_link='kategori-icerik?kp=7';
    }elseif($k_p['paylasim_kategori'] == 8) {
      $grup_no = 8;
      $kategori_ismi = 'Sağlık';
      $kategori_link='kategori-icerik?kp=8';
    }elseif($k_p['paylasim_kategori'] == 9) {
      $grup_no = 9;
      $kategori_ismi = 'Televizyon';
      $kategori_link='kategori-icerik?kp=9';
    }elseif($k_p['paylasim_kategori'] == 10) {
      $grup_no = 10;
      $kategori_ismi = 'Bilim';
      $kategori_link='kategori-icerik?kp=10';
    }elseif($k_p['paylasim_kategori'] == 11) {
      $grup_no = 11;
      $kategori_ismi = 'Müzik';
      $kategori_link='kategori-icerik?kp=11';
    }elseif($k_p['paylasim_kategori'] == 12) {
      $grup_no = 12;
      $kategori_ismi = 'Teknoloji';
      $kategori_link='kategori-icerik?kp=12';
    }elseif($k_p['paylasim_kategori'] == 13) {
      $grup_no = 13;
      $kategori_ismi = 'Bilişim';
      $kategori_link='kategori-icerik?kp=13';
    }elseif($k_p['paylasim_kategori'] == 14) {
      $grup_no = 14;
      $kategori_ismi = 'Mutfak';
      $kategori_link='kategori-icerik?kp=14';
    }elseif($k_p['paylasim_kategori'] == 15) {
      $grup_no = 15;
      $kategori_ismi = 'Tasarım';
      $kategori_link='kategori-icerik?kp=15';
    }else {
      $kategori_link='#';
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
                    <div class="miniAvatar">
                      <img class="minavatarimg" src="<?php echo $uy_li['uye_mini_resim']; ?>">
                    </div>  
                  </div>  
                </th>

                <?php $plink = $k_p['paylasim_ozelcode']; ?>
                <th class="ka_sa">
                  <div class="resvipc">
                    <div class="text-pylsm-yazi"><?php echo $k_p['paylasim_adsoyad']; ?><?php if ($uy_li['uye_profil_onay'] == 1) { ?><i class="fa fa-check-circle-o onaytype onay-tooltip" aria-hidden="true" aria-hidden="true" data-toggle="tooltip" data-placement="right"></i><?php } ?> - <span><?php echo $uy_li['uye_departman']; ?> DEPARTMANI- <?php echo $uy_li['uye_meslek']; ?> </span>
                    </div>
                  </div>



                  <div class="katfa-style">
                    <a class="kate-tooltip" href="<?php echo $kategori_link; ?>" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" >
                      <i class=""><span class="faspan"><?php echo $k_p['paylasim_yeri']; ?></span></i>
                    </a>
                  </div>
                </th>

                <th class="dr_me">

                  <?php if ($player_cek['uye_code']==$uyecodes) { ?>
                    <div class="paylasim-li ht-sag">
                      Size ait
                    </div>
                  <?php }elseif ($_SESSION['sessizin'] == 1){ ?>

                    <div class="dropdown ht-sag">


                    </div>

                  <?php } ?>

                </th>

              </tr>
            </thead>

          </table>

        </div>

        <div class="ht-pylsm-aln">
          <?php echo nl2br($k_p['paylasim_text']); ?>  
        </div>


        <?php if ($k_p['paylasim_resim_varmi'] == 1) { ?>
          <?php if (@getimagesize($k_p['paylasim_resim'])) { ?>
            <div class="ht-resim-aln">
              <div class="pop">
                <img class="paylasim-resim-style" src="<?php echo $k_p['paylasim_resim']; ?>">
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
        <?php }elseif ($k_p['paylasim_video_varmi'] == 1) { ?>
          <div class="ht-resim-aln">
            <iframe width="100%" height="315" src="https://www.youtube.com/embed/<?php echo $k_p['paylasim_video']; ?>?rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
          </div>
        <?php } ?>

        <div class="ht-pylsm-alt">

          <?php
          $ic_pkodu = $k_p['paylasim_ozelcode'];
          $paylasan_kisi = $uye_islem['uye_code'];

          if ($ic_pkodu && $paylasan_kisi) {

            $oyvermismi=$db->prepare("SELECT * from icerik_durum where icerik_code=:paylasimcode and icerik_oyveren_uye=:uyekodu");
            $oyvermismi->execute(array(
              'paylasimcode' => $ic_pkodu,
              'uyekodu' => $paylasan_kisi
            ));

            $oysor=$oyvermismi->rowCount();
            $oycek=$oyvermismi->fetch(PDO::FETCH_ASSOC);


          } 
          ?>

          <table class="tableclass">
            <thead>
              <tr>

                <th class="ps-alt-w1">
                  <?php if ($_SESSION['sessizin'] == 1){ ?>
                    <ul class="media-list">
                      <li class="media">

                        <div class="media-left mlb">
                          <a class="" href="data/katedurum.php?pod=<?php echo $k_p['paylasim_ozelcode']; ?>&puc=<?php echo $uye_islem['uye_code']; ?>&ara=<?php echo $aranan_uye; ?>&rp=1&b=s" aria-hidden="true" data-toggle="tooltip" data-placement="bottom">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"  fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                              <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
                            </svg>
                            <i class="<?php if ($oysor > 0) { if ($oycek['icerik_degerli'] == 1) { ?>durum_iyi<?php }; }; ?>"><span class="faspan"><?php echo number_format($k_p['paylasim_iyi']); ?></span></i>
                          </a>
                        </div>

                        <div class="media-body mlb" style="margin-top:3px;">
                          <a class="" href="data/katedurum.php?pod=<?php echo $k_p['paylasim_ozelcode']; ?>&puc=<?php echo $uye_islem['uye_code']; ?>&ara=<?php echo $aranan_uye; ?>&rp=1&d=l" aria-hidden="true" data-toggle="tooltip" data-placement="bottom">
                           <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"  class="bi bi-hand-thumbs-down" viewBox="0 0 16 16">
                            <path d="M8.864 15.674c-.956.24-1.843-.484-1.908-1.42-.072-1.05-.23-2.015-.428-2.59-.125-.36-.479-1.012-1.04-1.638-.557-.624-1.282-1.179-2.131-1.41C2.685 8.432 2 7.85 2 7V3c0-.845.682-1.464 1.448-1.546 1.07-.113 1.564-.415 2.068-.723l.048-.029c.272-.166.578-.349.97-.484C6.931.08 7.395 0 8 0h3.5c.937 0 1.599.478 1.934 1.064.164.287.254.607.254.913 0 .152-.023.312-.077.464.201.262.38.577.488.9.11.33.172.762.004 1.15.069.13.12.268.159.403.077.27.113.567.113.856 0 .289-.036.586-.113.856-.035.12-.08.244-.138.363.394.571.418 1.2.234 1.733-.206.592-.682 1.1-1.2 1.272-.847.283-1.803.276-2.516.211a9.877 9.877 0 0 1-.443-.05 9.364 9.364 0 0 1-.062 4.51c-.138.508-.55.848-1.012.964l-.261.065zM11.5 1H8c-.51 0-.863.068-1.14.163-.281.097-.506.229-.776.393l-.04.025c-.555.338-1.198.73-2.49.868-.333.035-.554.29-.554.55V7c0 .255.226.543.62.65 1.095.3 1.977.997 2.614 1.709.635.71 1.064 1.475 1.238 1.977.243.7.407 1.768.482 2.85.025.362.36.595.667.518l.262-.065c.16-.04.258-.144.288-.255a8.34 8.34 0 0 0-.145-4.726.5.5 0 0 1 .595-.643h.003l.014.004.058.013a8.912 8.912 0 0 0 1.036.157c.663.06 1.457.054 2.11-.163.175-.059.45-.301.57-.651.107-.308.087-.67-.266-1.021L12.793 7l.353-.354c.043-.042.105-.14.154-.315.048-.167.075-.37.075-.581 0-.211-.027-.414-.075-.581-.05-.174-.111-.273-.154-.315l-.353-.354.353-.354c.047-.047.109-.176.005-.488a2.224 2.224 0 0 0-.505-.804l-.353-.354.353-.354c.006-.005.041-.05.041-.17a.866.866 0 0 0-.121-.415C12.4 1.272 12.063 1 11.5 1z"/>
                          </svg>
                          <i class="<?php if ($oysor > 0) { if ($oycek['icerik_kotu'] == 1) { ?>durum_kotu<?php }; }; ?>"><span class="faspan"><?php echo number_format($k_p['paylasim_kotu']); ?></span></i>
                        </a>
                      </div>

                    </li>
                  </ul>
                <?php }elseif ($_SESSION['sessizin'] == 0) { ?>
                  <ul class="media-list">
                    <li class="media">

                      <div class="media-left mlb">
                        <a class="btn btn-default blue-tooltip" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Değerli içerik">
                          <i class="fa fa-heart-o <?php if ($oysor > 0) { if ($oycek['icerik_degerli'] == 1) { ?>durum_iyi<?php }; }; ?>"><span class="faspan"><?php echo number_format($k_p['paylasim_iyi']); ?></span></i>
                        </a>
                      </div>

                      <div class="media-body mlb">
                        <a class="btn btn-default red-tooltip" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Kötü içerik">
                          <i class="fa fa-meh-o  <?php if ($oysor > 0) { if ($oycek['icerik_kotu'] == 1) { ?>durum_kotu<?php }; }; ?>"><span class="faspan"><?php echo number_format($k_p['paylasim_kotu']); ?></span></i>
                        </a>
                      </div>

                    </li>
                  </ul>
                <?php } ?>
              </th>

              <th class="ps-alt-w2">
                <div class="text-pylsm-st">
                  <a href="paylasim-listele.php?paylist=<?php echo $plink; ?>">
                    <?php echo $k_p['paylasim_saat']; ?> | <?php echo $k_p['paylasim_tarih']; ?>
                  </a>
                </div> 
              </th>

            </tr>
          </thead>
        </table> 



      </div>

    </div>
  </div>

<?php } ?>

<?php } ?>



<?php if ($kat_say['paylasim_kategori'] == 1 and $arkadas_var == 0 and $toplamveri > 0) { ?>
  <?php if ($yetki_izin == 1) { ?> 
    <div class="uyari-pb">
      <div class="uyari-panel">
        <div class="uyari-panel-alan">
          <ul class="media-list">
            <li class="media">
              <div class="media-body">
                <div class="uyari-paylasim-text">
                  <span>Bildirim: </span>Moderatör tüm paylaşımları görüntüleme iznine sahip !
                </div>
              </div>

            </li>
          </ul>
        </div>
      </div>
      </div><?php }else { ?> 
        <div class="uyari-pb">
          <div class="uyari-panel">
            <div class="uyari-panel-alan">
              <ul class="media-list">
                <li class="media">
                  <div class="media-body">
                    <div class="uyari-paylasim-text">
                      <span>Bildirim: </span>Arkadaşlara özel paylaşımlar mevcut !
                    </div>
                  </div>

                </li>
              </ul>
            </div>
          </div>
        </div>
      <?php } ?>

    <?php } ?>

    <?php  
    $say2=$db->prepare("SELECT * from paylasim where paylasim_code=:pcode and paylasim_kategori > 1");
    $say2->execute(array(
      'pcode' => $player_cek['uye_code']));

    $digerveri=$say2->rowCount();
    ?>


    <?php if ($toplamveri > 0) { ?>

      <div class="sayfalama-style">
        <div class="sayfalama-panel">
          <div class="sayfalama-panel-alan">
            <div class="sayfalama">

              <?php if ($arkadas_var == 1) { ?>
                <?php if ($sayfa > 1) { ?>

                  <a href="kullanici.php?href=<?php echo $player_cek['uye_profil_code']; ?>&sayfa=1" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="İlk Sayfa"><i class="fa fa-step-backward"></i></a>
                  <a href="kullanici.php?href=<?php echo $player_cek['uye_profil_code']; ?>&sayfa=<?=$sayfa - 1?>" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Önceki Sayfa"><i class="fa fa-chevron-left"></i></a>
                <?php } ?>


                <?php if ($sayfa != $sayfa_sayisi) { ?>
                  <a href="kullanici.php?href=<?php echo $player_cek['uye_profil_code']; ?>&sayfa=<?=$sayfa + 1?>" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Sonraki Sayfa"><i class="fa fa-chevron-right"></i></a>
                  <a href="kullanici.php?href=<?php echo $player_cek['uye_profil_code']; ?>&sayfa=<?=$sayfa_sayisi?>" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Son Sayfa"><i class="fa fa-step-forward"></i></a>
                <?php } ?>

              <?php } else { ?>

                <?php if ($sayfa > 1 and $digerveri > 9) { ?>
                  <a href="kullanici.php?href=<?php echo $player_cek['uye_profil_code']; ?>&sayfa=1" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="İlk Sayfa"><i class="fa fa-step-backward"></i></a>
                  <a href="kullanici.php?href=<?php echo $player_cek['uye_profil_code']; ?>&sayfa=<?=$sayfa - 1?>" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Önceki Sayfa"><i class="fa fa-chevron-left"></i></a>
                <?php } ?>


                <?php if ($sayfa != $sayfa_sayisi and $digerveri > 9) { ?>
                  <a href="kullanici.php?href=<?php echo $player_cek['uye_profil_code']; ?>&sayfa=<?=$sayfa + 1?>" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Sonraki Sayfa"><i class="fa fa-chevron-right"></i></a>
                  <a href="kullanici.php?href=<?php echo $player_cek['uye_profil_code']; ?>&sayfa=<?=$sayfa_sayisi?>" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Son Sayfa"><i class="fa fa-step-forward"></i></a>
                <?php } ?>

              <?php } ?>

            </div>
          </div>
        </div>
      </div>

    <?php }else { ?>

      <div class="uyari-pb">
        <div class="uyari-panel">
          <div class="uyari-panel-alan">
            <ul class="media-list">
              <li class="media">
                <div class="media-body">
                  <div class="uyari-paylasim-text">
                    <span>Bildirim: </span>Henüz paylaşım yok !
                  </div>
                </div>

              </li>
            </ul>
          </div>
        </div>
      </div>

    <?php } ?>


  


  </div>





  <div class="col-md-3 col-sm-12 col-xs-12">


    

   

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
                  <a href="url-yazdir.php" class="btn btn-success btn-cek butsetg">Onayla</a>
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









  <?php include 'footer.php'; ?>
