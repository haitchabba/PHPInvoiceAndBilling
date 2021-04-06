<?php
//session_start();
include('header.php');
include('sess.php');
include 'Invoice.php';
$invoice = new Invoice();
$invoice->checkLoggedIn();
if(empty($_SESSION['stfcat'])) {
	echo '<center>Please login first! </center>';?>
	<center>	<a href = "action.php?action=logout">Login</a></center> <?php
	exit;
}
if($_SESSION['stfcat'] >= 2) {
	echo '<center>Access Denied :)</center>';?>
	<center>	<a href = "action.php?action=logout">Login</a></center> <?php
	exit;
}
?>
<title>PeopleWhoCode : Demo Build Invoice System with PHP & MySQL</title>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('container.php');?>
<div class="container">
	<h2 class="title mt-5">PHP Invoice System</h2>
	<?php include('menu.php'); ?>
	<center><input class="form-control" id="myInput" type="text" placeholder="Search.."></center>
	<table id="data-table" class="table table-condensed table-striped">
		<thead>
			<tr>
				<th>Client ID</th>
				<th>Invoice No.</th>
				<th>Create Date</th>
				<th>Customer Name</th>
				<th>Invoice Total</th>
				<th>Print</th>
				<th>Delete</th>
				<th>Pay</th>
			</tr>
		</thead>
		<?php
		$del = "delete";
		$invoiceList = $invoice->getInvoiceList();
		foreach($invoiceList as $invoiceDetails){
			$invoiceDate = date("d/M/Y, H:i:s", strtotime($invoiceDetails["order_date"]));
			echo '
			<tr>
			<td>'.$invoiceDetails["rID"].'</td>
			<td>'.$invoiceDetails["order_id"].'</td>
			<td>'.$invoiceDate.'</td>
			<td>'.$invoiceDetails["order_receiver_name"].'</td>
			<td>'.$invoiceDetails["order_total_after_tax"].'</td>
			<td><a href="print_invoice2.php?invoice_id='.$invoiceDetails["order_id"].$invoiceDetails["rID"].'" title="Print Invoice"><i class="fas fa-print"></i></a></td>
			<td><a href="action.php?action='.$del.'&delete_id='.$invoiceDetails["order_id"].$invoiceDetails["rID"].'"  title="Delete Invoice"><i class="far fa-trash-alt"></i></a></td>
			<td><a href="pay_bill.php?pay_id='.$invoiceDetails["order_id"].$invoiceDetails["rID"].'"  title="Pay Invoice"><i class="fas fa-cash-register"></i></a></td>
			</tr>
			';
		}
		?>
	</table>
</div>
<?php include('footer.php');?>
