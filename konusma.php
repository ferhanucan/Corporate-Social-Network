<?php error_reporting(0); ?>
<?php include 'header.php'; ?>


<?php if ($_SESSION['sessizin'] == 0) {
  header("Location:index.php"); 
  exit();
} ?>


<?php  

if ($_GET['msj']=="d") {

  $mess_sayfa = $_SESSION['mess_sayisi'];
  $mesaj_gonderen_okundu = 1;
  $mesaj_okundu = 1;
  $mesaj_b_durum = 2;

  $yazi_1 = strip_tags($_GET['msj-a']);
  $yazi_2 = stripslashes($yazi_1);
  $yazi_3 = trim($yazi_2);
  $yazi_4 = htmlspecialchars_decode($yazi_3, ENT_COMPAT);

  $yazi_5 = htmlentities($yazi_4);

  $mes_alici = str_replace("\r\n",'', $yazi_5);


  $bazi_1 = strip_tags($_GET['msj-b']);
  $bazi_2 = stripslashes($bazi_1);
  $bazi_3 = trim($bazi_2);
  $bazi_4 = htmlspecialchars_decode($bazi_3, ENT_COMPAT);

  $bazi_5 = htmlentities($bazi_4);

  $uye_getms = str_replace("\r\n",'', $bazi_5);


  $tazi_1 = strip_tags($_GET['msj-c']);
  $tazi_2 = stripslashes($tazi_1);
  $tazi_3 = trim($tazi_2);
  $tazi_4 = htmlspecialchars_decode($tazi_3, ENT_COMPAT);

  $tazi_5 = htmlentities($tazi_4);

  $mes_kodu = str_replace("\r\n",'', $tazi_5);


  if($_SESSION['mess_sayisi'] > 0) {
    $mess_sayfa = $_SESSION['mess_sayisi'];
  }else {
    $mess_sayfa = 1;
  }

  $mesaj_okundu_saat = date('H:i');
  $mesaj_okundu_tarih = date('d-m-Y');

  if ($uyecodes!=$uye_getms) {
    header('Location:mesajlar.php?mesaj-konusma-erisim=yok&ct=1'); 
    exit();
  }

//engel varmi sor

  $engelsor=$db->prepare("SELECT * from engel where engel_gonderen=:gonderen and engel_alan=:alan");
  $engelsor->execute(array(
    'gonderen' => $uyecodes,
    'alan' => $mes_alici
  ));

  $ters_engelsor=$db->prepare("SELECT * from engel where engel_gonderen=:gonderen and engel_alan=:alan");
  $ters_engelsor->execute(array(
    'gonderen' => $mes_alici,
    'alan' => $uyecodes
  ));

  $sor=$engelsor->rowCount();

  $ters_sor=$ters_engelsor->rowCount();

  if ($sor > 0 and $ters_sor > 0) {

    $engelli_uye = 1;

  }elseif ($sor > 0) {

    $engelli_uye = 1;


  }elseif ($ters_sor > 0) {

    $engelli_uye = 1;

  }



  $ark_kontrol = $db->prepare("SELECT * from arkadaslar where arkadas_sahibi=:sahibi and arkadas_kiminle=:kiminle");
  $ark_kontrol->execute(array(
    'sahibi' => $uyecodes,
    'kiminle'=> $mes_alici
  ));

  $ark_ters_kontrol = $db->prepare("SELECT * from arkadaslar where arkadas_sahibi=:sahibi and arkadas_kiminle=:kiminle");
  $ark_ters_kontrol->execute(array(
    'sahibi' => $mes_alici,
    'kiminle'=> $uyecodes
  ));

  $arkadas_cek=$ark_kontrol->fetch(PDO::FETCH_ASSOC); 
  $arkadas_ters_cek=$ark_ters_kontrol->fetch(PDO::FETCH_ASSOC); 

  $arkadas_sor=$ark_kontrol->rowCount();
  $arkadas_ters_sor=$ark_ters_kontrol->rowCount();

  if ($arkadas_sor > 0 and $arkadas_ters_sor > 0) {

    $arkadas_var = 1;
    $ark_durum = $arkadas_cek['arkadas_durum'];
    $ark_ters_durum = $arkadas_ters_cek['arkadas_durum'];

  }else {
    $arkadas_var = 0;
  }


  $mesaj_varmi_sor = $db->prepare("SELECT * from mesajlar where mesaj_kimin=:kimin and mesaj_alici=:alici and mesaj_code=:code");
  $mesaj_varmi_sor->execute(array(
    'kimin' => $uyecodes,
    'alici' => $mes_alici,
    'code' => $mes_kodu
  ));

  $mesaj_sorgu=$mesaj_varmi_sor->rowCount();

  if ($mesaj_sorgu > 0) {

    $ark_mesajvar = 1;
    $mvs=$mesaj_varmi_sor->fetch(PDO::FETCH_ASSOC);
    $gelen_mesaj = $mvs['mesaj_durum'];
    $gonderen_mid = $mvs['id'];


    if ($gelen_mesaj == 0) {

      $mesaj_alici_sor = $db->prepare("SELECT * from mesajlar where mesaj_kimin=:kimin and mesaj_alici=:alici and mesaj_code=:code");
      $mesaj_alici_sor->execute(array(
        'kimin' => $mes_alici,
        'alici' => $uyecodes,
        'code' => $mes_kodu
      ));

      $mesaj_alici_sorgu=$mesaj_alici_sor->rowCount();

      if ($mesaj_alici_sorgu > 0) {

        $mas=$mesaj_alici_sor->fetch(PDO::FETCH_ASSOC); 
        $alici_mid = $mas['id'];  


        $mesajg=$db->prepare("UPDATE mesajlar SET
          mesaj_durum=:durum,
          mesaj_okundu=:okundu,
          mesaj_okundu_saat=:mosat,
          mesaj_okundu_tarih=:motar                      
          WHERE id=$gonderen_mid");
        $mesajg_bas=$mesajg->execute(array(
          'durum'=> $mesaj_b_durum,
          'okundu'=> $mesaj_gonderen_okundu,
          'mosat'=> $mesaj_okundu_saat,
          'motar'=> $mesaj_okundu_tarih                
        ));

        if ($mesajg_bas) {
          $mesajal=$db->prepare("UPDATE mesajlar SET
            mesaj_okundu=:okundu,
            mesaj_okundu_saat=:mosat,
            mesaj_okundu_tarih=:motar                      
            WHERE id=$alici_mid");
          $mesajal_bas=$mesajal->execute(array(
            'okundu'=> $mesaj_okundu,
            'mosat'=> $mesaj_okundu_saat,
            'motar'=> $mesaj_okundu_tarih                
          ));
        }

      }else {
    //gönderen mesajı silerse
        $mesajg=$db->prepare("UPDATE mesajlar SET
          mesaj_durum=:durum,
          mesaj_okundu=:okundu,
          mesaj_okundu_saat=:mosat,
          mesaj_okundu_tarih=:motar                      
          WHERE id=$gonderen_mid");
        $mesajg_bas=$mesajg->execute(array(
          'durum'=> $mesaj_b_durum,
          'okundu'=> $mesaj_gonderen_okundu,
          'mosat'=> $mesaj_okundu_saat,
          'motar'=> $mesaj_okundu_tarih                
        ));
      }


    }

  }elseif($mesaj_sorgu == 0 and $engelli_uye == 1) {
    header('Location:mesajlar?mesaj-aranizda=engelvar&ct=1'); 
    exit();

  }elseif($mesaj_sorgu == 0 and $arkadas_var == 0) {
    header('Location:mesajlar?mesaj-arkadas=degil&ct=1'); 
    exit();

  }elseif($mesaj_sorgu == 0 and $ark_durum == 0) {
    header('Location:mesajlar?mesaj-engeli=atmissin&ct=1'); 
    exit();

  }elseif($mesaj_sorgu == 0 and $ark_ters_durum == 0) {
    header('Location:mesajlar?mesaj-atmanizi=istemiyor&ct=1'); 
    exit();

  }else {
    header('Location:mesajlar?mesaj-konusma=yok&ct=1'); 
    exit();
  }


}else {
  header('Location:mesajlar?mesaj-konusma=hata&ct=1'); 
  exit();
}



$ark_listesi = $mes_alici;

$arkadas_listele=$db->prepare("SELECT * from users where uye_code=:code");
$arkadas_listele->execute(array(
  'code' => $ark_listesi
));

$ark=$arkadas_listele->fetch(PDO::FETCH_ASSOC);

$ad = $ark['uye_ad'];
$soyad = $ark['uye_soyad'];

$adsoyad = $ad." ".$soyad;



if ($_GET['msj-s'] == 1) {
  $ts_ac_kapa = 1;
}elseif ($_GET['msj-s'] == 0){
  $ts_ac_kapa = 0;
}else {
  $ts_ac_kapa = 0;
}


?>




<?php 

if ($_GET['msj-x']=="eax") {
  $g_goster = 1;
  $g_mex = 20; 
  $g_adres = 'eax';
}elseif ($_GET['msj-x']=="e83754bx") {
  $g_goster = 2;
  $g_adres = 'e83754bx';
}else {
  $g_goster = 1;
  $g_mex = 20;  
  $g_adres = 'eax';
}



$say=$db->prepare("SELECT * from konusma where konusma_kimin=:kimin and konusma_alici=:alici");
$say->execute(array(
 'kimin' => $uyecodes,
 'alici'=> $mes_alici));
$toplamveri=$say->rowCount();
if ($toplamveri > 0 and $toplamveri < 30 and $g_goster == 1) {
  $goster = 0;
}elseif ($toplamveri > 29 and $g_goster == 1) {
  $goster = $toplamveri - $g_mex;
}elseif ($toplamveri > 29 and $g_goster == 2) {
  $goster = 0;
}

?>

<?php include 'menu.php'; ?>


<div class="col-md-3 col-sm-12 col-xs-12">




</div>




<div class="col-md-6 col-xs-12 ortbslk" style="margin-bottom:150px;">








  <div class="py-hak">
    <div class="pylsm1">

      <?php  
//online
      $online_uye_durumu=$db->prepare("SELECT * from online where online_uyecode=:on_uy");
      $online_uye_durumu->execute(array(
        'on_uy' => $mes_alici
      ));
      $online_uye_cek=$online_uye_durumu->fetch(PDO::FETCH_ASSOC);
      if (date('Y-m-d H:i:s') <= $online_uye_cek['online_zaman']) {
        $uye_onlinemi = 1;
      }else {
        $uye_onlinemi = 0;
        $uo_saat = $online_uye_cek['online_saat'];
        $uo_tarih = $online_uye_cek['online_tarih'];
        $uyox = $uo_saat." | ".$uo_tarih;
      }
      ?>


      <div class="ht-mesaj-bslk">


        <div class="pctype">
          <table class="mestab">
            <thead>
              <tr>

                <th class="b-tablo-1">
                  <div class="mestab-style">
                    <a href="mesajlar.php?sayfa=<?php echo $mess_sayfa; ?>"><button class="meb-buti"><i class="fa fa-reply" aria-hidden="true"></i></button></a>
                    <?php if (@getimagesize($ark['uye_mini_resim'])) { ?>
                      <a href="kullanici.php?href=<?php echo $ark['uye_profil_code']; ?>"><span class="mes-pad"><?php echo $adsoyad; ?></span></a><?php if ($ark['uye_profil_onay'] == 1) { ?><i class="fa fa-check-circle-o onaytype onay-tooltip" aria-hidden="true" aria-hidden="true" data-toggle="tooltip" data-placement="right"></i><?php } ?>- <span><?php echo $ark['uye_departman'] ?> DEPARTMANI</span>
                    <?php }else { ?><span class="text-blocked-yazi mes-pad">Bu hesap kapatılmıştır !</span><?php } ?>
                  </div>

                </th>


                


                </tr>
              </thead>
            </table>
          </div>  


          <div class="mobtype">
            <table class="mestab">
              <thead>
                <tr>

                  <th class="tabkonus1">

                    <a href="mesajlar.php?sayfa=<?php echo $mess_sayfa; ?>"><button class="meb-buti"><i class="fa fa-reply" aria-hidden="true"></i></button></a>

                  </th>

                  <th class="tabkonus2">

                    <div class="dropdown flo-alright">
                      <button class="sil-buti dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-chevron-down" aria-hidden="true"></i></button>

                      <ul class="dropdown-menu">

                        <li><a href="data/mesaj-sil.php?msj-a=<?php echo $mes_alici; ?>&msj-b=<?php echo $uyecodes; ?>&msj-c=<?php echo $mes_kodu; ?>&msj-t=p&msj-n=c">Konuşmayı sil</a></li>

                        <?php if ($engelli_uye != 1 and $arkadas_var == 1 and $ark_durum == 1) { ?>
                          <li><a href="data/mesaj-engel.php?msj-a=<?php echo $mes_alici; ?>&msj-b=<?php echo $uyecodes; ?>&msj-c=<?php echo $mes_kodu; ?>&msj-m=s&msj-y=t">Mesaj engeli at</a></li>

                        <?php } elseif ($engelli_uye != 1 and $arkadas_var == 1 and $ark_durum == 0) { ?>
                          <li><a href="data/mesaj-ac.php?msj-a=<?php echo $mes_alici; ?>&msj-b=<?php echo $uyecodes; ?>&msj-c=<?php echo $mes_kodu; ?>&msj-k=v&msj-z=e">Mesaj engeli aç</a></li>
                        <?php } ?> 

                      </ul>
                    </div>
                  </th>

                </tr>

                <tr>
                  <th class="tabkonus3">
                    <div class="mesnamex">
                      <?php if (@getimagesize($ark['uye_mini_resim'])) { ?>
                        <a href="kullanici.php?href=<?php echo $ark['uye_profil_code']; ?>"><span><?php echo $adsoyad; ?></span></a><?php if ($ark['uye_profil_onay'] == 1) { ?><i class="fa fa-check-circle-o onaytype onay-tooltip" aria-hidden="true" aria-hidden="true" data-toggle="tooltip" data-placement="right" data-original-title="Onaylı Profil"></i><?php } ?> 
                      <?php }else { ?><span class="text-blocked-yazi mes-pad">Bu hesap kapatılmıştır !</span><?php } ?>
                    </div>

                    <?php if (@getimagesize($ark['uye_mini_resim'])) { ?>
                      <?php if($uye_onlinemi == 1) { ?>
                        <span class="onnof1"><i class="fa fa-clock-o" aria-hidden="true"></i></span> <span class="onnotext">Çevrimiçi</span><?php }else { ?>
                          <span class="onnof2"><i class="fa fa-clock-o" aria-hidden="true"></i></span> <span class="onnotext"><?php echo $uyox; ?></span>
                        <?php } ?>
                      <?php }else { ?><span class="onnotext">Konuşmayı silebilirsiniz</span><?php } ?>
                    </th>




                  </tr>

                </thead>
              </table>
            </div>  


          </div>

          <div class="mesaj_tablosu">

            <div class="mesaj-yer-alan">
              <ul class="mess_ch">

                <?php 
                if ($toplamveri > 29 and $g_goster == 1) { ?>

                  <a href="konusma.php?msj-a=<?php echo $mes_alici; ?>&msj-b=<?php echo $uyecodes; ?>&msj-c=<?php echo $mes_kodu; ?>&msj=d&msj-x=e83754bx&msj-s=<?php echo $ts_ac_kapa; ?>"><div class="dahafazlalink">Hepsini göster</div></a>

                <?php } ?>




                <?php  

                $konusma_sor=$db->prepare("SELECT * from konusma where konusma_kimin=:kimin and konusma_alici=:alici ORDER BY konusma_zaman ASC Limit $goster, $toplamveri");
                $konusma_sor->execute(array(
                  'kimin' => $uyecodes,
                  'alici' => $mes_alici
                ));

                while($k_cek=$konusma_sor->fetch(PDO::FETCH_ASSOC)) { ?>  

                  <?php 
                  $gral = $k_cek['konusma_durum']; 
                  $_SESSION['pg_sayfa'] = $mess_sayisi; 
                  $konusma_icerik = $k_cek['konusma_icerik']; 
                  $konusma_ts = $k_cek['konusma_saat']." | ".$k_cek['konusma_tarih']; 


                  if ($gral == 1) {
                    $mesaj_balonu = 'mesaj_balon_r';
                    $balon_type = 'balon_style_2';
                  }else {
                    $mesaj_balonu = 'mesaj_balon_l';  
                    $balon_type = 'balon_style_1';
                  }


                  ?>





                  <li class="<?php echo $mesaj_balonu; ?>">
                    <div class="<?php echo $balon_type; ?>">


                      <div class="<?php echo $balon_type; ?>">
                        <?php echo $konusma_icerik; ?>
                      </div>


                      <?php if ($ts_ac_kapa == 1) { ?>

                        <div class="tptx">
                          <?php echo $konusma_ts; ?>
                        </div> 

                      <?php } ?>
                    </div>

                  </li>







                <?php } ?>
              </ul>

            </div>

            <br>


          </div>


          <?php if ($engelli_uye == 1) { ?>

            <table class="mestab">
              <thead>
                <tr>

                  <th class="b-tablo-1">
                    <div class="mestab-uyari-type1">
                      Bu kullanıcı, sizi engellemiş veya siz onu engellenmişsiniz.
                    </div>
                  </th>

                  <th class="b-tablo-2">
                    <div class="mestab-uyari-type2">
                      <a href="data/mesaj-sil.php?msj-a=<?php echo $mes_alici; ?>&msj-b=<?php echo $uyecodes; ?>&msj-c=<?php echo $mes_kodu; ?>&msj-t=p&msj-n=c">
                        <button class="sil-buti">Mesajı sil</button>
                      </a>
                    </div>
                  </th>

                </tr>
              </thead>

            </table>

          <?php }elseif ($ark_durum == 0 and $ark_mesajvar == 1 and $arkadas_var == 1) { ?>

            <table class="mestab">
              <thead>
                <tr>

                  <th class="b-tablo-1">
                    <div class="mestab-uyari-type1">
                      Bu kullanıcıya mesaj engeli atmışsınız.
                    </div>
                  </th>

                  <th class="b-tablo-2">
                    <div class="mestab-uyari-type2">
                      <a href="data/mesaj-sil.php?msj-a=<?php echo $mes_alici; ?>&msj-b=<?php echo $uyecodes; ?>&msj-c=<?php echo $mes_kodu; ?>&msj-t=p&msj-n=c">
                        <button class="sil-buti">Mesajı sil</button>
                      </a>
                    </div>
                  </th>

                </tr>
              </thead>

            </table>

          <?php }elseif ($ark_ters_durum == 0 and $ark_mesajvar == 1 and $arkadas_var == 1) { ?>

            <table class="mestab">
              <thead>
                <tr>

                  <th class="b-tablo-1">
                    <div class="mestab-uyari-type1">
                      Bu kullanıcı, sizin mesaj atmanızı istemiyor.
                    </div>
                  </th>

                  <th class="b-tablo-2">
                    <div class="mestab-uyari-type2">
                      <a href="data/mesaj-sil.php?msj-a=<?php echo $mes_alici; ?>&msj-b=<?php echo $uyecodes; ?>&msj-c=<?php echo $mes_kodu; ?>&msj-t=p&msj-n=c">
                        <button class="sil-buti">Mesajı sil</button>
                      </a>
                    </div>
                  </th>

                </tr>
              </thead>

            </table>

          <?php }elseif ($ark_mesajvar == 1 and $arkadas_var == 0) { ?>

            <table class="mestab">
              <thead>

                <tr>
                  <th width="100%">
                    <div class="mestab-ts-type">
                      <?php if ($ts_ac_kapa == 0) { ?>
                        <a href="konusma.php?msj-a=<?php echo $mes_alici; ?>&msj-b=<?php echo $uyecodes; ?>&msj-c=<?php echo $mes_kodu; ?>&msj=d&msj-x=<?php echo $g_adres; ?>&msj-s=1">
                          <button class="mts-buti"><i class="fa fa-clock-o" aria-hidden="true"></i> Tarih-Saat göster</button></a>
                        <?php }elseif ($ts_ac_kapa == 1) { ?>
                          <a href="konusma.php?msj-a=<?php echo $mes_alici; ?>&msj-b=<?php echo $uyecodes; ?>&msj-c=<?php echo $mes_kodu; ?>&msj=d&msj-x=<?php echo $g_adres; ?>&msj-s=0">
                            <button class="mts-buti"><i class="fa fa-clock-o" aria-hidden="true"></i> Tarih-Saat gizle</button></a>
                          <?php } ?>
                        </div>
                      </th>
                    </tr>
                    <tr>
                      <th width="80%">
                        <div class="mestab-uyari-type1">
                          Bu kullanıcı ile arkadaş değilsiniz.
                        </div>
                      </th>

                      <th width="20%">
                        <div class="mestab-uyari-type2">
                          <a href="data/mesaj-sil.php?msj-a=<?php echo $mes_alici; ?>&msj-b=<?php echo $uyecodes; ?>&msj-c=<?php echo $mes_kodu; ?>&msj-t=p&msj-n=c">
                            <button class="sil-buti">Konuşmayı sil</button>
                          </a>
                        </div>
                      </th>

                    </tr>
                  </thead>

                </table>

              <?php } else { ?>


                <div class="ht-msj1-bslk">
                  <table class="mestab">
                    <thead>
                      <tr>

                        <th class="b-tablo-1">
                          <div class="mestab-ts-type">
                            <?php if ($ts_ac_kapa == 0) { ?>
                              <a href="konusma.php?msj-a=<?php echo $mes_alici; ?>&msj-b=<?php echo $uyecodes; ?>&msj-c=<?php echo $mes_kodu; ?>&msj=d&msj-x=<?php echo $g_adres; ?>&msj-s=1">
                                <button class="mts-buti"><i class="fa fa-clock-o" aria-hidden="true"></i> Tarih-Saat göster</button></a>
                              <?php }elseif ($ts_ac_kapa == 1) { ?>
                                <a href="konusma.php?msj-a=<?php echo $mes_alici; ?>&msj-b=<?php echo $uyecodes; ?>&msj-c=<?php echo $mes_kodu; ?>&msj=d&msj-x=<?php echo $g_adres; ?>&msj-s=0">
                                  <button class="mts-buti"><i class="fa fa-clock-o" aria-hidden="true"></i> Tarih-Saat gizle</button></a>
                                <?php } ?>
                              </div>
                            </th>

                            <th class="b-tablo-2">
                              <div class="mestab-yenile-type">

                                <a href="konusma.php?msj-a=<?php echo $mes_alici; ?>&msj-b=<?php echo $uyecodes; ?>&msj-c=<?php echo $mes_kodu; ?>&msj=d&msj-x=eax&msj-s=<?php echo $ts_ac_kapa; ?>"><button class="mts-buti"><i class="fa fa-refresh" aria-hidden="true"></i> Yenile</button></a>

                              </div>
                            </th>

                          </tr>
                        </thead>

                      </table>
                    </div> 


                    <div class="mesaj-kontrol">
                      <form method="POST" action="tkpan/mesajlar/mesajat.php">


                        <?php $_SESSION['alici_uye_code'] = $ark['uye_code']; ?>
                        <?php $_SESSION['alici_mesaj_kodu'] = $mes_kodu; ?>
                        <?php $_SESSION['mesaj_adresi'] = 'g7412'; ?>

                        <div class="mbt">

                          <div class="ht-orta">


                            <textarea rows="3" id="sayd" class="form-control ht-area tarea setng tasd" name="mesaj" placeholder="Göndermek için bir mesaj yazın..."></textarea>

                          </div>

                          <div class="ht-m-alt">

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
                                  <button class="btn btn-success" name="mesaj_at">Gönder</button>
                                </div>
                              </li>
                            </ul>

                          </div>

                        </div>

                      </form> 
                    </div>


                  <?php } ?>




                </div>
              </div>



              <?php include 'copfoot-pc.php'; ?>


            </div>





            <div class="col-md-3 col-sm-12 col-xs-12">

              <div class="hidden-xs hidden-sm">
                <?php include 'sag-kategori.php'; ?>
              </div>

              <?php include 'copfoot-mobil.php'; ?>

            </div>


            <?php include 'footer.php'; ?>
