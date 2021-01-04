<?php
   session_start();
   include('header.php');
   include 'Invoice.php';
   $invoice = new Invoice();
   $invoice->checkLoggedIn();
   if(!empty($_POST['companyName']) && $_POST['companyName']) {
   	$invoice->saveInvoice($_POST);
    $invoice->saveTrans($_POST);
   	header("Location:invoice_list.php");
   }
   ?>
<title>Invoice System</title>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('container.php');?>
<div class="container content-invoice">
   <div class="cards">
     <div class="card-bodys">
       <form action="" id="invoice-form" method="post" class="invoice-form" role="form" novalidate="">
      <div class="load-animate animated fadeInUp">
         <div class="row">
            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
               <h2 class="title">PHP Invoice System</h2>
               <?php include('menu.php');?>
            </div>
         </div>
         <input id="currency" type="hidden" value="$">
         <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
               <h3>From,</h3>
               <?php echo $_SESSION['user']; ?><br>
               <?php echo $_SESSION['address']; ?><br>
               <?php echo $_SESSION['mobile']; ?><br>
               <?php echo $_SESSION['email']; ?><br>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
               <h3>To,</h3>
               <div class="form-group">
                  <input type="text" class="form-control" name="companyName" id="companyName" placeholder="Company Name" autocomplete="off">
               </div>
               <div class="form-group">
                  <textarea class="form-control" rows="3" name="address" id="address" placeholder="Your Address"></textarea>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
               <table class="table table-condensed table-striped" id="invoiceItem">
                  <tr>
                     <th width="2%">
                      <div class="custom-control custom-checkbox mb-3">
                        <input type="checkbox" class="custom-control-input" id="checkAll" name="checkAll">
                        <label class="custom-control-label" for="checkAll"></label>
                        </div>
                    </th>
                     <th width="15%">Room No</th>
                     <th width="38%">Room Type</th>
                     <th width="15%">Night</th>
                     <th width="15%">Rate</th>
                     <th width="15%">Total</th>
                  </tr>
                  <tr>
                     <td><div class="custom-control custom-checkbox">
                        <input type="checkbox" class="itemRow custom-control-input" id="itemRow_1">
                        <label class="custom-control-label" for="itemRow_1"></label>
                        </div></td>
                     <td>
                       <!--select class="form-control" name="productCode[]" id="productCode_1" onKEYUp = "capRoom()" placeholder="Room No."  required autocomplete="off">
                 				<option value="">Room No.</option>
                 				<option value="000">000</option>
                 				<option value="101">101</option>
                 				<option value="102">102</option>
                        <option value="103">103</option>
                 				<option value="104">104</option>
                 				<option value="105">105</option>
                        <option value="106">106</option>
                 				<option value="107">107</option>
                        <option value="108">108</option>
                 				<option value="109">109</option>
                 				<option value="110">110</option>
                        <option value="111">111</option>
                 			</select-->
                       <input type="text" name="productCode[]" id="productCode_1" onKEYUp = "capRoom()"class="form-control" autocomplete="off">
                     </td>
                     <td><input type="text" name="productName[]" id="productName_1" class="form-control" autocomplete="off" readonly></td>
                     <td><input type="number" name="quantity[]" id="quantity_1" class="form-control quantity" autocomplete="off"></td>
                     <td><input type="number" name="price[]" id="price_1" class="form-control price" autocomplete="off" readonly></td>
                     <td><input type="number" name="total[]" id="total_1" class="form-control total" autocomplete="off"></td>
                  </tr>
               </table>
            </div>
         </div>
         <div class="row">
            <div class="col-xs-12">
               <button class="btn btn-danger delete" id="removeRows" type="button">- Delete</button>
               <button class="btn btn-success" id="addRows" type="button">+ Add More</button>
            </div>
         </div>
         <div class="row">
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group mt-3 mb-3 ">
              <label>Subtotal: &nbsp;</label>
                 <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text currency">$</span>
            </div>
            <input value="" type="number" class="form-control" name="subTotal" id="subTotal" placeholder="Subtotal">
          </div>
              </div>
          </div>
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group mt-3 mb-3 ">
              <label>Tax Rate: &nbsp;</label>
                 <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text currency">%</span>
            </div>
           <input value="" type="number" class="form-control" name="taxRate" id="taxRate" placeholder="Tax Rate" readonly>
          </div>
              </div>
          </div>
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group mt-3 mb-3 ">
              <label>Tax Amount: &nbsp;</label>
                 <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text currency">$</span>
            </div>
            <input value="" type="number" class="form-control" name="taxAmount" id="taxAmount" placeholder="Tax Amount">
          </div>
              </div>
          </div>
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group mt-3 mb-3 ">
              <label>Total: &nbsp;</label>
                 <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text currency">$</span>
            </div>
             <input value="" type="number" class="form-control" name="totalAftertax" id="totalAftertax" placeholder="Total">
          </div>
              </div>
          </div>
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group mt-3 mb-3 ">
              <label>Amount Paid: &nbsp;</label>
                 <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text currency">$</span>
            </div>
            <input value="" type="number" class="form-control" name="amountPaid" id="amountPaid" placeholder="Amount Paid">
          </div>
              </div>
          </div>
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group mt-3 mb-3 ">
              <label>Amount Due: &nbsp;</label>
                 <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text currency">$</span>
            </div>
             <input value="" type="number" class="form-control" name="amountDue" id="amountDue" placeholder="Amount Due">
          </div>
              </div>
          </div>


          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group mt-3 mb-3 ">
              <label>Payment Type: &nbsp;</label>
              <div class="input-group mb-1">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="POS">
                  <label class="form-check-label" for="inlineRadio1">POS</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="Zenith">
                  <label class="form-check-label" for="inlineRadio2">Zenith Bank</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="FirstBank">
                  <label class="form-check-label" for="inlineRadio1">First Bank</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio4" value="Cash">
                  <label class="form-check-label" for="inlineRadio2">Cash</label>
                </div>
              </div>
            </div>
          </div>



            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
               <h3>Notes: </h3>
               <div class="form-group">
                  <textarea class="form-control txt" rows="5" name="notes" id="notes" placeholder="Your Notes"></textarea>
               </div>
               <br>
               <div class="form-group">
                  <input type="hidden" value="<?php echo $_SESSION['userid']; ?>" class="form-control" name="userId">
                  <input data-loading-text="Saving Invoice..." type="submit" name="invoice_btn" value="Save Invoice" class="btn btn-success submit_btn invoice-save-btm">
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