<?php
session_start();
include 'Invoice.php';
$invoice = new Invoice();
if($_GET['action'] == 'delete_invoice' && $_GET['id']) {
	$invoice->deleteInvoice($_GET['id']);
	$jsonResponse = array(
		"status" => 1
	);
	echo json_encode($jsonResponse);
}
if($_GET['action'] == 'Activate' && $_GET['email']) {
	$invoice->Activate($_GET['email']);
	header("Location:view_users.php");
}
if($_GET['action'] == 'Deactivate' && $_GET['email']) {
	$invoice->Deactivate($_GET['email']);
	header("Location:view_users.php");
}
if($_GET['action'] == 'delete' && $_GET['delete_id']) {
	$invoice->deleteInvoicePerm($_GET['delete_id']);
	$invoice->deleteInvoiceHistory($_GET['delete_id']);
	header("Location:invoice_list.php");
}
if($_GET['action'] == 'logout') {
session_unset();
session_destroy();
header("Location:index.php");
}
