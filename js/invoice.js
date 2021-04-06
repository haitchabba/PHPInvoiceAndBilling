 $(document).ready(function(){
   $("#myInput").on("keyup", function() {
     var value = $(this).val().toLowerCase();
     $("#data-table tr").filter(function() {
       $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
     });
   });

	$(document).on('click', '#checkAll', function() {
		$(".itemRow").prop("checked", this.checked);
	});
	$(document).on('click', '.itemRow', function() {
		if ($('.itemRow:checked').length == $('.itemRow').length) {
			$('#checkAll').prop('checked', true);
		} else {
			$('#checkAll').prop('checked', false);
		}
	});
	var count = $(".itemRow").length;
	$(document).on('click', '#addRows', function() {
		count++;
		var htmlRows = '';
		htmlRows += '<tr>';
		htmlRows += '<td><div class="custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input itemRow" id="itemRow_'+count+'"> <label class="custom-control-label" for="itemRow_'+count+'"></label> </div></td>';
		htmlRows += '<td><input type="text" name="productCode[]" id="productCode_'+count+'" class="form-control productCode" autocomplete="off" required></td>';
		htmlRows += '<td><input type="text" name="productName[]" id="productName_'+count+'" class="form-control productName" autocomplete="off" readonly required></td>';
		htmlRows += '<td><input type="number" name="quantity[]" id="quantity_'+count+'" class="form-control quantity" autocomplete="off" required></td>';
		htmlRows += '<td><input type="number" name="price[]" id="price_'+count+'" class="form-control price" autocomplete="off" readonly required></td>';
		htmlRows += '<td><input type="number" name="total[]" id="total_'+count+'" class="form-control total" autocomplete="off" readonly required></td>';
		htmlRows += '</tr>';
		$('#invoiceItem').append(htmlRows);
	});
	$(document).on('click', '#removeRows', function(){
		$(".itemRow:checked").each(function() {
			$(this).closest('tr').remove();
		});
		$('#checkAll').prop('checked', false);
		calculateTotal();
	});
	
	
	$(document).on('blur', "[id^=productCode_]", function(){
		capRoom();
	});
	$(document).on('blur', "[id^=quantity_]", function(){
		calculateTotal();
	});
	$(document).on('blur', "[id^=price_]", function(){
		calculateTotal();
	});
	$(document).on('blur', "#taxRate", function(){
		calculateTotal();
	});
	$(document).on('blur', "#amountPaid", function(){
		var amountPaid = $(this).val();
		var CAmountDue = $('#camountDue').val();
		var amountDue = $('#amountDue').val();
		if(amountDue && amountPaid){
			var amountPaidFinal = amountDue - amountPaid;
			$('#camountDue').val(amountPaidFinal);
		}else {
			$('#camountDue').val(amountDue);
		}
		
	});
	
	$(document).on('click', '.deleteInvoice', function(){
		var id = $(this).attr("id");
		if(confirm("Are you sure you want to remove this?")){
			$.ajax({
				url:"action.php",
				method:"POST",
				dataType: "json",
				data:{id:id, action:'delete_invoice'},
				success:function(response) {
					if(response.status == 1) {
						$('#'+id).closest("tr").remove();
					}
				}
			});
		} else {
			return false;
		}
	});
});

function capRoom(){
	var room = "";
	var rate = "";
	var tax = "";
	$("[id^='productCode_']").each(function() {
		var id = $(this).attr('id');
		id = id.replace("productCode_",'');
		var productCode = $('#productCode_'+id).val();
		switch(productCode){
			case '101':
			room = "Executive Suite";
			rate = "9500";
			tax = "7.5"
			break;
			case '102':
			case '109':
			case '110':
			case '112':
			case '118':
			room = "Deluxe";
			rate = "19500";
			tax = "7.5"
			break;
			case '103':
			room = "Executive";
			rate = "19500";
			tax = "7.5"
			break;
			case '104':
			case '105':
			case '106':
			case '108':
			case '113':
			case '114':
			case '115':
			case '116':
			case '117':
			room = "Standard";
			rate = "9600";
			tax = "7.5"
			break;
			case 'R101':
			room = "Executive Suite";
			rate = "14000";
			tax = "0"
			break;
			case 'R102':
			case 'R109':
			case 'R110':
			case 'R112':
			case 'R118':
			room = "Deluxe";
			rate = "14000";
			tax = "0"
			break;
			case 'R103':
			room = "Executive";
			rate = "14000";
			tax = "0"
			break;
			case 'R104':
			case 'R105':
			case 'R106':
			case 'R108':
			case 'R113':
			case 'R114':
			case 'R115':
			case 'R116':
			case 'R117':
			room = "Standard";
			rate = "14000";
			tax = "0"
			break;
		}
		$('#productName_'+id).val(room);
		$('#price_'+id).val(rate);
		$('#taxRate').val(tax);
		
	});
	
}


function calculateTotal(){
	var totalAmount = 0;
	$("[id^='price_']").each(function() {
		var id = $(this).attr('id');
		id = id.replace("price_",'');
		var price = $('#price_'+id).val();
		var quantity  = $('#quantity_'+id).val();
		if(!quantity) {
			quantity = 1;
		}
		var total = price*quantity;
		$('#total_'+id).val(parseFloat(total));
		totalAmount += total;
	});
	$('#subTotal').val(parseFloat(totalAmount));
	var taxRate = $("#taxRate").val();
	var subTotal = $('#subTotal').val();
	if(subTotal) {
		var taxAmount = subTotal*taxRate/100;
		$('#taxAmount').val(taxAmount);
		subTotal = parseFloat(subTotal)+parseFloat(taxAmount);
		$('#totalAftertax').val(subTotal);
		var amountPaid = $('#amountPaid').val();
		var totalAftertax = $('#totalAftertax').val();
		if(amountPaid && totalAftertax) {
			totalAftertax = totalAftertax-amountPaid;
			$('#amountDue').val(totalAftertax);
		} else {
			$('#amountDue').val(subTotal);
		}
	}
}
