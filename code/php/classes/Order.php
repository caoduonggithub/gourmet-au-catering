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
    private $valueUnit = MONEY_UNIT;
    private $orderAt = date("y-m-d h:i:s");

    public function __construct(int $id, int $customerId, int $menuId, int $numOfPeo, 
    	string $address, string $note, string $deadline, int $valueNum, $valueUnit, 
    	string $orderAt) { 

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
  }

 ?>