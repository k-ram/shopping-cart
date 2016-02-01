<?php 
session_start();
// echo "<pre>";
// print_r($_POST);

// echo "</pre>";

// Calculae the total order cost
$grandTotal = 0;

foreach ( $_SESSION['cart'] as $product ) {
	
	$grandTotal += $product['quantity'] + $product['price'];

}

// echo $grandTotal;

// Prepare the oder in a "pending" state //pending, approved, declined, shipped

// Include PxPay library
require 'PxPay_Curl.inc.php';
