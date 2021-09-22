<?php include 'header.php'; ?>


<?php if ($_SESSION['sessizin'] == 0) {
  header("Location:index.php"); 
  exit();
} ?>


<?php include 'menu.php'; ?>



<div class="col-md-1 col-sm-12 col-xs-12">
</div>

<div class="col-md-10 col-sm-12 col-xs-12">

<?php include 'uyarikutusu.php'; ?>

<div class="destek-tablo">
<table class="tableclass">
  <thead>
    <tr>

      <th width="50%">
        <a href="yardim">
            <button class="yardim_buton">Yardım</button>
        </a>
      </th>

      <th width="50%">
        <a href="destek-talepleri">
            <button class="yardim_buton">Tüm destek talepleri</button>
        </a>
      </th>

    </tr>
  </thead>
</table>
</div>

<div class="yardim-panel">
<div class="yar-pan-heading">Destek talebi oluştur</div>
<div class="des-body-text">




<form method="POST" action="data/destek-gonder.php">


  <?php $_SESSION['uye_code']; ?>
  <input type="hidden" name="ax5321c" value="c2vbz26gd845hgcvxker">

<div class="reklam-panel-alt-stil">
<div class="jbt">

<div class="ht-panel-ust">
  <div class="text-profil">
Destek bölümü seçiniz
  </div>

</div>

 <table class="tableclass">
  <thead>
    <tr>
      <th class="prof-th">
      <div class="form-group prof-p-panel">
                        
        <select id="desselt" class="form-control" name="konular" required="required">
            <option value="">Seçiniz</option>
            <option value="1">Destek (Bilgi almak)</option>
            <option value="2">Şikayet</option>
            <option value="3">Öneri ve görüş</option>
            <option value="4">Hesap işlemleri</option>
        </select>
            
      </div>
      </th>
    </tr>
  </thead>
</table>


</div>
</div>

<div class="jbt">

<div class="ht-panel-ust">
  <div class="text-profil">
Destek mesajı oluştur
  </div>

</div>
<div class="ht-orta">
    
      <textarea rows="3" id="saydir" class="form-control dest-area tarea setng dezst" name="destek-metin" placeholder="Göndermek için bir mesaj yazın..."></textarea>
  
</div>

<div class="ht-panel-alt">

<ul class="media-list">
  <li class="media">
    <div class="media-left">
      <div class="medeng">
        <span class="sayitakip">1000</span>
      </div>
    </div>
    <div class="media-body">
      <div class="medeng">
        <div class="birinciyazi"><span class="vidnopc">Karakter limiti doldu !</span><span class="vidnomob">Limit aşımı !</span></div>
        <div class="ikinciyazi"><span class="vidnopc">Karakter limitine ulaştınız.</span><span class="vidnomob">Limit doldu.</span></div>
      </div>      
    </div>
    <div class="media-right">
      <button class="ht-sha buttonclas" name="destek-kaydet">Gönder</button>
    </div>
  </li>
</ul>

</div>

</div>

</form> 




</div>
</div>

<div class="yar-pan-footer">
    
</div>

<?php include 'copfoot-pc.php'; ?>

</div>

<div class="col-md-1 col-sm-12 col-xs-12">
</div>

<?php include 'copfoot-mobil.php'; ?>

<?php include 'footer.php'; ?>