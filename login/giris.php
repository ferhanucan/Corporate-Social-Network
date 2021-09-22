<?php error_reporting(0); ?>
<?php include 'login-header.php'; ?>


<div class="d-lg-flex half">
  <div class="bg order-1 order-md-2" style="background-image: url('../img/img1.jpg');"></div>
  <div class="contents order-2 order-md-1">

    <div class="container">
      <div class="row align-items-center justify-content-center">
        <div class="col-md-7">
          <img src="../img/projelogo.png" style="height:150px; width:150px; margin-left:100px;">
          <h2  style="font-family: 'Bahnschrift Light', serif; font-size:30px; "><strong>KURUMSAL SOSYAL AĞ</strong></h2>
          <p class="mb-4" style="font-family: 'Bahnschrift Light', serif;">İK SÜREÇLERİNİZİ VE ŞİRKET İÇİ İLETİŞİMİNİZİ YÖNETİN</p>
          <form method="POST" action="../tkpan/database/girisislemi.php">
            <div class="form-group first last mb-3" style="border-style: solid; border-width: 0px;">
              <label for="select">YETKİ</label>
              <select class="form-select" id="uye_yetki" name="uye_yetki">
                <option value="1" >Yönetici</option>
                <option value="2">Personel</option>
                <option value="3">Aday Personel</option>
              </select>
            </div>
            <div class="form-group first">
              <label for="">E-POSTA</label>
              <input id="metin" type="text" name="metin" class="form-control">
            </div>
            <div class="form-group last mb-3">
              <label for="password">ŞİFRE</label>
              <input id="sifre" type="password" name="sifre" class="form-control password">
            </div>


            <div class="row mb-3 px-3"> <button type="submit" name="uye_giris" class="btn text-center" style="height:45px; width:100px; background-color:#104e8b; color:white;">GİRİŞ</button> </div>



          </form>
        </div>
      </div>
    </div>
  </div>


</div>
























<?php include 'login-footer.php'; ?>