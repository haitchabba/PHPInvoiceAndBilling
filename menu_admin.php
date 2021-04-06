<ul class="nav navbar-nav flex-row">
<li class="dropdown">
	<button class="btn btn-primary dropdown-toggle border-0" type="button" data-toggle="dropdown">Invoice
	<span class="caret"></span></button>
	<ul class="dropdown-menu">
		<li><a class="dropdown-item" href="invoice_list.php">Invoice List</a></li>
		<!-- <li><a class="dropdown-item" href="create_invoice.php">Create Invoice</a></li> -->
	</ul>
</li>
<li class="dropdown">
	<button class="btn btn-primary dropdown-toggle border-0" type="button" data-toggle="dropdown">Billing
	<span class="caret"></span></button>
	<ul class="dropdown-menu">
		<li><a class="dropdown-item" href="transhistory.php">Transaction History</a></li>
		<!--li><a class="dropdown-item" href="create_invoice.php">Create Invoice</a></li-->
	</ul>
</li>
<li class="dropdown">
	<button class="btn btn-primary dropdown-toggle border-0" type="button" data-toggle="dropdown">Clients
	<span class="caret"></span></button>
	<ul class="dropdown-menu">
		<li><a class="dropdown-item" href="new_client.php">Add Client</a></li>
		<li><a class="dropdown-item" href="view_clients.php">View Clients</a></li>
	</ul>
</li>
<li class="dropdown">
	<button class="btn btn-primary dropdown-toggle border-0" type="button" data-toggle="dropdown">Users
	<span class="caret"></span></button>
	<ul class="dropdown-menu">
		<li><a class="dropdown-item" href="comp.php">Add Company</a></li>
		<li><a class="dropdown-item" href="new_user.php">Add User</a></li>
		<li><a class="dropdown-item" href="view_users.php">View Users</a></li>
		<li><a class="dropdown-item" href="reset_user.php">Reset User</a></li>
	</ul>
</li>
<?php
if($_SESSION['userid']) { ?>
	<li class="dropdown">
		<button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">Logged in <?php echo $_SESSION['user']; ?>
		<span class="caret"></span></button>
		<ul class="dropdown-menu">
			<li><a class="dropdown-item" href="#">Account</a></li>
			<li><a class="dropdown-item" href="action.php?action=logout">Logout</a></li>
		</ul>
	</li>
<?php } ?>
</ul>
<br /><br /><br /><br />
