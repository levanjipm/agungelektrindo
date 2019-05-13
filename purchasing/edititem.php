<?php
	include("../Codes/Connect.php")
?>
<?php
$reference=$_POST['reference'];
$description = $_POST['description'];
$id = $_POST['id'];

$sql = "UPDATE itemlist
SET reference='$reference', description='$description'
WHERE id='$id'";
$result = $conn->query($sql);
if($result){
	$data =  ('Changes were made, please referesh to view the changes');
}
?>
