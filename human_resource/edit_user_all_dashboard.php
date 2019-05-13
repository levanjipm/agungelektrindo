<?php
	//Edit all users dashboard//
	include('hrheader.php');
?>
<div class='main'>
	<div class='row' id='users'>
<?php
	$sql_show = "SELECT id,username,name,role FROM users";
	$result_show = $conn->query($sql_show);
	while($show = $result_show->fetch_assoc()){
?>
		<div class='col-sm-2' style='padding:20px;background-color:#eee;margin:10px;text-align:center'>
			<img src='images/users/<?= $show['username'] ?>.png' style='width:100%;border-radius:50%;'>
			<p style='text-align:center'><strong><?= $show['name'] ?></strong></p>
			<button type='button' class='btn btn-default' id='<?= $show['id'] ?>' onclick='slideme(<?= $show['id'] ?>)'>Click me</button>
			<form action='edit_user_all.php' method='POST' id='form<?= $show['id'] ?>'>
				<input type='hidden' value='<?= $show['id'] ?>'name='user_id'>
			</form>
		</div>
<?php
	}
?>
	</div>
</div>
<script>
	function slideme(n){
		$('#users').animate({
		  width: "toggle"
		});
		$('#' + n).animate("slide", { direction: "right" }, 1000);
		setTimeout(function(){
			$('#form' + n).submit();
		},1000);
	};
</script>