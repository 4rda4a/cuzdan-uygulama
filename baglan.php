<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

@ob_start();
date_default_timezone_set('Europe/Istanbul');

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
	exit(' Erişim Engellendi.');
}
;
$db_user = "if0_35176754";
$db_pass = "WqmQLydheiugo";
$db_name = "if0_35176754_ardaanil";
$host_name = "sql207.infinityfree.com";

try {
	$conn = new PDO("mysql:host=$host_name;dbname=$db_name", $db_user, $db_pass);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage();
}
session_start();
$conn->query("SET NAMES utf8");
$conn->query("SET CHARACTER SET utf8");
$conn->query("SET COLLATION_CONNECTION = 'utf8mb4_general_ci'");
function clean($x)
{
	$x = htmlspecialchars($x);
	$x = str_replace("'", "''", $x);
	return $x;
}

function te($string)
{
	$trChars = array('ç', 'ğ', 'ı', 'ö', 'ş', 'ü', 'Ç', 'Ğ', 'İ', 'Ö', 'Ş', 'Ü', '"', "'");
	$enChars = array('c', 'g', 'i', 'o', 's', 'u', 'C', 'G', 'I', 'O', 'S', 'U', ' ', ' ');
	$string = str_replace($trChars, $enChars, $string);

	return $string;
}
?>