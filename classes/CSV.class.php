<?php

class CSV {
  function read($filename) {
    $file = fopen($filename, "r");
    while($data = fgetcsv($file)) {
      
    }
  }
  
  function write() {
    
  }
    
}
