<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Shopping Cart</title>
</head>
<body>

<?php 

	echo '<pre>';

	// Show the contents of the cart
	print_r( $_SESSION['cart']);
	
	echo '</pre>';
 ?>