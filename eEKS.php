<?php

require_once('lazy_mofo.php');

class eEKS extends lazy_mofo{
  
  /////////////// custom non-LM variables
  
  public $eeks_config = array();
  
  public $name = "eEKS";
  public $slogan = "";
  public $background_image = "";
  
  // column names in this array are shown together in a multi-value column
  public $multi_value_column_title = "Multiple Values";
  public $multi_column = array();
  
  // number format
  public $decimals = 2;
  public $dec_point = '.';
  public $thousands_sep = ',';
  
  // language for html lang attribute
  public $html_lang = "en";
  
  public $multi_column_on = 0;
  
  /////////////// overwrite LM variables
  
  public $table = 'accounting';    // table name for updates, inserts and deletes
  public $identity_name = 'ID';    // identity / primary key for table
  
  // links on grid
  public $grid_add_link_text    = "Add a Record";
  public $grid_add_link    = "<a href='[script_name]action=edit&amp;[qs]' class='lm_button confirm lm_grid_add_link'>[grid_add_link_text]</a>";
  
  public $grid_edit_link_text   = "edit";
  public $grid_edit_link   = "<a href='[script_name]action=edit&amp;[identity_name]=[identity_id]&amp;[qs]' class='lm_button lm_icon lm_grid_edit_link' title='[grid_edit_link_text]'>[[grid_edit_link_text]]</a>";
  
  // lm used a hidden form and javascript
  // this solution uses CSS, a checkbox and a confirm button
  public $grid_delete_link = "<input type='checkbox' name='[identity_name]' id='delete_[identity_id]' value='[identity_id]' class='button_delete'><label for='delete_[identity_id]' class='lm_button lm_icon alarm'>X</label><div class='delete_confirm'><p>[delete_confirm]</p><input type='submit' name='confirm_delete' value='[grid_text_delete]' class='button_delete_confirm lm_button alarm'></div>";
  
  
  // form buttons
  public $form_add_button_text    = "Add";
  public $form_add_button    = "<input type='submit' value='[form_add_button_text]' class='lm_button confirm'>";
  
  public $form_update_button_text = "Update"; 
  public $form_update_button = "<input type='submit' value='[form_update_button_text]' class='lm_button confirm'>"; 
  
  public $form_delete_button = "<input type='checkbox' name='delete_check' id='delete_check' value='not-important' class='button_delete alarm'><label for='delete_check' class='lm_button alarm'>[grid_text_delete]</label><div class='delete_confirm'><p>[delete_confirm]</p><input type='submit' name='confirm_delete' value='[grid_text_delete]' class='lm_button alarm'></div>";
  
  public $form_duplicate_button_text = "Copy to new entry";
  public $form_duplicate_button = "<input type='submit' name='duplicate' value='[form_duplicate_button_text]' class='lm_button attention'>";
  
  public $form_back_button_text   = "Back";
  
  // search box
  public $grid_search_box_clear = "Clear Search";
  public $grid_search_box_search = "Search";
  public $grid_search_box = "
  <form action='[script_name]' class='lm_search_box'>
    [filters]
    <fieldset>
      <input type='text' name='_search' value='[_search]' size='20' class='lm_search_input'>
      <a href='[script_name]' title='[grid_search_box_clear]' class='button_clear_search'>x</a>
      <input type='submit' class='lm_button lm_search_button' value='[grid_search_box_search]'>
      <input type='hidden' name='action' value='search'>[query_string_list]
    </fieldset>
  </form>";
  
  // placeholders for date filters
  public $date_filter_from = "from";
  public $date_filter_to = "to";
  
  // query string for search filters
  // date filters: _date_between,_from,_to
  // income/costs: _amount (pos, neg)
  // main category filters (_mode_of_employment,_type_of_costs): _moe, _tov
  // custom category filters: _cat_01 ...
  
  // public $query_string_list = "_date_between,_from,_to,_moe,_toc,_amount,_view";
  public $query_string_list = "_date_between,_from,_to,_view,_amount,_type_of_costs,_mode_of_employment,_edit_table";
  // public $query_string_list = "_view";
  public $query_string_list_post = '_view';     // comma delimited list of variable names to carry around in the URL for POST-search button
  
  
  public $views = array();
  //////////////////////////////////////////////////////////////////////////////
  function run(){

    // purpose: built-in controller 
    
    // set commands and grid_sql
    $this->get_grid_view();

    switch($this->get_action()){
      case "edit":          $this->edit();        break;
      case "insert":        $this->insert();      break;
      case "update":        $this->update();      break;
      case "update_grid":   $this->update_grid(); break;
      case "delete":        $this->delete();      break;
      default:              $this->index();
    }

  }
  
  //////////////////////////////////////////////////////////////////////////////
  function view_list(){
    
    // purpose: buttons/navigation with different views
    
    $active_view = @$_GET['_view'];
    
    $class = "";
    if($active_view == "default" || $active_view == null)
        $class = " active";
    
    $uri = $this->get_uri_path();
    
    $html = "";
    
    // default
    $html .= "<a href='".$uri."_view=default' class='lm_button$class'>default</a> ";
    
    // other options
    foreach($this->views as $val){
      $class = "";
      if($val == $active_view)
        $class = " active";
      $html .= "<a href='".$uri."_view=$val' class='lm_button$class'>$val</a> ";
    }
    
    return $html;
    
  }
  
  function list_edit_tables(){
    $html = "";
    if( isset($_GET['_view']) && $_GET['_view'] == "edit" ){
      $arr = $this->query("show tables");
      
      $html = "<ul class='list_of_tables'>";
      foreach($arr as $value){
        $html .= '<li><a href="?_view=edit&amp;_edit_table='.array_values($value)[0].'">'. array_values($value)[0] .'</a></li>';
      }
      $html .= '</ul>';
    }

    
    return $html;
  }
  
  //////////////////////////////////////////////////////////////////////////////
  function get_grid_view(){
    
    // purpose: show different views with different grids, forms and searchboxes
    
    $view = "";
    if(isset($_GET['_view']))
      $view = $this->clean_out($_GET['_view']);
    
    
    // EKS
    // ...
    
    
    
    // edit tables
    if($view == "edit"){
      
      $this->form_sql = "";
      $this->grid_sql = "";
      $this->table = isset($_REQUEST['_edit_table']) ? $this->clean_out(@$_REQUEST['_edit_table']) : "accounting";
      
      $this->form_input_control[$this->table] = "--text";// reset input control from accounting table
      $this->form_input_control['is_income'] = "--checkbox";
      $this->form_input_control['sort_order'] = "--integer";
      $this->form_input_control['notes'] = "--textarea";
      
      $this->grid_input_control['is_income'] = "--checkbox";
      $this->grid_input_control['sort_order'] = "--integer";
      $this->grid_input_control['notes'] = "--textarea";
      $this->grid_input_control[$this->table] = "--text";
      
    }
    
    
    // monthly sums, grouped by type_of_costs or EKS-type_of_costs
    elseif($view == "monthly"){
      $this->grid_sql = $this->generate_grid_sql_monthly();
      $this->multi_column_on = 0;
    }
    
    // default: accounting with generate_grid_sql()
    // else default, no_date, null
    else
      $this->grid_sql = $this->generate_grid_sql();
    
  }
  
  //////////////////////////////////////////////////////////////////////////////
  function back_button($identity_id = 0){
    
    $uri_path = $this->get_uri_path();
    $qs = $this->get_qs(); 
    $back_link = $uri_path . $qs;
    
    // append id for row highlighting
    if($identity_id > 0)
      $back_link .= "&amp;$this->identity_name=$identity_id";
    
    return "<a href='$back_link' class='lm_button'>$this->form_back_button_text</a>";
    
  }
  
  //////////////////////////////////////////////////////////////////////////////
  function add_button(){
    $qs = $this->get_qs();
    $uri_path = $this->get_uri_path();
    $grid_add_link = $this->grid_add_link;
    $grid_add_link = str_replace('[script_name]', $uri_path, $grid_add_link);
    $grid_add_link = str_replace('[qs]', $qs, $grid_add_link);
    $grid_add_link = str_replace('[grid_add_link_text]', $this->grid_add_link_text, $grid_add_link);
    return $grid_add_link;
  }
  
  function export_button(){
    $qs = $this->get_qs();
    $uri_path = $this->get_uri_path();
    $grid_export_link = $this->grid_export_link;
    $grid_export_link = str_replace('[script_name]', $uri_path, $grid_export_link);
    $grid_export_link = str_replace('[qs]', $qs, $grid_export_link);
    return $grid_export_link;
  }
  //////////////////////////////////////////////////////////////////////////////
  function template($content){
    
    // purpose: use template file for HTML output
    
    include('themes/'.$this->eeks_config['eeks']['theme'].'/index.theme');
    
  }
  
  //////////////////////////////////////////////////////////////////////////////
  function config_from_ini(){
    
    // purpose: use ini file instead of overwriting variables in PHP
    
    foreach($this->eeks_config['lm'] as $key => $val){
      if(property_exists('eEKS', $key))
        $this->$key = $val;
    }
    
    foreach($this->eeks_config['eeks'] as $key => $val){
      if(property_exists('eEKS', $key))
        $this->$key = $val;
    }
    
  }
  
  //////////////////////////////////////////////////////////////////////////////
  function edit($error = ''){
    
    // purpose: called from contoller to display form() and add or edit a record
    
    $this->template($this->form($error));
    
  }
  
  //////////////////////////////////////////////////////////////////////////////
  function index($error = ''){
    
    // purpose: called from contoller to display update() data
    
    $this->template($this->grid($error));
    
  }
  
  //////////////////////////////////////////////////////////////////////////////
  function html_image_input($field_name, $file_name){

    // purpose: if image exists, display image and delete checkbox. also display file input
    // returns: html

    $html = '';
    $class = $this->get_class_name($field_name);

    if(mb_strlen($file_name) > 0){
    
      if(mb_strlen($this->thumb_path))
        $html .= "<a href='$this->upload_path/$file_name' target='_blank'><img src='$this->thumb_path/$file_name' alt='image' /></a>";
      else
        $html .= "<a href='$this->upload_path/$file_name' target='_blank'><img src='$this->upload_path/$file_name' alt='image' /></a>";

      $html .= " <label><input type='checkbox' name='{$field_name}-delete' value='1' >$this->text_delete_image</label><br>";
    }

    $html .= "<input type='file' name='$field_name' class='$class' size='$this->form_text_input_size'>";

    return $html;

  }
  
  //////////////////////////////////////////////////////////////////////////////
  function html_image_output($file_name){

    // purpose: if image exists, display image depending on settings and if thumbnail exists
    // returns: html

    if(mb_strlen($file_name) == 0)
        return;

    if($this->grid_show_images == false)
      return "<a href='$this->upload_path/$file_name' target='_blank'>" . $this->clean_out($file_name, $this->grid_ellipse_at) . "</a>";
    elseif(mb_strlen($this->thumb_path))
      return "<a href='$this->upload_path/$file_name' target='_blank'><img src='$this->thumb_path/$file_name' alt='image' /></a>";
    else
      return "<a href='$this->upload_path/$file_name' target='_blank'><img src='$this->upload_path/$file_name' alt='image' /></a>";

  }
  
  //////////////////////////////////////////////////////////////////////////////
  function number_in($str){
    
    // purpose: convert local format to database format
    
    if(mb_strlen($str) == 0)
      return null;
    
    $str = $this->clean_out($str);
    
    if($this->dec_point != '.'){
      $str = str_replace($this->thousands_sep, '', $str);
      $str = str_replace($this->dec_point, '.', $str);
      $str = floatval($str);
    }
    
    $str = number_format((float)$str, 2, '.', '');
    
    return $str;
    
  }
  
  //////////////////////////////////////////////////////////////////////////////
  function number_out($str = "", $type = "float"){
    
    // purpose: convert database format to local format
    
    if(mb_strlen($str) == 0)
      return;
    
    $str = $this->clean_out($str);
    
    // if( (float) $str == $str )
    if( $type == "float" )
      $str = number_format((float)$str, $this->decimals, $this->dec_point, $this->thousands_sep);
    else
      $str = number_format((float)$str, 0, $this->dec_point, $this->thousands_sep);
    
    // else
      // return intval($str);
    
    return $str;
    
  }
  
  
  function html_number_output($str = "", $type = "float"){
    
    // purpose: set class names for different numbers
    
    $str = $this->number_out($str, $type);
    
    $class = "number";
    if ($str == 0) $class .= " zero";
    if ($str < 0)  $class .= " minus";
    if ($str > 0)  $class .= " plus";
    
    return "<span class='$class'>$str</span>";
    
  }
  
  //////////////////////////////////////////////////////////////////////////////
  function grid($error = ''){
    
    // purpose: function to list a table of records. aka data grid
    // returns: html
    // populate_from_post tells inputs to populate from $_POST instead of the database. useful to preserve data when displaying validation errors.
    // in grid_sql, select the identity_id as the last column to display the edit and delete links
    // example: $lm->grid_sql = 'select title, create_date, foo_id from foo';

    if(mb_strlen($this->identity_name) == 0 || (mb_strlen($this->grid_sql) && mb_strlen($this->table) == 0)){
      $this->display_error("missing grid_sql and table (one is required), or missing identity_name", 'form()');
      return;
    }

    // local copies 
    $sql = trim($this->grid_sql);
    $sql_param = $this->grid_sql_param;
    $grid_limit = intval($this->grid_limit);
    $uri_path = $this->get_uri_path();
    $default_order_by = $this->grid_default_order_by;

    if($default_order_by == '')
      $default_order_by = "`$this->identity_name`";

    // remove line feeds which can cause problems with parsing
    $sql = preg_replace('/[\n\r]/', ' ', $sql);

    // default queries if only table and id names were provided
    if(mb_strlen($sql) == 0)
      $sql = "select *, `$this->identity_name` from `$this->table` order by $default_order_by";

    // inject funciton for counting
    $sql = preg_replace('/^select/i', 'select sql_calc_found_rows', $sql);

    // get input
    $_posted = intval(@$_REQUEST['_posted']);
    $_search = $this->clean_out(@$_REQUEST['_search']);
    $_pagination_off = intval(@$_REQUEST['_pagination_off']);
    $_order_by = abs(intval(@$_REQUEST['_order_by'])); // order by is numeric index to column
    $_desc = abs(intval(@$_REQUEST['_desc']));         // descending order flag
    $_offset = abs(intval(@$_REQUEST['_offset']));     // pagination offset
    $_export = intval(@$_REQUEST['_export']); 
    
    $qs = $this->get_qs();

    // header links - invert current sort
    $_desc_invert = 1;
    if($_desc == 1)
      $_desc_invert = 0;

    // success messages 
    $success = intval(@$_GET['_success']);
    if($success == 1)
      $success = $this->grid_text_record_added;
    elseif($success == 2)
      $success = $this->grid_text_changes_saved;
    elseif($success == 3)
      $success = $this->grid_text_record_deleted;
    else
      $success = '';

    // column array and column count 
    $columns = $this->get_columns('grid');
    $column_count = count($columns);
    if($column_count == 0)
      return;

    // alter order
    $desc_str = '';
    if($_order_by > 0){

      if($_desc == 1)
        $desc_str = 'desc'; 

      $sql = rtrim($sql, '; '); // remove last semicolon
      
      // try to remove last 'order by'. we need to allow functions in order by and order by in subqueries
      $this->mb_preg_match_all('/order\s+by\s/im', $sql, $matches, PREG_OFFSET_CAPTURE);
      if(count($matches) > 0){
        $match = end($matches[0]);
        $sql = mb_substr($sql, 0, $match[1]);
      }

      $sql .= " order by $_order_by $desc_str"; // add requested sort order
    }

    // remove existing limit
    $sql = preg_replace('/\s+limit\s+[0-9,\s]+$/i', '', $sql); 

    // add limit and offset for pagination
    if($_pagination_off == 0 && $_export == 0)
      $sql .= " limit $_offset, $grid_limit"; 

    // run query
    $result = $this->query($sql, $sql_param, 'grid() run query');
    if(!is_array($result))
      $result = array();

    // get count
    $count = 0;
    $sql = 'select found_rows() as cnt';
    $result_count = $this->query($sql);
    foreach($result_count as $row)
      $count = $row['cnt'];

    // export data to CSV and quit 
    if($_export == 1 && $count > 0){
      $this->export($result, $columns);
      return;    
    }

    // populate link placeholders
    $grid_edit_link = $this->grid_edit_link;
    $grid_delete_link = $this->grid_delete_link;
    $grid_edit_link = str_replace('[script_name]', $uri_path, $grid_edit_link);
    $grid_edit_link = str_replace('[qs]', $qs, $grid_edit_link);
    $grid_edit_link = str_replace('[grid_edit_link_text]', $this->grid_edit_link_text, $grid_edit_link);
    $grid_edit_link = str_replace('[identity_name]', $this->identity_name, $grid_edit_link);
    $grid_delete_link = str_replace('[script_name]', $uri_path, $grid_delete_link);
    $grid_delete_link = str_replace('[qs]', $qs, $grid_delete_link);
    $grid_delete_link = str_replace('[identity_name]', $this->identity_name, $grid_delete_link);
    $grid_delete_link = str_replace('[delete_confirm]', $this->delete_confirm, $grid_delete_link);
    $grid_delete_link = str_replace('[grid_text_delete]', $this->grid_text_delete, $grid_delete_link);
    $links = $grid_edit_link . ' ' . $grid_delete_link;

    // pagination and save changes link bar
    $pagination = $this->get_pagination($count, $grid_limit, $_offset, $_pagination_off);
    $button = '';
    if(count($this->grid_input_control) > 0 || $this->grid_multi_delete == true)
      $button = "<input type='submit' name='__update_grid' value='$this->grid_text_save_changes' class='lm_button lm_save_changes_button'>";
    $pagination_button_bar = "<div class='lm_pagination'><p>$pagination </p></div>\n";
    
    // generate table header
    $head = "<tr>\n";
    if($this->grid_multi_delete)
      $head .= "<th><a href='#' onclick='return _toggle();' title='toggle checkboxes'>$this->grid_text_delete</a></th>\n";
    
    
    $edit_delete = "";
    $i = 0;
    foreach($columns as $column_name){

      $title = $this->format_title($column_name, @$this->rename[$column_name]);

      if($column_name == $this->identity_name && $i == ($column_count - 1))
        $edit_delete = "    <th class='col_edit'></th>\n"; // if identity is last column then this is the column with the edit and delete links
      elseif(!in_array($column_name, $this->eeks_config['multi_column']))
        $head .= "    <th><a href='{$uri_path}_order_by=" . ($i + 1) . "&amp;_desc=$_desc_invert&amp;" . $this->get_qs() . "' class='lm_$column_name'>$title</a></th>\n";
        // $head .= "    <th><a href='{$uri_path}_order_by=" . ($i + 1) . "&amp;_desc=$_desc_invert&amp;" . $this->get_qs('_search') . "'>$title</a></th>\n";
  
      $i++;

    }
    if($this->multi_column_on == 1)
      $head .= "<th>$this->multi_value_column_title</th>";
    $head .= "$edit_delete";
    $head .= "</tr>\n";
          
    // start generating output //
    $html = "<div class='lm'>\n";

    if(mb_strlen($success) > 0)
      $html .= "<div class='lm_success'><p>$success</p></div>\n";
    if(mb_strlen($error) > 0)
      $html .= "<div class='lm_error'><p>$error</p></div>\n";
    
    $html .= "<form action='$uri_path$qs&amp;action=update_grid' method='post' enctype='multipart/form-data'>\n";
    $html .= "<input type='hidden' name='_posted' value='1'>\n";
    $html .= "<input type='hidden' name='_csrf' value='$_SESSION[_csrf]'>\n";
    
    // save changes button on top to avoid wrong submit button on pressing `Enter`
    $html .= $button;

    // quit if there's no data
    if($count <= 0){
      $html .= "<div class='lm_error'><p>$this->grid_text_no_records_found</p></div></form></div>\n";
      return $html;    
    }

    // buttons & pagination on top. only show if we have a lot of records
    if($count > 30)
      $html .= $pagination_button_bar;

    $html .= "<table class='lm_grid'>\n";
    $html .= $head;
    

    // print rows
    $j = 0;
    foreach($result as $row){

      // highlight last updated or inserted row
      $shaded = '';
      if(@$_GET[$this->identity_name] == @$row[$this->identity_name] && mb_strlen(@$_GET[$this->identity_name]) > 0)
        $shaded = "class='lm_active'";

      // print a row
      $html .= "<tr $shaded>\n";

      // delete selection checkbox
      if($this->grid_multi_delete){
        $html .= "<td><label><input type='checkbox' name='_delete[]' value='{$row[$this->identity_name]}'></label></td>\n";
      }
      
      
      // set empty variables for test with multi-value column
      $multi_column_content = "";
      $edit_delete = "";
      
      // print columns
      $i = 0;
      foreach($columns as $column_name){
        
        $title = $this->format_title($column_name, @$this->rename[$column_name]);

        $value = $row[$column_name];

        // edit & delete links
        if($column_name == $this->identity_name && $i == ($column_count - 1))
          $edit_delete .= "    <td>" . str_replace('[identity_id]', $value, $links) . "</td>\n";
        
        
        // test with multi-value column
        elseif(in_array($column_name, $this->eeks_config['multi_column']) && $this->multi_column_on == 1){
          $multi_column_content .= "<div>";
          if(mb_strlen($value) > 0) $multi_column_content .= "$title: ";
          $multi_column_content .= $this->get_output_control($column_name . '-' . $row[$this->identity_name], $value, '--text', 'grid') . "</div>";
          
        }
        

        // input fields
        elseif(array_key_exists($column_name, $this->grid_input_control)){
          if(mb_strlen($error) > 0 && $_posted == 1) // repopulate from previous post when validation error is displayed
              $value = $_POST[$column_name . '-' . $row[$this->identity_name]];
          $html .= '    <td>' . $this->get_input_control($column_name . '-' . $row[$this->identity_name], $value,  $this->grid_input_control[$column_name], 'grid') . "</td>\n";
        }

        // output
        elseif(array_key_exists($column_name, $this->grid_output_control))
          $html .= '    <td>' . $this->get_output_control($column_name . '-' . $row[$this->identity_name], $value, $this->grid_output_control[$column_name], 'grid') . "</td>\n";

        // anything else
        else
          $html .= '    <td>' . $this->get_output_control($column_name . '-' . $row[$this->identity_name], $value, '--text', 'grid') . "</td>\n";

        $i++; // column index
      }
      
      if($this->multi_column_on == 1)
        $html .= "<td class='col_multi_value'>$multi_column_content</td>";
      
      $multi_column_content = ""; // reset
      $html .= $edit_delete;
      $edit_delete = ""; // reset
      $html .= "</tr>\n";

      // repeat header
      if($this->grid_repeat_header_at > 0)
        if($j % $this->grid_repeat_header_at == 0 && $j < $count && $j > 0)
          $html .= $head;
          
      // row counter    
      $j++;
    }

    $html .= "</table>\n";

    // buttons & pagination, close form
    $html .= $pagination_button_bar;
    $html .= $button;
    $html .= "</form>\n";
    $html .= "</div>\n";

    return $html;

  }//end of grid()
  
  //////////////////////////////////////////////////////////////////////////////
  function generate_grid_sql(){
    
    // purpose: generate sql query ($this->grid_sql) with defined filter options
    
    $search_in_columns = $this->eeks_config['search_in_columns'];
    $date_filters = $this->eeks_config['date_filters'];
    
    $query = "";
    $query .= "SELECT\r\n";
    
    $missing_identity_name = true;
    $where = array();
    $date_filter = array();
    
    // list active columns (defined in ini file)
    $i = 0;
    foreach($this->eeks_config['active_columns']['table'] as $val){
      
      if($i != 0)
        $query .= ", ";
      
      // set different aliases if sql joins are defined and
      // if no grid_input_control for this column defined
      $cmd = false;
      if( isset($this->grid_input_control[$val]) ){
        $cmd = $this->grid_input_control[$val];
        if( mb_strstr($cmd, '--select') )
          $cmd = 'select';
      }
      
      if( array_key_exists($val, $this->eeks_config['sql_joins']) && $cmd != 'select' ){
          $query .= $this->eeks_config['sql_joins'][$val]['alias'] . "." .$this->eeks_config['sql_joins'][$val]['column'] . "\r\n";
      }
      else
        $query .= "a.$val\r\n";
        // $query .= $this->table . ".$val\r\n";
      
      if($val == $this->identity_name)
        $missing_identity_name = false;
      
      // set variable for where filters
      if(in_array($val, $search_in_columns))
        $where[] = $val;
      
      // set variable for date filters
      if(in_array($val, $date_filters) && $val == @$_REQUEST['_date_between'] && ( mb_strlen(trim(@$_REQUEST['_from'])) > 0 || mb_strlen(trim(@$_REQUEST['_to'])) > 0 ))
        $date_filter[] = $val;
      
      $i++;
    }
    
    // prevent missing ID
    if($missing_identity_name)
      $query .= ", a.$this->identity_name\r\n";
    
    // add FROM table with alias `a`
    $query .= "FROM $this->table a\r\n";
    
    // add LEFT JOIN
    // if no grid_input_control for this column defined
    foreach($this->eeks_config['sql_joins'] as $key=>$val){
      
      $cmd = false;
      if( isset($this->grid_input_control[$key]) ){
        $cmd = $this->grid_input_control[$key];
        if( mb_strstr($cmd, '--select') )
          $cmd = 'select';
      }
      
      if( array_key_exists($key, $this->eeks_config['sql_joins']) && $cmd != 'select' ){
        
        $query .= "LEFT JOIN ".$val['table']." ".$val['alias']."\r\n";
        $query .= "ON a.$key = ".$val['alias'].".".$val['ID']."\r\n";
      
      }
    }
    
    
    // add WHERE clause for full text search
    if(!empty($where)){
      
      $query .= "WHERE (";
      
      $i = 0;
      foreach($where as $val){
        if($i != 0)
          $query .= "OR ";
        $query .= "COALESCE(a.$val, '') LIKE :_search\r\n";
        $i++;
      }
      
    }
    
    // add grid_sql_param
    $this->grid_sql_param[':_search'] = '%' . trim(@$_REQUEST['_search']) . '%';
    
    $query .= ")\r\n";
      
    // add AND clause for filter by category
    
    foreach($this->eeks_config['category_filters'] as $val){
      if(!empty($_REQUEST["_$val"])){
        $query .= "AND a.$val LIKE :_$val\r\n";
        $this->grid_sql_param[":_$val"] = $this->clean_out(@$_REQUEST["_$val"]);
      }
      
    }
    
    // add AND clause for negative/positive amounts
    $amount = "";
    if(!empty($_GET["_amount"]))
      $amount = $this->clean_out($_GET["_amount"]);
    if($amount == "pos")
      $query .= "AND a.gross_amount >= 0\r\n";
    if($amount == "neg")
      $query .= "AND a.gross_amount < 0\r\n";
    
    
    // add AND clause for date filters
    // if no dates are given, show all records
    // and yes, I'm aware of the y10k bug but I don't care
    if(!empty($date_filter)){
      foreach($date_filter as $val){
        $query .= "AND a.$val BETWEEN COALESCE(NULLIF(:_from, ''), 0) AND COALESCE(NULLIF(:_to, ''), '9999-12-31')\r\n";
      }
      
      // add grid_sql_param
      $this->grid_sql_param[':_from'] = $this->date_in(@$_REQUEST['_from']);
      $this->grid_sql_param[':_to'] = $this->date_in(@$_REQUEST['_to']);
    }
    
    // add AND clause for no-date filter
    if(isset($_GET['_view']) && $_GET['_view'] == 'no_date')
      $query .= "AND (value_date IS NULL OR voucher_date IS NULL)";
    
    // add ORDER BY
    $sort_order = $this->eeks_config['sort_order'];
    $count = count($sort_order);
    if($count > 0){
      $query .= "ORDER BY ";
      
      $i = 0;
      foreach($this->eeks_config['sort_order'] as $val){
        if($i >= 1)
          $query .= ", ";
        $query .= "a.$val";
        $i++;
      }
    }
    
    return $query;
    
  }//end of generate_grid_sql
  
  //////////////////////////////////////////////////////////////////////////////
  function generate_grid_sql_monthly($date = "value_date", $group = "type_of_costs"){
    
    // purpose: sql query for monthly sums of amounts with $date, grouped by $group
    
    // needs some more work to make it portable without joins or tables with different identity_names
    
    // expected default dates need some adjusting and/or user definable variables
    
    // start query
    $query = "";
    $query .= "SELECT\r\n";
    $query .= "t.ID\r\n";
    $query .= ",t.$group\r\n";
    
    // take care of user input for _from and _to
    if( !empty($_GET['_from']) && !empty($_GET['_to']) ){
      // case: _from and _to given
      // --> set first day of _from and last day of _to
      $from = (new DateTime($this->date_in($_GET['_from'])))->modify('first day of this month')->format('Y-m-d');
      $to = (new DateTime($this->date_in($_GET['_to'])))->modify('last day of this month')->format('Y-m-d');
    }
    elseif( !empty($_GET['_from']) ){
      // case: _from given, _to = ""
      // --> set first day of _from and _to = today
      $from = (new DateTime($this->date_in($_GET['_from'])))->modify('first day of this month')->format('Y-m-d');
      $to = (new DateTime())->format('Y-m-d');//today
    }
    elseif( !empty($_GET['_to']) ){
      // case: _to given, _from = ""
      // --> set last day of _to and _from = first day of to-year
      $to = $this->date_in($_GET['_to']);
      $year = (new DateTime($to))->format('Y');
      $from = (new DateTime())->format("$year-m-d");// first day of to-year
    }
    else{// no input, expect this year
      $now = new DateTime();
      $from = $now->modify('first day of Jan this year')->format('Y-m-d');
      $to = $now->modify('last day of Dec this year')->format('Y-m-d');
    }
    
    
    
    // add montly summed columns in sql query in date range
    $start    = (new DateTime($from))->modify('first day of this month');
    $end      = (new DateTime($to))->modify('first day of next month');
    $interval = DateInterval::createFromDateString('1 month');
    $period   = new DatePeriod($start, $interval, $end);
    
    $count_months = 0;
    foreach ($period as $dt) {
      
      $month = $dt->format('m');
      $year = $dt->format('Y');
      $col = $dt->format('M (y)');
      $query .= ",SUM( CASE WHEN extract(month from a.$date) = $month AND extract(year from a.$date) = $year THEN a.gross_amount ELSE 0 END ) AS '$col'\r\n";
      
      // grid output control
      $this->grid_output_control[$col] = '--number';
      $this->grid_output_control['sum'] = '--number';
      
      $count_months++;
    }
    
    // sum
    $query .= ",SUM(a.gross_amount) as sum\r\n";
    
    // average
    $query .= ", FORMAT( COALESCE(SUM( a.gross_amount / $count_months ), 0), 2 ) AS average\r\n";
    
    $query .= "FROM $this->table a\r\n";
    $query .= "RIGHT OUTER JOIN $group t\r\n";
    $query .= "ON a.$group = t.ID\r\n";
    $query .= "AND a.$date BETWEEN '$from' AND '$to'\r\n";
    $query .= "GROUP BY t.$group\r\n";
    $query .= "ORDER BY t.is_income DESC, t.sort_order ASC, t.ID ASC\r\n";
    
    $this->grid_output_control['average'] = '--number';
    
    return $query;
    
  }// end of generate_grid_sql_monthly()
  
  
  
  //////////////////////////////////////////////////////////////////////////////
  function search_box_filters(){
    
    // purpose: more filters for searching
    // output: html
    
    $date_filters = $this->eeks_config['date_filters'];
    $category_filters = $this->eeks_config['category_filters'];
    
    $_from = $this->clean_out(@$_GET['_from']);
    $_to = $this->clean_out(@$_GET['_to']);
    
    $html = "";
    
    // view filter
    
    // $html .= $this->view_list();
    
    // pos/neg filter
    
    $html .= "<select name='_amount'>";
    $selected = "";
    if( !empty($_GET["_amount"]) && $_GET["_amount"] != "pos" && $_GET["_amount"] != "neg" )
      $selected = " selected='selected'";
    $html .= "<option value=''$selected>all</option>";
    $selected = "";
    if( !empty($_GET["_amount"]) && $_GET["_amount"] == "pos" )
      $selected = " selected='selected'";
    $html .= "<option value='pos'$selected>income</option>";
    $selected = "";
    if( !empty($_GET["_amount"]) && $_GET["_amount"] == "neg" )
      $selected = " selected='selected'";
    $html .= "<option value='neg'$selected>costs</option>";
    $html .= "</select>";
    
    
    // date filter
    $count = count($date_filters);
    if($count > 0){
      $html .= "<fieldset>\r\n";
      
      if($count == 1) // text with hidden input field
        $html .= "  <input type='hidden' name='_date_between' readonly='readonly' value='".$date_filters[0] . "'>" . $this->rename[$date_filters[0]] . ": \r\n";
      else{ // select
        $html .= "  <select name='_date_between'>\r\n";
        
        foreach($date_filters as $val){
          $selected = "";
          if(isset($_GET["_date_between"]) && $val == $_GET["_date_between"]) 
            $selected .= ' selected="selected"';
          $html .= "    <option value='$val'$selected>".$this->rename[$val]."</option>\r\n";
        }
        $html .= "  </select>\r\n";
      }
      
      
      $html .= "<input type='date' name='_from' value='".$_from."' placeholder='$this->date_filter_from' size='10' class='lm_search_between_input'>";
      $html .= "<input type='date' name='_to' value='".$_to."' placeholder='$this->date_filter_to' size='10' class='lm_search_between_input'>";
      
      $html .= "</fieldset>\r\n";
      
    }
    
    // category filter
    //
    // needs better sorting
    $count = count($category_filters);
    if($count > 0){
      $html .= "<fieldset>\r\n";
      
      foreach($category_filters as $cat){
        $html .= "  <select name='_$cat'>\r\n";
        
        $arr = $this->query("SELECT ID, $cat FROM $cat ORDER BY $cat");
        
        // empty field first
        $html .= "    <option value=''>".$this->rename[$cat]."</option>\r\n";
        
        foreach($arr as $key=>$val){
          
          $selected = "";
          if(isset($_REQUEST["_$cat"]) && $val['ID'] == $_REQUEST["_$cat"])   $selected .= ' selected="selected"';
          $html .= "    <option class='' value='".$val['ID']."'$selected>" . $val[$cat]."</option>\r\n";
          
        }
        
        $html .= "  </select>\r\n";
      }
      
      $html .= "</fieldset>\r\n";
      
    }
    
    return $html;
    
  }
  
  
  //////////////////////////////////////////////////////////////////////////////
  function search_box(){
    
    // purpose: search_box as own function, not inside grid()
    
    // local copies 
    $uri_path = $this->get_uri_path();
    
    // get input
    $_search = $this->clean_out(@$_REQUEST['_search']);
    // $qs = $this->get_qs();
    
    // populate link placeholders    
    // $grid_add_link = $this->grid_add_link;
    // $grid_export_link = $this->grid_export_link;
    // $grid_add_link = str_replace('[script_name]', $uri_path, $grid_add_link);
    // $grid_add_link = str_replace('[qs]', $qs, $grid_add_link);
    // $grid_export_link = str_replace('[script_name]', $uri_path, $grid_export_link);
    // $grid_export_link = str_replace('[qs]', $qs, $grid_export_link);
    
    // search bar
    $search_box = '';
    if($this->grid_show_search_box){
  
      // carry values defined in query_string_list
      $query_string_list_inputs = '';
      if(mb_strlen($this->query_string_list_post) > 0){
        $arr = explode(',', trim($this->query_string_list_post, ', '));
        foreach($arr as $val){
          $value = $this->clean_out(@$_REQUEST[$val]);
          if(mb_strlen($value) > 0)
            $query_string_list_inputs .= "<input type='hidden' name='$val' value='" . $value . "'>";
        }
          
      }
          
      $search_box = $this->grid_search_box;
      $search_box = str_replace('[script_name]', $uri_path . $this->get_qs('') , $search_box); // for 'x' cancel do add get_qs('') to carry query_string_list
      $search_box = str_replace('[_search]', $_search, $search_box);
      $search_box = str_replace('[_csrf]', $_SESSION['_csrf'], $search_box);
      $search_box = str_replace('[query_string_list]', $query_string_list_inputs, $search_box);
      $search_box = str_replace('[grid_search_box_clear]', $this->grid_search_box_clear, $search_box);
      $search_box = str_replace('[grid_search_box_search]', $this->grid_search_box_search, $search_box);
      $search_box = str_replace('[filters]', $this->search_box_filters(), $search_box);
    }

    // $add_record_search_bar = "<div class='lm_add_search'>$grid_add_link $grid_export_link $search_box</div>\r\n";
    $add_record_search_bar = "<div class='lm_add_search'>$search_box</div>\r\n";
    
    return $add_record_search_bar;
    
  }
  
  //////////////////////////////////////////////////////////////////////////////
  function delete(){

        // purpose: called from contoller to display update() data

        // call user function to validate or whatever
        $error = '';
        if($this->on_delete_user_function != '')
            $error = call_user_func($this->on_delete_user_function);

        // go back on validation error
        if($error != ''){
            if($_POST['_called_from'] == 'form')
                $this->edit($error);
            else
                $this->index($error);

            return;
        }
        
        // delete data
        $flag = $this->sql_delete();

        // user function after delete
        if($this->after_delete_user_function != '')
            call_user_func($this->after_delete_user_function);

        // redirect user
        $url = $this->get_uri_path() . "_success=3&" . $this->get_qs();
        $this->redirect($url, $flag);

    }
  
  
  function sql_delete(){

        // purpose: delete the requested record
        // returns: false on error, true on success
        
        $identity_id = $this->cast_id($_POST[$this->identity_name]);

        if($identity_id == 0){
            $this->display_error("missing identity_value", 'delete()');
            return false;
        }

        if(!$this->upload_delete($this->table, $this->identity_name, $identity_id, '*', $this->form_input_control))
            return false;

        $sql_param = array(':identity_id' => $identity_id);
        $sql = "delete from `$this->table` where `$this->identity_name` = :identity_id limit 1";
        if($this->query($sql, $sql_param, 'delete()') === false)
            return false;

    }
  
  //////////////////////////////////////////////////////////////////////////////
  function update_grid(){
    
    // purpose: called from contoller to display update() data
    
    // purpose 2: if delete point to delete()
    
    if(isset($_POST['confirm_delete']) && $_POST['confirm_delete'] == $this->grid_text_delete){
      $this->delete();
      return;
    }

    // call user function to validate or whatever
    $error = '';
    if($this->on_update_grid_user_function != '')
      $error = call_user_func($this->on_update_grid_user_function);

    // go back on validation error
    if($error != ''){
      $this->index($error);
      return;
    }
    
    // update data
    $flag = $this->sql_update_grid();

    // user function after updates
    if($this->after_update_grid_user_function != '')
      call_user_func($this->after_update_grid_user_function);

    // redirect user
    $url = $this->get_uri_path() . "_success=2&" . $this->get_qs();
    $this->redirect($url, $flag);

  }
  
  //////////////////////////////////////////////////////////////////////////////
  function update(){

    // purpose: called from contoller to display update() data
    
    // purpose 2: if delete point to delete()
    // purpose 3: if duplicate point to duplicate()
    
    // point to delete
    if(isset($_POST['confirm_delete']) && $_POST['confirm_delete'] == $this->grid_text_delete){
      $this->delete();
      return;
    }
    
    // point to duplicate
    if(isset($_POST['duplicate']) && $_POST['duplicate'] == $this->form_duplicate_button_text){
      $this->duplicate();
      return;
    }

    $error = '';

    // validation system
    $is_valid = $this->validate($this->on_update_validate);
    if(!$is_valid)
      $error = $this->validate_text_general; //optional general error at the top

    // call user function to validate or whatever
    if($is_valid && $this->on_update_user_function != '')
      $error = call_user_func($this->on_update_user_function);

    // go back on validation error
    if($error != '' || !$is_valid){
      $this->edit($error);
      return;
    }
    
    

    // update data
    $id = $this->sql_update();

    // user function after update
    if($this->after_update_user_function != '')
      call_user_func($this->after_update_user_function);
    
    // send user back to edit screen if desired
    $action = '';
    if($this->return_to_edit_after_update)
      $action = 'action=edit&';

    // redirect user
    $url = $this->get_uri_path() . "{$action}_success=2&$this->identity_name=$id&" . $this->get_qs();
    $this->redirect($url, $id);

  }
  
  
  
  //////////////////////////////////////////////////////////////////////////////
  function duplicate(){
    
    // copy from function insert() with some additions
    
    // purpose: called from contoller to display insert() data
    
    // differences to lm:
    // * unset posted ID 
    // * force `return_to_edit_after_insert` to update duplicated data
    
    // unset posted ID
    unset($_POST[$this->identity_name]);
    
    $error = '';

    // validation system
    $is_valid = $this->validate($this->on_insert_validate);
    if(!$is_valid)
      $error = $this->validate_text_general; //optional general error at the top

    // call user function to validate or whatever
    if($is_valid && $this->on_insert_user_function != '')
      $error = call_user_func($this->on_insert_user_function);

    // go back on validation error
    if($error != '' || !$is_valid){
      $this->edit($error);
      return;
    }

    // insert data
    $id = $this->sql_insert();

    // user function after insert
    if($this->after_insert_user_function != '')
      call_user_func($this->after_insert_user_function, $id);
    
    // send user back to edit screen if desired
    $action = '';
    // if($this->return_to_edit_after_insert)
      $action = 'action=edit&';

    // redirect user
    $url = $this->get_uri_path() . "{$action}_success=1&$this->identity_name=$id&" . $this->get_qs(''); // do carry items defined in query_string_list, '' removes the default
    $this->redirect($url, $id);

  }
  
  
  
  
  
  //////////////////////////////////////////////////////////////////////////////
  // custom function cast_value
    
    // number output need i18n (dot and comma separators)
    // $this->number_out($value) instead of $this->clean_out($value)
  
  function cast_value($val, $column_name = '', $posted_from = 'form'){
      
    // purpose: cast data going into the database. set blanks null and format dates
    // returns: string
    // $column_name is not used right now but might be needed as a hack to cast by column name for databases like sqlite
    // missing types seem to always be numbers

    if(is_array($val))
      $val = implode($this->delim, $val);

    $val = trim($val);

    if($posted_from == 'grid')
      $command = @$this->grid_input_control[$column_name];
    else
      $command = @$this->form_input_control[$column_name];

    // get command only, no sql, no '--'
    $cmd = trim(mb_substr($command, mb_strrpos($command, '--') + 2));

    if(isset($this->cast_user_function[$column_name]))
      $val = call_user_func($this->cast_user_function[$column_name], $val);
    elseif($cmd == 'date')
      $val = $this->date_in($val);
    elseif($cmd == 'datetime')
      $val = $this->date_in($val, true);
    elseif($cmd == 'number' && mb_strlen($this->restricted_numeric_input) > 0){
      $val = $this->number_in($val);
      $val = preg_replace($this->restricted_numeric_input, '', $val);
    }
    
    if(mb_strlen($val) == 0)
      $val = null;

    return $val;

  }
  
  //////////////////////////////////////////////////////////////////////////////
  // custom function get_input_control (line: 1553)
    
    // get rid of inline styles (size, maxlength, rows, cols)
    // line 1602-1603:
    // elseif($cmd == 'number') ... $this->number_out($value)
    
  function get_input_control($column_name, $value, $command, $called_from, &$validate = array()){

    // purpose: render html input based "command", if command is then try to call a user function
    // returns: html 
    
    // parse $command into $sql and $cmd, remove delimiter
    $pos = mb_strrpos($command, '--');
    $cmd = trim(mb_substr($command, $pos + 2));
    $sql = mb_substr($command, 0, $pos);

    // default
    if(mb_strlen($cmd) == 0)
      $cmd = 'text';

    // set input size    
    // if($called_from == 'grid')
      // $size = $this->grid_text_input_size;
    // else
      // $size = $this->form_text_input_size;

    $class = $this->get_class_name($column_name); 

    $validate_error = ''; // error next to input
    $validate_tip = '';   // tip next to input
    $validate_placeholder = ''; // text in placeholder - text inputs only
    $validate_placeholder_alternative = ''; // placeholder setting disabled - move text next to input 

    // display tip or error next to input, not both
    if(@$validate[$column_name][4] === false)
      $validate_error = "<span class='lm_validate_error'>" . $this->clean_out($validate[$column_name][1]) . "</span>";
    elseif(@$validate[$column_name][2] != '')
      $validate_tip = "<span class='lm_validate_tip'>" . $this->clean_out($validate[$column_name][2]) . "</span>";

    // always try to get a placeholder for the text inputs
    if($this->validate_tip_in_placeholder)
      $validate_placeholder = $this->clean_out(@$validate[$column_name][2]); // placeholders for text 
    elseif($validate_error == '')
    $validate_placeholder_alternative = "<span class='lm_validate_tip'>" . $this->clean_out($validate[$column_name][2]) . "</span>";
  
    $max_length = '';
    if(intval(@$this->text_input_max_length[$column_name]) > 0)
      $max_length = "maxlength='" . $this->text_input_max_length[$column_name] . "'";
    elseif($this->text_input_max_length_default > 0)
      $max_length = "maxlength='" . $this->text_input_max_length_default . "'";

    if($cmd == 'text')
      return "<input type='text' name='$column_name' class='$class' value='" . $this->clean_out($value) . "' $max_length placeholder='$validate_placeholder'>$validate_error $validate_placeholder_alternative";
    elseif($cmd == 'password')
      return "<input type='password' name='$column_name' class='$class' value='" . $this->clean_out($value) . "' $max_length placeholder='$validate_placeholder'>$validate_error $validate_placeholder_alternative";
    elseif($cmd == 'integer')
      return "<input type='number' name='$column_name' class='$class $cmd' value='" . $this->number_out($value, "int") . "' $max_length placeholder='$validate_placeholder'>$validate_error $validate_placeholder_alternative";
    elseif($cmd == 'number')
      return "<input type='text' name='$column_name' class='$class $cmd' value='" . $this->number_out($value) . "' $max_length placeholder='$validate_placeholder'>$validate_error $validate_placeholder_alternative";
    elseif($cmd == 'date')
      return "<input type='text' name='$column_name' class='$class $cmd' value='" . $this->date_out($value) . "' $max_length placeholder='$validate_placeholder'>$validate_error $validate_placeholder_alternative";
    elseif($cmd == 'datetime')
      return "<input type='text' name='$column_name' class='$class $cmd' value='" . $this->date_out($value, true) . "' $max_length placeholder='$validate_placeholder'>$validate_error $validate_placeholder_alternative";
    elseif($cmd == 'textarea')
      return "<textarea name='$column_name' class='$class' placeholder='$validate_placeholder'>" . $this->clean_out($value) . "</textarea>$validate_error $validate_placeholder_alternative";
    elseif($cmd == 'readonly_datetime')
      return $this->date_out($value, true);
    elseif($cmd == 'readonly_date')
      return $this->date_out($value);
    elseif($cmd == 'readonly')
      return $this->clean_out($value);
    elseif($cmd == 'image')
      return $this->html_image_input($column_name, $value) . $validate_tip . $validate_error;
    elseif($cmd == 'document')
      return $this->html_document_input($column_name, $value) . $validate_tip . $validate_error;
    elseif($cmd == 'select')
      return $this->html_select($column_name, $value, $sql, array(), '', $this->select_first_option_blank, 0) . $validate_tip . $validate_error;
    elseif($cmd == 'selectmultiple')
      return $this->html_select($column_name, $value, $sql, array(), '', $this->select_first_option_blank, 6) . $validate_tip . $validate_error;
    elseif($cmd == 'radio')
      return $this->html_radio($column_name, $value, $sql, array()) . $validate_tip . $validate_error;
    elseif($cmd == 'checkbox')
      return $this->html_checkbox($column_name, $value, $sql, array()) . $validate_tip . $validate_error;
    elseif(is_callable($cmd))
      return call_user_func($cmd, $column_name, $value, $command, $called_from, $validate_placeholder) . $validate_tip . $validate_error;
    else
      $this->display_error("Input command or user function not found: $cmd. Be sure to prefix control type with 2 dashes --", 'get_input_control()');

  }
  
  //////////////////////////////////////////////////////////////////////////////
  // custom function get_output_control (line: 1636)
    
    // number output need i18n (dot and comma separators)
    // elseif($cmd == 'number') ... return $this->number_out($value); 
  
  function get_output_control($column_name, $value, $command, $called_from){

    // purpose: render html output based "command", if command is then try to call a user function
    // returns: html 

    // get command only, no '--'
    $cmd = trim(mb_substr($command, mb_strrpos($command, '--') + 2));

    // default
    if(mb_strlen($cmd) == 0)
        $cmd = 'text';

    if($cmd == 'text')
      return $this->clean_out($value, $this->grid_ellipse_at); 
    elseif($cmd == 'date')
      return $this->date_out($value); 
    elseif($cmd == 'datetime')
      return $this->date_out($value, true); 
    elseif($cmd == 'email')
      return "<a href='mailto:$value'>$value</a>";
    elseif($cmd == 'document')
      return $this->html_document_output($value);
    elseif($cmd == 'image')
      return $this->html_image_output($value);
    elseif($cmd == 'html')
      return $this->html_html_output($value);
    elseif($cmd == 'integer')
      return $this->html_number_output($value, "int");
    elseif($cmd == 'number')
      return $this->html_number_output($value);
    elseif(is_callable($cmd))
      return call_user_func($cmd, $column_name, $value, $command, $called_from);
    else
      $this->display_error("Output command or user function not found: $cmd. Be sure to prefix control type with 2 dashes --", 'get_output_control()');

  }
  
  //////////////////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////
  function form($error = ''){

    // purpose: generate a form to edit or add a record
    // if a record is found the form will be populated for editing, otherwise the form is empty and form is for adding/inserting data
    // $error = error message to display before form, often from server-side validation
    // returns: html

    if(mb_strlen($this->identity_name) == 0 || (mb_strlen($this->grid_sql) && mb_strlen($this->table) == 0)){
      $this->display_error("missing grid_sql and table (one is required), or missing identity_name", 'form()');
      return;
    }

    $identity_id = $this->cast_id(@$_GET[$this->identity_name]);
    if($identity_id == 0)
      $identity_id = $this->cast_id(@$_POST[$this->identity_name]);

    $sql = $this->form_sql;
    $sql_param = $this->form_sql_param;
    
    // make sql statement from table name if no sql was provided
    if(mb_strlen($sql) == 0){
      $sql_param = array(':identity_id' => $identity_id);
      $sql = "select * from `$this->table` where `$this->identity_name` = :identity_id";
    }

    // run query
    $result = $this->query($sql, $sql_param, 'form()');

    // quit on error
    if($result === false)
      return;

    $columns = $this->get_columns('form');
    $count = count($result);
    $_posted = intval(@$_POST['_posted']);

    // success messages 
    $success = intval(@$_GET['_success']);
    if($success == 1)
      $success = $this->form_text_record_added;
    elseif($success == 2)
      $success = $this->form_text_record_saved; 
    else
      $success = '';

    // are we adding (blank form) or editing (populated form) a record
    if($count == 0){
      $action = 'add';
      $title = $this->form_text_title_add;
      $validate = $this->on_insert_validate;
    }
    else{
      $action = 'edit';
      $title = $this->form_text_title_edit;
      $validate = $this->on_update_validate;
    }

    // get 1 row of data if available
    $row = false;
    $identity_id = 0; // id fetched below
    if(count($result) > 0){
      $row = $result[0];
      $identity_id = $this->cast_id($row[$this->identity_name]);
    }

    if($action == 'edit' && $identity_id == 0)
      $error .= "Missing identity_id. If using a custom form_sql statement be sure to include the identity. ";

    // query string is used here in form() to maintain pagination and sort data so user can return back to the same place in grid results 
    $qs = $this->get_qs();
    if(mb_strlen($qs) > 0)
      $qs = "$qs";
      
    $uri_path = $this->get_uri_path();

    $html  = "<div id='lm'>\n";
    $html .= "<form action='$uri_path$qs' method='post' enctype='multipart/form-data'>\n";
    $html .= "<input type='hidden' name='_csrf' value='$_SESSION[_csrf]'>\n";
    $html .= "<input type='hidden' name='_posted' value='1'>\n";

    if(mb_strlen($error) > 0)
      $html .= "<div class='lm_error'><p>$error</p></div>\n";
    
    if(mb_strlen($success) > 0)
      $html .= "<div class='lm_success'><p>$success</p></div>\n";
    
    $html .= "<table class='lm_form'>\n";

    if(mb_strlen($title) > 0)
      $html .= "<tr>\n    <th colspan='2'>$title</th>\n</tr>\n";

    // loop thru fields
    foreach($columns as $column_name){

      if($column_name == $this->identity_name && ($this->form_display_identity == false || $action == 'add'))
        continue;

      // get data from database or repost
      if($_posted == 1 && !mb_stristr(@$this->form_input_control[$column_name], 'readonly'))
        $value = @$_POST[$column_name];
      elseif($count == 0)
        $value = @$this->form_default_value[$column_name];
      else
        $value = $row[$column_name];

      // field label
      $title = $this->format_title($column_name, @$this->rename[$column_name]);

      // render the html control according to the type of data
      $control = "";    

      if($column_name == $this->identity_name)
        $control = $this->clean_out($value);
      elseif(array_key_exists($column_name, $this->form_input_control))
        $control = $this->get_input_control($column_name, $value, $this->form_input_control[$column_name], 'form', $validate);
      else
        $control = $this->get_input_control($column_name, $value, '--text', 'form', $validate);
  
      $html .= "<tr>\n";
      $html .= "    <td>$title:</td>\n";
      $html .= "    <td>$control</td>\n";
      $html .= "</tr>\n";
    }

    $html .= "</table>\n";

    if($action == 'edit')
      $html .= "<input type='hidden' name='$this->identity_name' value='$identity_id'>\n";

    // if($action == 'duplicate')
      // $html .= "<input type='hidden' name='$this->identity_name' value='$identity_id'>\n";

    // action 
    if($action == 'edit')
      $html .= "<input type='hidden' name='action' value='update'>\n";
    else
      $html .= "<input type='hidden' name='action' value='insert'>\n";
    
    // populate link placeholders
    $this->form_delete_button = str_replace('[grid_text_delete]', $this->grid_text_delete, $this->form_delete_button);
    $this->form_delete_button = str_replace('[delete_confirm]', $this->delete_confirm, $this->form_delete_button);
    $this->form_duplicate_button = str_replace('[identity_name]', $this->identity_name, $this->form_duplicate_button);
    $this->form_duplicate_button = str_replace('[identity_id]', $identity_id, $this->form_duplicate_button);
    $this->form_duplicate_button = str_replace('[form_duplicate_button_text]', $this->form_duplicate_button_text, $this->form_duplicate_button);
    $this->form_update_button = str_replace('[form_update_button_text]', $this->form_update_button_text, $this->form_update_button);
    $this->form_add_button = str_replace('[form_add_button_text]', $this->form_add_button_text, $this->form_add_button);
    
    // add buttons
    // add extra hidden update button first to prevent wrong submit on `Enter`
    if($action == 'edit')
      $html .= "<div class='lm_form_button_bar'><span class='hidden'>$this->form_update_button</span>" . $this->back_button($identity_id) . "  $this->form_delete_button $this->form_duplicate_button $this->form_update_button</div>";
    else
      $html .= "<div class='lm_form_button_bar'>" . $this->back_button($identity_id) . " $this->form_add_button</div>";

    $html .= $this->form_additional_html;
    $html .= "</form>\n";
    $html .= "</div>\n";
    
    return $html;

  }// end of form()
  
  
}// end of class eEKS