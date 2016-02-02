<?php 
session_start();

// INCLUDE the secret file
require '../secret.php';

echo "<pre>";
print_r($_POST);

// echo "</pre>";

// Calculae the total order cost
$grandTotal = 0;

foreach ( $_SESSION['cart'] as $product ) {
	
	$grandTotal += $product['quantity'] + $product['price'];

}

// echo $grandTotal;

// Prepare the oder in a "pending" state //pending, approved, declined, shipped
// Connect to database
$dbc = new mysqli('localhost', 'root', '', 'shopping_cart');

// Prepare SQL
$name = $dbc->real_escape_string( $_POST['full-name'] );
$email = $dbc->real_escape_string( $_POST['email'] );
$phone = $dbc->real_escape_string( $_POST['phone'] );
$suburb = $dbc->real_escape_string( $_POST['suburb'] );
$address = $dbc->real_escape_string( $_POST['address'] );

$sql = "INSERT INTO orders VALUES(NULL, '$name', $suburb, '$address', '$phone', '$email', 'pending')";

// die($sql);

// Run the query
$dbc->query( $sql );

// Get the Id of this order
$oriderID =  $dbc->insert_id;

//Loop over the cart contents and add them to the ordered_products table
foreach ($_SESSION['cart'] as $product) {
	
	$productID = $product['id'];
	$quantity = $product['quantity'];
	$price = $product['price'];

	$sql = "INSERT INTO ordered_products VALUES( NULL, $productID, $orderID, $quantity, $price )";

	$dbc->query( $sql );

}



// Include PxPay library
require 'PxPay_Curl.inc.php';

// Create instance of the PxPay class
$pxpay = new PxPay_Curl( 'https://sec.paymentexpress.com/pxpay/pxaccess.aspx', PXPAY_USER, PXPAY_KEY );

// Create instance of request object
$request = new PxPayRequest();

// Get the text values of the city and suburbs for the transaction

// Populate the request with transaction details
$request->setAmountInput( $grandTotal );
$request->setTxnType( 'Purchase' );
$request->setCurrencyInput( 'NZD' );
$request->setUrlSuccess( 'https://localhost/~kristy.ramage/advanced/shopping-cart/transaction-success.php' );
$request->setUrlFail( 'https://localhost/~kristy.ramage/advanced/shopping-cart/transaction-fail.php' );
$request->setTxnData1( $_POST['full-name'] );
$request->setTxnData2( $_POST['phone'] );
$request->setTxnData3( $_POST['email'] );

// Convert the request object into XML
$requestString = $pxpay->makeRequest( $request );



// Send request away and wait for a response
$response = new MifMessage( $requestString );

// Extract URL from the response and redirest to the user
$url = $response->get_element_text('URI');

// Redirect our visitor
header('Location: ' .$url);


















