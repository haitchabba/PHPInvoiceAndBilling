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
				<th>Client ID</th>
				<th>Company Name</th>
				<th>Surname</th>
				<th>First Name</th>
				<th>Phone No.</th>
				<th>Email</th>
				<th>View</th>
			</tr>
		</thead>
		<?php
		
		$ClientList = $invoice->getClientList();
		foreach($ClientList as $ClientDetails){
			$rcNO = $ClientDetails["rcNO"];
			$CompList = $invoice->getcompsPerClient($rcNO);
			foreach($CompList as $CompListPerClient){
				$comp = $CompListPerClient["cName"];
				if(empty($comp)){
					$comp = "NULL";
				}
			}
			echo '
			<tr>
			<td>'.$ClientDetails["rID"].'</td>
			<td>'.$comp.'</td>
			<td>'.$ClientDetails["sName"].'</td>
			<td>'.$ClientDetails["fName"].'</td>
			<td>'.$ClientDetails["cPhone"].'</td>
			<td>'.$ClientDetails["cEmail"].'</td>
			<td><a href="client_prof.php?client_id='.$ClientDetails["rID"].'"  title="View Client"><i class="fas fa-eye"></i></a></td>
			</tr>
			';
		}
		?>
	</table>
</div>
<?php include('footer.php');?>
