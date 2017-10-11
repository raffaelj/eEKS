<?php

// for development
error_reporting(E_ALL);

// speed things up with gzip plus ob_start() is required for csv export
if(!ob_start('ob_gzhandler'))
	ob_start();

header('Content-Type: text/html; charset=utf-8');

// enter your database host, name, username, and password in
// 'eEKS.db.ini.php.dist' and rename the file to 'eEKS.db.ini.php'
// change the path to '../eEKS.db.ini.php' if you want to
// store your login credentials outside your webroot
$db_config = parse_ini_file('eEKS.db.ini.php');

// user configuration
$eeks_config = parse_ini_file('eEKS.config.ini.php', true);

// include eEKS, lazy_mofo will be included in eEKS.php
include('eEKS.php');

// connect with pdo 
try {
	$dbh = new PDO("mysql:host=".$db_config['host'].";dbname=".$db_config['dbname'].";", $db_config['username'], $db_config['password']);
}
catch(PDOException $e) {
	die('pdo connection error: ' . $e->getMessage());
}

// create LM/eEKS object, pass in PDO connection and i18n code
$ee = new eEKS($dbh, 'de-de');


// table name for updates, inserts and deletes
$ee->table = 'Buchhaltung';           // !!! change to "accounting" after translating the database

// identity / primary key for table
$ee->identity_name = 'ID';

// this part should be in an external template file

$page_title = 'test';
$class = 'test';

echo '<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>' . $page_title . ' - eEKS</title>
  <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
  <link rel="stylesheet" type="text/css" href="css/style.min.css">
</head>
<body class="' . $class . '">
';

// run eEKS/LM
$ee->run();

echo "</body></html>";
// end of template part










?>