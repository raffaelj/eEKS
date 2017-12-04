<?php

$_GET['_missing_date_on'] = 1;
if( empty($_GET['_missing_date']) )
  foreach($this->date_filters as $val)
    $_GET['_missing_date'][] = $val;
$this->grid_sql = $this->generate_grid_sql();