<?php
ublic function updateInvoice($POST) {
  if($POST['invoiceId']) {
    $sqlInsert = "UPDATE ".$this->invoiceOrderTable."
    SET order_receiver_name = '".$POST['companyName']."', order_receiver_address= '".$POST['address']."', order_total_before_tax = '".$POST['subTotal']."', order_total_tax = '".$POST['taxAmount']."', order_tax_per = '".$POST['taxRate']."', order_total_after_tax = '".$POST['totalAftertax']."', order_amount_paid = '".$POST['amountPaid']."', order_total_amount_due = '".$POST['amountDue']."', note = '".$POST['notes']."'
    WHERE user_id = '".$POST['userId']."' AND order_id = '".$POST['invoiceId']."'";
    mysqli_query($this->dbConnect, $sqlInsert);
  }
  $this->deleteInvoiceItems($POST['invoiceId']);
  for ($i = 0; $i < count($POST['productCode']); $i++) {
    $sqlInsertItem = "INSERT INTO ".$this->invoiceOrderItemTable."(order_id, item_code, item_name, order_item_quantity, order_item_price, order_item_final_amount)
    VALUES ('".$POST['invoiceId']."', '".$POST['productCode'][$i]."', '".$POST['productName'][$i]."', '".$POST['quantity'][$i]."', '".$POST['price'][$i]."', '".$POST['total'][$i]."')";
    mysqli_query($this->dbConnect, $sqlInsertItem);
  }
}
public function getInvoiceList(){
  $sqlQuery = "SELECT * FROM ".$this->invoiceOrderTable."
  WHERE user_id = '".$_SESSION['userid']."'";
  return  $this->getData($sqlQuery);
}
public function getInvoice($invoiceId){
  $sqlQuery = "SELECT * FROM ".$this->invoiceOrderTable."
  WHERE user_id = '".$_SESSION['userid']."' AND order_id = '$invoiceId'";
  $result = mysqli_query($this->dbConnect, $sqlQuery);
  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
  return $row;
}
public function getInvoiceItems($invoiceId){
  $sqlQuery = "SELECT * FROM ".$this->invoiceOrderItemTable."
  WHERE order_id = '$invoiceId'";
  return  $this->getData($sqlQuery);
}
public function deleteInvoiceItems($invoiceId){
  $sqlQuery = "DELETE FROM ".$this->invoiceOrderItemTable."
  WHERE order_id = '".$invoiceId."'";
  mysqli_query($this->dbConnect, $sqlQuery);
}
public function deleteInvoice($invoiceId){
  $sqlQuery = "DELETE FROM ".$this->invoiceOrderTable."
  WHERE order_id = '".$invoiceId."'";
  mysqli_query($this->dbConnect, $sqlQuery);
  $this->deleteInvoiceItems($invoiceId);
  return 1;
}
}
?>
