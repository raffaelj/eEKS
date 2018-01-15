<?php

// set action to avoid default grid configuration
$_POST['action'] = "eks";

// parse profile
if( !empty($_GET['_profile']) ){
  $ini = glob('profiles/*.ini.php')[$_GET['_profile']];
  $this->eks_config = parse_ini_file($ini, true, INI_SCANNER_TYPED);
}
else{
  $this->eks_config = parse_ini_file('profiles/default.ini.php', true, INI_SCANNER_TYPED);
}

// set date range
if( empty($_GET['_from']) or $_GET['_profile'] != $_GET['_last_profile'] ){
  $from = new DateTime( $this->date_in($this->eks_config['eks']['eks_start_date']) );
}
else{
  $from = new DateTime( $this->date_in($_GET['_from']) );
}

// set dates in $_GET
$_GET['_from'] = $from->modify('first day of this month')->format('d.m.Y');
$_GET['_to'] = $from->modify('+ 5 months')->modify('last day of this month')->format('d.m.Y');


// set default mode_of_employment
if( empty($_GET['_mode_of_employment']) )
  $_GET['_mode_of_employment'] = $this->eks_config['eks']['default_mode_of_employment'];

$this->grid_sql = $this->generate_grid_sql_eks();

// reset some grid features
$this->multi_column_on = false;
$this->grid_repeat_header_at = false;
$this->grid_show_column_sums = false; // disable column sums