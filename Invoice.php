<?php
class Invoice{
	private $host  = 'localhost';
	private $user  = 'root';
	private $password   = "";
	private $database  = "ssn_demo";
	private $invoiceUserTable = 'invoice_user';
	private $invoiceOrderTable = 'invoice_order';
	private $invoiceOrderItemTable = 'invoice_order_item';
	private $transHistory = 'trans_history';
	private $NewClients = 'clients';
	private $comps = 'company';
	private $dbConnect = false;
	public function __construct(){
		if(!$this->dbConnect){
			$conn = new mysqli($this->host, $this->user, $this->password, $this->database);
			if($conn->connect_error){
				die("Error failed to connect to MySQL: " . $conn->connect_error);
			}else{
				$this->dbConnect = $conn;
			}
		}
	}
	private function getData($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$data= array();
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$data[]=$row;
		}
		return $data;
	}
	private function getNumRows($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$numRows = mysqli_num_rows($result);
		return $numRows;
	}
	public function loginUsers($email, $password){
		$sqlQuery = "
		SELECT id, email, first_name, last_name, address, mobile, sts, stfcat
		FROM ".$this->invoiceUserTable."
		WHERE email='".$email."' AND password='".$password."'";
		return  $this->getData($sqlQuery);
	}
	public function VerifyPass($pass1, $pass2){
		if($pass1 != $pass2){
			return 1;
		}else{
			return 2;
		}
	}
	public function VerifyUserID($email){
		$sqlQuery = "SELECT * FROM ".$this->invoiceUserTable."
		WHERE email='".$email."'";
		return  $this->getData($sqlQuery);
	}
	public function checkLoggedIn(){
		if(!$_SESSION['userid']) {
			header("Location:index.php");
		}
	}
	public function saveInvoice($POST) {
		$rid = $POST['rID'];
		$oid = $POST['order_id'];
		$sqlQuery = "SELECT COUNT(*) AS Total FROM ".$this->invoiceOrderTable."
		WHERE rID = '$rid'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$row = mysqli_fetch_assoc($result);
		$total = $row['Total'];
		if(empty($total)){
			$total = 0;
		}
		$tot = ++$total;
		$sqlInsert = "INSERT INTO ".$this->invoiceOrderTable."(rID, order_id, user_id, order_receiver_company, order_receiver_name, order_receiver_address, order_total_before_tax, order_total_tax, order_tax_per, order_total_after_tax, order_amount_paid, pay_type, order_total_amount_due, note) VALUES ('".$POST['rID']."', $tot, '".$POST['userId']."', '".$POST['companyName']."', '".$POST['fullname']."', '".$POST['cAddress']."', '".$POST['subTotal']."',
		'".$POST['taxAmount']."', '".$POST['taxRate']."', '".$POST['totalAftertax']."', '".$POST['amountPaid']."', '".$POST['inlineRadioOptions']."', '".$POST['camountDue']."', '".$POST['notes']."')";
		mysqli_query($this->dbConnect, $sqlInsert);
		$sqlInsertHist = "INSERT INTO ".$this->transHistory." (rID, invoice_id, order_id, user_id, customer_name, order_amount_paid, pay_type, order_total_amount_due, notes) VALUES ('".$POST['rID']."', $tot, $tot, '".$POST['userId']."', '".$POST['fullname']."', '".$POST['amountPaid']."', '".$POST['inlineRadioOptions']."', '".$POST['camountDue']."',
		 '".$POST['notes']."')";
		mysqli_query($this->dbConnect, $sqlInsertHist);
		$lastInsertId = mysqli_insert_id($this->dbConnect);
		$sqlQuery2 = "SELECT COUNT(*) AS Total FROM ".$this->invoiceOrderItemTable."
		WHERE rID = '$rid' AND order_id = '$tot'";
		$result2 = mysqli_query($this->dbConnect, $sqlQuery2);
		$row2 = mysqli_fetch_assoc($result2);
		$total2 = $row2['Total'];
		for ($i = 0; $i < count($POST['productCode']); $i++) {
			$tot2 = ++$total2;
			$sqlInsertItem = "INSERT INTO ".$this->invoiceOrderItemTable."(rID, order_item_id, order_id, item_code, item_name, order_item_quantity, order_item_price, order_item_final_amount)
			VALUES ('".$POST['rID']."', $tot2, $tot, '".$POST['productCode'][$i]."', '".$POST['productName'][$i]."', '".$POST['quantity'][$i]."', '".$POST['price'][$i]."', '".$POST['total'][$i]."')";
			mysqli_query($this->dbConnect, $sqlInsertItem);
		}
	}
	public function saveTrans($POST) {
		$rid = $POST['rID'];
		$oid = $POST['order_id'];
		$sqlQuery = "SELECT COUNT(*) AS Total FROM ".$this->transHistory."
		WHERE rID = '$rid'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$row = mysqli_fetch_assoc($result);
		$total = $row['Total'];
		$tot = ++$total;
		$sqlInsertHist = "INSERT INTO ".$this->transHistory." (rID, invoice_id) VALUES ('".$POST['rID']."', $oid)";
		mysqli_query($this->dbConnect, $sqlInsertHist);
	}
	public function updateInvoice($POST) {
		if($POST['invoiceId']) {
			$rid = $POST['rID'];
			$oid = $POST['invoiceId'];
			$sqlInsert = "UPDATE ".$this->invoiceOrderTable."
			SET order_receiver_company = '".$POST['companyName']."', order_receiver_name = '".$POST['fullname']."', order_receiver_address= '".$POST['address']."',
			order_total_before_tax = '".$POST['subTotal']."', order_total_tax = '".$POST['taxAmount']."', order_tax_per = '".$POST['taxRate']."', order_total_after_tax = '".$POST['totalAftertax']."', order_amount_paid = '".$POST['amountPaid']."', pay_type  = '".$POST['inlineRadioOptions']."',
			order_total_amount_due = '".$POST['amountDue']."', note = '".$POST['notes']."'
			WHERE rID = '$rid' AND order_id = '$oid'";
			mysqli_query($this->dbConnect, $sqlInsert);
			//Update Transaction i.e. Billing
			$sqlInsertTrans = "UPDATE ".$this->transHistory."
			SET customer_name = '".$POST['fullname']."', order_amount_paid = '".$POST['amountPaid']."', pay_type = '".$POST['inlineRadioOptions']."', order_total_amount_due = '".$POST['amountDue']."'
			WHERE rID = '$rid' AND order_id = '$oid'";
			mysqli_query($this->dbConnect, $sqlInsertTrans);
		}
		//$this->UpdateTransHistory($oid.$rid);
		$this->deleteInvoiceItems($POST['invoiceId']);
		$sqlQuery2 = "SELECT COUNT(*) AS Total FROM ".$this->invoiceOrderItemTable."
		WHERE rID = '$rid' AND order_id = '$oid'";
		$result2 = mysqli_query($this->dbConnect, $sqlQuery2);
		$row2 = mysqli_fetch_assoc($result2);
		$total2 = $row2['Total'];
		if(count($POST['productCode']) > $POST['invoiceId']){
			for ($i = $POST['invoiceId']; $i < count($POST['productCode']); ++$i) {
				$tot2 = ++$total2;
				$sqlInsertItem = "INSERT INTO ".$this->invoiceOrderItemTable."(rID, order_item_id, order_id, item_code, item_name, order_item_quantity, order_item_price, order_item_final_amount)
				VALUES ($rid, $tot2, '".$POST['invoiceId']."', '".$POST['productCode'][$i]."', '".$POST['productName'][$i]."', '".$POST['quantity'][$i]."', '".$POST['price'][$i]."', '".$POST['total'][$i]."')";
				mysqli_query($this->dbConnect, $sqlInsertItem);
			}
		}
	}
	public function updateInvoiceOnly($POST) {
		if($POST['invoiceId']) {
			$rid = $POST['rID'];
			$oid = $POST['invoiceId'];
			$sqlInsert = "UPDATE ".$this->invoiceOrderTable."
			SET order_receiver_company = '".$POST['companyName']."', order_receiver_name = '".$POST['fullname']."', order_total_before_tax = '".$POST['subTotal']."', order_total_tax = '".$POST['taxAmount']."', order_tax_per = '".$POST['taxRate']."',
			order_total_after_tax = '".$POST['totalAftertax']."', order_amount_paid = '".$POST['amountPaid']."', pay_type  = '".$POST['inlineRadioOptions']."',
			order_total_amount_due = '".$POST['camountDue']."', note = '".$POST['notes']."'
			WHERE rID = '$rid' AND order_id = '$oid'";
			mysqli_query($this->dbConnect, $sqlInsert);
			$sqlQuery = "SELECT COUNT(*) AS Total FROM ".$this->transHistory."
			WHERE rID = '$rid'";
			$result = mysqli_query($this->dbConnect, $sqlQuery);
			$row = mysqli_fetch_assoc($result);
			$total = $row['Total'];
			$tot = ++$total;
			$sqlInsertHist = "INSERT INTO ".$this->transHistory." (rID, invoice_id, order_id, user_id, customer_name, order_amount_paid, pay_type, order_total_amount_due, notes) VALUES ('".$POST['rID']."', $oid, $tot, '".$POST['userId']."', '".$POST['fullname']."', '".$POST['amountPaid']."', '".$POST['inlineRadioOptions']."', '".$POST['camountDue']."',
			'".$POST['notes']."')";
			mysqli_query($this->dbConnect, $sqlInsertHist);
		}

	}

	public function saveClient($POST) {
		$sqlQuery = "SELECT COUNT(*) AS Total FROM ".$this->NewClients."";
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$row = mysqli_fetch_assoc($result);
		$total = $row['Total'];
		$tot = ++$total;
		$regID = rand(999, 9999).$tot;
		$sqlInsertClient = "INSERT INTO ".$this->NewClients." (id, rID, rcNO, sName, fName, cEmail, cPhone, cAddress, UserID)
		VALUES ($tot, $regID, '".$POST['RCNO']."', '".$POST['SName']."', '".$POST['FName']."', '".$POST['cEmail']."', '".$POST['cPhone']."',
			 '".$POST['cAddress']."', '".$POST['userId']."')";
		mysqli_query($this->dbConnect, $sqlInsertClient);
	}
	public function saveUser($POST) {
		$sqlQuery = "SELECT COUNT(*) AS Total FROM ".$this->invoiceUserTable."";
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$row = mysqli_fetch_assoc($result);
		$total = $row['Total'];
		$tot = ++$total;
		$sqlInsertUser = "INSERT INTO ".$this->invoiceUserTable." (id, email, first_name, last_name, mobile, address, sts, stfcat)
		VALUES ($tot, '".$POST['cEmail']."', '".$POST['FName']."', '".$POST['SName']."',  '".$POST['cPhone']."', '".$POST['cAddress']."', '".$POST['act']."', '".$POST['stfcat']."')";
		mysqli_query($this->dbConnect, $sqlInsertUser);
	}

	public function ResetUser($POST) {
		$sqlResetUser = "UPDATE ".$this->invoiceUserTable."
		SET password = '' WHERE email = '".$POST['email']."'";
		mysqli_query($this->dbConnect, $sqlResetUser);
	}

	public function saveCompany($POST) {
		$sqlQuery = "SELECT COUNT(*) AS Total FROM ".$this->comps."";
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$row = mysqli_fetch_assoc($result);
		$total = $row['Total'];
		$tot = ++$total;
		$regID = $tot;
		$sqlInsert = "INSERT INTO ".$this->comps." (Sno, cName, RCNO, cEmail, cPhone, cAddress, user_id)
		VALUES ($tot, '".$POST['cName']."', '".$POST['rcNO']."', '".$POST['cEmail']."', '".$POST['cPhone']."', '".$POST['cAddress']."', '".$POST['userId']."')";
		mysqli_query($this->dbConnect, $sqlInsert);
	}

	public function updateInvoice2($POST) {
		if($POST['invoiceId']) {
			$sqlInsert = "UPDATE ".$this->invoiceOrderTable."
			SET order_receiver_name = '".$POST['companyName']."', order_receiver_address= '".$POST['address']."', order_total_before_tax = '".$POST['subTotal']."',
			order_total_tax = '".$POST['taxAmount']."', order_tax_per = '".$POST['taxRate']."', order_total_after_tax = '".$POST['totalAftertax']."', order_amount_paid = '".$POST['amountPaid']."', order_total_amount_due = '".$POST['amountDue']."', note = '".$POST['notes']."'
			WHERE user_id = '".$POST['userId']."' AND order_id = '".$POST['invoiceId']."'";
			mysqli_query($this->dbConnect, $sqlInsert);
		}
	}

	public function setPassword($POST) {
			$sqlInsert = "UPDATE ".$this->invoiceUserTable."
			SET password = '".$POST['pwd']."', sts = 'Activated' WHERE email = '".$POST['email']."'";
			mysqli_query($this->dbConnect, $sqlInsert);
	}

	public function Activate($email) {
			$sqlInsert = "UPDATE ".$this->invoiceUserTable."
			SET sts = 'Activate'
			WHERE email = '$email'";
			mysqli_query($this->dbConnect, $sqlInsert);
	}

	public function Deactivate($email) {
			$sqlInsert = "UPDATE ".$this->invoiceUserTable."
			SET sts = 'Deactivate'
			WHERE email = '$email'";
			mysqli_query($this->dbConnect, $sqlInsert);
	}

	public function getTransactionList(){
		$sqlQuery = "SELECT * FROM ".$this->transHistory." ORDER BY trans_date DESC";
		return  $this->getData($sqlQuery);
	}
	public function getcomps(){
		$sqlQuery = "SELECT * FROM ".$this->comps." ORDER BY cName ASC";
		return  $this->getData($sqlQuery);
	}
	public function getcompsPerClient($rcNO){
		$sqlQuery = "SELECT * FROM ".$this->comps." WHERE RCNO = '$rcNO' ORDER BY cName ASC";
		return  $this->getData($sqlQuery);
	}
	public function getInvoiceList(){
		$sqlQuery = "SELECT * FROM ".$this->invoiceOrderTable."
		";
		return  $this->getData($sqlQuery);
	}
	public function getInvoiceListByClient($clientid){
		$sqlQuery = "SELECT * FROM ".$this->invoiceOrderTable."
		WHERE rID = '$clientid'";
		return  $this->getData($sqlQuery);
	}
	public function getTranListByClient($clientid){
		$sqlQuery = "SELECT * FROM trans_history
		WHERE rID = '$clientid' ORDER BY trans_date DESC";
		return  $this->getData($sqlQuery);
	}
	public function getClientList(){
		$sqlQuery = "SELECT * FROM ".$this->NewClients."
		ORDER BY rID";
		return  $this->getData($sqlQuery);
	}
	public function getUsersList(){
		$sqlQuery = "SELECT * FROM ".$this->invoiceUserTable."
		ORDER BY id";
		return  $this->getData($sqlQuery);
	}
	public function getClient($clientid){
		$sqlQuery = "SELECT * FROM ".$this->NewClients."
		WHERE rID = '$clientid'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		return $row;
	}

	public function getCompDetails($clientid){
		$sqlQuery = "SELECT * FROM ".$this->comps."
		WHERE rcNO = '$clientid'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		return $row;
	}
	public function getInvoice($invoiceId){
		$oid = substr($invoiceId,0,1);
		$rID = substr($invoiceId,1);
		$sqlQuery = "SELECT * FROM ".$this->invoiceOrderTable."
		WHERE rID = '$rID' AND order_id = '$oid'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		return $row;
	}
	public function getInvoiceItems($invoiceId){
		$oid = substr($invoiceId,0,1);
		$rID = substr($invoiceId,1);
		$sqlQuery = "SELECT * FROM ".$this->invoiceOrderItemTable."
		WHERE order_id = '$oid' AND rID = '$rID'";
		return  $this->getData($sqlQuery);
	}
	public function UpdateTransHistory($invoiceId){
		$rid = substr($invoiceId,1);
		$oid = substr($invoiceId,0,1);
		$sqlInsertTrans = "UPDATE ".$this->transHistory."
		SET customer_name = '".$POST['fullname']."', order_amount_paid = '".$POST['amountPaid']."', pay_type = '".$POST['inlineRadioOptions']."', order_total_amount_due = '".$POST['amountDue']."'
		WHERE rID = '$rid' AND order_id = '$oid'";
		mysqli_query($this->dbConnect, $sqlInsertTrans);
	}
	public function deleteInvoiceItems($invoiceId){
		$oid = substr($invoiceId,0,1);
		$rID = substr($invoiceId,1);
		$sqlQuery = "DELETE FROM ".$this->invoiceOrderItemTable."
		WHERE order_id = '$oid' AND rID = '$rID'";
		mysqli_query($this->dbConnect, $sqlQuery);
	}
	public function deleteInvoice($invoiceId){
		$oid = substr($invoiceId,0,1);
		$rID = substr($invoiceId,1);
		$sqlQuery = "DELETE FROM ".$this->invoiceOrderTable."
		WHERE order_id = '$oid' AND rID = '$rID'";
		mysqli_query($this->dbConnect, $sqlQuery);
		$this->deleteInvoiceItems($invoiceId);
		return 1;
	}
	public function deleteInvoicePerm($invoiceId){
		$oid = substr($invoiceId,0,1);
		$rID = substr($invoiceId,1);
		$sqlQuery = "DELETE FROM ".$this->invoiceOrderTable."
		WHERE order_id = '$oid' AND rID = '$rID'";
		mysqli_query($this->dbConnect, $sqlQuery);
		$this->deleteInvoiceItems($invoiceId);
	}
	public function deleteInvoiceHistory($invoiceId){
		$oid = substr($invoiceId,0,1);
		$rID = substr($invoiceId,1);
		$sqlQuery = "DELETE FROM ".$this->transHistory."
		WHERE invoice_id = '$oid' AND rID = '$rID'";
		mysqli_query($this->dbConnect, $sqlQuery);
	}
}
?>
