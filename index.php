<?php  include'templates/header.template.php'; ?>

<h1>Products</h1>

<?php 

	//Connect to the database
	$dbc = new mysqli('localhost', 'root', '', 'shopping_cart');

	// Get all products from the database
	$sql = "	SELECT id, name, description, price, stock FROM products";

	// Run the query
	$result = $dbc->query( $sql );

	// Loop over the result
	while ( $row = $result->fetch_assoc() ) {
			
		include'templates/product.template.php';
	}
 ?>

<?php  include'templates/footer.template.php'; ?>

