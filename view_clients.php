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
				<label for="inputPassword2" class="sr-only">Password</label>
				<input type="password" class="form-control" id="inputPassword2" placeholder="Password">
			</div>
			<div class="form-group col-md-6">
			<button type="submit" class="btn btn-primary mb-2">Confirm identity</button>
		</div>
		</form>
	</div>
</div>
<?php include('footer.php');?>
