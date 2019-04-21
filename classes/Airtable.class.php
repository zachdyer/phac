<?php //Airtable class that handles the airtable api requests

class Airtable {
  private $api_key;
  private $app;
  
  function __construct($api_key = "keynZnxXDTPJQ1UsX", $app = "appE9f3ZmmTXoN369") {
    $this->api_key = $api_key;
    $this->app = $app;
  }
  
  public function getTable($table = "Weight") {
    if($data =  file_get_contents("https://api.airtable.com/v0/$this->app/$table?api_key=$this->api_key&view=Grid%20view")) {
      $data = json_decode($data);
      $data = $data->records;
      return $data;
    } else {
      die("I could not retrieve the data");
    }
  }
  
  public function selectField($field, $data) {
    $column = array();
    foreach($data as $row) {
      $column[] = $row->fields->{$field};
    }
    return $column;
  }
}
