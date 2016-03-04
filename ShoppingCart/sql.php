<?php
// set_time_limit ( 0 );
function sql_read($sql) {
	$time = microtime ();
	$conn = connect ();
	// echo microtime()-$time . "\n";
	$result = $conn->query ( $sql );
	// echo microtime()-$time . "\n";	
	$result = $result->fetch_all ( MYSQLI_BOTH );
	// echo microtime()-$time . "\n";	
	$conn->close ();
	// print_r($result);
	// echo microtime()-$time . "\n";
	
	return $result;
}
function sql_write($sql) {
	$time = microtime ();
	$conn = connect ();
	// echo microtime()-$time . "\n";
	$result = $conn->query ( $sql );
	// echo microtime()-$time . "\n";
	$conn->close ();
	// echo microtime()-$time . "\n";	
	return $result;
}
function connect() {
	$conn = new mysqli ( '127.0.0.1', '#user#', '#pw#', '#database#' );
	return $conn;
}
?>