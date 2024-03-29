<?php
session_start();
include('header.php');
include 'Invoice.php';
$invoice = new Invoice();
$invoice->checkLoggedIn();
if(!empty($_POST['RCNO']) && $_POST['RCNO']){
	$invoice->saveClient($_POST);
	header("Location:view_clients.php");
}
?>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('container.php');?>
<div class="container">
	<h2 class="title mt-5">PHP Invoice System</h2>
	<?php include('menu.php');?>
	<form action="" id="newclient-form" method="post"  class="needs-validation" novalidate autocomplete="off">
		<div class="form-row">
			<div class="form-group col-md-6">
				<label for="inputEmail4">Company Name:</label>
				<select class="form-control" name="RCNO" id="RCNO" required>
					<option value="">Select Company</option>
					<option value="RCNOT">No Company</option>
					<?php
					$CompList = $invoice->getcomps();
					foreach($CompList as $list){ ?>
						<option value=<?php echo $list["RCNO"]; ?>><?php echo $list["cName"]; ?></option>
					<?php } ?>
				</select>
			</div>

		</div>
		<div class="form-row">
			<div class="form-group col-md-6">
				<label for="inputEmail4">Surname:</label>
				<input type="text" class="form-control" name = "SName" id = "SName" placeholder="Surname" required>
			</div>
			<div class="form-group col-md-6">
				<label for="inputPassword4">First Name:</label>
				<input type="text" class="form-control" name = "FName" id="FName" placeholder="First Name" required>
			</div>
		</div>
		<div class="form-row">
		<div class="form-group col-md-6">
			<label for="inputEmail4">Phone No</label>
			<input type="tel" class="form-control" name = "cPhone" id="cPhone" maxlength="11" placeholder="Phone No" required>
		</div>
		<div class="form-group col-md-6">
			<label for="inputEmail4">Email</label>
			<input type="email" class="form-control" name = "cEmail" id="cEmail" placeholder="Email Address" required>
		</div>
	</div>
		<div class="form-group">
			<label for="inputAddress">Address</label>
			<input type="text" class="form-control" name = "cAddress" id="cAddress" placeholder="1234 Main St" required>
		</div>
		<input type="hidden" value="<?php echo $_SESSION['userid']; ?>" class="form-control" name="userId">
		<button type="submit" class="btn btn-primary mb-2">Submit</button>

</div>

<?php include('footer.php');?>
