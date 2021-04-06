<?php
session_start();
include('header.php');
include 'Invoice.php';
$invoice = new Invoice();
$invoice->checkLoggedIn();
if(!empty($_POST['fullname']) && $_POST['fullname'] && !empty($_POST['invoiceId']) && $_POST['invoiceId']) {
	$invoice->updateInvoiceOnly($_POST);
	//$invoice->saveTrans($_POST);
	header("Location:client_prof.php?client_id=".$_POST['rID']."");
}
if(!empty($_GET['pay_id']) && $_GET['pay_id']) {
	$invoiceValues = $invoice->getInvoice($_GET['pay_id']);
	$invoiceItems = $invoice->getInvoiceItems($_GET['pay_id']);
}
?>
<title>PeopleWhoCode : Demo Build Invoice System with PHP & MySQL</title>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('container.php');?>
<div class="container content-invoice">
	<div class="cards">
		<div class="card-bodys">
			<form action="" id="invoice-form" method="post" class="needs-validation" novalidate autocomplete="off">
				<div class="load-animate animated fadeInUp">
					<div class="row">
						<div class="col-xs-12">
							<h1 class="title">PHP Invoice System</h1>
							<?php include('menu.php');?>
						</div>
					</div>
					<input id="currency" type="hidden" value="$">
					<div class="row">
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

						</div>
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
							<h3>To,</h3>
							<div class="form-group">
								<input value="<?php echo $invoiceValues['order_receiver_company']; ?>" type="text" class="form-control" name="companyName" id="companyName" placeholder="Company Name" autocomplete="off" readonly>
							</div>
							<div class="form-group">
								<input value="<?php echo $invoiceValues['order_receiver_name']; ?>" type="text" class="form-control" name="fullname" id="fullname" placeholder="Company Name" autocomplete="off" readonly>

							</div>

						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<table class="table table-condensed table-striped" id="invoiceItem">
								<tr>
									<th width="2%">
										<div class="custom-control custom-checkbox mb-3">
											<input type="checkbox" class="custom-control-input" id="checkAll" name="checkAll" readonly>
											<label class="custom-control-label" for="checkAll"></label>
										</div>
									</th>
									<th width="15%">Item No</th>
									<th width="38%">Item Name</th>
									<th width="15%">Quantity</th>
									<th width="15%">Price</th>
									<th width="15%">Total</th>
								</tr>
								<?php
								$count = 0;
								foreach($invoiceItems as $invoiceItem){
									$count++;
									?>
									<tr>
										<td><div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input itemRow"  readonly>
											<label class="custom-control-label" for="itemRow"></label>
										</div></td>
										<td><input type="text" value="<?php echo $invoiceItem["item_code"]; ?>" name="productCode[]" id="productCode_<?php echo $count; ?>" class="form-control" autocomplete="off" readonly></td>
										<td><input type="text" value="<?php echo $invoiceItem["item_name"]; ?>" name="productName[]" id="productName_<?php echo $count; ?>" class="form-control" autocomplete="off" readonly></td>
										<td><input type="number" value="<?php echo $invoiceItem["order_item_quantity"]; ?>" name="quantity[]" id="quantity_<?php echo $count; ?>" class="form-control quantity" autocomplete="off" readonly></td>
										<td><input type="number" value="<?php echo $invoiceItem["order_item_price"]; ?>" name="price[]" id="price_<?php echo $count; ?>" class="form-control price" autocomplete="off" readonly></td>
										<td><input type="number" value="<?php echo $invoiceItem["order_item_final_amount"]; ?>" name="total[]" id="total_<?php echo $count; ?>" class="form-control total" autocomplete="off" readonly></td>
										<input type="hidden" value="<?php echo $invoiceItem['order_item_id']; ?>" class="form-control" name="itemId[]" readonly>
									</tr>
								<?php } ?>
							</table>
						</div>
					</div>
					<!-- <div class="row mt-3 mb-3">
						<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
							<button class="btn btn-danger delete" id="removeRows" type="button">- Delete</button>
							<button class="btn btn-primary border-0" id="addRows" type="button">+ Add More</button>
						</div>
					</div> -->
					<div class="row">
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<div class="form-group mt-3 mb-3">
								<label>Subtotal: &nbsp;</label>
								<div class="input-group">
									<div class="input-group-prepend currency">
										<span class="input-group-text currency">$</span>
									</div>
									<input value="<?php echo $invoiceValues['order_total_before_tax']; ?>" type="number" class="form-control" name="subTotal" id="subTotal" placeholder="Subtotal" readonly>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<div class="form-group">
								<label>Tax Rate: &nbsp;</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">%</span>
									</div>
									<input value="<?php echo $invoiceValues['order_tax_per']; ?>" type="number" class="form-control" name="taxRate" id="taxRate" placeholder="Tax Rate" readonly>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<div class="form-group">
								<label>Tax Amount: &nbsp;</label>
								<div class="input-group">
									<div class="input-group-append currency"><span class="input-group-text">$</span></div>
									<input value="<?php echo $invoiceValues['order_total_tax']; ?>" type="number" class="form-control" name="taxAmount" id="taxAmount" placeholder="Tax Amount" readonly>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<div class="form-group">
								<label>Total: &nbsp;</label>
								<div class="input-group">
									<div class="input-group-append currency"><span class="input-group-text">$</span></div>
									<input value="<?php echo $invoiceValues['order_total_after_tax']; ?>" type="number" class="form-control" name="totalAftertax" id="totalAftertax" placeholder="Total" readonly>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<div class="form-group">
								<label>Amount Paid: &nbsp;</label>
								<div class="input-group">
									<div class="input-group-append currency"><span class="input-group-text">$</span></div>
									<input value="" type="number" class="form-control" name="amountPaid" id="amountPaid" placeholder="Amount Paid">
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<div class="form-group">
								<label>Previous Amount Due: &nbsp;</label>
								<div class="input-group">
									<div class="input-group-append currency"><span class="input-group-text">$</span></div>
									<input value="<?php echo $invoiceValues['order_total_amount_due']; ?>" type="number" class="form-control" name="amountDue" id="amountDue" placeholder="Amount Due" readonly>
								</div>
							</div>
						</div>

						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">

						</div>

						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">

						</div>

						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<div class="form-group">
								<label>Current Amount Due: &nbsp;</label>
								<div class="input-group">
									<div class="input-group-append currency"><span class="input-group-text">$</span></div>
									<input value="" type="number" class="form-control" name="camountDue" id="camountDue" placeholder="Current Amount Due" readonly>
								</div>
							</div>
						</div>

						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
	            <div class="form-group mt-3 mb-3 ">
	              <label>Payment Type: &nbsp;</label>
	              <div class="input-group mb-1">
	                <div class="form-check form-check-inline">
	                  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="POS" <?php if ($invoiceValues['pay_type'] == 'POS') echo 'checked="checked"'; ?> >
	                  <label class="form-check-label" for="inlineRadio1">POS</label>
	                </div>
	                <div class="form-check form-check-inline">
	                  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="Zenith" <?php if ($invoiceValues['pay_type'] == 'Zenith') echo 'checked="checked"'; ?> >
	                  <label class="form-check-label" for="inlineRadio2">Zenith Bank</label>
	                </div>
	                <div class="form-check form-check-inline">
	                  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="FirstBank" <?php if ($invoiceValues['pay_type'] == 'FirstBank') echo 'checked="checked"'; ?> >
	                  <label class="form-check-label" for="inlineRadio1">First Bank</label>
	                </div>
	                <div class="form-check form-check-inline">
	                  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio4" value="Cash" <?php if ($invoiceValues['pay_type'] == 'Cash') echo 'checked="checked"'; ?> >
	                  <label class="form-check-label" for="inlineRadio2">Cash</label>
	                </div>
	              </div>
	            </div>
	          </div>

						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<h3>Notes: </h3>
							<div class="form-group">
								<textarea class="form-control txt" rows="5" name="notes" id="notes" placeholder="Your Notes" ></textarea>
							</div>
							<br>
							<div class="form-group">
								<input type="hidden" value="<?php echo $_SESSION['userid']; ?>" class="form-control" name="userId">
								<input type="hidden" value="<?php echo $invoiceValues["rID"]; ?>" class="form-control" name="rID">
								<input type="hidden" value="<?php echo $invoiceValues['order_id']; ?>" class="form-control" name="invoiceId" id="invoiceId">
								<input type="hidden" value="" class="form-control" name="amountPaidFinal" id="amountPaidFinal">
								<input data-loading-text="Updating Invoice..." type="submit" name="invoice_btn" value="Save Invoice" class="btn btn-success submit_btn invoice-save-btm">
							</div>

						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</form>
		</div>
	</div>
</div>
</div>
<?php include('footer.php');?>
