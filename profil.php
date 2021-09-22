<?php error_reporting(0); ?>
<?php include 'header.php'; ?>

<?php if ($_SESSION['sessizin'] == 0) {
  header("Location:index.php"); 
  exit();
} ?>

<?php 

if ($uye_islem['uye_yetki']==3) {
  header('Location:aday_anasayfa.php');
}

?>


<?php $profil_pg = 'profil_anasayfa'; ?>

<?php include 'menu.php'; ?>



<div class="col-md-3 col-sm-12 col-xs-12">

  

</div>





<div class="col-md-6 col-sm-12 col-xs-12 ortbslk">

 <!-- paylaşma formu başlangıç ---------------------->
 <div class="paylas-kontrol">
  <form method="POST" action="tkpan/paylasim/paylas.php" enctype="multipart/form-data">


    <?php $_SESSION['uye_code']; ?>


    <div class="kategori-panel">
      <div class="resimpaylas">

        <div class="ht-panel-resim">
          <div class="text-models">
            <span class="tpspan">Paylaşmak istediğiniz kategoriyi seçin</span>
          </div>
        </div>

        <table class="tableclass">
          <thead>
            <tr>
              <th class="prof-th">
                <div class="form-group prof-p-panel">

                  <select id="htselecet" class="form-control" name="kategori">
                    <option value="1">Profil</option>
                    <option value="2">Haber</option>
                    <option value="7">Eğitim</option>
                    <option value="8">Sağlık</option>
                    <option value="9">Televizyon</option>
                    <option value="10">Bilim</option>
                    <option value="12">Teknoloji</option>
                    <option value="13">Bilişim</option>
                    
                  </select>

                </div>
              </th>
            </tr>
          </thead>
        </table>


      </div>
    </div>


    <div class="secimyap-panel">
      <div class="resimpaylas">

        <div class="ht-panel-resim">

         <table class="tableclass">
          <thead>
            <tr>

              <th class="bs-dt1">
                <div class="text-models">Bir resim yada bir video seçin</div>
              </th>

              <th class="bs-dt2">
                <div class="text-models ht-sag kpt-butpan">Kapat</div>      
              </th>

            </tr>
          </thead>
        </table>

      </div>

      <table class="tableclass">
        <thead>
          <tr>

            <th class="w-th-video1">
              <div class="w-video-class">
                <div class="fovid-buton resim-secildi"><span class="fototype resvipc"><i class="fa fa-camera bosty" aria-hidden="true"></i>Resim paylaş</span><span class="fototype resvimob"><i class="fa fa-camera bosty" aria-hidden="true"></i>Resim</span></div>
              </div>
            </th>

            <th class="w-th-video2">
              <div class="w-video-class">
                <div class="fovid-buton video-secildi"><span class="fototype resvipc"><i class="fa fa-video-camera bosty" aria-hidden="true"></i>Video paylaş</span><span class="fototype resvimob"><i class="fa fa-video-camera bosty" aria-hidden="true"></i>Video</span></div>
              </div>
            </th>

          </tr>
        </thead>
      </table>

    </div>
  </div>


  <div class="resim-alani-ac">
    <div class="resimpaylas">

      <div class="ht-panel-resim">

       <table class="tableclass">
        <thead>
          <tr>

            <th class="bs-dt1">
              <div class="text-models">Paylaşmak istediğiniz bir resmi seçin</div>
            </th>

            <th class="bs-dt2">
              <div class="text-models ht-sag kpt-butpan">Kapat</div>      
            </th>

          </tr>
        </thead>
      </table>

    </div>

    <table class="tableclass">
      <thead>
        <tr>

          <th class="res-pay-th1">
            <div class="res-pay-style1">

              <div class="file-upload">

                <label for="resimst-file" class="file-upload__label"><i class="fa fa-camera" aria-hidden="true"></i><span class="vidnopc"> Resim Ekle</span></label>


                <input id="resimst-file" class="file-upload__input dosyaSec" type="file" accept="image/*" name="paylasim_resim">
              </div>

            </div>
          </th>

          <th class="res-pay-th2">
            <div class="res-pay-style2">
              <div class="onres">
                <div id="pf-foto"></div>
              </div>

              <div class="onyazi">
                Resim yok
              </div>
            </div>
          </th>

          <th class="res-pay-th3">
            <div class="res-pay-style3">
              <button id="btn-resimst-file-reset" type="button">Kaldır</button>
            </div>
          </th>

        </tr>
      </thead>
    </table>


  </div>
</div>             



<div class="video-alani-ac">
  <div class="resimpaylas">

    <div class="ht-panel-resim">

     <table class="tableclass">
      <thead>
        <tr>

          <th class="bs-dt1">
            <div class="text-models">Youtube videonuzun id'sini yazınız</div>
          </th>

          <th class="bs-dt2">
            <div class="text-models ht-sag kpt-butpan">Kapat</div>      
          </th>

        </tr>
      </thead>
    </table>

  </div>



  <table class="tableclass">
    <thead>
      <tr>

        <th class="thvid1">
          <div class="vidno1">

            <span class="vidpan1">https://www.youtube.com/watch?v=</span><span class="vidpan2">xxxxxxxxxxx</span> <br>
            Video id'niz örnekteki kırmızı alanda bulunur.

          </div>
        </th>

      </tr>
      <tr>

        <th class="thvid2">
          <div class="vidno2">

            <input id="video-id" type="text" class="form-control video-kodu-style" name="videoid" placeholder="Video id'sini yazınız"/>

          </div>
        </th>

      </tr>

    </thead>
  </table>






</div>
</div> 



<div class="jbt">

  <div class="ht-nvpan-ust">

    <div class="resvipc">
      <span class="kategori-buton">
        <i class="fa fa-th-large bres" aria-hidden="true"></i> <span class="repspan text-models">Kategori - <span class="kategori-ackapat">Aç</span></span> 
      </span>
      <span class="secimyap-buton">
        <i class="fa fa-camera bres" aria-hidden="true"></i> <span class="repspan text-models">Resim / Video</span> 
      </span>
    </div>

    <div class="resvimob">
      <span class="kategori-buton">
        <i class="fa fa-reorder notbres1" aria-hidden="true"></i>
      </span>
      <span class="secimyap-buton">
        <i class="fa fa-camera notbres2" aria-hidden="true"></i>
      </span>
    </div>
    

  </div>
  <div class="ht-orta">

    <textarea rows="3" id="sayd" class="form-control ht-area tarea setng tasd" name="yazi" placeholder="Paylaşmak için birşeyler yazabilirsin.."></textarea>
    
  </div>

  <div class="ht-panel-alt">

    <ul class="media-list">
      <li class="media">
        <div class="media-left">
          <div class="medeng">
            <span class="psay">200</span>
          </div>
        </div>
        <div class="media-body">
          <div class="medeng">
            <b class="puyr">Karakter limiti doldu !</b>
            <b class="uys">Karakter limitine ulaştınız.</b>
          </div>      
        </div>
        <div class="media-right">
          <button class="btn btn-sm btn-primary pull-right" name="paylasim_yap" type="submit"><i class="fa fa-pencil fa-fw"></i>Paylaş</button>
        </div>
      </li>
    </ul>

  </div>

</div>

</form> 
</div>

<!-- paylaşma formu bitiş -------------------------------------------------------->


<!-- paylaşılan post başlangıç -------------------------------------------------------->


<?php

$goster = 30;
$say=$db->prepare("SELECT * from paylasim where paylasim_code=:pcode");
$say->execute(array(
  'pcode' => $_SESSION['uye_code']));

$toplamveri=$say->rowCount();
$sayfa_sayisi = ceil($toplamveri / $goster);
$sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;
if ($sayfa < 1) {$sayfa = 1;}
if ($sayfa > $sayfa_sayisi) {$sayfa = 1;}
$listele = ($sayfa - 1) * $goster;

$_SESSION['pro_sayfa'] = $sayfa;


$paylasim_listele = $db->prepare("SELECT * from paylasim where paylasim_code=:pcode order by paylasim_id DESC limit $listele, $goster");
$paylasim_listele->execute(array(
  'pcode' => $_SESSION['uye_code']
));

while($p_c=$paylasim_listele->fetch(PDO::FETCH_ASSOC)) { ?>

  <?php if($p_c['paylasim_kategori'] == 1) {
    $grup_no = 1;
    $kategori_ismi = 'Profil';
    $kategori_link='#';
  }elseif($p_c['paylasim_kategori'] == 2) { 
    $grup_no = 2;
    $kategori_ismi = 'Haber';
    $kategori_link='kategori-icerik.php?kp=2';
  }elseif($p_c['paylasim_kategori'] == 3) {
    $grup_no = 3;
    $kategori_ismi = 'Spor';
    $kategori_link='kategori-icerik.php?kp=3';
  }elseif($p_c['paylasim_kategori'] == 4) {
    $grup_no = 4;
    $kategori_ismi = 'Magazin';
    $kategori_link='kategori-icerik.php?kp=4';
  }elseif($p_c['paylasim_kategori'] == 5) {
    $grup_no = 5;
    $kategori_ismi = 'Moda';
    $kategori_link='kategori-icerik.php?kp=5';
  }elseif($p_c['paylasim_kategori'] == 6) {
    $grup_no = 6;
    $kategori_ismi = 'Oyun';
    $kategori_link='kategori-icerik.php?kp=6';
  }elseif($p_c['paylasim_kategori'] == 7) {
    $grup_no = 7;
    $kategori_ismi = 'Eğitim';
    $kategori_link='kategori-icerik.php?kp=7';
  }elseif($p_c['paylasim_kategori'] == 8) {
    $grup_no = 8;
    $kategori_ismi = 'Sağlık';
    $kategori_link='kategori-icerik.php?kp=8';
  }elseif($p_c['paylasim_kategori'] == 9) {
    $grup_no = 9;
    $kategori_ismi = 'Televizyon';
    $kategori_link='kategori-icerik.php?kp=9';
  }elseif($p_c['paylasim_kategori'] == 10) {
    $grup_no = 10;
    $kategori_ismi = 'Bilim';
    $kategori_link='kategori-icerik.php?kp=10';
  }elseif($p_c['paylasim_kategori'] == 11) {
    $grup_no = 11;
    $kategori_ismi = 'Müzik';
    $kategori_link='kategori-icerik.php?kp=11';
  }elseif($p_c['paylasim_kategori'] == 12) {
    $grup_no = 12;
    $kategori_ismi = 'Teknoloji';
    $kategori_link='kategori-icerik.php?kp=12';
  }elseif($p_c['paylasim_kategori'] == 13) {
    $grup_no = 13;
    $kategori_ismi = 'Bilişim';
    $kategori_link='kategori-icerik.php?kp=13';
  }elseif($p_c['paylasim_kategori'] == 14) {
    $grup_no = 14;
    $kategori_ismi = 'Mutfak';
    $kategori_link='kategori-icerik.php?kp=14';
  }elseif($p_c['paylasim_kategori'] == 15) {
    $grup_no = 15;
    $kategori_ismi = 'Tasarım';
    $kategori_link='kategori-icerik.php?kp=15';
  }else {
    $kategori_link='#';
  }
  ?>

  <div class="py-bs">
    <div class="pylsm1">



      <table class="tableclass">
        <thead>
          <tr>
            <th class="prof_th">
              <div class="minakarti">
                <div class="miniAvatar">
                  <img class="minavatarimg" src="<?php echo $uye_islem['uye_mini_resim']; ?>">
                </div>  
              </div>  
            </th>

            <?php $plink = $p_c['paylasim_ozelcode']; ?>

            <th class="ka_sa">
              <div class="resvipc">


                <div class="text-pylsm-yazi"><a href="<?php if ($p_c['paylasim_code']==$uyecodes) { ?>profil.php?profil=senin&kp=1<?php }else{ ?>kullanici.php?ara=<?php echo $p_c['paylasim_profil_code']; ?>&kp=<?php echo $grup_no; ?><?php } ?>"><?php echo $p_c['paylasim_adsoyad']; ?></a></span><?php if ($uye_islem['uye_profil_onay'] == 1) { ?><i class="fa fa-check-circle-o onaytype onay-tooltip" aria-hidden="true" aria-hidden="true" data-toggle="tooltip" data-placement="right"></i><?php } ?> - <span>
                  <?php echo $uye_islem['uye_departman']; ?> DEPARTMANI- <?php echo $uye_islem['uye_meslek']; ?> 
                </span>
              </div>
            </div>



            <div class="katfa-style">
              <a class="kate-tooltip" href="<?php echo $kategori_link; ?>" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" >
                <i class=""><span class="faspan"><?php echo $p_c['paylasim_yeri']; ?></span></i>
              </a>
            </div>

          </th>

          <th class="dr_me">

            <div class="dropdown ht-sag">
              <button class="btn-htran dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-chevron-down" aria-hidden="true"></i>
              </button>
              <ul class="dropdown-menu">
                <li><a class="cursx" data-href="data/sil.php?pod=<?php echo $p_c['paylasim_ozelcode']; ?>&puc=<?php echo $p_c['paylasim_code']; ?>&l=k" data-toggle="modal" data-name="<?php echo substr($p_c['paylasim_text'], 0, 20).'...'; ?>" data-target="#silpanel">Sil</a></li>
              </ul>
            </div>


          </th>

        </tr>
      </thead>
    </table>


    <div class="ht-pylsm-aln">
      <?php echo nl2br($p_c['paylasim_text']); ?>
    </div>


    <?php if ($p_c['paylasim_resim_varmi'] == 1) { ?>
      <?php if (@getimagesize($p_c['paylasim_resim'])) { ?>

        <div class="ht-resim-aln">
          <div class="pop">
            <img class="paylasim-resim-style" src="<?php echo $p_c['paylasim_resim']; ?>">
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
    <?php }elseif ($p_c['paylasim_video_varmi'] == 1) { ?>
      <div class="ht-resim-aln">
        <iframe width="100%" height="315" src="https://www.youtube.com/embed/<?php echo $p_c['paylasim_video']; ?>?rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
      </div>
    <?php } ?>


    <!-- begen begenme butonu ve saat tarih baslangic -->
    <div class="ht-pylsm-alt">

      <?php
      $ic_pkodu = $p_c['paylasim_ozelcode'];
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
              <ul class="media-list">
                <li class="media">

                  <div class="media-left mlb">
                    <a class="" href="data/durum.php?pod=<?php echo $p_c['paylasim_ozelcode']; ?>&puc=<?php echo $p_c['paylasim_code']; ?>&b=s" aria-hidden="true" data-toggle="tooltip" data-placement="bottom">
                      <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"  fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                        <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
                      </svg><i class="<?php if ($oysor > 0) { if ($oycek['icerik_degerli'] == 1) { ?>durum_iyi<?php }; }; ?>"><span class="faspan"><?php echo (number_format($p_c['paylasim_iyi'])); ?></span></i>
                    </a>
                  </div>

                  <div class="media-body mlb" style="margin-top:3px;">
                    <a class="" href="data/durum.php?pod=<?php echo $p_c['paylasim_ozelcode']; ?>&puc=<?php echo $p_c['paylasim_code']; ?>&d=l" aria-hidden="true" data-toggle="tooltip" data-placement="bottom">
                     <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"  class="bi bi-hand-thumbs-down" viewBox="0 0 16 16">
                      <path d="M8.864 15.674c-.956.24-1.843-.484-1.908-1.42-.072-1.05-.23-2.015-.428-2.59-.125-.36-.479-1.012-1.04-1.638-.557-.624-1.282-1.179-2.131-1.41C2.685 8.432 2 7.85 2 7V3c0-.845.682-1.464 1.448-1.546 1.07-.113 1.564-.415 2.068-.723l.048-.029c.272-.166.578-.349.97-.484C6.931.08 7.395 0 8 0h3.5c.937 0 1.599.478 1.934 1.064.164.287.254.607.254.913 0 .152-.023.312-.077.464.201.262.38.577.488.9.11.33.172.762.004 1.15.069.13.12.268.159.403.077.27.113.567.113.856 0 .289-.036.586-.113.856-.035.12-.08.244-.138.363.394.571.418 1.2.234 1.733-.206.592-.682 1.1-1.2 1.272-.847.283-1.803.276-2.516.211a9.877 9.877 0 0 1-.443-.05 9.364 9.364 0 0 1-.062 4.51c-.138.508-.55.848-1.012.964l-.261.065zM11.5 1H8c-.51 0-.863.068-1.14.163-.281.097-.506.229-.776.393l-.04.025c-.555.338-1.198.73-2.49.868-.333.035-.554.29-.554.55V7c0 .255.226.543.62.65 1.095.3 1.977.997 2.614 1.709.635.71 1.064 1.475 1.238 1.977.243.7.407 1.768.482 2.85.025.362.36.595.667.518l.262-.065c.16-.04.258-.144.288-.255a8.34 8.34 0 0 0-.145-4.726.5.5 0 0 1 .595-.643h.003l.014.004.058.013a8.912 8.912 0 0 0 1.036.157c.663.06 1.457.054 2.11-.163.175-.059.45-.301.57-.651.107-.308.087-.67-.266-1.021L12.793 7l.353-.354c.043-.042.105-.14.154-.315.048-.167.075-.37.075-.581 0-.211-.027-.414-.075-.581-.05-.174-.111-.273-.154-.315l-.353-.354.353-.354c.047-.047.109-.176.005-.488a2.224 2.224 0 0 0-.505-.804l-.353-.354.353-.354c.006-.005.041-.05.041-.17a.866.866 0 0 0-.121-.415C12.4 1.272 12.063 1 11.5 1z"/>
                    </svg> <i class="<?php if ($oysor > 0) { if ($oycek['icerik_kotu'] == 1) { ?>durum_kotu<?php }; }; ?>"><span class="faspan"><?php echo (number_format($p_c['paylasim_kotu'])); ?></span></i>
                  </a>
                </div>

              </li>
            </ul>
          </th>

          <th class="ps-alt-w2">
            <div class="text-pylsm-st">
              <a href="paylasim-listele?paylist=<?php echo $plink; ?>">
                <?php echo $p_c['paylasim_saat']; ?> | <?php echo $p_c['paylasim_tarih']; ?>
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


<?php if ($toplamveri > 0) { ?>

  <div class="sayfalama-style">
    <div class="sayfalama-panel">
      <div class="sayfalama-panel-alan">
        <div class="sayfalama">

          <?php if ($sayfa > 1) { ?>
            <a href="profil?sayfa=1" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="İlk Sayfa"><i class="fa fa-step-backward"></i></a>
            <a href="profil?sayfa=<?=$sayfa - 1?>" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Önceki Sayfa"><i class="fa fa-chevron-left"></i></a>
          <?php } ?>
          

          <?php if ($sayfa != $sayfa_sayisi) { ?>
            <a href="profil?sayfa=<?=$sayfa + 1?>" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Sonraki Sayfa"><i class="fa fa-chevron-right"></i></a>
            <a href="profil?sayfa=<?=$sayfa_sayisi?>" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Son Sayfa"><i class="fa fa-step-forward"></i></a>
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










<?php include 'footer.php'; ?>
