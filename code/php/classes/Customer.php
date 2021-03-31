<?php 
  class Customer {
    use createDetails;
    
    // order properties list (according to order columns in table)
    // must'n change
    private $id;
    private $name;
    private $phone;

    public function __construct(string $name, string $phone, int $id = 0) {
      $this->id = $id;
      $this->name = $name;
      $this->phone = $phone;
    }

    // insert data to table customer
    public function createCustomer(): bool {
      $details = $this->createDetails();

      //check if the customer is existed
      $result = $this->getCustomer();
      if ($result->num_rows == 0) {
        $db = new Database();
        $result = $db->toTable($db->tableCustomer)->insertRow($details);
        return $result;
      }
      else {
        return false;
      }
    }

    public function getCustomer(): Object {
      $condition = COL_NAME . " = '" . $this->name . "' " . 
      "AND " . COL_PHONE . " = '" . $this->phone . "'";

      $db = new Database();
      $result = $db->toTable($db->tableCustomer)->getRows($condition);
      return $result;
    }
  }

 ?>