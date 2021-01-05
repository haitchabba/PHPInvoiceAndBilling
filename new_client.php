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
	<?php include('menu.php');?>
	<form>
		<div class="form-row">
			<div class="form-group col-md-6">
				<label for="inputEmail4">Name</label>
				<input type="text" class="form-control" id="inputEmail4" placeholder="Name">
			</div>
			<div class="form-group col-md-6">
				<label for="inputPassword4">Email</label>
				<input type="email" class="form-control" id="inputPassword4" placeholder="Email">
			</div>
		</div>
		<div class="form-row">
		<div class="form-group col-md-6">
			<label for="inputEmail4">Phone No</label>
			<input type="text" class="form-control" id="inputPhone4" placeholder="Phone No">
		</div>
	</div>
		<div class="form-group">
			<label for="inputAddress">Address</label>
			<input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
		</div>

		<button type="submit" class="btn btn-primary">Save</button>
	</form>
</div>
<?php include('footer.php');?>
