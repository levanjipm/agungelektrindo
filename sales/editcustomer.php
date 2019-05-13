<?php
	include("../codes/Connect.php")
?>

<?php
$id = $_POST['id'];
$name = $_POST['namaperusahaan'];
$address = $_POST['address'];
$phone=$_POST['phone'];
$npwp=$_POST['npwp'];
$city = $_POST['city'];
$prefix = $_POST['prefix'];
$pic = $_POST['pic'];

$sql = "UPDATE customer
SET name='$name', address='$address', phone='$phone', npwp='$npwp', city='$city', prefix='$prefix', pic='$pic'
WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

header("Location: sales.php");
die();

?>
