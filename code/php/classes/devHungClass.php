<?php 
  declare(strict_types = 1);
  require "trait.php";
  require "GLOBAL_CONSTANT.php";
  require "Database.php";
  require "Customer.php";



  $c = new Customer("Hung", "0962772226");
  $c->createCustomer();

 ?>