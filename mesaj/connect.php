<?php 
	$host = "localhost";
	$username = "root";
	$password = "";
	$db = "db";

	$conn = mysqli_connect($host, $username, $password, $db);
	if (mysqli_connect_errno() > 0) {
		die("Hata: ". mysqli_connect_errno());
	}
 ?>