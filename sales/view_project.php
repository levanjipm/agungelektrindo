<?php
	include('../codes/connect.php');
	$major_id = $_POST['project_major'];
	$sql_minor = "SELECT * FROM code_project WHERE major_id = '" .$major_id . "'";
	$result_minor = $conn->query($sql_minor);
	if(mysqli_num_rows($result_minor)){
?>
<table class='table table-hover'>
	<tr>
		<th>Assignment name</th>
		<th>Start date</th>
		<th></th>
	</tr>
<?php
		while($minor = $result_minor->fetch_assoc()){
?>
	<tr>
		<td><?= $minor['project_name'] ?></td>
		<td><?= date('d M Y',strtotime($minor['start_date'])) ?></td>
		<td><button type='button' class='btn btn-default'>Details</button></td>
	</tr>
<?php
		}
?>
</table>
<?php
	}
?>