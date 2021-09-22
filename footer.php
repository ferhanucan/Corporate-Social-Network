<?php
if ($inckont == 0) {
	header("Location:index.php"); 
	exit();
}elseif (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
	header("Location:index.php"); 
	exit();
} ?>


<script src="general/jquery/jquery.form.js"></script>
<script src="general/bootstrap/js/bootstrap.min.js"></script>



<script type="text/javascript" src="js/header.js"></script>
<script type="text/javascript" src="js/panel-nav.js"></script>
<script type="text/javascript" src="js/panel-drum.js"></script>
<script type="text/javascript" src="js/totlip.js"></script>
<script type="text/javascript" src="js/selbox.js"></script>
<script type="text/javascript" src="js/sec.js"></script>
<script type="text/javascript" src="js/profil.js"></script>
<script type="text/javascript" src="js/yayin.js"></script>

<script src="assets/vendor/jquery/dist/jquery.min.js"></script>
<script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/js-cookie/js.cookie.js"></script>
<script src="assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
<script src="assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
<script src="assets/vendor/chart.js/dist/Chart.min.js"></script>
<script src="assets/vendor/chart.js/dist/Chart.extension.js"></script>
<script src="assets/js/argon.js?v=1.2.0"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

<script type="text/javascript">
    $("#success").click(function () {
      $(".notify").toggleClass("active");
      $("#notifyType").toggleClass("success");

      setTimeout(function(){
        $(".notify").removeClass("active");
        $("#notifyType").removeClass("success");
      },2000);
    });

    $("#failure").click(function () {
      $(".notify").addClass("active");
      $("#notifyType").addClass("failure");

      setTimeout(function(){
        $(".notify").removeClass("active");
        $("#notifyType").removeClass("failure");
      },2000);
    });
  </script>

</body>
</html>