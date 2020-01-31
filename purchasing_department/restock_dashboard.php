<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/purchasing_header.php');
?>
<head>
	<title>Restock</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Restock</h2>
	<hr>
	<form action='restock_class' method='POST'>
	<label>Item category</label>
	<select class='form-control' name='class'>
<?php
	$sql		= "SELECT * FROM itemlist_category ORDER BY name ASC";
	$result		= $conn->query($sql);
	while($row	= $result->fetch_assoc()){
?>
		<option value='<?= $row['id'] ?>'><?= $row['name'] ?></option>
<?php
	}
?>
	</select>
	<br>
	<button type='submit' class='button_default_dark'>Submit</button>
	</form>
</div>