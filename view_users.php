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
				<th>User ID</th>
				<th>Full Name</th>
				<th>Mobile</th>
				<th>Status</th>
				<th>Activate</th>
				<th>Deactivate</th>
			</tr>
		</thead>
		<?php
		$act = "Activate";
		$deact = "Deactivate";
		$UserList = $invoice->getUsersList();
		foreach($UserList as $UserDetails){
			echo '
			<tr>
			<td>'.$UserDetails["id"].'</td>
			<td>'.$UserDetails["last_name"].' '.$UserDetails["first_name"].'</td>
			<td>'.$UserDetails["mobile"].'</td>
			<td>'.$UserDetails["sts"].'</td>
			<td><a href="action.php?action='.$act.'&email='.$UserDetails["email"].'"  title="Activate User"><i class="fas fa-eye"></i></a></td>
			<td><a href="action.php?action='.$deact.'&email='.$UserDetails["email"].'"  title="Deactivate User"><i class="fas fa-eye"></i></a></td>
			</tr>
			';
		}
		?>
	</table>
</div>
<?php include('footer.php');?>
