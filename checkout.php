<?php 

session_start();
	
//include header template
include 'templates/header.template.php';

// Display contents of the cart
include 'templates/cart-contents.template.php';

// Checkout form
include 'templates/checkout-form.template.php';

//include footer template
include 'templates/footer.template.php';