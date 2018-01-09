<?php

// for development
error_reporting(E_ALL);

// speed things up with gzip plus ob_start() is required for csv export
if(!ob_start('ob_gzhandler'))
	ob_start();

header('Content-Type: text/html; charset=utf-8');


//////////////////////////////////////////////////////////////////////////////
function validate_is_income(){
  
  // purpose: check for correct sign of amount in form if type_of_costs is set
  // returns true if is income, else false
  
  global $eeks;
  
  $toc = $eeks->clean_out(@$_POST['type_of_costs']);
  
  if(mb_strlen($toc) == 0) // can't validate without type_of_costs
    return true;
  else{
    $sql = "SELECT ID FROM type_of_costs WHERE ID = $toc AND is_income = true";
    $result = $eeks->query($sql);
    
    $amount = $eeks->clean_out(@$_POST['gross_amount']);
    
    // reimbursements
    $is_reimbursement = false;
    if( $eeks->clean_out(@$_POST['is_reimbursement']) == 1 )
      $is_reimbursement = true;
    
    if( !empty($result) && $amount >= 0 && !$is_reimbursement )
      return true; // is income and has plus sign
    elseif( empty($result) && $amount <= 0 && !$is_reimbursement )
      return true; // is cost and has minus sign
    elseif( !empty($result) && $amount <= 0 && $is_reimbursement )
      return true; // is income, has minus sign, but is reimbursement
    elseif( empty($result) && $amount >= 0 && $is_reimbursement )
      return true; // is cost, has plus sign, but is reimbursement
    else
      return false;
  }
  
}

//////////////////////////////////////////////////////////////////////////////
// function validate_date_format(){
  
  // global $eeks;
  
  
// }

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
$eeks = new eEKS($dbh, '', 'eEKS.config.ini.php');


$eeks->form_sql = "
SELECT
  a.ID
, a.value_date
, a.voucher_date
, a.gross_amount
, a.tax_rate
, a.account
, a.invoice_number
, a.customer_supplier
/* , a.posting_text */
, a.item
, a.type_of_costs
, a.mode_of_employment
, a.scope
, a.project
/* , a.cat_01 */
/* , a.cat_02 */
/* , a.cat_03 */
/* , a.cat_05 */
, a.notes_01
, a.notes_02
/* , a.notes_03 */
/* , a.notes_04 */
/* , a.notes_05 */
, a.file_01
/* , a.file_02 */
/* , a.file_03 */
, a.is_reimbursement
FROM accounting a
WHERE a.ID = :ID
";

$eeks->form_sql_param[":$eeks->identity_name"] = @$_REQUEST[$eeks->identity_name]; 

// may not be here

$eeks->form_input_control['file_01'] = '--image';
$eeks->form_input_control['file_02'] = '--image';
$eeks->form_input_control['file_03'] = '--image';

$eeks->form_input_control['is_reimbursement'] = '--checkbox';

$eeks->form_input_control['type_of_costs'] = 'SELECT ID AS val, type_of_costs AS opt FROM type_of_costs ORDER BY is_income DESC, sort_order ASC, type_of_costs ASC;--select';
$eeks->form_input_control['mode_of_employment'] = 'SELECT ID, mode_of_employment FROM mode_of_employment ORDER BY sort_order ASC, mode_of_employment ASC;--select';
$eeks->form_input_control['scope'] = 'SELECT ID, scope FROM scope ORDER BY sort_order ASC, scope ASC;--select';
$eeks->form_input_control['project'] = 'SELECT ID, project FROM project ORDER BY sort_order ASC, project ASC;--select';
$eeks->form_input_control['account'] = 'SELECT NULL, "nicht angegeben" UNION SELECT "Girokonto", "Girokonto" UNION SELECT "Barkasse", "Barkasse"; --radio';

$eeks->grid_output_control['file_01'] = '--image'; // image clickable
$eeks->grid_output_control['file_02'] = '--image'; // image clickable
$eeks->grid_output_control['file_03'] = '--image'; // image clickable

$eeks->grid_output_control['gross_amount'] = '--number'; // 


$eeks->on_insert_validate['gross_amount'] = array('validate_is_income', 'Only costs have negative signs.', '-0'.$eeks->dec_point.'00');
// copy validation rules to update - same rules
$eeks->on_update_validate = $eeks->on_insert_validate;

// $eeks->grid_input_control['value_date'] = '--date';
// $eeks->grid_input_control['voucher_date'] = '--date';
// $eeks->grid_input_control['gross_amount'] = '--number';
// $eeks->grid_input_control['account'] = 'SELECT NULL, "n.a." UNION SELECT "Girokonto", "Giro" UNION SELECT "Barkasse", "bar"; --radio';
// $eeks->grid_input_control['invoice_number'] = '--text';
// $eeks->grid_input_control['from_to'] = '--text';
// $eeks->grid_input_control['item'] = '--textarea';
// $eeks->grid_input_control['type_of_costs'] = 'SELECT ID AS val, type_of_costs AS opt FROM type_of_costs ORDER BY is_income DESC, sort_order ASC, type_of_costs ASC;--select';
// $eeks->grid_input_control['mode_of_employment'] = 'SELECT ID, mode_of_employment FROM mode_of_employment;--select';
// $eeks->grid_input_control['cat_01'] = '--text';// area of operations
// $eeks->grid_input_control['notes_01'] = '--textarea';
// $eeks->grid_input_control['notes_02'] = '--textarea';

// run eEKS/LM
$eeks->run();

// $eeks->debug($eeks->get_action(),"action");
// $eeks->debug($eeks->inject_rows,"inject_rows");
// $eeks->debug($eeks->view_filter,"view_filter");
// $eeks->debug($eeks->get_qs('_order_by,_desc,_offset,_search,_pagination_off,_view,_lang'));
// $eeks->debug($eeks->get_qs('_view,_lang'));
// $eeks->debug($eeks->config['active_columns'],"columns");
// $eeks->debug($eeks->grid_show_column_sums,"column sums on");
// $eeks->debug($_GET,"GET");
// $eeks->debug($eeks->grid_sql, "sql");
// $eeks->debug($eeks->sum_these_columns, "sum cols", "dump");
// $eeks->debug($eeks->grid_sql_param,"sql param");

?>