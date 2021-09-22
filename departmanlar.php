<?php include 'header.php'; ?>


<?php if ($_SESSION['sessizin'] == 0) {
	header("Location:index.php"); 
	exit();
} ?>


<div class="col-md-12 col-sm-12 col-xs-12 ortbslk row" style="margin-bottom:150px;">
	


	<div class="col-xs-12">
		<div class="pme-pad">
			<div class="pme-box-text">Departman Grubu Seçin<br>
				<span>Departmanlara Göre Çalışma Arkadaşlarınızı Bulun</span></div>
			</div>
		</div>


		<div class="container py-5">


			<div class="row text-center">

				

				<div class="col-xl-3 col-sm-6 mb-5">
					<div class="bg-white rounded shadow-sm py-5 px-4">
						<h5 class="mb-0">İnsan Kaynakları Departmanı</h5>
						<ul class="social mb-0 list-inline mt-3">
							<li class="list-inline-item"><a href="departman-alani.php?d=2" class="social-link"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
								<path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
							</svg></i></a></li>
						</div>
					</div>



					<div class="col-xl-3 col-sm-6 mb-5">
						<div class="bg-white rounded shadow-sm py-5 px-4">
							<h5 class="mb-0">Üretim Departmanı</h5>
							<ul class="social mb-0 list-inline mt-3">
								<li class="list-inline-item"><a href="departman-alani.php?d=3" class="social-link"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
									<path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
								</svg></i></a></li>
							</div>
						</div>


						<div class="col-xl-3 col-sm-6 mb-5">
							<div class="bg-white rounded shadow-sm py-5 px-4">
								<h5 class="mb-0">AR-GE Departmanı</h5>
								<ul class="social mb-0 list-inline mt-3">
									<li class="list-inline-item"><a href="departman-alani.php?d=4" class="social-link"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
										<path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
									</svg></i></a></li>
								</div>
							</div>



							<div class="col-xl-3 col-sm-6 mb-5">
								<div class="bg-white rounded shadow-sm py-5 px-4">
									<h5 class="mb-0">Muhasebe Departmanı</h5>
									<ul class="social mb-0 list-inline mt-3">
										<li class="list-inline-item"><a href="departman-alani.php?d=5" class="social-link"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
											<path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
										</svg></i></a></li>
									</div>
								</div>


								<div class="col-xl-3 col-sm-6 mb-5">
									<div class="bg-white rounded shadow-sm py-5 px-4">
										<h5 class="mb-0">Pazarlama Departmanı</h5>
										<ul class="social mb-0 list-inline mt-3">
											<li class="list-inline-item"><a href="departman-alani.php?d=6" class="social-link"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
												<path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
											</svg></i></a></li>
										</div>
									</div>


									<div class="col-xl-3 col-sm-6 mb-5">
									<div class="bg-white rounded shadow-sm py-5 px-4">
										<h5 class="mb-0">Yönetim Departmanı</h5>
										<ul class="social mb-0 list-inline mt-3">
											<li class="list-inline-item"><a href="departman-alani.php?d=7" class="social-link"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
												<path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
											</svg></i></a></li>
										</div>
									</div>










								</div>
							</div>



							






						</div>




						<?php include 'footer.php'; ?>
