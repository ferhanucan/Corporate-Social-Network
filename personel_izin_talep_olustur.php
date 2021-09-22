<?php include 'header.php'; ?>

<?php if ($_SESSION['sessizin'] == 0) {
  header("Location:index.php"); 
  exit();
} ?>


<!-- TÜM SAYFA İÇİ BAŞLANGIÇ -->
<div class="main-content" id="panel" style="padding:50px; margin-bottom:100px;">
  <div class="row">









    <!-- izin talep form başlangıç ---------------------------------------------------------------------->


    <div class="yardim-panel" style="width:500px;">
      <div class="bg-white navbar border-bottom navbar-expand" style="color:black;">İZİN TALEBİ OLUŞTUR</div>
      <div class="des-body-text">

        <form action="personel-izin-gonder-islem.php" method="POST">

          <?php $_SESSION['uye_code']; ?>
         


          <div class="reklam-panel-alt-stil">
            <div class="jbt">

              <div class="bg-white navbar" style="height:10px;">
                <div class="text-profil" style="color:red;">
                  İzin Türü
                </div>

              </div>

              <table class="tableclass">
                <thead>
                  <tr>
                    <th class="prof-th">
                      <div class="form-group prof-p-panel">

                        <select id="desselt" class="form-control" name="konular" required="required">
                          <option value="">Seçiniz</option>
                          <option value="Askerlik İzni">Askerlik İzni</option>
                          <option value="Doğum İzni">Doğum İzni</option>
                          <option value="Evlilik İzni">Evlilik İzni</option>
                          <option value="Hastalık İzni">Hastalık İzni</option>
                          <option value="Yıllık İzin">Yıllık İzin</option>
                          <option value="Yol İzni">Yol İzni</option>
                          <option value="Ücretsiz İzin">Ücretsiz İzin</option>
                          <option value="Mazeret İzni">Mazeret İzni</option>
                        </select>

                      </div>
                    </th>
                  </tr>
                </thead>
              </table>


            </div>
          </div>
          
          <div class="row">

            <div class="reklam-panel-alt-stil" style="width:235px;">
              <div class="jbt">

                <div class="bg-white navbar" style="height:10px;">
                  <div class="text-profil" style="color:red;">
                    İzin Başlangıç Tarihi
                  </div>

                </div>
                <input type="date"  class="form-control" name="izin_baslangic" id="izin_baslangic">



              </div>
            </div>

            <div class="reklam-panel-alt-stil" style="width:235px;">
              <div class="jbt">

                <div class="bg-white navbar" style="height:10px;">
                  <div class="text-profil" style="color:red;">
                    İzin Bitiş Tarihi
                  </div>
              
                </div>

                 <input type="date"   class="form-control" name="izin_bitis" id="izin_bitis">



              </div>
            </div>

          </div>

          






          <div class="jbt">

            <div class="ht-panel-ust">
              <div class="text-profil"  style="color:red;">
                Talep mesajı oluştur
              </div>

            </div>
            <div class="ht-orta">

              <textarea rows="3" id="saydir" class="form-control dest-area tarea setng dezst" name="talep_mesaj" placeholder="Göndermek için bir mesaj yazın..."></textarea>

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
                    <button class="btn btn-success" name="izin_gonder">Gönder</button>
                  </div>
                </li>
              </ul>

            </div>

          </div>







        </form>


      </div>

    </div>



    <!-- izin talep form bitiş ---------------------------------------------------------------------------------->



<!--
    <div class="yardim-panel" style="width:500px; margin-left:300px;">
      <div class="bg-white navbar border-bottom navbar-expand" style="color:black;">İZİN TALEPLERİM</div>
      <div class="des-body-text">



      </div>

    </div> -->












  </div>
</div>





<?php include 'footer.php'; ?>