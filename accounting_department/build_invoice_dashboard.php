<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
?>
<head>
	<title>Create sales invoice</title>
</head>
<script>
	$('#sales_invoice_side').click();
	$('#build_invoice_dashboard').find('button').addClass('activated');
</script>
<div class='main'>
	<h2 style='font-family:bebasneue'>Sales Invoice</h2>
	<p style='font-family:museo'>Create sales invoice</p>
	<hr>
	<div id='invoice_pane'></div>
</div>
<script>
	$(document).ready(function(){
		refresh_view();
	});
	
	function submiting(n){
		$('#do' + n).submit();
	}
	
	function refresh_view(){
		$.ajax({
			url:'build_invoice_view',
			success:function(response){
				$('#invoice_pane').html(response);
				setTimeout(function(){
					refresh_view();
				},500);
			}
		});
	}
</script>