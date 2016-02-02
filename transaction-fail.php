<?php 

session_start();

// Get the result form the address bar
// $result = $_GET['result'];

require 'PxPay_Curl.inc.php';
require '../secret.php';

// Create instance
$pxpay = new PxPay_Curl( 'https://sec.paymentexpress.com/pxpay/pxaccess.aspx', PXPAY_USER, PXPAY_KEY );

// Convert the response into something we can use
$response = $pxpay->getResponse( $_GET['result'] );

// Was the transaction result successful
if ( $response->getSuccess() == 0) {
	
	// Update the databse order to say paid
	echo "<pre>";
	print_r($response);

	// E-mail the client

	// E-mail the website owner
}