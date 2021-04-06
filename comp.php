<?php
session_start();
include('header.php');
include 'Invoice.php';
$invoice = new Invoice();
$invoice->checkLoggedIn();
if(!empty($_POST['cName']) && $_POST['cName']){
	$invoice->saveCompany($_POST);
	header("Location:view_clients.php");
}
?>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('container.php');?>
<div class="container">
	<h2 class="title mt-5">PHP Invoice System</h2>
	<?php include('menu.php');?>
	<form action="" id="newclient-form" method="post" class="needs-validation" novalidate autocomplete="off">

		<div class="form-row">
			<div class="form-group col-md-6">
				<label for="inputEmail4">Company Name:</label>
				<input type="text" class="form-control" name = "cName" id = "cName" required>
			</div>
			<div class="form-group col-md-6">
				<label for="inputPassword4">RC Number:</label>
				<input type="text" class="form-control" name = "rcNO" id="rcNO" required>
			</div>
		</div>
		<div class="form-row">
		<div class="form-group col-md-6">
			<label for="inputEmail4">Phone No</label>
			<input type="tel" class="form-control" name = "cPhone" id="cPhone" maxlength = "11" required>
		</div>
		<div class="form-group col-md-6">
			<label for="inputEmail4">Email</label>
			<input type="email" class="form-control" name = "cEmail" id="cEmail" required>
		</div>
	</div>
		<div class="form-group">
			<label for="inputAddress">Address</label>
			<input type="text" class="form-control" name = "cAddress" id="cAddress" required>
		</div>
		<input type="hidden" value="<?php echo $_SESSION['userid']; ?>" class="form-control" name="userId">
		<button type="submit" class="btn btn-primary mb-2">Submit</button>

</div>

<?php include('footer.php');?>
