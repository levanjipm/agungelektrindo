<?php
	include('tutorial_header.php');
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Tutorial</h2>
	<hr>
	<h3 style='font-family:bebasneue'>Departemen penjualan</h3>
	<p>Departemen penjualan merupakan departemen dalam CV Agung Elektrindo yang berfungsi untuk melayani transaksi penjualan dari CV Agung Elektrindo ke pelanggan.</p>
	<br>
	<table class='table table-bordered'>
		<tr>
			<th style='width:30%'>Nama tugas</th>
			<th style='width:50%'>Deskripsi tugas</th>
			<th style='width:20%'></th>
		</tr>
		<tr>
			<td><p>Penawaran harga (<i><strong>quotation</strong></i>)</p></td>
			<td><p>Secara umum, penawaran harga dibuat untuk menginformasikan harga kepada pelanggan. Informasi tambahan lainnya dapat berupa status stock dan
					keterangan perjanjian pembayaran.</p></td>
			<td>
				<a href='sales_create_quotation'>
					<button type='button' class='button_default_dark'>Go to</button>
				</a>
			</td>
		</tr>
		<tr>
			<td><p>Data pelanggan</p></td>
			<td><p>Menambah pelanggan untuk dapat dibuatkan penawaran harga. Perusahaan yang belum membeli (<i>lead</i>) dan memintakan penawaran harga, 
					perlu dimasukkan ke dalam daftar pelanggan.</p></td>
			<td>
				<a href='sales_create_sales_order'>
					<button type='button' class='button_default_dark'>Go to</button>
				</a>
			</td>
		</tr>
		<tr>
			<td><p>Order pembelian (<i><strong>sales order</strong></i>)</p></td>
			<td><p>Order pembelian dibuat untuk menginformasikan order penjualan ke bagian gudang untuk dikirimkan kepada pelanggan.</p></td>
			<td>
				<a href='sales_create_sales_order'>
					<button type='button' class='button_default_dark'>Go to</button>
				</a>
			</td>
		</tr>
		<tr>
			<td><p>Retur penjualan</p></td>
			<td><p>Retur penjualan dibuat apabila pelanggan berencana mengembalikan barang yang telah dibeli sebelumnya dan telah dikonfirmasi pengirimannya oleh bagian gudang.
					Retur dapat dilakukan dengan beberapa ketentuan yang akan dijelaskan selanjutnya.</p></td>
			<td>
				<a href='sales_create_sales_order'>
					<button type='button' class='button_default_dark'>Go to</button>
				</a>
			</td>
		</tr>
		<tr>
			<td><p>Proyek</p></td>
			<td><p>Proyek merupakan fitur yang dibuat apabila terdapat pesanan yang berbentuk barang jadi seperti panel.</p></td>
			<td>
				<a href='sales_create_sales_order'>
					<button type='button' class='button_default_dark'>Go to</button>
				</a>
			</td>
		</tr>
		<tr>
			<td><p>Sampel</p></td>
			<td><p>Sampel dapat diberikan kepada pelanggan terdaftar dengan beberapa ketentuan yang akan dijelaskan selanjutnya.</p></td>
			<td>
				<a href='sales_create_sales_order'>
					<button type='button' class='button_default_dark'>Go to</button>
				</a>
			</td>
		</tr>
	</table>
	<br>
	<a href='getting_started'>
		<button type='button' class='button_success_dark'>
			Back
		</button>
	</a>
</div>