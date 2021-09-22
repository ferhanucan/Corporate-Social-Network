<?php error_reporting(0); ?>
<?php include 'header.php'; ?>


<?php if ($_SESSION['sessizin'] == 0) {
  header("Location:index.php"); 
  exit();
} ?>


<?php 
$goster = 10;
$say=$db->prepare("SELECT * from arkadaslar where arkadas_sahibi=:sahibi");
$say->execute(array(
 'sahibi' => $uyecodes));
$toplamveri=$say->rowCount();
$sayfa_sayisi = ceil($toplamveri / $goster);
$sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;
if ($sayfa < 1) {$sayfa = 1;}
if ($sayfa > $sayfa_sayisi) {$sayfa = 1;}
$listele = ($sayfa - 1) * $goster;
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

            Arkadaşlar (<?php echo $toplamveri; ?>)
          </th>

        </tr>
      </thead>

    </table>



    <div class="bildirim-yer-alan">


      <?php  


      $arkadas_sor=$db->prepare("SELECT * from arkadaslar where arkadas_sahibi=:sahibi ORDER BY id DESC limit $listele, $goster");
      $arkadas_sor->execute(array(
        'sahibi' => $uyecodes
      ));


      while($arkadas_cek=$arkadas_sor->fetch(PDO::FETCH_ASSOC)) { ?>  

        <?php  
        $arkadas_listesi = $arkadas_cek['arkadas_kiminle'];
        $arkadas_listele=$db->prepare("SELECT * from users where uye_code=:code");
        $arkadas_listele->execute(array(
          'code' => $arkadas_listesi
        ));
        $ark=$arkadas_listele->fetch(PDO::FETCH_ASSOC);

        ?>

        <?php  

        $ad = $ark['uye_ad'];
        $soyad = $ark['uye_soyad'];

        $adsoyad = $ad." ".$soyad;


        if (date('d-m-Y') == $arkadas_cek['arkadas_tarih']) { 
          $ark_tarih = 'Bugün'; } else { 
            $ark_tarih = $arkadas_cek['arkadas_tarih']; 
          }

          ?>

          <?php  
//online
          $online_uye_durumu=$db->prepare("SELECT * from online where online_uyecode=:on_uy");
          $online_uye_durumu->execute(array(
            'on_uy' => $arkadas_listesi
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


            <?php  
            $uy_listele = $db->prepare("SELECT * from users where uye_code=:uycode");
            $uy_listele->execute(array(
              'uycode' => $ark['uye_code']
            ));
            $uy_li=$uy_listele->fetch(PDO::FETCH_ASSOC);
            ?>


            <div class="bildirim-pnl">


              <div class="bildirim-alt">

                <table class="tableclass">
                  <thead>
                    <tr>
                      <th class="arktab1">
                        <div class="minakarti">
                          <a href="kullanici?ara=<?php echo $ark['uye_profil_code']; ?>&ci=3">
                            <div class="miniAvatar">
                              <img class="minavatarimg" src="<?php if (@getimagesize($ark['uye_mini_resim'])) { ?><?php echo $ark['uye_mini_resim']; ?><?php }else { ?>yimg/profil/disabledprofil.jpg<?php } ?>">
                            </div>
                          </a>
                        </div>  
                      </th>

                      <th class="arktab2 tablo-norm">
                        <div class="text-pylsm-yazi"><a href="kullanici.php?ara=<?php echo $ark['uye_profil_code']; ?>&ci=3"><?php echo $adsoyad; ?></a><?php if ($uy_li['uye_profil_onay'] == 1) { ?><i class="fa fa-check-circle-o onaytype onay-tooltip" aria-hidden="true" aria-hidden="true" data-toggle="tooltip" data-placement="right"></i><?php } ?> - <span>
                          <?php if ($ark['uye_meslek_grup'] > 0) { ?>
                            <a href="meslek-alani?m=<?php echo $ark['uye_meslek_grup']; ?>"><?php echo $ark['uye_meslek']; ?></a>
                          <?php } else {
                            echo $ark['uye_meslek'];
                          } ?>
                          </span>
                         


                            </div>

                            <div class="text-pylsm-st">Onay zamanı : <?php echo $arkadas_cek['arkadas_saat']; ?> | <?php echo $ark_tarih; ?></div> 
                          </th>

                          <th class="arktab2 tablo-hids">
                            <div class="txtonelimed">
                              <div class="text-pylsm-yazi"><a href="kullanici?ara=<?php echo $ark['uye_profil_code']; ?>&ci=3"><?php echo $adsoyad; ?></a><?php if ($uy_li['uye_profil_onay'] == 1) { ?><i class="fa fa-check-circle-o onaytype onay-tooltip" aria-hidden="true" aria-hidden="true" data-toggle="tooltip" data-placement="right"></i><?php } ?> - <span>
                                <?php if ($ark['uye_meslek_grup'] > 0) { ?>
                                  <a href="meslek-alani.php?m=<?php echo $ark['uye_meslek_grup']; ?>"><?php echo $ark['uye_meslek']; ?></a>
                                <?php } else {
                                  echo $ark['uye_meslek'];
                                } ?>
                              </span>
                            </div>
                          </div>

                          <div class="txttwolimed">
                            <div class="text-pylsm-yazi"><a href="kullanici?ara=<?php echo $ark['uye_profil_code']; ?>&ci=3"><?php if (strlen($adsoyad) > 20) { echo substr($adsoyad, 0,18).'...'; }else { echo $adsoyad; } ?></a><?php if ($uy_li['uye_profil_onay'] == 1) { ?><i class="fa fa-check-circle-o onaytype onay-tooltip" aria-hidden="true" aria-hidden="true" data-toggle="tooltip" data-placement="right"></i><?php } ?> - <span>
                              <?php if ($ark['uye_meslek_grup'] > 0) { ?>
                                <a href="meslek-alani?m=<?php echo $ark['uye_meslek_grup']; ?>"><?php echo $ark['uye_meslek']; ?></a>
                              <?php } else {
                                echo $ark['uye_meslek'];
                              } ?>
                            </span>
                          </div>
                          <div>

                        
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
                            <a href="arkadaslar?sayfa=1" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="İlk Sayfa"><i class="fa fa-step-backward"></i></a>
                            <a href="arkadaslar?sayfa=<?=$sayfa - 1?>" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Önceki Sayfa"><i class="fa fa-chevron-left"></i></a>
                          <?php } ?>


                          <?php if ($sayfa != $sayfa_sayisi) { ?>
                            <a href="arkadaslar?sayfa=<?=$sayfa + 1?>" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Sonraki Sayfa"><i class="fa fa-chevron-right"></i></a>
                            <a href="arkadaslar?sayfa=<?=$sayfa_sayisi?>" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Son Sayfa"><i class="fa fa-step-forward"></i></a>
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
                                <span>Bildirim: </span>Henüz arkadaş yok !
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




            <?php include 'copfoot-pc.php'; ?>



          </div>





          <div class="col-md-3 col-sm-12 col-xs-12">


            <?php include 'sag-kategori.php'; ?>

            <?php include 'copfoot-mobil.php'; ?>

          </div>


          <?php include 'footer.php'; ?>
