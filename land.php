<?php
session_start();
include('header.php');
include 'Invoice.php';
$invoice = new Invoice();
$invoice->checkLoggedIn();
?>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('container.php');?>
	<div class="container">
	  <h2 class="title mt-5">PHP Invoice System</h2>
	  <?php include('menu.php');?>
		<div class="card-deck">
  <div class="card text-white bg-success mb-3">
		<div class="card-header">Header</div>
    <img src="..." class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title">Card title</h5>
      <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
    </div>
    <div class="card-footer">
      <a href="#" class="btn btn-dark">Go somewhere</a>
    </div>
  </div>
  <div class="card text-white bg-info mb-3">
		<div class="card-header">Header</div>
    <img src="..." class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title">Card title</h5>
      <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
    </div>
    <div class="card-footer">
      <a href="#" class="btn btn-dark">Go somewhere</a>
    </div>
  </div>

</div>
</div>
<?php include('footer.php');?>
