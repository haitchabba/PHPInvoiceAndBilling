<?php
session_start();
include('header.php');
include 'Invoice.php';
$invoice = new Invoice();
$invoice->checkLoggedIn();
?>
<title>PeopleWhoCode : Demo Build Invoice System with PHP & MySQL</title>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('container.php');?>
<div class="container">
	<h2 class="title mt-5">PHP Invoice System</h2>
	<?php include('menu.php');?>
	<center><input class="form-control" id="myInput" type="text" placeholder="Search.."></center>
	<table id="data-table" class="table table-condensed table-striped">
		<thead>
			<tr>
				<th>S No.</th>
				<th>Transaction Date</th>
				<th>Customer Name</th>
				<th>Amount Paid</th>
				<th>Payment Type</th>
				<th>Amount Due</th>
			</tr>
		</thead>
		<?php
		$TransactList = $invoice->getTransactionList();
		foreach($TransactList as $transactionDetails){
			$transactionDate = date("d/M/Y, H:i:s", strtotime($transactionDetails["trans_date"]));
			echo '
			<tr>
			<td>'.$transactionDetails["order_id"].'</td>
			<td>'.$transactionDate.'</td>
			<td>'.$transactionDetails["customer_name"].'</td>
			<td>'.$transactionDetails["order_amount_paid"].'</td>
			<td>'.$transactionDetails["pay_type"].'</td>
			<td>'.$transactionDetails["order_total_amount_due"].'</td>
			</tr>
			';
		}
		?>
	</table>
</div>
<?php include('footer.php');?>
