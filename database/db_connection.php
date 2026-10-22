<?php
/**
 * Single place for database credentials.
 * Local (XAMPP): dhothar_admin | Live: fill in when ready
 */

if (defined('DHOTHAR_DB_LOADED')) {
	return;
}
define('DHOTHAR_DB_LOADED', true);

$http_host = $_SERVER['HTTP_HOST'] ?? 'localhost';

if ($http_host === 'localhost' || $http_host === '127.0.0.1') {
	$db_host = 'localhost';
	$db_user = 'root';
	$db_pass = '';
	$db_name = 'dhothar_admin';
} else {
	// Live credentials — keep empty for now
	$db_host = '';
	$db_user = '';
	$db_pass = '';
	$db_name = '';
}

$con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$con) {
	die('Connection failed: ' . mysqli_connect_error());
}

// One timezone set for the shared connection (avoid per-page repeats)
mysqli_query($con, "SET time_zone = '+05:00'");

require_once __DIR__ . '/count_cache.php';
