<?php // An object that handles mysql related requests

class MYSQL {
    private $mysqli;
    
    function __construct($host = "localhost", $db_name, $username, $password) {
        try {
            print $host;
            $this->mysqli = new mysqli($host, $username, $password, $db_name);
            if(!$this->mysqli) {
                throw new Exception("There was a problem connecting to the Database.");
            }
        } catch(Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        
    }
}
