<?php
//session_start();
include('header.php');
include('sess.php');
include 'Invoice.php';
$invoice = new Invoice();
$invoice->checkLoggedIn();
if(!empty($_GET['client_id']) && $_GET['client_id']) {
	$Client = $invoice->getClient($_GET['client_id']);
	$invoiceList = $invoice->getInvoiceListByClient($_GET['client_id']);
	$TransactList = $invoice->getTranListByClient($_GET['client_id']);
}
?>
<title>PeopleWhoCode : Demo Build Invoice System with PHP & MySQL</title>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('container.php');?>
<div class="container content-invoice">
	<div class="cards">
		<div class="card-bodys">
			<div class="load-animate animated fadeInUp">
				<div class="row">
					<div class="col-xs-12">
						<h1 class="title">PHP Invoice System</h1>
						<?php include('menu.php');?>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<div class="card" style="width: 18rem;">
							<div class="card-body">
								<?php $companyDetails = $invoice->getCompDetails($Client['rcNO']); ?>
								<h4>
									<?php echo $companyDetails['cName']; ?><br>
									<?php echo $Client['sName']." ".$Client['fName']; ?><br>
									<?php echo $Client['cAddress']; ?><br>
									<?php echo $Client['cPhone']; ?><br>
									<?php echo $Client['cEmail']; ?><br>
								</h4>
							</div>
						</div>
					</div>
					<div class=".col-xs-6 .col-sm-3">
						<a href="new_invoice.php?client_id=<?php echo $Client['rID']; ?>"  title="Create Invoice"><i class="far fa-plus-square fa-7x" size = "7x"></i></a>
					</div>
				</div>
				<br>
				<div>
					<nav>
						<div class="nav nav-tabs" id="nav-tab" role="tablist">
							<a class="flex-sm-fill text-sm-center nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Invoice</a>
							<a class="flex-sm-fill text-sm-center nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Bills</a>
						</div>
					</nav>
				</div>
				<div class="tab-content" id="nav-tabContent">
					<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
						<center><input class="form-control" id="myInput" type="text" placeholder="Search.."></center>
						<table id="data-table" class="table table-condensed table-striped">
							<thead>
								<tr>
									<th>Invoice No.</th>
									<th>Create Date</th>
									<th>Invoice Total</th>
									<th>Amount Paid</th>
									<th>Amount Due</th>
									<th>Print</th>
									<th>Pay</th>
								</tr>
							</thead>
							<?php

							foreach($invoiceList as $invoiceDetails){
								$invoiceDate = date("d/M/Y, H:i:s", strtotime($invoiceDetails["order_date"]));
								echo '
								<tr>
								<td>'.$invoiceDetails["order_id"].'</td>
								<td>'.$invoiceDate.'</td>
								<td>'.$invoiceDetails["order_total_after_tax"].'</td>
								<td>'.$invoiceDetails["order_amount_paid"].'</td>
								<td>'.$invoiceDetails["order_total_amount_due"].'</td>
								<td><a href="print_invoice2.php?invoice_id='.$invoiceDetails["order_id"].$invoiceDetails["rID"].'" title="Print Invoice"><i class="fas fa-print"></i></a></td>
								<td><a href="pay_bill.php?pay_id='.$invoiceDetails["order_id"].$invoiceDetails["rID"].'"  title="Pay Invoice"><i class="fas fa-cash-register"></i></a></td>
								</tr>
								';
							}
							?>
						</table>
					</div>
					<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
						<center><input class="form-control" id="myInput2" type="text" placeholder="Search.."></center>
						<table id="data-table" class="table table-condensed table-striped">
							<thead>
								<tr>
									<th>Invoice ID</th>
									<th>Order ID</th>
									<th>Transaction Date</th>
									<th>Customer Name</th>
									<th>Amount Paid</th>
									<th>Payment Type</th>
									<th>Amount Due</th>
									<th>Notes</th>
								</tr>
							</thead>
							<?php

							foreach($TransactList as $transactionDetails){
								$transactionDate = date("d/M/Y, H:i:s", strtotime($transactionDetails["trans_date"]));
								echo '
								<tr>
								<td>'.$transactionDetails["invoice_id"].'</td>
								<td>'.$transactionDetails["order_id"].'</td>
								<td>'.$transactionDate.'</td>
								<td>'.$transactionDetails["customer_name"].'</td>
								<td>'.$transactionDetails["order_amount_paid"].'</td>
								<td>'.$transactionDetails["pay_type"].'</td>
								<td>'.$transactionDetails["order_total_amount_due"].'</td>
								<td>'.$transactionDetails["notes"].'</td>
								</tr>
								';
							}
							?>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<?php include('footer.php');?>
