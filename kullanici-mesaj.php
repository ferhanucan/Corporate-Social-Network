<?php error_reporting(0); ?>
<?php include 'header.php'; ?>

<?php $pg_sayfa = 'kullanici-mesajlar'; ?>


<?php if ($_SESSION['sessizin'] == 0) {
  header("Location:index.php"); 
  exit();
} ?>


<?php include 'kullanici-kontrol.php'; ?>

<?php include 'kullanici-menu.php'; ?>


<div class="col-md-3 col-sm-12 col-xs-12">



</div>




<div class="col-md-6 col-sm-12 col-xs-12 ortbslk" style="margin-bottom:300px;">









<?php  
if ($player_cek['uye_code']!=$uyecodes and $istek_at['istek_durum'] != 1 and $istek_bak['istek_durum'] != 1 and $arkadas_var == 1) { ?>

<?php

  $mesaj_kontrol = $db->prepare("SELECT * from mesajlar where mesaj_kimin=:kimin and mesaj_alici=:alici");
  $mesaj_kontrol->execute(array(
  'kimin' => $uyecodes,
  'alici'=> $player_cek['uye_code']
  ));

  $mesaj_varmi=$mesaj_kontrol->rowCount();

  $misco=$mesaj_kontrol->fetch(PDO::FETCH_ASSOC);

  $arkis = $player_cek['uye_code'];
  $meskod = $misco['mesaj_code'];

?>

<?php if ($mesaj_varmi > 0) { ?> 

  <div class="uyari-pb">
    <div class="uyari-panel">
      <div class="uyari-panel-alan">
        <ul class="media-list">
          <li class="media">
            <div class="media-body">
              <div class="lik-paylasim-text">
                  <span>Bildirim: </span>Mevcut sohbetiniz var.
                </div>
              </div>
                <div class="media-right">
                <a href="konusma.php?msj-a=<?php echo $arkis; ?>&msj-b=<?php echo $uyecodes; ?>&msj-c=<?php echo $meskod; ?>&msj=d&msj-x=eax">
                <button class="ht-uyari">Konuşmaya git</button>
              </a>
                </div>
            </li>
        </ul>
      </div>
    </div>
  </div>

<?php } ?> 


<?php if ($ark_drm_cek['arkadas_durum'] == 1) { ?>

<div class="paylas-kontrol">
<form method="POST" action="tkpan/mesajlar/mesajat.php">


    <?php $_SESSION['alici_uye_code'] = $player_cek['uye_code']; ?>
    <?php $_SESSION['alici_profil_code'] = $player_cek['uye_profil_code']; ?>
    <?php $_SESSION['mesaj_adresi'] = 'x9371'; ?>

<div class="jbt">

<div class="ht-panel-ust">
  <div class="text-profil">
  <span class="tpspan">
    <?php $ad = $player_cek['uye_ad']; $soyad = $player_cek['uye_soyad']; echo $ad." ".$soyad; ?>
    <?php if ($player_cek['uye_profil_onay'] == 1) { ?><i class="fa fa-check-circle-o mesonaytp onay-tooltip" aria-hidden="true" aria-hidden="true" data-toggle="tooltip" data-placement="right" data-original-title="Onaylı Profil"></i><?php } ?> 
</span><b>Mesaj gönder</b>

  </div>

</div>
<div class="ht-orta">
    
      <textarea rows="3" id="sayd" class="form-control ht-area tarea setng tasd" name="mesaj" placeholder="Göndermek için bir mesaj yazın..."></textarea>
  
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
      <button class="btn btn-success" name="mesaj_at">Gönder</button>
    </div>
  </li>
</ul>

</div>

</div>

</form> 
</div>

<?php }else { ?>

  <div class="uyari-pb">
    <div class="uyari-panel">
      <div class="uyari-panel-alan">
        <ul class="media-list">
          <li class="media">
            <div class="media-body">
              <div class="nolik-paylasim-text">
                  <span>Dikkat: </span>Bu kullanıcı ile aranızda mesaj engeli bulunuyor !
                </div>
              </div>

            </li>
        </ul>
      </div>
    </div>
  </div>
<?php } ?> 



<?php }else { ?>

  <div class="uyari-pb">
    <div class="uyari-panel">
      <div class="uyari-panel-alan">
        <ul class="media-list">
          <li class="media">
            <div class="media-body">
              <div class="lik-paylasim-text">
                  <span>Bildirim: </span>Arkadaşınız olmayan kullanıcılara mesaj atamazsınız !
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
