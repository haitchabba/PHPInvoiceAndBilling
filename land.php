<?php
session_start();
include('header.php');
include 'Invoice.php';
$invoice = new Invoice();
$invoice->checkLoggedIn();
?>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('container.php');?>
<div class="container">
	<h2 class="title mt-5">PHP Invoice System</h2>
	<?php if($_SESSION['stfcat'] == 1 ){
		include('menu_admin.php');
	}elseif ($_SESSION['stfcat'] == 2) {
		include('menu_mngr.php');
	}else{
		include('menu.php');
	} ?>
	<div class="card-deck">
		<div class="card text-white bg-success mb-3">
			<!-- <div class="card-header">Header</div>
			<img src="..." class="card-img-top" alt="..."> -->
			<div class="card-body">
				<h5 class="card-title">Create a New Client</h5>
				<p class="card-text">All new clients are to be captured first.</p>
			</div>
			<div class="card-footer">
				<a href="new_client.php" class="btn btn-dark">Go</a>
			</div>
		</div>
		<div class="card text-white bg-info mb-3">
			<!-- <div class="card-header">Header</div>
			<img src="..." class="card-img-top" alt="..."> -->
			<div class="card-body">
				<h5 class="card-title">View All Clients</h5>
				<p class="card-text">All existing clients can be found on the next table</p>
			</div>
			<div class="card-footer">
				<a href="view_clients.php" class="btn btn-dark">Go</a>
			</div>
		</div>

	</div>
</div>
<?php include('footer.php');?>
