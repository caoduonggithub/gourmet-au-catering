<?php 
  class Order {
    use createDetails;

    // order properties list (according to order columns in table)
    // must'n change
  	private $id;
    private $customerId;
    private $menuId;
    private $numOfPeo;
    private $address;
    private $note;
    private $deadline;
    private $valueNum;
    private $valueUnit;
    private $orderAt;

    public function __construct(int $numOfPeo, string $address, string $note, string $deadline, 
    	int $id = 0, int $customerId = 0, int $menuId = 0, float $valueNum = 0, 
    	string $valueUnit = MONEY_UNIT, string $orderAt = "") { 

    	$this->id = $id;
    	$this->customerId = $customerId;
    	$this->menuId = $menuId;
    	$this->numOfPeo = $numOfPeo;
    	$this->address = $address;
    	$this->note = $note;
      $this->deadline = $deadline;
      $this->valueNum = $valueNum;
      $this->valueUnit = $valueUnit;
      $this->orderAt = $orderAt;
    }

    // insert data to table customer_order
    public function createOrder(Customer $customer, $menuId): bool {
      // get customer's id
      $customerId;
      $result1 = $customer->getCustomer();
      if ($result1->num_rows == 1) {
        $row = $result1->fetch_object();
        $customerId = $row->id;
      }
      else {
      	return false;
      }

      // get menu's id which is active
      $result2 = Menu::checkIsActive($menuId);
      if ($result2) {
      	$this->customerId = $customerId;
      	$this->menuId = $menuId;
      	$this->valueNum = Menu::checkValueNum($menuId)*$this->numOfPeo;
      	$this->orderAt = date("y-m-d h:i:s");

        // insert data to table customer_order
        $details = $this->createDetails();
        $db = new Database();
        $result3 = $db->toTable($db->tableOrder)->insertRow($details);
        return $result3;
      }
      else {
      	return false;
      }
    }
  }

 ?>