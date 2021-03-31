<?php 
  declare(strict_types = 1);
  require "trait.php";
  require "GLOBAL_CONSTANT.php";
  require "Database.php";
  require "Customer.php";
  require "Menu.php";
  require "Order.php";


  $customer = new Customer("Hung", "0973593797");
  $customer->createCustomer();

  $order = new Order(5, "address1", "note1", "2121-12-12 12:12:12");
  $order->createOrder(new Customer("hung", "0973593797"), 1);

 ?>