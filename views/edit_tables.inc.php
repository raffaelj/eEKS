<?php

// disable multi-value column
$this->multi_column_on       = false;
$this->grid_show_column_sums = false;

$this->form_sql = "";
$this->grid_sql = "";
$this->table    = isset($_REQUEST['_edit_table']) ? $this->clean_out(@$_REQUEST['_edit_table']) : "accounting";

$this->form_input_control[$this->table] = "--text";// reset input control from accounting table
$this->form_input_control['sort_order'] = "--integer";
$this->form_input_control['notes']      = "--textarea";

$this->grid_input_control['sort_order'] = "--integer";
$this->grid_input_control['notes']      = "--textarea";
$this->grid_input_control[$this->table] = "--text";


////// type_of_costs
if ($this->table == "type_of_costs") {
    $this->form_input_control['is_income'] = "--checkbox";
    // $this->form_input_control['coa_jobcenter_eks_01_2017'] = "--integer";
    $this->form_input_control['coa_jobcenter_eks_01_2017'] = 'SELECT ID AS val, type_of_costs AS opt FROM coa_jobcenter_eks_01_2017 ORDER BY ID ASC;--select';

    $this->grid_input_control['is_income']                 = "--checkbox";
    $this->grid_input_control['coa_jobcenter_eks_01_2017'] = 'SELECT ID AS val, type_of_costs AS opt FROM coa_jobcenter_eks_01_2017 ORDER BY ID ASC;--select';
}
////// coa_jobcenter_eks_01_2017
elseif ($this->table == "coa_jobcenter_eks_01_2017") {
    $this->form_input_control['page']          = "--integer";
    $this->form_input_control['type_of_costs'] = "--text";
}
