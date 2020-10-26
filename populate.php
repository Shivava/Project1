<?php

// OUTMOST IMPORTANT!!!!!!! run het file EEN keer bij het begin van de applicatie!!!!!@#!@#!@#@!#!@
include 'database.php';
class populate{

  public function populate_database(){
    $database = new database('localhost', 'root', '', 'project1', 'utf8');

    $database->populate_table_usertype();

    // roept de sign_up methode van de database class
    $database->create_or_update_user('admin', 'admin', 'peter', NULL, 'boom', 'p.boom@test.com', 'admin');
    $database->create_or_update_user('user', 'user', 'nilu', NULL, 'li', 'n.lican1@test.com', 'user');
  }
}


?>
