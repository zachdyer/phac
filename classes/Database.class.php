<?php

class Database {
  public function readcsv($filename) {
    $file = fopen($filename, "r");
    $header = fgetcsv($file);
    $csv = array();
    while($data = fgetcsv($file)) {
      $record = array();
      foreach($data as $key=>$value) {
        if (is_numeric($value)) $value = floatval($value);
        $record[$header[$key]] = $value;
     }
     array_push($csv, $record);
    }
    fclose($file);
    return $csv;
  }
  
  // Returns html table of a csv file
  public function printcsv($filename) {
    $csv = $this->readcsv($filename);
    $html = "<table class='table'>";
    $html .= "<tr>";
    foreach($csv[0] as $key=>$value) {
      $html .= "<th scope='col'>";
      $html .= $key;
      $html .= "</th>";
    }
    
    foreach($csv as $row) {
      $html .= "<tr>";
      foreach($row as $cell) {
        $html .= "<td scope='row'>";
        $html .= $cell;
        $html .= "</td>";
      }
      $html .= "</tr>";
    }
    $html .= "</table>";
    return $html;
  }
  
  public function getColumn($column, $data_array) {
    $column_data = array();
    foreach($data_array as $data) {
      $column_data[] = $data[$column];
    }
    return $column_data;
  }
  
  public function writecsv($filename, $fields) {
    $file = fopen($filename, "a");
    $result = fputcsv($file, $fields); 
    fclose($file);
    return $result;
  }
  
  public function getAirtable($app = "appE9f3ZmmTXoN369",  $table = "Weight", $apikey = "keynZnxXDTPJQ1UsX") {

    if($data =  file_get_contents("https://api.airtable.com/v0/$app/$table?api_key=$apikey")) {
      $data = json_decode($data);
      return $data;
    } else {
      die("I could not retrieve the data");
    }
  }
}
