<?php

require_once('lazy_mofo.php');

class eEKS extends lazy_mofo{
  
  // custom variables
  public $eeks_config = "";
  
  // template function
  // could be nicer but it works
  function template($content){
    include('themes/'.$this->eeks_config['eeks']['theme'].'/index.theme');
    echo $header;
    echo $content;
    echo $footer;
  }
  
  // custom grid
  
  // custom search box
  
  // filter functions
  
  // custom function get_columns($context = '') ?
  
  
    function edit($error = ''){

        // purpose: called from contoller to display form() and add or edit a record

        $this->template($this->form($error));

    }
    function index($error = ''){

        // purpose: called from contoller to display update() data

        $this->template($this->grid($error));

    }
}