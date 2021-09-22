
<!-- EN ÜST NAVBAR BAŞLANGIÇ--------------------------------------------------------------------- -->

<?php include 'header.php';?>

<!-- EN ÜST NAVBAR BİTİŞ--------------------------------------------------------------------- -->


<script type="text/javascript">

	<?php 


	$sorgu1=$db->prepare("SELECT * from users  where   uye_cinsiyet='Erkek' ");
	$sorgu1->execute();
	$sorgucek1=$sorgu1->rowCount();
	$sorgu2=$db->prepare("SELECT * from users  where   uye_cinsiyet='Kadın' ");
	$sorgu2->execute();
	$sorgucek2=$sorgu2->rowCount();




	?>

	
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart);

	function drawChart() {

		var data = google.visualization.arrayToDataTable([
			['Task', 'Hours per Day'],
			
			['Erkek',     <?php echo $sorgucek1; ?>],
			['Kadın',     <?php echo $sorgucek2; ?>]
			
			]);

		var options = {
			title:"",
			width: 650,
			height: 250,
			bar: {groupWidth: "100%"},
			
			
		};

		var chart = new google.visualization.PieChart(document.getElementById('piechart'));

		chart.draw(data, options);
	}
</script>

<script type="text/javascript">
	google.charts.load("current", {packages:['corechart']});
	google.charts.setOnLoadCallback(drawChart);
	function drawChart() {
		var data = google.visualization.arrayToDataTable([
			["", "", { role: "style" } ],
			["<18", 0, "primary"],
			["18-25", 5, "primary"],
			["26-34", 6, "primary"],
			["35-44", 7, "primary"],
			["45-54", 4, "primary"],
			["55-64", 2, "primary"],
			["65+", 0, "primary"]
			]);

		var view = new google.visualization.DataView(data);
		view.setColumns([0, 1,
			{ calc: "stringify",
			sourceColumn: 1,
			type: "string",
			role: "annotation" },
			2]);

		var options = {
			title: "",
			width: 675,
			height: 200,
			bar: {groupWidth: "95%"},
			
		};
		var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_material"));
		chart.draw(view, options);
	}
</script>



<script type="text/javascript">
	google.charts.load("current", {packages:['corechart']});
	google.charts.setOnLoadCallback(drawChart);
	function drawChart() {
		var data = google.visualization.arrayToDataTable([
			["", "", { role: "style" } ],
			["MUHASEBE", 3, "primary"],
			["İK", 4, "primary"],
			["PAZARLAMA", 2, "primary"],
			["AR-GE", 5, "primary"],
			["ÜRETİM", 2, "primary"],
			["YÖNETİM", 1, "primary"]
			
			]);

		var view = new google.visualization.DataView(data);
		view.setColumns([0, 1,
			{ calc: "stringify",
			sourceColumn: 1,
			type: "string",
			role: "annotation" },
			2]);

		var options = {
			title: "",
			width: 675,
			height: 200,
			bar: {groupWidth: "95%"},

		};
		var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
		chart.draw(view, options);
	}
</script>


<!-- TÜM SAYFA İÇİ BAŞLANGIÇ -->
<div class="main-content row" id="panel" style="margin-bottom:100px;">


	<div class="container" style="margin-left:300px; margin-top:20px;">
		<div class="row">
			<div class="col-md-4 col-xl-3">
				<div class="cardss bg-c-yellow order-cardd">
					<div class="cardd-block">
						<?php 

						$sorgupersonelsayisi=$db->prepare("SELECT * from users  where   uye_yetki=1 or uye_yetki=2 ");
						$sorgupersonelsayisi->execute();
						$sorgucekpersonesayisi=$sorgupersonelsayisi->rowCount(); 
						?>
						<h4 class="m-b-20">PERSONEL</h4>
						<h2 class="text-right"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-file-person f-left" viewBox="0 0 16 16">
							<path d="M12 1a1 1 0 0 1 1 1v10.755S12 11 8 11s-5 1.755-5 1.755V2a1 1 0 0 1 1-1h8zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z"/>
							<path d="M8 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
						</svg><span><?php echo $sorgucekpersonesayisi; ?></span></h2>

					</div>
				</div>
			</div>

			<div class="col-md-4 col-xl-3">
				<div class="cardss bg-c-green order-cardd">
					<div class="cardd-block">
						<h4 class="m-b-20">DEPARTMAN</h4>
						<h2 class="text-right"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-diagram-2 f-left" viewBox="0 0 16 16">
							<path fill-rule="evenodd" d="M6 3.5A1.5 1.5 0 0 1 7.5 2h1A1.5 1.5 0 0 1 10 3.5v1A1.5 1.5 0 0 1 8.5 6v1H11a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0v-1A.5.5 0 0 1 5 7h2.5V6A1.5 1.5 0 0 1 6 4.5v-1zM8.5 5a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1zM3 11.5A1.5 1.5 0 0 1 4.5 10h1A1.5 1.5 0 0 1 7 11.5v1A1.5 1.5 0 0 1 5.5 14h-1A1.5 1.5 0 0 1 3 12.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm4.5.5a1.5 1.5 0 0 1 1.5-1.5h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1A1.5 1.5 0 0 1 9 12.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z"/>
						</svg><span>6</span></h2>
						
					</div>
				</div>
			</div>


			<div class="col-md-4 col-xl-3">
				<div class="cardss bg-c-pink order-cardd">
					<div class="cardd-block">
						<h4 class="m-b-20">MESLEK</h4>
						<h2 class="text-right"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-list-task f-left" viewBox="0 0 16 16">
							<path fill-rule="evenodd" d="M2 2.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5V3a.5.5 0 0 0-.5-.5H2zM3 3H2v1h1V3z"/>
							<path d="M5 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM5.5 7a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9zm0 4a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9z"/>
							<path fill-rule="evenodd" d="M1.5 7a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5V7zM2 7h1v1H2V7zm0 3.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5H2zm1 .5H2v1h1v-1z"/>
						</svg><span>12</span></h2>
						
					</div>
				</div>
			</div>

		</div>
	</div>



	

	

	




	









	

	





	<div class="container mt-5">
		<div class="row">
			<div class="col-md-12">

				<div class="mt-3">
					<ul class="list list-inline">
						
						<!-- CİNSİYET GRAFİĞİ BASLANGIC -->
						<li class="d-flex justify-content-between">
							<div class="d-flex flex-row align-items-center"><i class="fa fa-check-circle checkicon"></i>
								<div class="ml-2">
									<h4 class="mb-0">PERSONEL CİNSİYET DAĞILIMI</h4>

								</div>
							</div>
							<div class="d-flex flex-row align-items-center">
								<div class="d-flex flex-column mr-2">
									<button type="button" class="btn btn-white" style="box-shadow:0px 0px 0px" data-toggle="modal" data-target="#exampleModal2">
										<svg
										width="24"
										height="24"
										viewBox="0 0 24 24"
										fill="none"
										xmlns="http://www.w3.org/2000/svg"
										>
										<path d="M10 18V16H8V14H10V12H12V14H14V16H12V18H10Z" fill="currentColor" />
										<path
										fill-rule="evenodd"
										clip-rule="evenodd"
										d="M6 2C4.34315 2 3 3.34315 3 5V19C3 20.6569 4.34315 22 6 22H18C19.6569 22 21 20.6569 21 19V9C21 5.13401 17.866 2 14 2H6ZM6 4H13V9H19V19C19 19.5523 18.5523 20 18 20H6C5.44772 20 5 19.5523 5 19V5C5 4.44772 5.44772 4 6 4ZM15 4.10002C16.6113 4.4271 17.9413 5.52906 18.584 7H15V4.10002Z"
										fill="currentColor"
										/>
									</svg>
								</button>
							</div>
							<div class="modal fade  bd-example-modal-lg" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true" style="background-color:transparent;">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel2">PERSONEL CİNSİYET DAĞILIMI</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">



											<div id="piechart"></div>



										</div>

									</div>
								</div>
							</div>



						</div>
					</li><!-- CİNSİYET GRAFİĞİ BİTİS -->


					<!-- YAŞ GRAFİĞİ BASLANGIC -->
					<li class="d-flex justify-content-between">
						<div class="d-flex flex-row align-items-center"><i class="fa fa-check-circle checkicon"></i>
							<div class="ml-2">
								<h4 class="mb-0">PERSONEL YAŞ DAĞILIMI</h4>

							</div>
						</div>
						<div class="d-flex flex-row align-items-center">
							<div class="d-flex flex-column mr-2">
								<button type="button" class="btn btn-white" style="box-shadow:0px 0px 0px" data-toggle="modal" data-target="#exampleModal3">
									<svg
									width="24"
									height="24"
									viewBox="0 0 24 24"
									fill="none"
									xmlns="http://www.w3.org/2000/svg"
									>
									<path d="M10 18V16H8V14H10V12H12V14H14V16H12V18H10Z" fill="currentColor" />
									<path
									fill-rule="evenodd"
									clip-rule="evenodd"
									d="M6 2C4.34315 2 3 3.34315 3 5V19C3 20.6569 4.34315 22 6 22H18C19.6569 22 21 20.6569 21 19V9C21 5.13401 17.866 2 14 2H6ZM6 4H13V9H19V19C19 19.5523 18.5523 20 18 20H6C5.44772 20 5 19.5523 5 19V5C5 4.44772 5.44772 4 6 4ZM15 4.10002C16.6113 4.4271 17.9413 5.52906 18.584 7H15V4.10002Z"
									fill="currentColor"
									/>
								</svg>
							</button>
						</div>
						<div class="modal fade  bd-example-modal-lg" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true" style="background-color:transparent;">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel2">PERSONEL YAŞ DAĞILIMI</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">



										<div id="columnchart_material"></div>





									</div>

								</div>
							</div>
						</div>



					</div>
				</li><!-- YAŞ GRAFİĞİ BİTİS -->



				




				<!-- DEPARTMAN GRAFİĞİ BASLANGIC -->
				<li class="d-flex justify-content-between">
					<div class="d-flex flex-row align-items-center"><i class="fa fa-check-circle checkicon"></i>
						<div class="ml-2">
							<h4 class="mb-0">DEPARTMAN PERSONEL DAĞILIMI</h4>

						</div>
					</div>
					<div class="d-flex flex-row align-items-center">
						<div class="d-flex flex-column mr-2">
							<button type="button" class="btn btn-white" style="box-shadow:0px 0px 0px" data-toggle="modal" data-target="#exampleModal4">
								<svg
								width="24"
								height="24"
								viewBox="0 0 24 24"
								fill="none"
								xmlns="http://www.w3.org/2000/svg"
								>
								<path d="M10 18V16H8V14H10V12H12V14H14V16H12V18H10Z" fill="currentColor" />
								<path
								fill-rule="evenodd"
								clip-rule="evenodd"
								d="M6 2C4.34315 2 3 3.34315 3 5V19C3 20.6569 4.34315 22 6 22H18C19.6569 22 21 20.6569 21 19V9C21 5.13401 17.866 2 14 2H6ZM6 4H13V9H19V19C19 19.5523 18.5523 20 18 20H6C5.44772 20 5 19.5523 5 19V5C5 4.44772 5.44772 4 6 4ZM15 4.10002C16.6113 4.4271 17.9413 5.52906 18.584 7H15V4.10002Z"
								fill="currentColor"
								/>
							</svg>
						</button>
					</div>
					<div class="modal fade  bd-example-modal-lg" id="exampleModal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true" style="background-color:transparent;">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel4">DEPARTMAN PERSONEL DAĞILIMI</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">



									<div id="columnchart_values" ></div>





								</div>

							</div>
						</div>
					</div>



				</div>
			</li><!-- DEPARTMAN GRAFİĞİ BİTİS -->



		</ul>
	</div>
</div>
</div>
</div>















































































































</div>

<!-- TÜM SAYFA İÇİ BİTİŞ -->



























<?php include 'footer.php'; ?>