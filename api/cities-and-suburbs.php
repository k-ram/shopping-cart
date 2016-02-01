<?php 
	// whitepages has a free database with streets and suburbs to download
	

	//connect to the database
	$dbc = new mysqli('localhost', 'root', '', 'cities_and_suburbs');

	// Filter data
	// ------------------------------ capture and save chosen ciy ID
	$cityID = $dbc->real_escape_string($_GET['city']);

	// Prepare SQL
	$sql = "SELECT suburbId, suburbName FROM suburbs WHERE cityID = $cityID";

	// echo $sql;

	// Run the query and capture the result
	$result = $dbc->query( $sql );

	//extract result
	$suburbs = $result->fetch_all( MYSQLI_ASSOC );

	// print_r($suburbs);

	// Convert data into JSON
	$suburbs = json_encode($suburbs);

	// Prepare the header to say we are about to send JSON, not text
	header('Content-Type: application/json');

	echo $suburbs;