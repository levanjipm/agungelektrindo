<?php
	include('../codes/connect.php');

	if(empty($_GET['term']) || $_GET['term'] == ''){
		$sql		= "SELECT id FROM announcement";
		$result		= $conn->query($sql);
		$pages		= min(1,ceil(mysqli_num_rows($result) / 25));
		if(empty($_GET['page'])){
			$page	= 1;
		} else {
			$page	= $_GET['page'];
		}
		$offset	= ($page - 1) * 25;
		
		if(empty($_GET['page']) || $_GET['page'] == 1){
			$sql	= "SELECT * FROM announcement ORDER BY date DESC LIMIT 25 OFFSET $offset";
		} else {
			$sql	= "SELECT * FROM announcement ORDER BY date DESC LIMIT 25";
		}
		$result		= $conn->query($sql);

	} else if(!empty($_GET['term']) && $_GET['term'] != ''){
		$term		= $_GET['term'];
		$sql		= "SELECT id FROM announcement WHERE event LIKE '%$term%' OR description LIKE '%$term%'";
		$result		= $conn->query($sql);
		$pages		= min(1,ceil(mysqli_num_rows($result) / 25));
		if(empty($_GET['page'])){
			$page	= 1;
		} else {
			$page	= $_GET['page'];
		}
		$offset	= ($page - 1) * 25;
		
		if(empty($_GET['page']) || $_GET['page'] == 1){
			$sql	= "SELECT * FROM announcement WHERE event LIKE '%$term%' OR description LIKE '%$term%' ORDER BY date DESC LIMIT 25";
		} else {
			$sql	= "SELECT * FROM announcement WHERE event LIKE '%$term%' OR description LIKE '%$term%' ORDER BY date DESC LIMIT 25 OFFSET $offset";
		}
		$result		= $conn->query($sql);
	}
?>
<div class='row'>
<?php
		while($row		= $result->fetch_assoc()){
			$id				= $row['id'];
			$name			= $row['event'];
			$description	= $row['description'];
			$date			= $row['date'];
?>
	<div class='col-xs-12'>
		<hr style='border-top:1px solid #424242'>
		<label><?= $name ?></label>
		<p><i><?= date('d M Y',strtotime($date)) ?></i></p>
		<p style='font-family:museo'><?= $description ?></p>
		<button type='button' class='button_success_dark' onclick='view_edit_announcement(<?= $id ?>)'><i class='fa fa-pencil'></i></button>
	</div>
<?php
		}
?>
</div>
	
<select class='form-control' id='page' style='width:100px'>
<?php
	for($i = 1; $i <= $pages; $i++){
?>
	<option value='<?= $i ?>' <?php if($i == $page){ echo 'selected';  } ?>><?= $i ?></option>
<?php
	}
?>
</select>

<script>
	function view_edit_announcement(n){
		$.ajax({
			url:'announcement_edit_form',
			data:{
				id:n
			},
			success:function(response){
				$('#edit_announcement_wrapper .full_screen_box').html(response);
				$('#edit_announcement_wrapper').fadeIn();
			}
		});
	};
</script>