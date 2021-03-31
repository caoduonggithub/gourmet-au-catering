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