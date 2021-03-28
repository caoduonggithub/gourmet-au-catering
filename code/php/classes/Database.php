<?php 
  class Database {
  	private $serverName = "localhost";
  	private $userName = "root";
  	private $password = "";
  	private $dbName = "gourmet_catering";
  	private $tableName = "";
  	private $conn = null;

  	public $tableAdmin = "admin";
  	public $tableCreateAdmin = "create_admin";
  	public $tableCustomer = "customer";
  	public $tableOrder = "customer_order";
  	public $tableDeleteAdmin = "delete_admin";
  	public $tableFood = "food";
  	public $tableMenu = "menu";
  	public $tableMenuFood = "menu_food";
  	public $tableUpdateOrder = "update_order";

  	public function __construct() {
      $this->conn = new mysqli($this->serverName, $this->userName, $this->password, $this->dbName);
  	}

  	public function toTable($tableName): Database {
      $this->tableName = $tableName;
      return $this;
  	}

  	public function insertRow($typeStr, $values): bool {
      $sttm = $this->conn->prepare($this->prepareInsert());
      $sttm->bind_param($typeStr, ...$values);
      $result = $sttm->execute();
      return $result;
  	}

  	public function getRows($condition = ""): Object {
      if ($condition == "") {
      	$sql = "SELECT * FROM " . $this->tableName;
      }
      else {
      	$sql = "SELECT * FROM " . $this->tableName . " WHERE " . $condition;
      }
      $result = $this->conn->query($sql);
      print_r($result);
      return $result;
  	}

  	private function prepareInsert(): string {
      $result = $this->getColumnName();
  		$numOfColumns = $result->num_rows;

  		$columnNames = "(";
  		$hideValue = "(?";
  		while($row = $result->fetch_object()) {
    		$columnNames .= $row->COLUMN_NAME . ", ";
    		$hideValue .= ", ?";
  		}
  		$columnNames = chop($columnNames, ", ");
  		$columnNames .= ")";
  		$hideValue = chop($hideValue, "?");
  		$hideValue = chop($hideValue, ", ");
  		$hideValue .= ")";

  		$prepare = "INSERT INTO " . $this->tableName . " " . $columnNames . " VALUES " . $hideValue; 
  		return $prepare;
  	}

  	private function getColumnName(): Object {
      $sql = "SELECT COLUMN_NAME 
  			FROM INFORMATION_SCHEMA.COLUMNS 
  			WHERE TABLE_NAME = '" . $this->tableName . "' AND NOT COLUMN_NAME = 'id'
  			ORDER BY ORDINAL_POSITION";

  		$result = $this->conn->query($sql);
  		return $result;
  	}
  }
 ?>