<?php
session_start();
include('header.php');
include 'Invoice.php';
$invoice = new Invoice();
$invoice->checkLoggedIn();
if(!empty($_GET['user']) && $_GET['user']) {
	$invoiceValues = $invoice->getInvoice($_GET['update_id']);
	$invoiceItems = $invoice->getInvoiceItems($_GET['update_id']);
	header("Location:client_prof.php?client_id=".$_POST['rID']."");
}
?>
<title>PeopleWhoCode : Demo Build Invoice System with PHP & MySQL</title>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('container.php');?>

<?php include('footer.php');?>
