<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
?>
<head>
	<title>Confirm sales invoice</title>
</head>
<script>
	$('#sales_invoice_side').click();
	$('#confirm_invoice_dashboard').find('button').addClass('activated');
</script>
<div class='main'>
	<h2 style='font-family:bebasneue'>Sales Invoice</h2>
	<p style='font-family:museo'>Confirm invoice</p>
	<hr>
	<div id='confirm_invoice_pane'></div>
</div>
<script>
	$(document).ready(function(){
		refresh_view();
	});
	
	function refresh_view(){
		$.ajax({
			url:'confirm_invoice_view.php',
			success:function(response){
				$('#confirm_invoice_pane').html(response);
				setTimeout(function(){
					refresh_view()
				},1000);
			}
		})
	}
</script>