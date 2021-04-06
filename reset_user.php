<?php
session_start();
include('header.php');
include 'Invoice.php';
$invoice = new Invoice();
$invoice->checkLoggedIn();
if(!empty($_POST['email']) && $_POST['email']){
	$invoice->ResetUser($_POST);
	header("Location:view_users.php");
}
?>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('container.php');?>
<div class="container">
	<h2 class="title mt-5">PHP Invoice System</h2>
	<?php include('menu.php');?>
	<form action="" id="newclient-form" method="post" class="newclient-form" novalidate="" autocomplete="off">
		<div class="form-group">
			<label for="inputAddress">Email Address</label>
			<input type="email" class="form-control" name = "email" id="email" >
		</div>
		<button type="submit" class="btn btn-primary mb-2">Submit</button>
	</form>
</div>

<?php include('footer.php');?>
