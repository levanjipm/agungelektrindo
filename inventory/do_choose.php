<?php
	include("inventoryheader.php")
?>
<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<script> 
$( function() {
	$('#so_id').autocomplete({
		source: "Ajax/search_so.php"
	 })
});
</script>
<style>
#pick1 {
	text-align:center;
	padding:50px;
	background-color:#eee;
	transition: all 0.3s ease;
	color:black;
	border-radius:30px;
}

#pick1:hover{
	background-color:#ccc;
	transition: 0.3s ease;
}
#pick2 {
	text-align:center;
	padding:50px;
	background-color:#222;
	transition: all 0.3s ease;
	color:white;
	border-radius:30px;
}
#pick2:hover{
	background-color:#444;
	transition: 0.3s ease;
}
.one-is-active {
  & .section-one {
    width: 70%;
  }
  
  & .section-two {
    width: 30%;
  }
}

.two-is-active {
  & .section-one {
    width: 30%;
  }
  
  & .section-two {
    width: 70%;
  }
}
.container {
	width: 100%;
	height: calc(90vh - 40px);
	overflow: hidden;
}
.section-one {
	width: 50%;
	float: left;
	height: 100%;
	background: #666;
	position: relative;
	transform: skew(-9deg);
	z-index: 1;
	transition: width 0.5s;
	&:before {
		content: "";
		width: 50%;
		height: 100%;
		position: absolute;
		background: #666;
		top: 0;
		left: 0;
		transform: skew(9deg);
		z-index: -1;
	}
}
.section-two {
	width: 50%;
	float: left;
	height: 100%;
	background: #999;
	transform: skew(-9deg);
	position: relative;
	z-index: 1;
	transition: width 0.5s;
	&:after {
		content: "";
		width: 50%;
		height: 100%;
		position: absolute;
		background: #999;
		top: 0;
		right: 0;
		transform: skew(9deg);
		z-index: -1;
	}
}
.content {
	transform: skew(9deg);
	padding: 20px;
	color: #fff;
	text-align: center;
}
</style>
	<div class="main">
		<div class="container">
			<div class="section-one">
				<div class="content">
					Map
				</div>
			</div>
			<div class="section-two">
				<div class="content">
					White paper
				</div>
			</div>
		</div>
		<script>
		$('.section-one').hover(function() {
			$('.container').addClass('one-is-active');
		});

		$('.section-two').hover(function() {
			$('.container').addClass('two-is-active');
		});

		$('.scroll').click(function() {
			$('html, body').animate({
				scrollTop: $(".container").offset().top
			}, 800);
		});
		</script>
		<div class="row" style="padding:30px" id="choose">
			<div class="col-lg-5" id="pick1">
				<i class="fa fa-edit" style="font-size:120px"></i>
				<br>
				<button type="button" class="btn btn-primary" onclick="show_exist()">Pick from existing Sales Order</button>
				<br><br>
				<p>Choose a sales order to create a delivery order</p>
				<p>and the default settings has already been installed automatically</p>
			</div>
			<div class="col-lg-5 offset-lg-1" id="pick2">
				<i class="fa fa-pencil" style="font-size:120px"></i>
				<br>
				<a href="random_delivery_order_dashboard.php" class="btn btn-danger">Create random delivery order</a>
				<br><br>
				<p>Cases which there is <b>no sales order available</b></p>
				<p>Input every data manually, there are no settings installed</p>
			</div>
		</div>
		<form id="exist_form" style="display:none" action="do_exist_dasboard.php" method="POST">
			<div class="row">
				<div class="col-lg-4 offset-lg-4">
					<label>Insert Sales Order number</label>
					<input type="text" class="form-control" name="so_id" id="so_id">
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-lg-6 offset-lg-3">
					<button class="btn btn-success" type="submit">Next</button>
					<button class="btn btn-primary" type="button" onclick="go_back()">Back</button>
				</div>
			</div>
		</form>
	</div>
</body>
<script>
function show_exist(){
	$('#choose').fadeOut( "10", function() {
		$('#exist_form').fadeIn( "slow", function() {
		});	
	});
};
function go_back(){
	$('#exist_form').fadeOut('300', function() {
		$('#choose').fadeIn( "slow", function() {
		});
	});
};
</script>