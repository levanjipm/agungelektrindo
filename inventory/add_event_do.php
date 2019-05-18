<?php
	include('../codes/connect.php');
	$event = $_POST['event_selector'];
	switch ($event){
		case "1":
		$date = $_POST['date1'];
		$reference = $_POST['lost_reference'];
		$quantity = $_POST['lost_quantity'];
		$sql_item = "SELECT stock FROM stock WHERE reference = '" . $reference . "' ORDER BY id DESC LIMIT 1";
		$result_item = $conn->query($sql_item);
		if(mysqli_num_rows($result_item) == 0){
			echo("This operation is illegal, the mentioned items does not exist.");
			header( "Refresh:3; url=add_event_dashboard.php");
		} else{
			$row_item = $result_item->fetch_assoc();
			if ($row_item['stock'] < $quantity){
				echo ('This operation is illegal');
				header( "refresh:5; url=inventory.php" ); 
			} else {
				$sql_event_i = "SELECT COUNT(*) AS event_raw FROM events WHERE event_id = '1' AND YEAR(date) = YEAR('$date')";
				$result_event_i = $conn->query($sql_event_i);
				while($row_event_i = $result_event_i->fetch_assoc()){
					if($row_event_i['event_raw'] == 0){
						$event_name_raw = 1;
					} else {
						$event_name_raw = $row_event_i['event_raw'] + 1;
					}
				}
				$event_name = 'LOS' . $event_name_raw;
				$sql_event = "INSERT INTO events (date,event_id,event_name) VALUES ('$date','1','$event_name')";
				$result_event = $conn->query($sql_event);
				$final_stock = $row_item['stock'] - $_POST['lost_quantity'];
				$sql_input = "INSERT INTO stock (reference,transaction,quantity,stock,supplier_id,customer_id,document)
				VALUES ('$reference','LOS','$quantity','$final_stock','0','0','$event_name')";
				$result_input = $conn->query($sql_input);
				//Stock value//
				$sql_in = "SELECT * FROM stock_value_in WHERE reference = '" . $reference . "' AND sisa > 0 ORDER BY id ASC";
				$result_in = $conn->query($sql_in);
				while($in = $result_in ->fetch_assoc()){
					$in_id = $in['id'];
					$sisa = $in['sisa'];
					$pengurang = min($sisa,$quantity);
					$sql_update = "UPDATE stock_value_in SET sisa = '" . ($sisa - $pengurang) . "' WHERE id = '" . $in_id . "'";
					$result_update = $conn->query($sql_update);
					$sql_out = "INSERT INTO stock_value_out (in_id,quantity,customer_id)
					VALUES ('$in_id	','$pengurang','$customer_id')";
					$result_out = $conn->query($sql_out);
					$quantity = $quantity - $pengurang;
					if ($quantity == 0){
						break;
				 	}
				}
				header('location:inventory.php');
			}
		}
	break;
	
	case "2":
	$date = $_POST['date2'];
	$reference = $_POST['found_reference'];
	$quantity = $_POST['found_quantity'];
	$sql_event_i = "SELECT COUNT(*) AS event_raw FROM events WHERE event_id = '2' AND YEAR(date) = YEAR('$date')";
	$result_event_i = $conn->query($sql_event_i);
	while($row_event_i = $result_event_i->fetch_assoc()){
		if($row_event_i['event_raw'] == 0){
			$event_name_raw = 1;
		} else {
			$event_name_raw = $row_event_i['event_raw'] + 1;
		}
	};
	$sql_item = "SELECT stock FROM stock WHERE reference = '" . $reference . "' ORDER BY id DESC LIMIT 1";
	$result_item = $conn->query($sql_item);
	while($row_item = $result_item->fetch_assoc()){
		$final_stock = $row_item['stock'] + $_POST['found_quantity'];
	}
	$event_name = 'FOU' . $event_name_raw;
	$sql_event = "INSERT INTO events (date,event_id,event_name) VALUES ('$date','1','$event_name')";
	$result_event = $conn->query($sql_event);
	$sql_input = "INSERT INTO STOCK (reference,transaction,quantity,stock,supplier_id,customer_id,document)
	VALUES ('$reference','FOU','$quantity','$final_stock','0','0','$event_name')";
	$result_input = $conn->query($sql_input);
	$sql_found = "INSERT INTO stock_value_in (reference,quantity,price,sisa) VALUES ('$reference','$quantity','0','$quantity')";
	$result_found = $conn->query($sql_found);
	header('location:inventory.php');
	break;
	
	case "3":
	$date = $_POST['date3'];
	$reference_initial = $_POST['initial_item_de_reference'];
	$quantity_i = $_POST['initial_item_de_quantity'];
	$sql_item = "SELECT stock FROM stock WHERE reference = '" . $reference_initial . "' ORDER BY id DESC LIMIT 1";
	$result_item = $conn->query($sql_item);
	if(mysqli_num_rows($result_item) == 0){
		echo("This operation is illegal, the mentioned items does not exist.");
		header( "Refresh:3; url=add_event_dashboard.php");
	} else{
		while($row_item = $result_item->fetch_assoc()){
			if ($row_item['stock'] < $quantity_i){
				echo ('This operation is illegal');
			} else {
				$sql_event_i = "SELECT COUNT(*) AS event_raw FROM events WHERE event_id = '3' AND YEAR(date) = YEAR('$date')";
				$result_event_i = $conn->query($sql_event_i);
				while($row_event_i = $result_event_i->fetch_assoc()){
					if($row_event_i['event_raw'] == 0){
						$event_name_raw = 1;
					} else {
						$event_name_raw = $row_event_i['event_raw'] + 1;
					}
				};
				$price_initial = 0;
				$event_name = 'DEM' . $event_name_raw;
				$sql_event = "INSERT INTO events (date,event_id,event_name) VALUES ('$date','3','$event_name')";
				$result_event = $conn->query($sql_event);
				$final_stock = $row_item['stock'] - $quantity_i;
				$sql_input = "INSERT INTO stock (reference,transaction,quantity,stock,supplier_id,customer_id,document)
				VALUES ('$reference_initial','DEM','$quantity_i','$final_stock','0','0','$event_name')";
				$result_input = $conn->query($sql_input);
				$sql_in_id = "SELECT * FROM stock_value_in WHERE reference = '" . $reference_initial . "' AND sisa > 0 ORDER BY id ASC";
				$result_in_id = $conn->query($sql_in_id);
				while($in = $result_in_id ->fetch_assoc()){
					$in_id = $in['id'];
					$sisa = $in['sisa'];
					$pengurang = min($sisa,$quantity_i);
					$sql_update = "UPDATE stock_value_in SET sisa = '" . ($sisa - $pengurang) . "' WHERE id = '" . $in_id . "'";
					$result_update = $conn->query($sql_update);
					$sql_out = "INSERT INTO stock_value_out (date,in_id,quantity,customer_id)
					VALUES ('$date','$in_id	','$pengurang','0')";
					$result_out = $conn->query($sql_out);
					$price_initial = $price_initial + $pengurang * $in['price'];
					$quantity_i = $quantity_i - $pengurang;
					if ($quantity_i == 0){
						break;
					}
				}
				$i = 1;
				$dem = 1;
				$pricelist_total = 0;
				for($i = 1; $i <= 3; $i++){
					$pricelist = $_POST['de_pl' . $i];
					$item = $_POST['de_' . $i];
					$quantity_break = $_POST['de_q' . $i] * $_POST['initial_item_de_quantity'];
					if($item == '' || $_POST['de_q' . $i] == 0){
					} else {
						$sql_stock = "SELECT * FROM stock WHERE reference = '" . $item . "' ORDER BY id DESC LIMIT 1";
						$result_stock = $conn->query($sql_stock);
						$row_stock = $result_stock->fetch_assoc();
						$stock_awal = $row_stock['stock'];
						
						$stock_final = ($stock_awal + $quantity_break);
						$sql_input_2 = "INSERT INTO STOCK (reference,transaction,quantity,stock,supplier_id,customer_id,document)
						VALUES ('$item','DEM','$quantity_break','$stock_final','0','0','$event_name')";
						$result_input_2 = $conn->query($sql_input_2);					
						$pricelist_total = $pricelist_total + $quantity_break * $pricelist;
						
					}
				}
				for($i = 1; $i <= 3; $i++){
					$pricelist = $_POST['de_pl' . $i];
					$item = $_POST['de_' . $i];
					$quantity_break = $_POST['de_q' . $i] * $_POST['initial_item_de_quantity'];
					if($item == '' || $quantity = '0'){
					} else {
						$price = ($pricelist)* $price_initial/ $pricelist_total;
						$sql_insert = "INSERT INTO stock_value_in (date,reference,quantity,price,sisa,supplier_id) 
						VALUES ('$date','$item','$quantity_break','$price','$quantity_break','0')";
						$result_insert = $conn->query($sql_insert);
					}
				}
					
			}
		}
	
	}
	header('location:inventory.php');
	break;
	
	case "4":
	$i = 1;
	$date = $_POST['date4'];
	$mfinal = $_POST['mfinal'];
	$mqfinal = $_POST['mqfinal'];
	$price_initial = 0;
	$validation = true;
	for($i =1; $i < 3; $i++){
		$item = $_POST['m' . $i];
		$quantity = $_POST['mq' . $i] * $mqfinal;
		if($item == '' || $quantity == 0){
			
		} else {
			$sql = "SELECT stock FROM stock WHERE reference = '" . $item . "' ORDER BY id DESC LIMIT 1";
			$result = $conn->query($sql);
			$row = $result->fetch_assoc();
			$stock = $row['stock'];
			if ($quantity > $stock){
				echo ('This operation is illegal');
				$validation = false;
				break;
			} else {
			}
		}
	}
	if ($validation == true){
		$sql_event_i = "SELECT COUNT(*) AS event_raw FROM events WHERE event_id = '4' AND YEAR(date) = YEAR('$date')";
		$result_event_i = $conn->query($sql_event_i);
		while($row_event_i = $result_event_i->fetch_assoc()){
			if($row_event_i['event_raw'] == 0){
				$event_name_raw = 1;
			} else {
				$event_name_raw = $row_event_i['event_raw'] + 1;
			}
		};
		$event_name = 'MAT' . $event_name_raw;
		for ($i = 1; $i <= 3; $i++){
			if($_POST['m' . $i] == ''){
			} else {
				$item = $_POST['m' . $i];
				$quantity = $_POST['mq' . $i] * $mqfinal;
				$sql_initial = "SELECT stock FROM stock WHERE reference = '" . $item . "' ORDER BY id DESC LIMIT 1";
				$result_initial = $conn->query($sql_initial);
				$row_initial = $result_initial->fetch_assoc();
				$stock_awal = $row_initial['stock'];
				
				$stock_akhir = $stock_awal - $quantity;
				
				$sql_stock = "INSERT INTO STOCK (reference, transaction, quantity, stock, supplier_id, customer_id, document) 
				VALUES ('$item','MAT','$quantity','$stock_akhir','0','0','$event_name')";
				$result_stock = $conn->query($sql_stock);
				
				//Find the price of that item//
				$sql_stock_in = "SELECT * FROM stock_value_in WHERE reference = '" . $item . "' AND sisa > 0 ORDER BY id ASC";
				$result_stock_in = $conn->query($sql_stock_in);
				while($in = $result_stock_in->fetch_assoc()){
					$in_id = $in['id'];
					$sisa = $in['sisa'];
					$pengurang = min($sisa, $quantity);
					$sql_update = "UPDATE stock_value_in SET sisa = '" . ($sisa - $pengurang) . "' WHERE id = '" . $in_id . "'";
					$result_update = $conn->query($sql_update);
					
					$sql_out = "INSERT INTO stock_value_out (date,in_id,quantity,customer_id)
					VALUES ('$date','$in_id	','$pengurang','0')";
					$result_out = $conn->query($sql_out);
					
					$price_initial = $price_initial + $pengurang * $in['price'];
					
					$quantity = $quantity - $quantity;
					if ($quantity == 0){
						break;
					}
				}
			}
		}
		$sql_initial2 = "SELECT stock FROM stock WHERE reference = '" . $mfinal . "' ORDER BY id DESC LIMIT 1";
		$result_initial2 = $conn->query($sql_initial2);
		$row_initial2 = $result_initial2->fetch_assoc();
		$stock_awal = $row_initial2['stock'];
		$stock_akhir = $mqfinal + $stock_awal;
		$sql_stock = "INSERT INTO STOCK (reference, transaction, quantity, stock, supplier_id, customer_id, document) 
		VALUES ('$mfinal','MAT','$mqfinal','$stock_akhir','0','0','$event_name')";
		$result_stock = $conn->query($sql_stock);
		$sql_event = "INSERT INTO events (date,event_id,event_name) VALUES ('$date','4','$event_name')";
		$result_event = $conn->query($sql_event);
		$sql_in_again = "INSERT INTO stock_value_in (reference,quantity,price,sisa,supplier_id)
		VALUES ('$mfinal','$mqfinal','$price_initial','$mqfinal','0')";
		$result_in_again = $conn->query($sql_in_again);
		
	}
	header('location:inventory.php');
	break;
	
	case "5":
	$date = $_POST['date5'];
	$quantity_swap = $_POST['swapq'];
	$swap_cal = $_POST['swapq'];
	
	$price_one = $_POST['price_one'];
	$price_two = $_POST['price_two'];
	
	$swap_minus1 = $_POST['swap_minus_one'];
	$swap_minus2 = $_POST['swap_minus_two'];
	$swap_plus1 = $_POST['swap_plus_one'];
	$swap_plus2 = $_POST['swap_plus_two'];
	
	$sql_check = "SELECT stock FROM stock WHERE reference = '" . $swap_minus1 . "' ORDER BY id DESC LIMIT 1";
	$result_check = $conn->query($sql_check);
	$row_check = $result_check->fetch_assoc();
	$stock1 = $row_check['stock'];
	
	$sql_check2 = "SELECT stock FROM stock WHERE reference = '" . $swap_minus2 . "' ORDER BY id DESC LIMIT 1";
	$result_check2 = $conn->query($sql_check2);
	$row_check2 = $result_check2->fetch_assoc();
	$stock2 = $row_check2['stock'];
	
	if ($quantity_swap > $stock1 || $quantity_swap > $stock2){
		echo ('this operation is illegal');
		header( "refresh:5; url=inventory.php" ); 
		return false;
	} else {
		$sql_event_i = "SELECT COUNT(*) AS event_raw FROM events WHERE event_id = '5' AND YEAR(date) = YEAR('$date')";
		$result_event_i = $conn->query($sql_event_i);
		while($row_event_i = $result_event_i->fetch_assoc()){
			if($row_event_i['event_raw'] == 0){
				$event_name_raw = 1;
			} else {
				$event_name_raw = $row_event_i['event_raw'] + 1;
			}
		};
		$event_name = 'SWP' . $event_name_raw;
		$sql_initial = "SELECT stock FROM stock WHERE reference = '" . $swap_minus1 . "' ORDER BY id DESC LIMIT 1";
		$result_initial = $conn->query($sql_initial);
		$row_initial = $result_initial->fetch_assoc();
		$stock_awal1 = $row_initial['stock'];
		
		$sql_initial2 = "SELECT stock FROM stock WHERE reference = '" . $swap_minus2 . "' ORDER BY id DESC LIMIT 1";
		$result_initial2 = $conn->query($sql_initial2);
		$row_initial2 = $result_initial2->fetch_assoc();
		$stock_awal2 = $row_initial2['stock'];
		
		$stock_akhir1 = $stock_awal1 - $quantity_swap;
		$stock_akhir2 = $stock_awal2 - $quantity_swap;
		
		$sql_stock1 = "INSERT INTO stock (reference, transaction, quantity, stock, supplier_id, customer_id, document) 
		VALUES ('$swap_minus1','SWP','$quantity_swap','$stock_akhir1','0','0','$event_name')";
		
		$sql_stock2 = "INSERT INTO stock (reference, transaction, quantity, stock, supplier_id, customer_id, document) 
		VALUES ('$swap_minus2','SWP','$quantity_swap','$stock_akhir2','0','0','$event_name')";
		
		$result1 = $conn->query($sql_stock1);
		$result2 = $conn->query($sql_stock2);
		$sql_event = "INSERT INTO events (date,event_id,event_name) VALUES ('$date','5','$event_name')";
		$result_event = $conn->query($sql_event);
		
		$sql_initial3 = "SELECT stock FROM stock WHERE reference = '" . $swap_plus1 . "' ORDER BY id DESC LIMIT 1";
		$result_initial3 = $conn->query($sql_initial3);
		$row_initial3 = $result_initial3->fetch_assoc();
		$stock_awal3 = $row_initial3['stock'];
		
		$sql_initial4 = "SELECT stock FROM stock WHERE reference = '" . $swap_plus2 . "' ORDER BY id DESC LIMIT 1";
		$result_initial4 = $conn->query($sql_initial4);
		$row_initial4 = $result_initial4->fetch_assoc();
		$stock_awal4 = $row_initial4['stock'];
		
		$stock_akhir3 = $quantity_swap + $stock_awal3;
		$stock_akhir4 = $quantity_swap + $stock_awal4;
		
		$sql_stock = "INSERT INTO stock (reference, transaction, quantity, stock, supplier_id, customer_id, document) VALUES ('$swap_plus1','SWP','$quantity_swap','$stock_akhir3','0','0','$event_name')";
		$result3 = $conn->query($sql_stock);
		$sql_stock = "INSERT INTO stock (reference, transaction, quantity, stock, supplier_id, customer_id, document) VALUES ('$swap_plus2','SWP','$quantity_swap','$stock_akhir4','0','0','$event_name')";
		$result4 = $conn->query($sql_stock);
		
		$price_initial1 = 0;
		$sql_value_in1 = "SELECT * FROM stock_value_in WHERE reference = '" . $swap_minus1 . "' AND sisa > 0 ORDER BY id ASC";
		$result_value_in1 = $conn->query($sql_value_in1);
		while($value_in1 = $result_value_in1->fetch_assoc()){
			$in_id = $value_in1['id'];
			$sisa = $value_in1['sisa'];
			$pengurang = min($sisa,$quantity_swap);
			$sql_update = "UPDATE stock_value_in SET sisa = '" . ($sisa - $pengurang) . "' WHERE id = '" . $in_id . "'";
			$sql_insert_out1 = "INSERT INTO stock_value_out (date,in_id,quantity,customer_id) VALUES ('$date','$in_id','$pengurang','0')";
			$result_update = $conn->query($sql_update);
			$result_insert_out1 = $conn->query($sql_insert_out1);
			$price_initial1 = $price_initial1 + $value_in1['price'] * $pengurang;
			$quantity_swap = $quantity_swap - $pengurang;
			if ($quantity_swap == 0){
				break;
			}
		}
		$quantity_swap = $_POST['swapq'];
		
		$price_initial2 = 0;
		$sql_value_in2 = "SELECT * FROM stock_value_in WHERE reference = '" . $swap_minus2 . "' AND sisa > 0 ORDER BY id ASC";
		$result_value_in2 = $conn->query($sql_value_in2);
		while($value_in2 = $result_value_in2->fetch_assoc()){
			$in_id = $value_in2['id'];
			$sisa = $value_in2['sisa'];
			$pengurang = min($sisa,$quantity_swap);
			$sql_update = "UPDATE stock_value_in SET sisa = '" . ($sisa - $pengurang) . "' WHERE id = '" . $in_id . "'";
			$sql_insert_out2 = "INSERT INTO stock_value_out (date,in_id,quantity,customer_id) VALUES ('$date','$in_id','$pengurang','0')";
			$result_update = $conn->query($sql_update);
			$result_insert_out2 = $conn->query($sql_insert_out2);
			$price_initial2 = $price_initial2 + $value_in2['price'] * $pengurang;
			$quantity_swap = $quantity_swap - $pengurang;
			if ($quantity_swap == 0){
				break;
			}
		}
		$total_price = $price_initial1 + $price_initial2;
		$unit_price = $total_price/ (2 * $swap_cal);
		echo $unit_price;
		$price1 = $price_one * $unit_price / ($price_one + $price_two);
		
		$stock_1 = "INSERT INTO stock_value_in (date,reference,quantity,price,sisa,supplier_id,customer_id,gr_id)
		VALUES ('$date','$swap_plus1','$swap_cal','$price1','$swap_cal','0','0','0')";
		$result_1 = $conn->query($stock_1);
		
		$price2 = $price_two * $unit_price / ($price_one + $price_two);
		$stock_2 = "INSERT INTO stock_value_in (date,reference,quantity,price,sisa,supplier_id,customer_id,gr_id)
		VALUES ('$date','$swap_plus2','$swap_cal','$price2','$swap_cal','0','0','0')";
		$result_2 = $conn->query($stock_2);
	}
	//header('location:inventory.php');
	break;
	}
?>