<?php

class Login {
  
  private $password;
  
  function __construct() {
    session_start();
  }
  
  public function simplePassword($userInput, $password) {
      if($userInput == $password) {
        $_SESSION['simplePassword'] = $userInput;
        return true;
      } else {
        return false;
      }
  }
  
  public function simpleLogin($users, $username, $password) {
    foreach($users as $user) {
      if($user['username'] == $username && $user['password'] == $password || 
      $user['email'] == $username && $user['password'] == $password) {
        $_SESSION['username'] = $user['username'];
        return true;
      }
    }
    return false;
  }
  
  public function isLoggedIn(){
    if(isset($_SESSION['username'])) {
      return true;
    } else {
      return false;
    }
  }
  
  public function logout() {
    session_unset();
    session_destroy();
  }
  
}
