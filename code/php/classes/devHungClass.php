<?php 
  declare(strict_types = 1);
  require "trait.php";
  require "GLOBAL_CONSTANT.php";
  require "Database.php";
  require "Customer.php";
  require "Menu.php";
  require "Order.php";


  // $customer = new Customer("Hung", "0973593797");
  // $customer->createCustomer();

  // $menu = new Menu(1, "menu11", '', "img11");
  // $menu->createMenu();

  // $order = new Order(100, "address11", "note11", "2021-04-02 21:00:00");
  // $order->createOrder(new Customer("dung", "0962859206"), 11);

  // $db = new Database();
  // $condition = COL_IS_ACTIVE . " = " . MY_TRUE;
  // $result = $db->toTable($db->tableMenu)->updateRows([COL_IS_ACTIVE], [MY_FALSE], $condition);
  // echo var_dump($result);

  // $sql = "UPDATE menu SET " . 
  // COL_IS_ACTIVE . " = " . MY_TRUE . 
  // " WHERE " . COL_IS_ACTIVE . " = " . MY_FALSE;
  // $result = $db->conn->query($sql);
  // echo var_dump($result);

  // $db = new Database();
  // $condition = COL_NAME . " = " . "'Hung'";
  // $result = $db->toTable($db->tableCustomer)->updateRows([COL_NAME], ["'seal'"], $condition);  
  // echo var_dump($result);

  
 ?>