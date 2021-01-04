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
		htmlRows += '<td><input type="text" name="productCode[]" id="productCode_'+count+'" class="form-control" autocomplete="off"></td>';
		htmlRows += '<td><input type="text" name="productName[]" id="productName_'+count+'" class="form-control" autocomplete="off"></td>';
		htmlRows += '<td><input type="number" name="quantity[]" id="quantity_'+count+'" class="form-control quantity" autocomplete="off"></td>';
		htmlRows += '<td><input type="number" name="price[]" id="price_'+count+'" class="form-control price" autocomplete="off"></td>';
		htmlRows += '<td><input type="number" name="total[]" id="total_'+count+'" class="form-control total" autocomplete="off"></td>';
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
		var totalAftertax = $('#totalAftertax').val();
		if(amountPaid && totalAftertax) {
			totalAftertax = totalAftertax-amountPaid;
			$('#amountDue').val(totalAftertax);
		} else {
			$('#amountDue').val(totalAftertax);
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
	var rm_no = document.getElementById('productCode_1').value;
	var rate = "";
	var room = "";
	var tax = "";
	switch(rm_no){
		case '104':
		case '105':
		case '106':
		case '108':
		room = "Standard";
		rate = "9600";
		tax = "7.5";
		break;
    case '102':
		case '109':
		case '110':
		room = "Deluxe";
		rate = "10800";
		tax = "7.5";
		break;
    case '103':
		room = "Executive";
		rate = "13200";
		tax = "7.5";
		break;
    case '111':
		room = "Standard Suite";
		rate = "15900";
		tax = "7.5";
		break;
    case '107':
		room = "Deluxe Suite";
		rate = "18000";
		tax = "7.5";
		break;
    case '101':
		room = "Executive Suite";
		rate = "19200";
		tax = "7.5";
		break;
    case '000':
		room = "SPCFR14";
		rate = "14000";
		tax = "0";
		break;
	}

	document.getElementById('productName_1').value = room;
	document.getElementById('price_1').value = rate;
	document.getElementById('taxRate').value = tax;
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
