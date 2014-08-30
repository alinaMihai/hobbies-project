<?php

define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "mydb");
// 1. Create a database connection
try {
	$connection = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (PDOException $e) {
	print "Error!: " . $e->getMessage() . "<br/>";
	die();
}

function confirm_query($result_set) {
	if (!$result_set) {
		die("Database query failed.");
	}
}

function query($sql, $params, $singleRow = false) {
	global $connection;
	$stmt = $connection->prepare($sql);
	$result_set = $stmt->execute($params);
	confirm_query($result_set);
	if ($singleRow) {
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	else {
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}

?>
