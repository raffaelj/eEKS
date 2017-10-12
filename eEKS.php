<?php

require_once('lazy_mofo.php');

class eEKS extends lazy_mofo{
  
  // custom non-LM variables
  
  public $eeks_config = array();
  
  
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
  
  function number_in($str){
    
    // purpose: convert local format to database format
    
    // ...
    
  }
  
  function number_out($str){
    
    // purpose: convert database format to local format
    
    // ...
    
  }
  
  
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
    
  
  
  // custom search box
    
    // filter by income/costs
    // filter by value date or voucher date
    // filters by categories
  
  
  // filter functions
    
    // see custom search box above
  
  
  // custom function cast_value
    
    // number output need i18n (dot and comma separators)
    // $this->number_out($value) instead of $this->clean_out($value)
  
  
  // custom function get_input_control (line: 1553)
    
    // get rid of inline styles (size, maxlength, rows, cols)
    // line 1602-1603:
    // elseif($cmd == 'number') ... $this->number_out($value)
  
  
  // custom function get_output_control (line: 1636)
    
    // number output need i18n (dot and comma separators)
    // elseif($cmd == 'number') ... return $this->number_out($value); 
  
  
  
  
}// end of class eEKS