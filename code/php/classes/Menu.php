<?php 
  class Menu {
    use createDetails;

    // order properties list (according to order columns in table)
    // must'n change
    private $id;
    private $adminId;
    private $name;
    private $description;
    private $menuImg;
    private $isActive;
    private $valueNum;
    private $valueUnit;
    private $createAt;

    public function __construct(int $adminId, string $name, string $description, 
    	string $menuImg, int $valueNum, int $id = 0, bool $isActive = true, 
    	string $valueUnit = MONEY_UNIT, $createAt = "") {

    	$this->id = $id;
    	$this->adminId = $adminId;
    	$this->name = $name;
    	$this->description = $description;
    	$this->menuImg = $menuImg;
    	$this->isActive = $isActive;
    	$this->valueNum = $valueNum;
    	$this->valueUnit = $valueUnit;
    }

    public function createMenu(): bool {

    	if ($this->checkUniqueName()) {

    		// insert to table menu
    		$this->createAt = date("y-m-d h:i:s");
    	  $details = $this->createDetails();
    	  $db = new Database();
    	  $db->toTable($db->tableMenu)->inserRow($details);

    	  // change is_active's value of other rows to false

    	}
    	else {
    		return false;
    	}
    }

   	// check rule: menu's name is unique
    private function checkUniqueName(): bool {
    	$name = $this->name;
    	$condition = COL_NAME . " = " . $name;
    	$db = new Database();
    	$result = $db->toTable($db->tableMenu)->getRows($condition);
      if ($result->num_rows > 0) {
      	return false;
      }  	
      else {
      	return true;
      }
    }

    public static function checkIsActive(int $menuId): bool {
      $db = new Database();
      $result = $db->toTable($db->tableMenu)->getRows(COL_ID . " = " . $menuId);
      if ($result->num_rows == 1) {
      	$row = $result->fetch_object();
      	$isActive = $row->is_active;
      	if ($isActive) {
      		return true;
      	}
      	else {
      		return false;
      	}
      }
      else {
      	return false;
      }
    }

    public static function checkValueNum(int $menuId): int {
      $db = new Database();
      $result = $db->toTable($db->tableMenu)->getRows(COL_ID . " = " . $menuId);
      if ($result->num_rows == 1) {
      	$row = $result->fetch_object();
      	$valueNum = $row->value_num;
      	return $valueNum;
      }
      else {
      	return 0;
      }
    }
  }

 ?>