<?php

require_once('lazy_mofo.php');

class eEKS extends lazy_mofo{
  
  /////////////// custom non-LM variables
  
  public $software_name = "eEKS";
  public $slogan = "";
  public $background_image = "";
  
  // column names in this array are shown together in a multi-value column
  public $multi_column_on = false;
  public $multi_value_column_title = "Multiple Values";
  public $multi_column = array();
  
  // number format
  public $decimals = 2;
  public $dec_point = '.';
  public $thousands_sep = ',';
  
  // language for html lang attribute
  public $html_lang = "en";
  
  // contains error message --> must be in template
  public $error = "";
  
  // placeholders for date filters
  public $date_filter_from = "from";
  public $date_filter_to = "to";
  
  // other words that need translation and may appear somewhere
  // example in i18n file: $this->translate['all'] = "alle";
  public $translate = array();
  
  // active views
  // options: missing_date, monthly, edit, eks
  public $views = array();
  
  
  // filter settings for search bar and configurable grid sql
  // Set column names to use for filtering
  // Arrays can contain multiple columns, variables can contain one column name
  public $date_filters = array();       // date range filter(s)
  public $category_filters = array();   // category filters
  public $search_in_columns = array();  // full text search
  public $amount_filter = "";           // positive/negative/all amounts
  
  // display sums of columns in the last row of the grid
  public $grid_show_column_sums = false;
  public $sum_these_columns = array();
  
  // inject rows into grid for column sums, carryovers, additional infos etc.
  public $inject_rows = array();
  
  // rename column headers to nice names instead of original database headers
  public $rename_csv_headers = false;
  
  // folder for pdf creation
  public $pdf_path = "exports";
  
  // for PDF export wkhtmltopdf must be installed
  // you have to define the full path of the wkhtmltopdf executable
  // Example on Uberspace: '/home/$USER/bin/wkhtmltopdf';
  // more info in `docs/install.md` (coming soon)
  public $wkhtmltopdf_path = 'wkhtmltopdf';
  
  // optional configuration via ini file
  public $config = array();
  
  // EKS profile via ini file
  private $eks_config = array();
  
  // public variable to overwrite i18n
  public $i18n = "";
  
  // allow javascript - if enabled scripts are added at bottom of template
  public $allow_javascript = false;
  
  // missing singular if only one record is found
  public $pagination_text_record = "Record";
  
  
  /////////////// overwrite LM variables
  // some of them are new for i18n
  
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
  
  public $grid_export_link_text = "Export CSV";
  public $grid_export_link = "<a href='[script_name]_export=1&amp;[qs]' title='[grid_export_link_text]' class='lm_button grid_export_link'>CSV</a>";
  
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
      <input type='submit' class='lm_button lm_search_button' value='[grid_search_box_search]'>
      <input type='hidden' name='' value=''>[query_string_list]
    </fieldset>
  </form>";
  
  /**
   * query string list for search filters
   * 
   * date filters: _date_between,_from,_to
   * income/costs: _amount (pos, neg)
   * main category filters: _mode_of_employment,_type_of_costs
   * custom category filters: _cat_01... - coming soon
   */
  
  public $query_string_list = "";
  public $query_string_list_post = "";
  
  
  //////////////////////////////////////////////////////////////////////////////
  function __construct($dbh, $i18n = 'en-us', $ini = ''){

    if(!$dbh)
      die('Pass in a PDO object connected to the mysql database.');

    if(!(get_magic_quotes_gpc() == 0) && (get_magic_quotes_runtime() == 0))
      echo('Warning: lazy mofo requires magic_quotes be disabled.');

    $this->dbh = $dbh; 

    $timezone = @date_default_timezone_get();
    if($timezone == '' || $timezone == 'UTC')
      date_default_timezone_set($this->timezone);

    // avoid notices for this noonce token
    if(!isset($_SESSION['_csrf']))
      $_SESSION['_csrf'] = '';
    
    // load configuration from ini file
    if(strlen($ini) > 0){
      if(file_exists("config/{$ini}"))
        $this->config = parse_ini_file("config/{$ini}", true, INI_SCANNER_TYPED);
      elseif(file_exists("config/{$ini}.dist"))
        $this->config = parse_ini_file("config/{$ini}.dist", true, INI_SCANNER_TYPED);
      else
        die("Error: Requested ini file ({$ini}) does not exist.");
      
      // overwrite public variables defined in config file
      $this->config_from_ini();
    }
    
    // load internationalization file if it exists, en-us (default) is defined in this class
    $this->set_language();
    
  }
  
  //////////////////////////////////////////////////////////////////////////////
  function run(){

    // purpose: built-in controller
    
    // set commands and grid_sql
    $this->set_grid_view_parameters();
    
    switch($this->get_action()){
      case "edit":          $this->template($this->edit());        break;
      case "insert":        $this->insert();      break;
      case "update":        $this->update();      break;
      case "update_grid":   $this->update_grid(); break;
      case "delete":        $this->delete();      break;
      case "eks":           $this->template($this->eks());         break;
      case "settings":      $this->template($this->settings());    break;
      case "dashboard":     $this->template($this->dashboard());    break;
      default:              $this->template($this->index());
    }

  }
  
  //////////////////////////////////////////////////////////////////////////////
  function set_language(){
    
    // purpose: load internationalization file, default: en-us
    
    if(strlen(@$_GET['_lang']) == 5 && !strpos(@$_GET['_lang'], '/'))
      $this->i18n = $_GET['_lang'];
    
    $i18n = $this->i18n;
    
    if(strlen($i18n) > 0 && $i18n != 'en-us'){
      if(!file_exists("i18n/{$i18n}.php"))
        $this->error = "Error: Requested i18n file ({$i18n}.php) does not exist.";
      else
        include("i18n/{$i18n}.php");
    }
  }
  
  //////////////////////////////////////////////////////////////////////////////
  function translate($str = "", $upper = ""){
    
    // purpose: translate words
    // example:
    // content of i18n file: `$this->translate['all'] = "alle";`  (array)
    //          use in code: `$this->translate('all');`           (function)
    
    if(array_key_exists($str, $this->translate)){
      if($upper == "pretty"){
        return $this->format_title($this->translate($str));
      }
      else
        return $this->translate[$str];
    }
    else{
      if($upper == "pretty"){
        return $this->format_title($str);
      }
      return $str;
    }
  }
  
  //////////////////////////////////////////////////////////////////////////////
  function dashboard(){
    
    // purpose: show multiple grids with predefined filters
    
    $html = "";
    
    $html .= "<div class='lm_error'><p>Dashboard - coming soon</p></div>";
    
    $html .= "<div class='center'>";
    
    //// unpayed invoices
    
    // income
    $_GET['_missing_date_on'] = "1";
    $_GET['_missing_date'][] = "value_date";
    $_GET['_amount'] = "pos";
    
    $this->multi_column_on = false;
    $tmp_active_columns = $this->config['active_columns'];
    $this->config['active_columns'] = array(
      "ID" => 1
      ,"invoice_number" => 1
      ,"value_date" => 1
      ,"voucher_date" => 1
      ,"gross_amount" => 1
      ,"customer_supplier" => 1
      ,"item" => 1
      ,"edit_delete_column" => 1
    );
    
    $this->set_grid_view_parameters("default");
    $link = $this->get_uri_path() . $this->get_qs();
    
    $html .= "<div class='dash_box'>";
    $html .= "<a href='$link'>";
    $html .= "<h2>Do I have to send an admonition?</h2>";
    $html .= "</a>";
    
    $html .= $this->grid('', true);
    
    $html .= "</div>";
    
    
    // unpayed invoices - costs
    $_GET['_amount'] = "neg";
    
    $this->config['active_columns'] = array(
      "ID" => 1
      ,"value_date" => 1
      ,"voucher_date" => 1
      ,"gross_amount" => 1
      ,"customer_supplier" => 1
      ,"item" => 1
      ,"edit_delete_column" => 1
    );
    
    $this->set_grid_view_parameters("default");
    $link = $this->get_uri_path() . $this->get_qs();
    
    $html .= "<div class='dash_box'>";
    $html .= "<a href='$link'>";
    $html .= "<h2>Hey, don't forget to pay your crazy stuff!</h2>";
    $html .= "</a>";
    
    $html .= $this->grid('', true);
    
    // reset variables
    unset($_GET['_missing_date_on']);
    unset($_GET['_missing_date']);
    unset($_GET['_amount']);
    $this->config['active_columns'] = $tmp_active_columns;
    
    $html .= "</div>";
    
    //// sums of last three months
    
    // set only _from, if _to is not set `generate_grid_sql_monthly()` expects _to = today
    $_GET['_from'] = (new DateTime())->modify("- 3 months")->modify("first day of this month")->format($this->date_out);
    $_GET['_view'] = "monthly_sums";
    
    $this->set_grid_view_parameters();
    $link = $this->get_uri_path() . $this->get_qs();
    
    $html .= "<div class='dash_box'>";
    $html .= "<a href='$link'>";
    $html .= "<h2>last three months</h2>";
    $html .= "</a>";
    
    $html .= $this->grid('', true);
    
    unset($_GET['_from']);
    unset($_GET['_view']);
    
    $html .= "</div>";
    
    // graphs
    $html .= "<div class='dash_box'>";
    $html .= "<h2>maybe a graph, because it looks cool</h2>";
    
    
    $html .= "</div>";
    
    // a wide one
    $html .= "<div class='dash_box wide'>";
    $html .= "<h2>another table with a lot of columns</h2>";
    
    $html .= "</div>";
    
    $html .= "</div>";// close surrounding div
    
    return $html;
    
  }// end of dashboard()
  
  //////////////////////////////////////////////////////////////////////////////
  function settings(){
    
    // purpose: show settings page to user
    
    $html = "";
    
    // form(s) for editing config file(S)
    
    $html .= "<div class='lm_error'><p>Settings - coming soon - form doesn't work</p></div>";
    // $this->error = "Settings - coming soon";
    
    $html .= "<div class='center'>";
    
    // var_dump($this->config);

    foreach($this->config as $group=>$arr){
      $html .= "<div style='display:inline-block;vertical-align:top;border:1px solid #ccc;height:300px;margin:5px;padding:5px;overflow:auto;'>";
      $html .= "<h2>$group</h2>";
      foreach($arr as $key=>$val){
        
        if( is_array($val) ){
          
          $html .= '<label for="'.htmlspecialchars($key).'">'.$key."</label>";
          $html .= "<fieldset id='$key'>";
          
          foreach($val as $k=>$v){
            
            if( is_bool($v) ){
              $v ? $checked = ' checked="checked"' : $checked = '';
              $html .= '<p>'.$k.': <input type="checkbox" name="'.$k.'"'.$checked.'></p>';
            }
              
            else
              $html .= '<p>'.$k.': <input type="text" value="'.htmlspecialchars($v).'" name="'.$k.'"></p>';
          }
          
          $html .= "</fieldset>";
        }
        else{
          
          if( is_bool($val) ){
              $val ? $checked = ' checked="checked"' : $checked = '';
              $html .= '<p>'.$key.': <input type="checkbox" name="'.$key.'"'.$checked.'></p>';
            }
          else
            $html .= '<p>'.$key.': <input type="text" value="'.htmlspecialchars($val).'" name="'.$key.'"></p>';
        }
      
      }
      $html .= "</div>";
    }
    $html .= "</div>";
    
    return $html;
    
  }
  
  //////////////////////////////////////////////////////////////////////////////
  function list_of_views(){
    
    // purpose: buttons/navigation with different views
    
    $active_view = $this->get_view();
    
    $class = "";
    if($active_view == "default")
        $class = " active";
    
    $uri = $this->get_uri_path();
    
    // qs without _view
    // $qs = $this->get_qs('_order_by,_desc,_offset,_search,_pagination_off,_lang');
    $qs = $this->get_qs('_lang');
    
    $html = "";
    
    // default
    $html .= "<a href='{$uri}_view=default&amp;$qs' class='lm_button view_button$class'>".$this->translate("accounting", "pretty")."</a>";
    
    // other options
    foreach($this->views as $val){
      $class = "";
      if($val == $active_view)
        $class = " active";
      $html .= "<a href='".$uri."_view=$val&amp;$qs' class='lm_button view_button$class'>".$this->translate($val, 'pretty')."</a>";
    }
    
    return $html;
    
  }
  
  //////////////////////////////////////////////////////////////////////////////
  function list_of_editable_tables(){
    
    // purpose: list existing tables in database with edit links
    
    $html = "";
    if( isset($_GET['_view']) && $_GET['_view'] == "edit_tables" ){
      $arr = $this->query("SHOW TABLES");
      
      $html = "<ul class='list_of_tables'>";
      foreach($arr as $value){
        $title = array_values($value)[0];
        $html .= '<li><a class="lm_button" href="?_view=edit_tables&amp;_edit_table='.$title.'">'. $this->format_title($title, @$this->rename[$title]) .'</a></li>';
      }
      $html .= '</ul>';
    }
    
    return $html;
  }
  
  //////////////////////////////////////////////////////////////////////////////
  function set_grid_view_parameters($view = ""){
    
    // purpose: show different views with different grids, forms and searchboxes
    // views must be defined in $this->views or via ini file
    // for a better overview views are in external files in folder `views`
    
    
    if($view == "")
      $view = $this->get_view();
    
    if( file_exists("views/{$view}.inc.php") )
      include("views/{$view}.inc.php");
    
  }
  
  //////////////////////////////////////////////////////////////////////////////
  function eks(){
    
    // purpose: show form with prefilled data to user (attachment EKS)

    // parse profile
    // --> inside `views/eks.inc.php`
    
    $uri_path = $this->get_uri_path();
    $qs = $this->get_qs();
    $eks = $this->eks_config;
    
    $estimated = false;
    if(@$_GET['_eks'] == 'estimated')
      $estimated = true;
    
    $disabled = $checked = '';
    
    // $this->debug($eks);
    
    // get current date for signatures
    $today = $this->date_out(date('Y-m-d'));
    
    $html = "";
    
    $html .= "<div class='lm_error'><p>experimental - no input possible - coming soon</p></div>";
    
    $html .= "<form action='$uri_path$qs&amp;action=eks' method='post' class='eks_form'>";
    
    // hide selected pages
    //     CSS checkbox ~ hack
    // --> pages must
    //     * follow checkboxes in the DOM
    //     * have the same parent
      
    for($i=1; $i <=6; $i++){
      $checked = "";
      if( !empty($_GET['_hide_page']) && in_array($i, $_GET['_hide_page']) )
        $checked .= " checked=checked";
      $html .= "<input type='checkbox' value='$i' name='_hide_page[]' id='_hide_page_$i' class='hide_page'$checked />\r\n";
      $hide = $this->translate("hide");
      $show = $this->translate("show");
      $html .= "<label for='_hide_page_$i' data-hide='$hide' data-show='$show'>$i</label>\r\n";
    }
    
    ///////////////// EKS page 1
      $html .= "<page id='eks_page1' class='eks_page portrait'>";
      
      // 1.1 personal data of applicant
      $html .= "<fieldset>";
      foreach($eks['personal_data'] as $key=>$val){
        $html .= '<input type="text" value="'.htmlspecialchars($val).'" name="'.htmlspecialchars($key).'">';
      }
      $html .= "</fieldset>";
      
      $html .= "<fieldset>";
      // 1.2 personal data of person to whom the data of this attachment refers to
      foreach($eks['personal_data_refer'] as $key=>$val){
        if(mb_strlen($val) > 0)
          $html .= '<input type="text" value="'.htmlspecialchars($val).'" name="'.htmlspecialchars($key).'_refer">';
        else
          $html .= '<input type="text" value="'.htmlspecialchars($eks['personal_data'][$key]).'" name="'.htmlspecialchars($key).'_refer">';
      }
      $html .= "</fieldset>";
      
      // 2. estimated or calculated data
      $html .= "<fieldset>";
      $checked = (!$estimated) ? "" : " checked='checked'";
      $html .= "<input type='radio' id='estimated' name='estimated' disabled='disabled'$checked />";
      $html .= '<label for="estimated"></label>';
      $checked = ($estimated) ? "" : " checked='checked'";
      $html .= "<input type='radio' id='calculated' name='calculated' disabled='disabled'$checked />";
      $html .= '<label for="calculated"></label>';
      $html .= "</fieldset>";
      
      
      // 3. period for receipt of unemployment benefits
      $html .= "<fieldset>";
      
      $period = htmlspecialchars($_GET['_from']) . " - " . htmlspecialchars($_GET['_to']);
      $html .= '<input type="text" value="'.$period.'" name="period" readonly="readonly">';
      
      $html .= "</fieldset>";
      
      // 4.1 company data
      $html .= "<fieldset>";
      foreach($eks['company_data'] as $key=>$val){
        $html .= '<input type="text" value="'.htmlspecialchars($val).'" name="'.htmlspecialchars($key).'">';
      }
      
      $html .= "</fieldset>";
      
      // 4.2 employees
      $html .= "<fieldset>";
      
      $checked = "";
      if( $eks['employees']['has_employees'] )
        $checked = " checked='checked'";
      
      $html .= '<input type="checkbox" id="has_employees" name="has_employees"'.$checked.' />';
      $html .= '<label for="has_employees"></label>';
      $html .= '<input type="text" value="'.htmlspecialchars($eks['employees']['number_of_employees']).'" name="number_of_employees">';
      $html .= "</fieldset>";
      
      
      $html .= "</page>";
    
    ///////////////// EKS page 2
      $html .= "<page id='eks_page2' class='eks_page portrait'>";
      
      
      // 5. subsidies
      $html .= "<fieldset>";
      foreach($eks['subsidies'] as $key=>$val){
        if( is_bool($val) ){
            $val ? $checked = ' checked="checked"' : $checked = '';
            $html .= '<input type="checkbox" id="subsidies_'.$key.'" name="subsidies_'.$key.'"'.$checked.'>';
            $html .= '<label for="subsidies_'.$key.'"></label>';
          }
        else
          $html .= '<input type="text" value="'.htmlspecialchars($val).'" name="subsidies_'.$key.'">';
      }
      
      $html .= "</fieldset>";
      
      // 6. loan
      $html .= "<fieldset>";
      foreach($eks['loan'] as $key=>$val){
        if( is_bool($val) ){
            $val ? $checked = ' checked="checked"' : $checked = '';
            $html .= '<input type="checkbox" id="loan_'.$key.'" name="loan_'.$key.'"'.$checked.'>';
            $html .= '<label for="loan_'.$key.'"></label>';
          }
        else
          $html .= '<input type="text" value="'.htmlspecialchars($val).'" name="loan_'.$key.'">';
      }
      
      $html .= "</fieldset>";
      
      // 7. home office
      $html .= "<fieldset>";
      foreach($eks['home_office'] as $key=>$val){
        if( is_bool($val) ){
            $val ? $checked = ' checked="checked"' : $checked = '';
            $html .= '<input type="checkbox" id="home_office_'.$key.'" name="home_office_'.$key.'"'.$checked.'>';
            $html .= '<label for="home_office_'.$key.'"></label>';
          }
        else
          $html .= '<input type="text" value="'.htmlspecialchars($val).'" name="home_office_'.$key.'">';
      }
      
      $html .= "</fieldset>";
      
      
      // signature
      $html .= "<fieldset>";
      
      $html .= '<textarea name="location">'.htmlspecialchars($eks['signature']['location']).', '.$today.'</textarea>';
      $html .= '<textarea name="signature">'.htmlspecialchars($eks['signature']['signature']).'</textarea>';
      
      $html .= "</fieldset>";
      
      
      $html .= "</page>";
      
    
    ///////////////// EKS page 3
      $html .= "<page id='eks_page3' class='eks_page landscape'>";
      
      $html .= "<fieldset>";
      
      // get name
      $name = "";
      if(mb_strlen($eks['personal_data_refer']['last_name']) > 0)
        $name .= htmlspecialchars($eks['personal_data_refer']['last_name']);
      else
        $name .= htmlspecialchars($eks['personal_data']['last_name']);
      $name .= ", ";
      if(mb_strlen($eks['personal_data_refer']['first_name']) > 0)
        $name .= htmlspecialchars($eks['personal_data_refer']['first_name']);
      else
        $name .= htmlspecialchars($eks['personal_data']['first_name']);
      
      $html .= '<input type="text" value="'.$name.'" name="last_first_name">';
      $html .= '<input type="text" value="'.htmlspecialchars($eks['personal_data']['bg_number']).'" name="page3_bg_number">';
      
      $html .= "</fieldset>";
      
      // estimated or calculated data
      $html .= "<fieldset>";
      $checked = (!$estimated) ? "" : " checked='checked'";
      $html .= "<input type='radio' id='page3_estimated' name='page3_estimated' disabled='disabled'$checked />";
      $html .= '<label for="page3_estimated"></label>';
      $checked = ($estimated) ? "" : " checked='checked'";
      $html .= "<input type='radio' id='page3_calculated' name='page3_calculated' disabled='disabled'$checked />";
      $html .= '<label for="page3_calculated"></label>';
      $html .= "</fieldset>";
      
      // small business / Kleinunternehmer/in (§19 UStG)
      $html .= "<fieldset>";
      $eks['eks']['small_business'] ? $checked = " checked='checked'" : $checked = "";
      $html .= '<input type="checkbox" id="small_business" name="small_business"'.$checked.' />';
      $html .= '<label for="small_business"></label>';
      $html .= "</fieldset>";
      
      // inject rows with sums/carryover
      $sql = $this->generate_grid_sql_eks(3, true);
      $this->inject_rows['last'] = $this->query($sql, $this->grid_sql_param);
      $this->inject_rows['last'][0]['ID'] = "";
      $this->inject_rows['last'][0]['type_of_costs'] = "Summe A1-A7";
      
      // grid
      $this->grid_sql = $this->generate_grid_sql_eks(3);
      $html .= $this->grid('', true);
      
      // reset row injection
      $this->inject_rows = array();
      
      $html .= "</page>";
      
    
    ///////////////// EKS page 4
      $html .= "<page id='eks_page4' class='eks_page landscape'>";
      
      // inject rows with sums/carryover
      $sql = $this->generate_grid_sql_eks(4, true); // sum of page 4
      $sum_page_4 = $this->query($sql, $this->grid_sql_param);
      $this->inject_rows["last"] = $sum_page_4;
      $this->inject_rows['last'][0]['ID'] = "";
      $this->inject_rows['last'][0]['type_of_costs'] = "Zwischensumme B1-B7";
      
      
      // grid
      $this->grid_sql = $this->generate_grid_sql_eks(4);
      $html .= $this->grid('', true);
      
      // reset row injection
      $this->inject_rows = array();
      
      $html .= "</page>";

    
    ///////////////// EKS page 5
      $html .= "<page id='eks_page5' class='eks_page landscape'>";
      
      // inject rows with sums/carryover
      $this->inject_rows[1] = $sum_page_4; // carryover from page 4
      $this->inject_rows[1][0]['ID'] = "";
      $this->inject_rows[1][0]['type_of_costs'] = "Übertrag B1-B7";
      
      $sql = $this->generate_grid_sql_eks("4,5", true); // sum of all costs
      $this->inject_rows[22] = $this->query($sql, $this->grid_sql_param);
      $this->inject_rows[22][0]['ID'] = "";
      $this->inject_rows[22][0]['type_of_costs'] = "Summe B1-B18";
      
      $sql = $this->generate_grid_sql_eks("3,4,5", true); // total income - costs
      $this->inject_rows[23] = $this->query($sql, $this->grid_sql_param);
      $this->inject_rows[23][0]['ID'] = "";
      $this->inject_rows[23][0]['type_of_costs'] = "Gewinn";
      
      // grid
      $this->grid_sql = $this->generate_grid_sql_eks(5);
      $html .= $this->grid('', true);
      
      // reset row injection
      $this->inject_rows = array();
      
      
      $html .= "</page>";
      
    
    ///////////////// EKS page 6
      $html .= "<page id='eks_page6' class='eks_page landscape'>";
      
      // grid
      // $this->grid_sql = $this->generate_grid_sql_eks(6);
      // $html .= $this->grid('', true);
      
      // signature
      $html .= "<fieldset>";
      
      $html .= '<textarea name="location">'.htmlspecialchars($eks['signature']['location']).', '.$today.'</textarea>';
      $html .= '<textarea name="signature">'.htmlspecialchars($eks['signature']['signature']).'</textarea>';
      
      $html .= "</fieldset>";
      
      $html .= "</page>";
      

    $html .= "</form>";
    
    return $html;
    
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
  
  //////////////////////////////////////////////////////////////////////////////
  function export_button(){
    $qs = $this->get_qs();
    $uri_path = $this->get_uri_path();
    $grid_export_link = $this->grid_export_link;
    $grid_export_link = str_replace('[script_name]', $uri_path, $grid_export_link);
    $grid_export_link = str_replace('[qs]', $qs, $grid_export_link);
    $grid_export_link = str_replace('[grid_export_link_text]', $this->grid_export_link_text, $grid_export_link);
    return $grid_export_link;
  }
  
  //////////////////////////////////////////////////////////////////////////////
  function template($content){
    
    // purpose: use template file for HTML output
    
    // wkhtmltopdf has a bug and doesnt't load background images inside @media rules
    // issue: https://github.com/wkhtmltopdf/wkhtmltopdf/issues/3126
    // Therefore we have to insert some CSS to overwrite the screen images with
    // high-resulution images for printing
    $_wkhtmltopdf_img_fix = intval(@$_REQUEST['_wkhtmltopdf_img_fix']);
    $_pdf = intval(@$_REQUEST['_pdf']);

    // export page to PDF and quit 
    if($_pdf == 1){
      $url = $this->get_uri_path() . $this->get_qs();
      $url .= "&_wkhtmltopdf_img_fix=1"; // add parameter to qs of current page for CSS insert
      $this->generate_pdf($url);
      return;
    }

    $css = "";
    if($_wkhtmltopdf_img_fix == 1) // insert CSS to overwrite background images
      $css .= "body.eks form.eks_form #eks_page1.eks_page{background-image:url('img/eks_1-6_print.png');}body.eks form.eks_form #eks_page2.eks_page{background-image:url('img/eks_2-6_print.png');}body.eks form.eks_form #eks_page3.eks_page{background-image:url('img/eks_3-6_print.png');}body.eks form.eks_form #eks_page4.eks_page{background-image:url('img/eks_4-6_print.png');}body.eks form.eks_form #eks_page5.eks_page{background-image:url('img/eks_5-6_print.png');}body.eks form.eks_form #eks_page6.eks_page{background-image:url('img/eks_6-6_print.png');}";
    
    
    //// variables for templating
    
    // class name generated by page name/type for easier styling
    $body_class = $this->get_action();

    $uri = $this->get_uri_path();
    $qs = $this->get_qs();
    $qs_without_lang = $this->get_qs('_order_by,_desc,_offset,_search,_pagination_off,_view,action');// + action

    // optional background image
    $background_image = "";
    if (mb_strlen($this->background_image) > 0)
      $background_image = " style='background-image:url($this->background_image)' ";
    
    $html_lang = substr($this->i18n,0,2);
    $title = $this->get_page_name();
    $software_name = htmlspecialchars($this->software_name);
    $slogan = htmlspecialchars($this->slogan);
    $version = $this->version();
    
    $user_css = "";
    if(mb_strlen($css) > 0)
      $user_css .= "<style>$css</style>";
    
    // buttons
    $settings_button = "<a href='{$uri}action=settings' class='lm_button'>".$this->translate("settings", "pretty")."</a>";
    $dashboard_button = "<a href='{$uri}action=dashboard' class='lm_button'>Dashboard</a>";
    $add_button = $this->add_button();
    $export_button_csv = $this->export_button();
    $export_button_pdf = "<a target='_blank' href='{$uri}_pdf=1&amp;{$qs}' class='lm_button' title='PDF Export'>PDF</a>";
    // language buttons
    $langs = array("de-de", "en-us");
    $language_button = "";
    foreach($langs as $lang)
      if($lang != $this->i18n)
        $language_button .= "<a href='{$uri}_lang=$lang&amp;$qs_without_lang' class='lang_button'>".substr($lang,0,2)."</a>";
    
    $list_of_views = $this->list_of_views();
    $searchbox = $this->search_box();
    $list_of_editable_tables = $this->list_of_editable_tables(); // empty if _view != "edit_tables"
    
    // javascript
    $js = "";
    if($this->allow_javascript){
      $js = "<script src='js/pikaday.js'></script>";
      $js .= "<script>var lang = '$this->i18n', date_out = '$this->date_out'</script>";
      $js .= "<script src='js/eEKS.js'></script>";
    }
    
    $error = $this->error;
    
    // include template file
    if(file_exists('themes/'.$this->config['eeks']['theme'].'/index.theme'))
      echo include('themes/'.$this->config['eeks']['theme'].'/index.theme');
    else
      echo include('themes/default/index.theme');
  }
  
  //////////////////////////////////////////////////////////////////////////////
  function config_from_ini(){
    
    // purpose: use ini file instead of overwriting variables in PHP
    
    if(!empty($this->config)){
      
      foreach($this->config['lm'] as $key => $val){
        if(property_exists('eEKS', $key))
          $this->$key = $val;
      }
      
      foreach($this->config['eeks'] as $key => $val){
        if(property_exists('eEKS', $key))
          $this->$key = $val;
      }
      
    }
    
  }
  
  //////////////////////////////////////////////////////////////////////////////
  function edit($error = ''){
    
    // purpose: called from contoller to display form() and add or edit a record
    
    return $this->form($error);
    
  }
  
  //////////////////////////////////////////////////////////////////////////////
  function index($error = ''){
    
    // purpose: called from contoller to display update() data
    
    return $this->grid($error);
    
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
    
    // delete thousands separator if it exists
    $str = str_replace(',', '', $str);
    
    // format number with local separators
    if( $type == "float" )
      $str = number_format((float)$str, $this->decimals, $this->dec_point, $this->thousands_sep);
    else
      $str = number_format((float)$str, 0, $this->dec_point, $this->thousands_sep);
    
    return $str;
    
  }
  
  //////////////////////////////////////////////////////////////////////////////
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
  function html_date_output($str = "", $use_time = false){
    
    // purpose: set class names for different numbers
    
    $str = $this->date_out($str, $use_time);
    
    if($use_time)
      $class = "datetime";
    else
      $class = "date";
    
    return "<span class='$class'>$str</span>";
    
  }
  
  //////////////////////////////////////////////////////////////////////////////
  function grid($error = '', $no_form = false){
    
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

    // inject function for counting
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
    $pagination_button_bar = "<div class='lm_pagination'>$pagination</div>\n";
    
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
      elseif( $this->multi_column_on ){ // experimental multi-value column active
        if( !in_array($column_name, $this->multi_column) )
          $head .= "    <th><a href='{$uri_path}_order_by=" . ($i + 1) . "&amp;_desc=$_desc_invert&amp;" . $this->get_qs('_search,_view,_lang') . "' class='lm_$column_name'>$title</a></th>\n";
      }
      else
        $head .= "    <th><a href='{$uri_path}_order_by=" . ($i + 1) . "&amp;_desc=$_desc_invert&amp;" . $this->get_qs('_search,_view,_lang') . "' class='lm_$column_name'>$title</a></th>\n";
  
      $i++;

    }
    if($this->multi_column_on)
      $head .= "<th>$this->multi_value_column_title</th>";
    $head .= "$edit_delete";
    $head .= "</tr>\n";
          
    // start generating output //
    $html = "";
    // $html .= "<div class='lm'>\n";

    if(mb_strlen($success) > 0)
      $html .= "<div class='lm_success'><p>$success</p></div>\n";
    if(mb_strlen($error) > 0)
      $html .= "<div class='lm_error'><p>$error</p></div>\n";
    
    if(!$no_form){
      $html .= "<form action='$uri_path$qs&amp;action=update_grid' method='post' enctype='multipart/form-data'>\n";
      $html .= "<input type='hidden' name='_posted' value='1'>\n";
      $html .= "<input type='hidden' name='_csrf' value='$_SESSION[_csrf]'>\n";
    }
      
    
    // save changes button on top to avoid wrong submit button on pressing `Enter`
    $html .= $button;

    // quit if there's no data
    if($count <= 0){
      if(!$no_form)
        $html .= "<div class='lm_notice'><p>$this->grid_text_no_records_found</p></div></form>\n";
      else
        $html .= "<div class='lm_notice'><p>$this->grid_text_no_records_found</p></div>\n";
      
      return $html;    
    }

    // buttons & pagination on top. only show if we have a lot of records
    if($count > 30)
      $html .= $pagination_button_bar;

    $html .= "<table class='lm_grid'>\r\n";
    $html .= $head;
    
    // optional: sums of results
    $sum = array();
    if($this->grid_show_column_sums){
      foreach($columns as $col){
        // no settings: sum everything except identity_name
        if(!$this->sum_these_columns && $col != $this->identity_name)
          $sum[$col] = array_sum(array_column($result, $col));
        // with settings: sum defined column(s)
        elseif( in_array($col, $this->sum_these_columns) ){
          if(is_numeric($col))
            $sum[$col] = array_sum( array_column( $result, intval($col) ) );
          else
            $sum[$col] = array_sum( array_column($result, $col) );
        }
        else
          $sum[$col] = "";
      }
      // inject row with sums into result
      $this->inject_rows['last'][0] = $sum;
      $this->inject_rows['last'][0]["ID"] = $this->translate("sum");
    }
      
    // optional: inject rows at specified positions into $result
    $count_inject_rows = count($this->inject_rows);
    if($count_inject_rows > 0)
      $result = $this->inject_rows_into_result($result);
    
    $count_result = count($result);
    
    // print rows
    $j = 0;
    foreach($result as $row){
      
      // add extra classes to rows
      $class = array();
      
      $c = $this->grid_add_css_classes($row);
      if($c != "")
        $class[] = $c;
      
      // highlight last updated or inserted row
      $shaded = '';
      if(@$_GET[$this->identity_name] == @$row[$this->identity_name] && mb_strlen(@$_GET[$this->identity_name]) > 0)
        $class[] = "lm_active'";
      
      
      // add class to column sums
      if($this->grid_show_column_sums && $j == $count_result - 1)
        $class[] = "column_sums";
      
      if(!empty($class))
        $shaded = " class='".trim(implode(" ",$class))."'";
      
      $html .= "<tr$shaded>\r\n";// print a row
      

      // delete selection checkbox
      if($this->grid_multi_delete){
        $html .= "<td><label><input type='checkbox' name='_delete[]' value='{$row[$this->identity_name]}'></label></td>\r\n";
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
          if($this->grid_show_column_sums && $j == $count_result - 1)
            $edit_delete .= "<td class='col_edit'></td>";
          else
            $edit_delete .= "    <td class='col_edit'>" . str_replace('[identity_id]', $value, $links) . "</td>\n";
        
        // experimental multi-value column
        elseif(in_array($column_name, $this->multi_column) && $this->multi_column_on){
          $multi_column_content .= "<div>";
          if(mb_strlen($value) > 0) $multi_column_content .= "$title: ";
          $multi_column_content .= $this->get_output_control($column_name . '-' . $row[$this->identity_name], $value, '--text', 'grid') . "</div>";
          
        }

        // input fields
        elseif(array_key_exists($column_name, $this->grid_input_control)){
          if(mb_strlen($error) > 0 && $_posted == 1) // repopulate from previous post when validation error is displayed
              $value = $_POST[$column_name . '-' . $row[$this->identity_name]];
          $html .= '    <td data-coltitle="'.htmlspecialchars($title).'" data-col="'.htmlspecialchars($column_name).'">' . $this->get_input_control($column_name . '-' . $row[$this->identity_name], $value,  $this->grid_input_control[$column_name], 'grid') . "</td>\n";
        }
        
        // output
        elseif(array_key_exists($column_name, $this->grid_output_control))
          $html .= '    <td data-coltitle="'.htmlspecialchars($title).'" data-col="'.htmlspecialchars($column_name).'">' . $this->get_output_control($column_name . '-' . $row[$this->identity_name], $value, $this->grid_output_control[$column_name], 'grid') . "</td>\n";
        
        // anything else
        else
          $html .= '    <td data-coltitle="'.htmlspecialchars($title).'" data-col="'.htmlspecialchars($column_name).'">' . $this->get_output_control($column_name . '-' . $row[$this->identity_name], $value, '--text', 'grid') . "</td>\n";

        $i++; // column index
      }
      
      if($this->multi_column_on)
        $html .= "<td class='col_multi_value'>$multi_column_content</td>";
      
      $multi_column_content = ""; // reset
      $html .= $edit_delete;
      $edit_delete = ""; // reset
      $html .= "</tr>\n";

      // repeat header
      if($this->grid_repeat_header_at > 0)
        if($j % $this->grid_repeat_header_at == 0 && $j < $count && $j > 0)
          $html .= str_replace('<tr', '<tr class="grid_repeat_header"',$head);
      
      // row counter    
      $j++;
    }

    $html .= "</table>\n";

    // buttons & pagination, close form
    $html .= $pagination_button_bar;
    $html .= $button;
    if(!$no_form)
      $html .= "</form>\n";
    // $html .= "</div>\n";

    return $html;

  }//end of grid()
  
  //////////////////////////////////////////////////////////////////////////////
  function generate_grid_sql(){
    
    // purpose: generate sql query ($this->grid_sql) with defined filter options
    
    $search_in_columns = $this->search_in_columns;
    $date_filters = $this->date_filters;
    
    $query = "";
    $query .= "SELECT\r\n";
    
    $missing_identity_name = true;
    $where = array();
    $date_filter = array();
    
    // get active columns
    $active_columns = array();
    foreach($this->config['active_columns'] as $key=>$val){
      if($val && $key != "edit_delete_column")
        $active_columns[] = $key;
      elseif($val && $key == "edit_delete_column")
      $active_columns[] = $this->identity_name;
    }
    
    // list active columns (defined in ini file)
    $i = 0;
    foreach($active_columns as $val){
      
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
      
      if( array_key_exists($val, $this->config['sql_joins']) && $cmd != 'select' ){
          $query .= $this->config['sql_joins'][$val]['alias'] . "." .$this->config['sql_joins'][$val]['column'] . "\r\n";
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
    foreach($this->config['sql_joins'] as $key=>$val){
      
      $cmd = false;
      if( isset($this->grid_input_control[$key]) ){
        $cmd = $this->grid_input_control[$key];
        if( mb_strstr($cmd, '--select') )
          $cmd = 'select';
      }
      
      if( array_key_exists($key, $this->config['sql_joins']) && $cmd != 'select' ){
        
        $query .= "LEFT JOIN ".$val['table']." ".$val['alias']."\r\n";
        $query .= "ON a.$key = ".$val['alias'].".".$val['ID']."\r\n";
      
      }
    }
    
    
    // add WHERE clause for full text search
    if(!empty($where)){
      
      $query .= "WHERE (\r\n";
      
      $i = 0;
      foreach($where as $val){
        if($i != 0)
          $query .= "  OR\r\n";
        $query .= "  COALESCE(a.$val, '') LIKE :_search\r\n";
        $i++;
      }
      
    }
    
    // add grid_sql_param
    $this->grid_sql_param[':_search'] = '%' . trim(@$_REQUEST['_search']) . '%';
    
    $query .= ")\r\n";
      
    // add AND clause for filter by category
    foreach($this->category_filters as $val){
      if(!empty($_REQUEST["_$val"])){
        $query .= "AND a.$val LIKE :_$val\r\n";
        $this->grid_sql_param[":_$val"] = $this->clean_out(@$_REQUEST["_$val"]);
      }
    }
    
    // add AND clause for negative/positive amounts
    if(mb_strlen($this->amount_filter) > 0){
      $column = $this->amount_filter;
      $amount = "";
      if(!empty($_GET["_amount"]))
        $amount = $this->clean_out($_GET["_amount"]);
      if($amount == "pos")
        $query .= "AND ( a.$column >= 0 AND a.is_reimbursement = 0 OR ( a.$column < 0 AND a.is_reimbursement = 1 ) )\r\n";
      if($amount == "neg")
        $query .= "AND ( a.$column < 0 AND a.is_reimbursement = 0 OR ( a.$column >= 0 AND a.is_reimbursement = 1 ) )\r\n";
    }
    
    
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
    if( !empty($_GET['_missing_date_on']) && !empty($_GET['_missing_date'])==1 && !empty($_GET['_missing_date']) ){
      $query .= "AND (";
      
      foreach($_GET['_missing_date'] as $key=>$val){
        if($key == 0)
          $query .= "a.$val IS NULL";
        else
          $query .= " OR a.$val IS NULL";
      }
      
      $query .= ")\r\n";
    }
    
    
    // add ORDER BY
    $sort_order = $this->config['sort_order'];
    $count = count($sort_order);
    if($count > 0){
      $query .= "ORDER BY ";
      
      $i = 0;
      foreach($this->config['sort_order'] as $val){
        if($i >= 1)
          $query .= ", ";
        $query .= "a.$val";
        $i++;
      }
    }
    
    return $query;
    
  }//end of generate_grid_sql
  
  //////////////////////////////////////////////////////////////////////////////
  function expect_sloppy_date_filter_inputs($case = "default"){
    
    // purpose: correct sloppy user input for date ranges filter and provide default ranges
    
    if($case == "monthly"){
      
      // take care of user input for _from and _to
      if( !empty($_GET['_from']) && !empty($_GET['_to']) ){
        // case: _from and _to given
        // --> set first day of _from and last day of _to
        $from = (new DateTime($this->date_in($_GET['_from'])))->modify('first day of this month')->format('Y-m-d');
        $to = (new DateTime($this->date_in($_GET['_to'])))->modify('last day of this month')->format('Y-m-d');
      }
      elseif( !empty($_GET['_from']) ){
        // case: _from given, _to = ""
        // --> from = first day of _from-month and to = today
        $from = (new DateTime($this->date_in($_GET['_from'])))->modify('first day of this month')->format('Y-m-d');
        $to = (new DateTime())->format('Y-m-d');//today
      }
      elseif( !empty($_GET['_to']) ){
        // case: _to given, _from = ""
        // --> from = first day of _to-year, to = last day of _to-month
        $to = (new DateTime($this->date_in($_GET['_to'])))->modify('last day of this month')->format('Y-m-d');
        $from = (new DateTime($to))->modify('first day of Jan this year')->format("Y-m-d");// first day of to-year
      }
      else{// no input, expect this year
        $now = new DateTime();
        $from = $now->modify('first day of Jan this year')->format('Y-m-d');
        $to = $now->modify('last day of Dec this year')->format('Y-m-d');
      }
      
    }
    elseif($case == "yearly"){
      if( !empty($_GET['_from']) && !empty($_GET['_to']) ){
        // case: _from and _to given
        // --> from = first day of _from-year, to = last day of _to-year
        $from = (new DateTime($this->date_in($_GET['_from'])))->modify('first day of Jan this year')->format('Y-m-d');
        $to = (new DateTime($this->date_in($_GET['_to'])))->modify('last day of Dec this year')->format('Y-m-d');
      }
      elseif( !empty($_GET['_from']) ){
        // case: _from given, _to = ""
        // --> from = first day of _from-year, to = today
        $from = (new DateTime($this->date_in($_GET['_from'])))->modify('first day of Jan this year')->format('Y-m-d');
        $to = (new DateTime())->modify('last day of Dec this year')->format('Y-m-d');//Dec this year
      }
      elseif( !empty($_GET['_to']) ){
        // case: _to given, _from = ""
        // --> from = first day of _to-year, to = last day of _to-year
        $to = (new DateTime($this->date_in($_GET['_to'])))->modify('last day of Dec this year')->format('Y-m-d');
        $from = (new DateTime($to))->modify('first day of Jan this year')->modify('- 2 years')->format("Y-m-d");// first day of to-year
      }
      else{// no input, expect this year and last two years
        // $now = new DateTime();
        $from = (new DateTime())->modify('first day of Jan this year')->modify('- 2 years')->format('Y-m-d');
        $to = (new DateTime())->modify('last day of Dec this year')->format('Y-m-d');
      }
    }
    else{
      $from = @$_GET['_from'];
      $to = @$_GET['_to'];
    }
    
    // set GET parameters to calculated params
    // --> pro: params are visible
    // --> contra: overwriting existing params
    // $_GET['_from'] = $from;
    // $_GET['_to'] = $to;
    
    return array($from, $to);
  }
  
  //////////////////////////////////////////////////////////////////////////////
  function select_interval($interval = "monthly", $from, $to, $date){
    
    if($interval == "monthly"){
      // add montly summed columns in sql query in date range
      $start    = (new DateTime($from))->modify('first day of this month');
      $end      = (new DateTime($to))->modify('first day of next month');
      $inter = DateInterval::createFromDateString('1 month');
    }
    if($interval == "yearly"){
      // add montly summed columns in sql query in date range
      $start    = (new DateTime($from))->modify('first day of this year');
      $end      = (new DateTime($to))->modify('last day of this year');
      $inter = DateInterval::createFromDateString('1 year');
    }
    
    $period = new DatePeriod($start, $inter, $end);
    
    $query = "";
    $count_cols = 0;
    foreach ($period as $dt) {
      $month = $dt->format('m');
      $year = $dt->format('Y');
      
      if( $interval == "monthly" ){
        $col = $this->translate($dt->format('M')) . $dt->format(' (y)');
        $query .= ", SUM( CASE WHEN EXTRACT(MONTH FROM a.$date) = $month AND EXTRACT(YEAR FROM a.$date) = $year THEN a.gross_amount ELSE 0 END ) AS '$col'\r\n";
      }
      elseif($interval == "yearly"){
        $col = $dt->format('Y');
        $query .= ", SUM( CASE WHEN EXTRACT(YEAR FROM a.$date) = $year THEN a.gross_amount ELSE 0 END ) AS '$col'\r\n";
      }
      
      // set grid output control
      $this->grid_output_control[$col] = '--number';
      
      // set column sums
      $this->sum_these_columns[] = $col;
      
      $count_cols++;
    }
    
    // set grid output control
    $this->grid_output_control['sum'] = '--number';
    $this->grid_output_control['average'] = '--number';
    
    // set column sums
    $this->sum_these_columns[] = "sum";
    $this->sum_these_columns[] = "average";
    
    // sum
    if( $interval == "monthly" )
      $query .= ", SUM(COALESCE(NULLIF(a.gross_amount, ''), 0)) as sum\r\n";
    
    // average
    $query .= ", ROUND( COALESCE(SUM( a.gross_amount / $count_cols ), 0), 2 ) AS average\r\n";
    
    return $query;
    
  }// end of select_interval()
  
  //////////////////////////////////////////////////////////////////////////////
  function generate_grid_sql_interval($interval = "monthly", $date = "", $group = "", $no_group_by = false){
    
    // purpose: sql query for monthly sums of amounts with $date, grouped by $group
    
    // needs some more work to make it portable without joins or tables with different identity_names
    
    // expected default dates need some adjusting and/or user definable variables
    if($date == ""){
      if(isset($this->date_filters[0]))
        $date = $this->date_filters[0];
      else
        $this->display_error("specify a column in your date filter", "generate_grid_sql_interval()");
    }
    
    if($group == ""){
      if(isset($this->category_filters[0]))
        $group = $this->category_filters[0];
      else
        $this->display_error("specify a column in your category filter", "generate_grid_sql_interval()");
    }
    
    // start query
    $query = "";
    
    $query .= "SELECT\r\n";
    $query .= "  t.ID\r\n";
    
    // add column with type income/cost in interval view
    // $query .= ", CASE WHEN t.is_income = true THEN '".$this->translate("income")."' ELSE '".$this->translate("costs")."' END AS income_costs\r\n";
    
    $query .= ", t.$group\r\n";
    
    $from_to = $this->expect_sloppy_date_filter_inputs($interval);
    $from = $from_to[0];
    $to = $from_to[1];
    
    // add select summed columns in month/year interval
    $query .= $this->select_interval($interval, $from, $to, $date);
    
    $query .= "FROM $this->table a\r\n";
    $query .= "RIGHT OUTER JOIN $group t\r\n";
    $query .= "ON a.$group = t.ID\r\n";
    
    // add WHERE clause(s) for negative/positive amounts
    if(mb_strlen($this->amount_filter) > 0){
      $column = $this->amount_filter;
      $amount = "";
      if(!empty($_GET["_amount"]))
        $amount = $this->clean_out($_GET["_amount"]);
      if($amount == "pos")
        $query .= "WHERE ( a.$column >= 0 AND a.is_reimbursement = 0 OR ( a.$column < 0 AND a.is_reimbursement = 1 ) )\r\n";
      if($amount == "neg")
        $query .= "WHERE ( a.$column < 0 AND a.is_reimbursement = 0 OR ( a.$column >= 0 AND a.is_reimbursement = 1 ) )\r\n";
    }
    
    // add AND clause for filter by category
    foreach($this->category_filters as $val){
      if(!empty($_GET["_$val"])){
        $query .= "AND a.$val LIKE :_$val\r\n";
        $this->grid_sql_param[":_$val"] = $this->clean_out(@$_GET["_$val"]);
      }
    }
    
    $query .= "AND a.$date BETWEEN '$from' AND '$to'\r\n";
    if(!$no_group_by)
      $query .= "GROUP BY t.$group\r\n";
    
    $query .= "ORDER BY t.is_income DESC, t.sort_order ASC, t.$group ASC\r\n";
    
    return $query;
    
  }// end of generate_grid_sql_interval()
  
  //////////////////////////////////////////////////////////////////////////////
  function generate_grid_sql_eks($pages = "1,2,3,4,5,6", $no_group_by = false){
    
    $date = "value_date";
    
    $estimated = false;
    if(@$_GET['_eks'] == 'estimated')
      $estimated = true;
    
    $query = "";
    
    $from = (new DateTime($this->date_in($_GET['_from'])))->modify('first day of this month')->format('Y-m-d');
    
    // use last 6 months for estimated EKS
    if($estimated){
      $from    = (new DateTime($from))->modify('- 6 months')->format('Y-m-d');
    }
    
    $to = (new DateTime($from))->modify('+ 5 months')->modify('last day of this month')->format('Y-m-d');
    
    
    // add montly summed columns in sql query in date range
    $start    = (new DateTime($from));
    $end      = (new DateTime($to))->modify('first day of next month');
    $interval = DateInterval::createFromDateString('1 month');
    $period   = new DatePeriod($start, $interval, $end);
    
    $select_months = "";// contains query for summed months
    $i = "a";// temporary column name for estimated months
    $cols = array();// contains temporary month names and 
    foreach ($period as $dt) {
      
      $month = $dt->format('m');
      $year = $dt->format('Y');
      
      if(!$estimated)
        $col = $this->translate($dt->format('M')) . $dt->format(' (y)');
      else{
        $col = $this->translate($dt->modify('+ 6 months')->format('M')) . $dt->format(' (y)');
      }
      
      if(!$estimated)// concluded EKS, don't change data
        $select_months .= ",SUM( CASE WHEN EXTRACT(MONTH FROM a.$date) = $month AND EXTRACT(YEAR FROM a.$date) = $year THEN a.gross_amount ELSE 0 END ) AS '$col'\r\n";
      else{
        // estimated EKS, use averages and defined multipliers
        $multiplier = $this->eks_config['eks']['intended_growth'] / 100;
        $multiplier_income = $multiplier * 2 + 1;
        $multiplier_cost = $multiplier + 1;
        
        $select_months .= ", ROUND( COALESCE( SUM(\r\n";
        $select_months .= "    CASE WHEN c.page = 3 THEN a.gross_amount / 6 * $multiplier_income ELSE a.gross_amount / 6 * $multiplier_cost END\r\n";
        $select_months .= "  ), 0), 2 ) AS '$i'\r\n";
      }
      
      // grid output control
      $this->grid_output_control[$col] = '--number';
      $this->grid_output_control['sum'] = '--number';
      
      $cols[$i] = $col;
      $i++;
    }
    
    // add sub-query for estimated EKS to avoid rounding issues in calculated sums
    if($estimated){
      $query .= "SELECT ID, type_of_costs\r\n";
      foreach($cols as $key=>$val)
        $query .= ", $key AS '$val'\r\n";
      $query .= ", ". implode('+', array_keys($cols) ) ." AS sum\r\n";
      $query .= ", average AS old_average\r\n";
      $query .= "FROM (\r\n";
      
      $this->grid_output_control['old_average'] = '--number';// grid output control
    }
    
    $query .= "SELECT\r\n";
    $query .= "c.ID, c.type_of_costs\r\n";
    
    $query .= $select_months;
    
    // sum
    if(!$estimated)
      $query .= ", SUM(COALESCE(NULLIF(a.gross_amount, ''), 0)) as sum\r\n";
    
    // average
    $query .= ", ROUND( COALESCE(SUM( a.gross_amount / 6 ), 0), 2 ) AS average\r\n";
    
    $this->grid_output_control['average'] = '--number';
    
    $query .= "FROM type_of_costs t\r\n";
    $query .= "RIGHT JOIN coa_jobcenter_eks_01_2017 c\r\n";
    $query .= "  ON t.coa_jobcenter_eks_01_2017 = c.ID\r\n";
    $query .= "LEFT JOIN accounting a\r\n";
    $query .= "  ON a.type_of_costs = t.ID\r\n";
    $query .= "AND a.mode_of_employment LIKE :_mode_of_employment\r\n";
    $query .= "AND a.$date BETWEEN '$from' AND '$to'\r\n";
    
    // get specific page
    $query .= "WHERE c.page IN ($pages)\r\n";
    
    if(!$no_group_by)
      $query .= "GROUP BY c.type_of_costs\r\n";
    
    if($estimated)// close sub-query
      $query .= ") b\r\n";
    
    $query .= "ORDER BY ID\r\n";
    
    
    $this->grid_sql_param[":_mode_of_employment"] = $this->clean_out(@$_GET["_mode_of_employment"]);
    
    return $query;
    
  }// end of generate_grid_sql_eks()
  
  //////////////////////////////////////////////////////////////////////////////
  function search_box_filter_between_dates(){
    
    // purpose: return inputs for date filter
    
    $date_filters = $this->date_filters;
    $_from = $this->clean_out(@$_GET['_from']);
    $_to = $this->clean_out(@$_GET['_to']);
    $html = "";
    $count = count($date_filters);
    if($count > 0){
      $html .= "<fieldset>\r\n";
      
      if($count == 1) // text with hidden input field
        $html .= "  <input type='hidden' name='_date_between' readonly='readonly' value='".$date_filters[0] . "'>" . $this->format_title($date_filters[0], @$this->rename[$date_filters[0]]) . ": \r\n";
      else{ // select
        $html .= "  <select name='_date_between'>\r\n";
        
        foreach($date_filters as $val){
          $selected = "";
          if(isset($_GET["_date_between"]) && $val == $_GET["_date_between"]) 
            $selected .= ' selected="selected"';
          $html .= "    <option value='$val'$selected>" . $this->format_title($val, @$this->rename[$val]) . "</option>\r\n";
        }
        $html .= "  </select>\r\n";
      }
      
      $html .= "<input type='text' name='_from' value='".$_from."' placeholder='$this->date_filter_from' size='10' class='lm_search_between_input date'>";
      $html .= "<input type='text' name='_to' value='".$_to."' placeholder='$this->date_filter_to' size='10' class='lm_search_between_input date'>";
      
      $html .= "</fieldset>\r\n";
      
    }
    
    return $html;
  }
  
  //////////////////////////////////////////////////////////////////////////////
  function search_box_filter_missing_date(){
    
    // purpose: return checkboxes to filter by missing date(s)
    
    $date_filters = $this->date_filters;
    
    $html = "";
    $html .= "<fieldset>\r\n";
    
    // checkbox filter by missing date
    $checked = "";
    if( !empty($_GET['_missing_date_on']) && $_GET['_missing_date_on'] == 1 )
      $checked = " checked='checked'";
    $html .= "<input type='checkbox' id='_missing_date_on' name='_missing_date_on' value='1'$checked />";
    $html .= "<label for='_missing_date_on'>".$this->translate("missing_date", "pretty")."</label>";
    
    // checkboxes foreach date column (unvisible via CSS until checkbox above is selected)
    foreach($date_filters as $val){
      $checked = "";
      if( !empty($_GET['_missing_date']) && in_array($val, $_GET['_missing_date']) )
        $checked = " checked='checked'";
      $html .= "<input type='checkbox' name='_missing_date[]' id='_missing_date_$val' value='$val'$checked />";
      $html .= "<label for='_missing_date_$val'>".$this->translate($val, "pretty")."</label>";
    }
    
    $html .= "</fieldset>\r\n";
    
    return $html;
    
  }
  
  //////////////////////////////////////////////////////////////////////////////
  function search_box_filter_by_category(){
    
    // purpose: return select box(es) with category filters
    
    // needs better sorting
    
    $category_filters = $this->category_filters;
    $html = "";
    $count = count($category_filters);
    if($count > 0){
      $html .= "<fieldset>\r\n";
      
      foreach($category_filters as $cat){
        $html .= "  <select name='_$cat'>\r\n";
        
        if($cat == "type_of_costs")
          $arr = $this->query("SELECT ID, $cat FROM $cat ORDER BY $cat.is_income DESC, COALESCE(NULLIF($cat.sort_order, ''), 99) ASC, $cat", array(), "search_box_filters()");
        else
          $arr = $this->query("SELECT ID, $cat FROM $cat ORDER BY COALESCE(NULLIF($cat.sort_order, ''), 99)  ASC, $cat", array(), "search_box_filters()");
        
        // empty field first
        $html .= "    <option value='' class='select_title'>" . $this->format_title($cat, @$this->rename[$cat]) . " (".$this->translate('all').")</option>\r\n";
        
        foreach($arr as $key=>$val){
          
          $selected = "";
          if(!empty($_GET["_$cat"]) && $val['ID'] == $_GET["_$cat"])
            $selected .= ' selected="selected"';
          
          $html .= "    <option class='' value='".$val['ID']."'$selected>" . $val[$cat]."</option>\r\n";
          
        }
        
        $html .= "  </select>\r\n";
      }
      
      $html .= "</fieldset>\r\n";
      
    }
    
    return $html;
    
  }
  
  //////////////////////////////////////////////////////////////////////////////
  function search_box_filter_by_pos_neg_amount(){
    
    // purpose: return selectbox to filter by positive/negative/all amounts
    
    $html = "";
    
    $html .= "<fieldset>\r\n";
    
    $html .= "<select name='_amount'>";
    $selected = "";
    if( !empty($_GET["_amount"]) && $_GET["_amount"] != "pos" && $_GET["_amount"] != "neg" )
      $selected = " selected='selected'";
    $html .= "<option value=''$selected>".$this->translate('all')."</option>";
    $selected = "";
    if( !empty($_GET["_amount"]) && $_GET["_amount"] == "pos" )
      $selected = " selected='selected'";
    $html .= "<option value='pos'$selected>".$this->translate('income')."</option>";
    $selected = "";
    if( !empty($_GET["_amount"]) && $_GET["_amount"] == "neg" )
      $selected = " selected='selected'";
    $html .= "<option value='neg'$selected>".$this->translate('costs')."</option>";
    $html .= "</select>";
    
    $html .= "</fieldset>\r\n";
    
    return $html;
    
  }
  
  //////////////////////////////////////////////////////////////////////////////
  function search_box_filter_full_text_search(){
    
    // purpose: return input field for full text search
    
    // get input
    $_search = $this->clean_out(@$_REQUEST['_search']);
    $script_name = $this->get_uri_path() . $this->get_qs('_view,_lang');
    
    $html = "";
    $html .= "<input type='text' name='_search' value='$_search' size='20' class='lm_search_input'>";
    $html .= "<a href='$script_name' title='$this->grid_search_box_clear' class='button_clear_search'>x</a>";
    
    return $html;
    
  }
  
  //////////////////////////////////////////////////////////////////////////////
  function search_box_filter_eks_date_range(){
    
    // purpose: return select box with possible date ranges
    // used in EKS view
    
    $search_box = "";
    $start = new DateTime( $this->date_in($this->eks_config['eks']['eks_start_date']) );
    
    $today = new DateTime();
    
    $interval = DateInterval::createFromDateString('6 month');
    $period   = new DatePeriod($start, $interval, $today->modify("+6month"));
    
    $search_box .= "<select name='_from'>";
    foreach ($period as $dt) {
      $selected = "";
      if( !empty($_GET['_from']) && $dt->format($this->date_out) == $_GET['_from'] )
        $selected = " selected='selected'";
        
      $search_box .= "<option$selected>" . $dt->format($this->date_out) . "</option>";
    }
    $search_box .= "</select>";
    
    return $search_box;
    
  }
  
  //////////////////////////////////////////////////////////////////////////////
  function search_box_filter_choose_eks_profile(){
    
    // purpose: return selectbox to choose EKS profiles
    
    $html = "";
    
    $html .= "<span title='coming soon'> choose profile... </span>";
    
    return $html;
    
  }
  
  //////////////////////////////////////////////////////////////////////////////
  function search_box_filter_eks_estimated(){
    
    // purpose: return links for estimated or calculated EKS
    
    $uri = $this->get_uri_path();
    $qs = $this->get_qs();
    
    $html = "";
    
    $active = (@$_GET['_eks'] != 'estimated') ? " active" : "";
    $html .= "<a class='lm_button$active' href='$uri$qs'>".$this->translate('concluded', 'pretty')."</a>";
    
    $active = (@$_GET['_eks'] == 'estimated') ? " active" : "";
    $html .= "<a class='lm_button$active' href='$uri$qs&amp;_eks=estimated'>".$this->translate('estimated', 'pretty')."</a>";
    
    return $html;
    
  }
  
  //////////////////////////////////////////////////////////////////////////////
  function search_box_filters(){
    
    // purpose: more filters for searching and choose filters per view
    
    $html = "";
    
    $view = $this->get_view();
    
    // filter per view
    if( isset($this->config['view_filter'][$view]) ){
      
      // call filter function if it exists
      foreach($this->config['view_filter'][$view] as $filter){
        $function_name = "search_box_filter_".$filter;
        if( method_exists( $this, $function_name ) )
          $html .= $this->$function_name();
      }
      
    }
    else{
      
      // use all default filters
      $html .= $this->search_box_filter_by_pos_neg_amount();
      $html .= $this->search_box_filter_between_dates();
      $html .= $this->search_box_filter_missing_date();
      $html .= $this->search_box_filter_by_category();
      $html .= $this->search_box_filter_full_text_search();
      
    }
    
    return $html;
    
  }// end of search_box_filters()
  
  
  //////////////////////////////////////////////////////////////////////////////
  function search_box(){
    
    // purpose: search_box as own function, not inside grid()
    
    // local copies 
    $uri_path = $this->get_uri_path();
    
    // search bar
    $search_box = '';
    if($this->grid_show_search_box){
  
      // carry values defined in query_string_list
      $query_string_list_inputs = '';
      // if(mb_strlen($this->query_string_list) > 0){
        // $arr = explode(',', trim($this->query_string_list, ', '));
      if(mb_strlen($this->query_string_list_post) > 0){
        $arr = explode(',', trim($this->query_string_list_post, ', '));
        $arr[] = "_view";
        $arr[] = "_lang";
        foreach($arr as $val){
          $value = $this->clean_out(@$_REQUEST[$val]);
          if(mb_strlen($value) > 0)
            $query_string_list_inputs .= "<input type='hidden' name='$val' value='" . $value . "'>";
        }
          
      }
          
      $search_box = $this->grid_search_box;
      $search_box = str_replace('[script_name]', $uri_path . $this->get_qs('_view,_lang') , $search_box); // for 'x' cancel do add get_qs('') to carry query_string_list
      $search_box = str_replace('[_csrf]', $_SESSION['_csrf'], $search_box);
      $search_box = str_replace('[query_string_list]', $query_string_list_inputs, $search_box);
      $search_box = str_replace('[grid_search_box_search]', $this->grid_search_box_search, $search_box);
      $search_box = str_replace('[filters]', $this->search_box_filters($this->get_view()), $search_box);
    }

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
        $this->template($this->edit($error));
      else
        $this->template($this->index($error));

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
  
  //////////////////////////////////////////////////////////////////////////////
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
      $this->template($this->index($error));
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
      $this->template($this->edit($error));
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
  function insert(){

    // purpose: called from contoller to display insert() data
    // differences to lm: changed qs
    
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
      $this->template($this->edit($error));
      return;
    }

    // insert data
    $id = $this->sql_insert();

    // user function after insert
    if($this->after_insert_user_function != '')
      call_user_func($this->after_insert_user_function, $id);
    
    // send user back to edit screen if desired
    $action = '';
    if($this->return_to_edit_after_insert)
      $action = 'action=edit&';

    // redirect user
    $url = $this->get_uri_path() . "{$action}_success=1&$this->identity_name=$id&" . $this->get_qs('_view,_lang'); // do carry items defined in query_string_list, '' removes the default
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
      $this->template($this->edit($error));
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
    $url = $this->get_uri_path() . "{$action}_success=1&$this->identity_name=$id&" . $this->get_qs('_view,_lang'); // do carry items defined in query_string_list, '' removes the default
    $this->redirect($url, $id);

  }// end of duplicate()
  
  //////////////////////////////////////////////////////////////////////////////
  function cast_value($val, $column_name = '', $posted_from = 'form'){
      
    // purpose: cast data going into the database. set blanks null and format dates
    // returns: string
    // $column_name is not used right now but might be needed as a hack to cast by column name for databases like sqlite
    // missing types seem to always be numbers
    
    // changes in eEKS, compared to lm: added number_in)()

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
  function get_input_control($column_name, $value, $command, $called_from, &$validate = array()){

    // purpose: render html input based "command", if command is then try to call a user function
    // returns: html 
    
    // changes in eEKS, compared to lm: added number_out(), no inline styles
    
    // parse $command into $sql and $cmd, remove delimiter
    $pos = mb_strrpos($command, '--');
    $cmd = trim(mb_substr($command, $pos + 2));
    $sql = mb_substr($command, 0, $pos);

    // default
    if(mb_strlen($cmd) == 0)
      $cmd = 'text';

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
  function get_output_control($column_name, $value, $command, $called_from){

    // purpose: render html output based "command", if command is then try to call a user function
    // returns: html
    
    // changes in eEKS, compared to lm: added html_number_output()

    // get command only, no '--'
    $cmd = trim(mb_substr($command, mb_strrpos($command, '--') + 2));

    // default
    if(mb_strlen($cmd) == 0)
        $cmd = 'text';

    if($cmd == 'text')
      return $this->clean_out($value, $this->grid_ellipse_at); 
    // elseif($cmd == 'date')
      // return $this->date_out($value); 
    // elseif($cmd == 'datetime')
      // return $this->date_out($value, true); 
    elseif($cmd == 'date')
      return $this->html_date_output($value); 
    elseif($cmd == 'datetime')
      return $this->html_date_output($value, true); 
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
  
  //////////////////////////////////////////////////////////////////////////////
  function display_error($error, $source_function){
        
    // purpose: display errors to user.

    $msg = nl2br($this->clean_out("Error: $error\nSent From: $source_function"));
    
    $this->error .= "<div class='lm_error'><p>$msg</p></div>" ;

  }
  
  //////////////////////////////////////////////////////////////////////////////
  function export(&$result, $columns){

    // purpose: send database result in CSV format to browser. 

    if(mb_strlen($this->export_csv_file_name) > 0)
      $file_name = $this->export_csv_file_name;
    elseif(mb_strlen($this->table) > 0)
      $file_name = $this->clean_file_name($this->table . '.csv');
    else
      $file_name = 'download.csv';

    // output buffering required
    $level = 0;
    $arr = ob_get_status(true);
    if($arr)
      $level = count($arr);

    if($level <= 0){
      $error = "ob_start() or ob_start('ob_gzhandler') must be called at the beginning of the script to use CSV Export.";
      $this->display_error($error, 'export()');
      return;
    }

    // erase any existing buffers
    while($level >= 1 ){
      ob_end_clean();
      $level--;
    }

    if(!ob_start('ob_gzhandler'))
      ob_start();

    header("Cache-Control: maxage=1");
    header("Pragma: public");
    header("Content-Type: application/csv");
    header("Content-Disposition: attachment; filename=$file_name");

    // remove last column if last column is the identity that holds the [edit] and [delete] links
    if(end($columns) == $this->identity_name)
       array_pop($columns);
       
    // header row    
    $column_index = 0;
    foreach($columns as $key => $val){
      if($this->rename_csv_headers && isset($this->rename[$val]) && mb_strlen($this->rename[$val]) > 0)
        $val = $this->rename[$val];
      echo $this->export_escape($val, $column_index++);
    }

    echo "\r\n";

    // loop thru data
    $row_index = 0;
    foreach($result as $row){

      $column_index = 0;
      foreach($columns as $val)
        echo $this->export_escape($row[$val], $column_index++);
      
      $row_index++;

      echo "\r\n";
      
    }

    ob_end_flush();
    die();

  }
  
  //////////////////////////////////////////////////////////////////////////////
  function generate_pdf($url = ""){
    
    // purpose: generate PDF
    // requires wkhtmltopdf: https://wkhtmltopdf.org/downloads.html
    // see installation instructions in `docs/install.md`
    
    $path = "wkhtmltopdf";
    
    // try if wkhtmltopdf is installed and path is known
    if( !mb_substr(exec($path.' --version'), 0, 11) == "wkhtmltopdf" ){
      
      // set path to user defined path
      $path = $this->wkhtmltopdf_path;
    }
    // try with explicit path to wkhtmltopdf
    if( !mb_substr(exec($path.' --version'), 0, 11) == "wkhtmltopf" ){
      $error = 'wkhtmltopdf is not installed or the path '.$this->wkhtmltopdf_path.' is incorrect';
      $this->display_error($error, 'generate_pdf()');
      return;
    }
    else{
      
      // create folder if not exist
      if(!file_exists($this->pdf_path) && mb_strlen($this->pdf_path) > 0){
        mkdir($this->pdf_path, 0755);
        usleep(500);
      }
      
      
      // set page name as file name
      $filename = trim(strtolower($this->get_page_name()));
      
      // escape unwanted characters
      $filename = preg_replace('/[^A-Za-z0-9_\-]/', '_', $filename);
      
      // rename if file exists
      $filename = $this->upload_rename_if_exists($this->pdf_path, $filename);
      
      $ext = ".pdf";
      
      $file = $this->pdf_path ."/". $filename . $ext;
      
      // get complete url
      $port = '';
      $host = preg_replace('/:[0-9]+$/', '', $_SERVER['HTTP_HOST']); // host without port number
      $protocol = 'http://';
      if(@$_SERVER['HTTPS'] != '' && @$_SERVER['HTTPS'] != 'off')
        $protocol = 'https://';
      if(!($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] == '443'))
        $port = ':' . $_SERVER['SERVER_PORT'];
      
      $url = $protocol.$host.$port.$url;
      
      // set params
      $param = "";
      $param .= " --print-media-type";            // use print CSS
      $param .= " -L 10 -R 10 -B 10 -T 10";           // set margins to 0 for full size background images
      $param .= " -d 300";                        // dpi
      $param .= " --disable-smart-shrinking";     // Disable to make WebKit pixel/dpi ratio constant
      if( empty($_GET['_portrait']) && @$_GET['_portrait'] != 1 ) // wkhtmltopdf default: portrait
        $param .= " -O Landscape";                // orientation landscape as default for printing tables
        
      
      // use different params for EKS view
      if( !empty($_GET['_view']) && $_GET['_view'] == "eks" ){
        $param = " --print-media-type -L 0 -R 0 -B 0 -T 0 -d 300 --disable-smart-shrinking";
      }
      
      
      // execute wkhtmltopdf
      exec($path.$param.' "'.$url.'" '.$file);
      
      // pass pdf as download to user
      $fileinfo = pathinfo($file);
      $sendname = $fileinfo['filename'] . '.' . strtoupper($fileinfo['extension']);
      
      header('Content-Type: application/pdf');
      header("Content-Disposition: attachment; filename=\"$sendname\"");
      header('Content-Length: ' . filesize($file));
      readfile($file);
      die();
    }
    
  }
  
  //////////////////////////////////////////////////////////////////////////////
  function get_view(){
    
    // purpose: return name of current view
    
    if( !empty($_GET['_view']) && in_array($_GET['_view'], $this->views) )
      return $_GET['_view'];
    elseif( $this->get_action() == 'dashboard' || $this->get_action() == 'settings' )
      return "";
    else
      return "default";
  }
  
  //////////////////////////////////////////////////////////////////////////////
  function get_page_name(){
    
    // purpose: get a page name from action and view
    
    $title = "";
    
    // add action
    $title .= $this->translate($this->get_action(), "pretty");
    
    // add view
    if($this->get_view() != "default"){
      if(mb_strlen($title) > 0)
        $title .= " - ";
      $title .= $this->translate($this->get_view(), "pretty");
    }
    
    // add software name
    if(mb_strlen($title) > 0)
      $title .= " - ";
    $title .= "$this->software_name";
      
    return htmlspecialchars($title);
    
  }
  
  //////////////////////////////////////////////////////////////////////////////
  function version(){
    
    // purpose: until I don't have versioning show date of last commit
    // `last_commit.txt` will be created while `update.sh` runs
    // or as git hook
    
    if( file_exists('last_commit.txt') ){
      $arr = explode(",", file_get_contents('last_commit.txt'));
      return "<a href='https://github.com/raffaelj/eEKS/commit/$arr[1]'>last commit:</a> ". $this->date_out($arr[0], true);
    }
    else
      return "no version number available";
    
  }
  
  //////////////////////////////////////////////////////////////////////////////
  function get_qs($query_string_list = '_order_by,_desc,_offset,_search,_pagination_off,_view,_lang'){

    // purpose: render querysting. user selections for order, search, and page are carry from page to page. 
    // this maintains search state while paging, updating, etc...

    // append users additions
    if(mb_strlen($this->query_string_list) > 0)
        $query_string_list .= ',' . $this->query_string_list;

    $get = '';
    $arr = explode(',', trim($query_string_list, ','));
    foreach($arr as $var){
      if( !empty($_GET[$var]) ){
        if(!is_array($_GET[$var]))
          $get .= "&amp;$var=" . urlencode($_GET[$var]);
        else
          foreach($_GET[$var] as $key=>$val)
            $get .= "&amp;{$var}[]=" . urlencode($_GET[$var][$key]);
      }
    }

    return mb_substr($get, 5);

  }
  
  //////////////////////////////////////////////////////////////////////////////
  function redirect($url, $automatic = true){

    // purpose: redirect user to url
    // returns: html redirect
    // if $automatic is false user has to click "continue" to proceed. 
    
    // replace escaped ampersands from get_qs() with unescaped ampersands
    $url = str_replace('&amp;', '&', $url);

    if($automatic === false){
      // echo("<center><a href='$url'>Continue</a></center>");
      $this->template("<center><a href='$url'>Continue</a></center>");
      return;
    }
    
    // this feature is only used used with WordPress plugins - use a simple js redirect for WP
    if(mb_strlen($this->uri_path) > 0 || $this->redirect_using_js){
      $this->template("<script>window.location.href='$url';</script><noscript><a href='$url'>Continue</a></noscript>");
      return;
    }

    $port = '';    
    $host = preg_replace('/:[0-9]+$/', '', $_SERVER['HTTP_HOST']); // host without port number
    $protocol = 'http://';
    if(@$_SERVER['HTTPS'] != '' && @$_SERVER['HTTPS'] != 'off')
      $protocol = 'https://';
    if(!($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] == '443'))
      $port = ':' . $_SERVER['SERVER_PORT'];
    if(!isset($_SESSION))
      session_write_close();
    
    header("Location: $protocol$host$port$url");
    die;
  
  }
  
  //////////////////////////////////////////////////////////////////////////////
  function inject_rows_into_result( $result = array() ){
    
    // purpose: add arrays/rows into result from query() to display extra rows in grid
    // for example: sums of all columns, carryover
    // the keys of $this->inject_rows define the position
    // if string "last" is given --> push
    
    foreach($this->inject_rows as $key=>$val){
      
      if($key != "last")
        array_splice( $result, $key-1, 0, $val );
    
    }
    
    if(isset($this->inject_rows['last']))
      $result[] = $this->inject_rows['last'][0];
    
    return $result;
    
  }
  
  //////////////////////////////////////////////////////////////////////////////
  private $debug_count = 0;
  function debug($var, $str = "", $out = "print"){
    
    // purpose: output of readable content for arrays and variables

    $str = $this->debug_count.": $str";
        
    $html = "";
    $html .= "<div class='debug'>";
    $html .= "<input type='checkbox' id='debug$this->debug_count' /><label for='debug$this->debug_count' class='lm_button'>$str</label>";
    $html .= "<pre>";
    if($out == "export")
      $html .= var_export($var, true);
    elseif($out == "dump"){
      ob_start();
      var_dump($var);
      $html .= ob_get_clean();
    }
    else
      $html .= print_r($var, true);
    $html .= "</pre>";
    $html .= "</div>";
    
    $this->debug_count++;
    
    echo $html;
  }
  
  //////////////////////////////////////////////////////////////////////////////
  function get_pagination($count, $limit, $_offset, $_pagination_off){

        // purpose: pagination for grid
        
        // changes: added only ',_view,_lang' to get_qs()

        static $id = 0;    // for unique active page input id
        $get = $this->get_qs('_order_by,_desc,_search,_view,_lang');
        $active_page = floor($_offset / $limit) + 1; 
        $total_page = ceil($count / $limit);
        $uri_path = $this->get_uri_path();
        $pagination_text_records = $this->pagination_text_records;

        if($count <= 0)
            return;
          
        if($count == 1)
          $pagination_text_records = $this->pagination_text_record;

        $use_paging_link = '';
        if($_pagination_off == 1)
            $use_paging_link = " <a href='{$uri_path}_pagination_off=0&amp;$get' rel='nofollow'>$this->pagination_text_use_paging</a>";

        if($_pagination_off == 1 || $count <= $limit) 
            return "<p>" . number_format($count) . " $pagination_text_records$use_paging_link</p>";

        // simple text input for page number on giant datasets. use drop-down for smaller datasets.
        if($count > 100000){
            $input = "<input type='text' size='7' id='active_page_$id' value='$active_page' ><input type='button' value='$this->pagination_text_go' onclick='window.location.href=\"{$uri_path}_offset=\" + ((document.getElementById(\"active_page_$id\").value * $limit) - $limit) + \"&amp;$get\"'>";
        }
        else
        {
          $input = "";
          $input .= "<ul>";
          
          for($i = 0, $p = 1; $i < $count; $i += $limit, $p++){
            $sel = "";
            if($p == $active_page)
              $sel .= " class='active'";
            $input .= "<li$sel><a href='{$uri_path}_offset=$i&amp;$get'>$p</a></li>";
          }
          
          $input .= "</ul>";
        }        

        $pagination = "<p>$this->pagination_text_page: </p>$input <p>$this->pagination_text_of $total_page &nbsp; ";
        
        if($_offset == 0)
            $pagination .= " $this->pagination_text_back ";
        else
            $pagination .= " <a href='{$uri_path}_offset=" . ($_offset - $limit) . "&amp;$get'>$this->pagination_text_back</a> ";

        if($active_page >= $total_page)
            $pagination  .= " $this->pagination_text_next ";
        else
            $pagination  .= " <a href='{$uri_path}_offset=" . ($_offset + $limit) . "&amp;$get'>$this->pagination_text_next</a> ";

        $pagination .= " &nbsp; " . number_format($count) . " $pagination_text_records <a href='{$uri_path}_pagination_off=1&amp;$get' rel='nofollow'>$this->pagination_text_show_all</a></p>";

        $id++;
        return $pagination;

  }
  
  //////////////////////////////////////////////////////////////////////////////
  function grid_add_css_classes($row){
    
    // purpose: add CSS classes to rows and/or cells
    
    $class = "";
    
    if( isset($row['type_of_costs']) ){
      $sql = "SELECT COALESCE(is_income, 0) AS is_income FROM type_of_costs WHERE type_of_costs = '" . $row['type_of_costs']."'";
      $result = $this->query($sql);
      // $this->debug($result);
      
      
      if(isset($result[0]['is_income']) && $result[0]['is_income'] == 1)
        $class .= "is_income";
      elseif(isset($result[0]['is_income']))
        $class .= "is_cost";
      
    }
      // $class .= "test";
      
    return $class;
    
  }
  
  
  
  
  
  
}// end of class eEKS