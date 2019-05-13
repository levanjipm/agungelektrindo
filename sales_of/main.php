<?php
include('header.php');
include('connect.php');
?>
<div class="row" id="form-holder" style="background-color:#888;padding-top:30px">
	<div class="container">
		<div class="col-xs-12 col-sm-12">
			<label>Reference:</label>
			<input type='text' class='form-control' placeholder='Insert the reference here...' id='item'>
		</div>
	</div>
</div>
<div class="row" id='edititemtable' style="background-color:#888;padding-top:30px">
	<div class="col-sm-10 offset-sm-1">
		<div class="container" style="background-color:#eee;height:300px;border-radius:30px"></div>
	</div>
</div>
<div id="showresults"></div>
<a href=" https://wa.me/6285290000241">aaa</a>
<script>
$('#item').change(function () {
    $.ajax({
        url: "search_check_stock.php",
        data: {
            term: $('#item').val()
        },
        type: "GET",
        dataType: "html",
        success: function (data) {
            $('#edititemtable').replaceWith($('#showresults').html(data));
        },
        error: function (xhr, status) {
            alert("Sorry, there was a problem!");
        },
    });
});
</script>