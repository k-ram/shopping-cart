<?php  
	// Start session
	session_start();

	//Connect to the database
	$dbc = new mysqli('localhost', 'root', '', 'shopping_cart');

	//create a cart if they don't have one already
	if ( !isset( $_SESSION['cart']) ) {
		
		// Create cart
		$_SESSION['cart'] = [];
	}

	// If clear cart is in the get array or address bar
	if ( isset($_GET['clearcart']) ) {
		// Clear cart
		$_SESSION['cart'] = [];

		// Refreash the page
		header('Location: index.php');

	}

	// Did the user submit a form
	if ( isset($_POST['add-to-cart']) ) {
		
		// Find out the price of the product
		$id = $dbc->real_escape_string($_POST['product-id']);

		// Prepare the SQL to find the price of the product
		$sql = "SELECT price FROM products WHERE id = $id";

		// Run the query
		$result = $dbc->query( $sql );

		// Vlaidation goes here
		// Extract data from database object
		$result = $result->fetch_assoc();

		$productFound = false;

		// Loop over the cart and see if this product is added already
		for ($i=0; $i < count($_SESSION['cart']); $i++) { 
			
			// Get the id of the prouct in the cart
			// $i will look at each item in the cart
			$cartItemId = $_SESSION['cart'][$i]['id'];

			// Get the id of the cart being added to the cart
			$addItemId = $_POST['product-id'];

			// If the two IDs match
			if ( $cartItemId == $addItemId ) {
				
				$_SESSION['cart'][$i]['quantity'] += $_POST['quantity'];
				$productFound = true;

			}

		}

		// IF product is not found in the cart
		if ( !$productFound ) {
			
			// Add the item to the cart
			//array_push() is similar to ['cart'][]
			$_SESSION['cart'][] = [
								'id'=>$_POST['product-id'],
								'name'=>$_POST['name'],
								'description'=>$_POST['description'],
								'price'=>$result['price'],
								'quantity'=>$_POST['quantity']
							];

		}
		
	}

	// include header
	include'templates/header.template.php'; ?>

<h1>Products</h1>

<?php 

	// Get all products from the database
	// SELECT * grabs all the columns in that table
  	$sql = "	SELECT id, name, description, price, stock FROM products";

	// Run the query
	$result = $dbc->query( $sql );

	// Loop over the result
	while ( $row = $result->fetch_assoc() ) {
			
		include'templates/product.template.php';
	}
 ?>

<?php  include'templates/footer.template.php'; ?>

