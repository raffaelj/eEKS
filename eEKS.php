<?php

require_once('lazy_mofo.php');

class eEKS extends lazy_mofo{
  
  // custom non-LM variables
  
  public $eeks_config = array();
  
  public $name = "eEKS";
  public $slogan = "";
  
  // overwrite LM variables
  
  public $table = 'accounting';    // table name for updates, inserts and deletes
  public $identity_name = 'ID';    // identity / primary key for table
  // public $image_style = "";
  
  
  function template($content){
    
    // purpose: use template file for HTML output
    // could be nicer but it works
    // $header and $footer are defined in the theme file
    // $ content is the part LM/eEKS generates
    
    include('themes/'.$this->eeks_config['eeks']['theme'].'/index.theme');
    echo $header;
    echo $content;
    echo $footer;
    
  }
  
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
  
  function edit($error = ''){
    
    // purpose: called from contoller to display form() and add or edit a record
    
    $this->template($this->form($error));
    
  }
  
  function index($error = ''){
    
    // purpose: called from contoller to display update() data
    
    $this->template($this->grid($error));
    
  }
  
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
    
    // ...
    
  }
  
  //////////////////////////////////////////////////////////////////////////////
  function number_out($str){
    
    // purpose: convert database format to local format
    
    // ...
    
  }
  
  
  //////////////////////////////////////////////////////////////////////////////
  // custom grid(s)
    
    // get rid of javascript inside code
    // get rid of inline styles (nowrap, align...)
    // position of edit link, export link and searchbox should be defined in template file
    // searchbox shouldn't be a table (easier styling and semantic HTML)
    // possibly extra classes like
    //   * with_rollup (last row bold)
    //   * positive/negative numbers (colors/backgrounds)
    //   * number (text-align:right)
    //   * ...
    // possibly HTML5 data attributes for easier evaluation with javascript
    
    // nice to have:
    // info about column on th:hover (or click?)
    
    
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
      $grid_add_link = $this->grid_add_link;
      $grid_edit_link = $this->grid_edit_link;
      $grid_delete_link = $this->grid_delete_link;
      $grid_export_link = $this->grid_export_link;
      $grid_add_link = str_replace('[script_name]', $uri_path, $grid_add_link);
      $grid_add_link = str_replace('[qs]', $qs, $grid_add_link);
      $grid_edit_link = str_replace('[script_name]', $uri_path, $grid_edit_link);
      $grid_edit_link = str_replace('[qs]', $qs, $grid_edit_link);
      $grid_edit_link = str_replace('[identity_name]', $this->identity_name, $grid_edit_link);
      $grid_delete_link = str_replace('[script_name]', $uri_path, $grid_delete_link);
      $grid_delete_link = str_replace('[qs]', $qs, $grid_delete_link);
      $grid_delete_link = str_replace('[identity_name]', $this->identity_name, $grid_delete_link);
      $grid_export_link = str_replace('[script_name]', $uri_path, $grid_export_link);
      $grid_export_link = str_replace('[qs]', $qs, $grid_export_link);
      $links = $grid_edit_link . ' ' . $grid_delete_link;

      // pagination and save changes link bar
  $pagination = $this->get_pagination($count, $grid_limit, $_offset, $_pagination_off);
      $button = '';
  if(count($this->grid_input_control) > 0 || $this->grid_multi_delete == true)
          $button = "<input type='submit' name='__update_grid' value='$this->grid_text_save_changes' class='lm_button lm_save_changes_button'>";
  $pagination_button_bar = "<table class='lm_pagination'><tr><td>$pagination</td><td>$button</td></tr></table>\n";

      // search bar
      $search_box = '';
  if($this->grid_show_search_box){
  
          // carry values defined in query_string_list
          $query_string_list_inputs = '';
          if(mb_strlen($this->query_string_list) > 0){
              $arr = explode(',', trim($this->query_string_list, ', '));
              foreach($arr as $val)
                  $query_string_list_inputs .= "<input type='hidden' name='$val' value='" . $this->clean_out(@$_REQUEST[$val]) . "'>";
          }
          
          $search_box = $this->grid_search_box;
    $search_box = str_replace('[script_name]', $uri_path . $this->get_qs('') , $search_box); // for 'x' cancel do add get_qs('') to carry query_string_list
    $search_box = str_replace('[_search]', $_search, $search_box);
    $search_box = str_replace('[_csrf]', $_SESSION['_csrf'], $search_box);
    $search_box = str_replace('[query_string_list]', $query_string_list_inputs, $search_box);
      }

  $add_record_search_bar = "<table class='lm_add_search'><tr><td>$grid_add_link &nbsp; $grid_export_link</td><td>$search_box</td></tr></table>\n";

      // generate table header
      $head = "<tr>\n";
      if($this->grid_multi_delete)
          $head .= "<th><a href='#' onclick='return _toggle();' title='toggle checkboxes'>$this->grid_text_delete</a></th>\n";
      
      $i = 0;
      foreach($columns as $column_name){

          $title = $this->format_title($column_name, @$this->rename[$column_name]);

          if($column_name == $this->identity_name && $i == ($column_count - 1))
              $head .= "    <th></th>\n"; // if identity is last column then this is the column with the edit and delete links
          else
              $head .= "    <th><a href='{$uri_path}_order_by=" . ($i + 1) . "&amp;_desc=$_desc_invert&amp;" . $this->get_qs('_search') . "'>$title</a></th>\n";
      
          $i++;

      }
      $head .= "</tr>\n";
          
      // start generating output //
      $html = "<div id='lm'>\n";

      if(mb_strlen($success) > 0)
          $html .= "<div class='lm_success'><b>$success</b></div>\n";
      if(mb_strlen($error) > 0)
          $html .= "<div class='lm_error'><b>$error</b></div>\n";
      
      $html .= $add_record_search_bar;

      $html .= "<form action='$uri_path$qs' method='post' onsubmit='return _update_grid()' enctype='multipart/form-data'>\n";
      $html .= "<input type='hidden' name='_posted' value='1'>\n";
      $html .= "<input type='hidden' name='_csrf' value='$_SESSION[_csrf]'>\n";

      // quit if there's no data
      if($count <= 0){
          $html .= "<div class='lm_error'><b>$this->grid_text_no_records_found</b></div></form></div><!-- close #lm -->\n";
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

          // print columns
          $i = 0;
          foreach($columns as $column_name){

              $value = $row[$column_name];

              // edit & delete links
              if($column_name == $this->identity_name && $i == ($column_count - 1))
                  $html .= "    <td>" . str_replace('[identity_id]', $value, $links) . "</td>\n";

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
      $html .= "</form>\n";
      $html .= "</div><!-- close #lm -->\n";
  $html .= $this->delete_js(0, 'grid');

      return $html;

  }
    
  
  
  //////////////////////////////////////////////////////////////////////////////
  // custom search box
    
    // filter by income/costs
    // filter by value date or voucher date
    // filters by categories
  
  //////////////////////////////////////////////////////////////////////////////
  // filter functions
    
    // see custom search box above
  
  //////////////////////////////////////////////////////////////////////////////
  // custom function cast_value
    
    // number output need i18n (dot and comma separators)
    // $this->number_out($value) instead of $this->clean_out($value)
  
  //////////////////////////////////////////////////////////////////////////////
  // custom function get_input_control (line: 1553)
    
    // get rid of inline styles (size, maxlength, rows, cols)
    // line 1602-1603:
    // elseif($cmd == 'number') ... $this->number_out($value)
  
  //////////////////////////////////////////////////////////////////////////////
  // custom function get_output_control (line: 1636)
    
    // number output need i18n (dot and comma separators)
    // elseif($cmd == 'number') ... return $this->number_out($value); 
  
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
            $html .= "<div class='lm_error'><b>$error</b></div>\n";
        
        if(mb_strlen($success) > 0)
            $html .= "<div class='lm_success'><b>$success</b></div>\n";
        
        $html .= "<table class='lm_form'>\n";

        if(mb_strlen($title) > 0)
            $html .= "<tr>\n    <th>$title</th>\n</tr>\n";

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

        // action 
        if($action == 'edit')
            $html .= "<input type='hidden' name='action' value='update'>\n";
        else
            $html .= "<input type='hidden' name='action' value='insert'>\n";
        
        // add buttons
        if($action == 'edit')
            $html .= "<div class='lm_form_button_bar'>$this->form_back_button $this->form_delete_button $this->form_update_button</div>";
        else
            $html .= "<div class='lm_form_button_bar'>$this->form_back_button $this->form_add_button</div>";

        $html .= $this->form_additional_html;
        $html .= "</form>\n";
        $html .= "</div><!-- close #lm -->\n";
        $html .= $this->delete_js($identity_id, 'form');
        
        return $html;    

    }
  
  
}// end of class eEKS