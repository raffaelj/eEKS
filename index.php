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

// user configuration --> could be in function __construct
$ee->eeks_config = parse_ini_file('eEKS.config.ini.php', true);
$ee->config_from_ini();

// automatic generation of grid_sql
// needs some configuration in config file
// $ee->grid_sql = $ee->generate_grid_sql();


$ee->form_sql = "
SELECT
  a.ID
, a.value_date
, a.voucher_date
, a.gross_amount
, a.tax_rate
, a.account
, a.invoice_number
, a.from_to
, a.posting_text
, a.object
, a.type_of_costs
, a.cat_01
, a.cat_02
, a.cat_03
, a.cat_04
/* , a.cat_05 */
, a.notes_01
, a.notes_02
/* , a.notes_03 */
/* , a.notes_04 */
/* , a.notes_05 */
, a.file_01
/* , a.file_02 */
/* , a.file_03 */
FROM accounting a
WHERE a.ID = :ID
";

$ee->form_sql_param[":$ee->identity_name"] = @$_REQUEST[$ee->identity_name]; 

// may not be here

$ee->form_input_control['file_01'] = '--image';
$ee->form_input_control['file_02'] = '--image';
$ee->form_input_control['file_03'] = '--image';

$ee->grid_output_control['file_01'] = '--image'; // image clickable
$ee->grid_output_control['file_02'] = '--image'; // image clickable
$ee->grid_output_control['file_03'] = '--image'; // image clickable

$ee->grid_output_control['gross_amount'] = '--number'; // 

// $ee->grid_input_control['notes_01'] = '--text';

// run eEKS/LM
$ee->run();

echo "<pre><code style='font-size: .7em;'>";
/* print_r($ee->generate_grid_sql()); */
print_r($ee->grid_sql);
echo "\r\n";
print_r($ee->grid_sql_param);
echo "\r\n";
print_r($ee->multi_column_on);
echo "</pre></code>";

?>