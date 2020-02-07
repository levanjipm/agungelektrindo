<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
?>
<head>
	<title>Input debt document</title>
</head>
<script>
	$('#purchase_invoice_side').click();
	$('#debt_document_dashboard').find('button').addClass('activated');
	
$( function() {
	$('#supplier').autocomplete({
		source: "ajax/search_supplier.php"
	 })
});
</script>
<div class='main'>
	<h2 style='font-family:bebasneue'>Debt</h3>
	<p style='font-family:museo'>Input debt document</p>
	<hr>
	<label>Date</label>
	<input type='date' class='form-control' id='date'>
	
	<label>Supplier</label>
	<select class='form-control' placeholder='Insert vendor name here' id='supplier'>
<?php
			$sql_supplier 		= "SELECT DISTINCT(code_goodreceipt.supplier_id), supplier.id, supplier.name FROM code_goodreceipt
									JOIN supplier ON code_goodreceipt.supplier_id = supplier.id
									WHERE code_goodreceipt.isinvoiced = '0' AND isconfirm = '1'
									ORDER BY supplier.name ASC";
			$result_supplier 	= $conn->query($sql_supplier);
			while($supplier 	= $result_supplier->fetch_assoc()){
				$supplier_id	= $supplier['id'];
				$supplier_name	= $supplier['name'];
?>
			<option value='<?= $supplier_id ?>'><?= $supplier_name ?></option>
<?php
			}
?>
	</select>
	<br>
	<button type='button' class='button_default_dark' onclick='search_document()'><i class='fa fa-search'></i></button>
	<br><br>
</div>

<div class='full_screen_wrapper'>
	<button type='button' class='full_screen_close_button'>&times </button>
	<div class='full_screen_box'>
	</div>
</div>
<script>
	function search_document(){
		if($('#date').val() == ''){
			alert('Insert correct supplier!');
			return false;
		} else if($('#supplier').val() == ''){
			alert('Please insert supplier');
			return false;
		} else {
			$.ajax({
				url: "debt_document_view.php",
				data: {
					date : $('#date').val(),
					supplier : $('#supplier').val()
				},
				type: "POST",
				success: function (response) {
					$('.full_screen_box').html(response);
					$('.full_screen_wrapper').fadeIn();
				},
			})
		}
	}
	
	$('.full_screen_close_button').click(function(){
		$(this).parent().fadeOut();
	});
</script>