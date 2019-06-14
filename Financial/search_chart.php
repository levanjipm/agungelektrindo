<?php
	include('../codes/connect.php');
	$max = 0;
	$month = $_POST['month'];
	$year = $_POST['year'];
	if($month != 0){
		$sql = "SELECT SUM(value) AS pengeluaran FROM petty_cash WHERE MONTH(date) = '" . $month . "' AND YEAR(date) = '" . $year . "' AND class <> '25' GROUP BY class";
		$result = $conn->query($sql);
		while($row = $result->fetch_assoc()){
			if($row['pengeluaran'] > $max){
				$max = $row['pengeluaran'];
			}
		}
?>
	<style>
		#width_control{
			border-left:2px solid #333;
			border-bottom:2px solid #333;
		}
		.chart_bar{
			background-color:#333;
			position:relative;
			display:inline-block;
		}
	</style>
	<div class='row'>
		<div class='col-sm-12' id='width_control'>
<?php
		$sql_classes = "SELECT COUNT(*) AS jumlah_kelas FROM petty_cash_classification";
		$result_classes = $conn->query($sql_classes);
		$classes = $result_classes->fetch_assoc();
		$jumlah_kelas = $classes['jumlah_kelas'];
?>
	<script>
		var chart_width = $('#width_control').innerWidth() / <?= $jumlah_kelas ?>;
		$('.chart_bar').each(function(){
			$(this).css('width',chart_width  );
		});
	</script>
<?php
		$sql_show = "SELECT SUM(value) AS pengeluaran_kategori,class FROM petty_cash WHERE MONTH(date) = '" . $month . "' AND YEAR(date) = '" . $year . "' AND class <> '25' GROUP BY class ORDER BY class ASC";
		$result_show = $conn->query($sql_show);
		while($show = $result_show->fetch_assoc()){
			$height_percentage = $show['pengeluaran_kategori'];
			$sql_name = "SELECT name FROM petty_cash_classification WHERE id = '" . $show['class'] . "'";
			$result_name = $conn->query($sql_name);
			$name = $result_name->fetch_assoc();
			$class_name = $name['name'];
?>
					<div data-html="true" class='chart_bar chart<?= $row['class'] ?>' style='height:<?= max(10,200 * $height_percentage / $max) ?>px' data-toggle="tooltip" title="<?= $class_name . "<br/>Rp. " . number_format($height_percentage,2)?>"></div>
<?php
	}
?>
		</div>
	</div>
	<script>
		$(document).ready(function(){
		  $('[data-toggle="tooltip"]').tooltip(); 
		});
	</script>
<?php
	} else {
		$sql = "SELECT SUM(value) AS pengeluaran FROM petty_cash WHERE YEAR(date) = '" . $year . "' AND class <> '25' GROUP BY class";
		$result = $conn->query($sql);
		while($row = $result->fetch_assoc()){
			if($row['pengeluaran'] > $max){
				$max = $row['pengeluaran'];
			}
		}
?>
	<style>
		#width_control{
			border-left:2px solid #333;
			border-bottom:2px solid #333;
		}
		.chart_bar{
			background-color:#333;
			position:relative;
			display:inline-block;
		}
	</style>
	<div class='row'>
		<div class='col-sm-12' id='width_control'>
<?php
		$sql_classes = "SELECT COUNT(*) AS jumlah_kelas FROM petty_cash_classification";
		$result_classes = $conn->query($sql_classes);
		$classes = $result_classes->fetch_assoc();
		$jumlah_kelas = $classes['jumlah_kelas'];
?>
	<script>
		var chart_width = $('#width_control').innerWidth() / <?= $jumlah_kelas ?>;
		$('.chart_bar').each(function(){
			$(this).css('width',chart_width  );
		});
	</script>
<?php
		$sql_show = "SELECT SUM(value) AS pengeluaran_kategori,class FROM petty_cash WHERE YEAR(date) = '" . $year . "' AND class <> '25' GROUP BY class ORDER BY class ASC";
		$result_show = $conn->query($sql_show);
		while($show = $result_show->fetch_assoc()){
			$height_percentage = $show['pengeluaran_kategori'];
			$sql_name = "SELECT name FROM petty_cash_classification WHERE id = '" . $show['class'] . "'";
			$result_name = $conn->query($sql_name);
			$name = $result_name->fetch_assoc();
			$class_name = $name['name'];
?>
					<div data-html="true" class='chart_bar chart<?= $row['class'] ?>' style='height:<?= max(10,200 * $height_percentage / $max) ?>px' data-toggle="tooltip" title="<?= $class_name . "<br/>Rp. " . number_format($height_percentage,2)?>"></div>
<?php
	}
?>
		</div>
	</div>
	<script>
		$(document).ready(function(){
		  $('[data-toggle="tooltip"]').tooltip(); 
		});
	</script>
<?php
	}
?>