<?php 
  class Database {
    use upercaseString;

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

  	public function toTable(string $tableName): Database {
      $this->tableName = $tableName;
      return $this;
  	}

  	public function insertRow(array $values): bool {
      $newValues = $this->upercaseString($values);
      
      // insert data
      $sttm = $this->conn->prepare($this->prepareInsert());
      $typeStr = $this->changeColumnType();
      $sttm->bind_param($typeStr, ...$newValues);
      $result = $sttm->execute();
      return $result;
  	}

  	public function getRows(string $condition = ""): Object {
      if ($condition == null) {
      	$sql = "SELECT * FROM " . $this->tableName;
      }
      else {
      	$sql = "SELECT * FROM " . $this->tableName . " WHERE " . $condition;
      }
      $result = $this->conn->query($sql);
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
        WHERE TABLE_NAME = '" . $this->tableName . "' 
        ORDER BY ORDINAL_POSITION";

      $result = $this->conn->query($sql);
      return $result;
    }    

    private function changeColumnType(): string {
      $result = $this->getColumnType();

      $typeStr = "";

      while ($row = $result->fetch_object()) {
        $type = $row->DATA_TYPE;
        if ($type === "int" || $type === "tinyint") {
          $type = "i";
        }
        else if (($type === "varchar" || $type === "text") || 
          ($type === "date" || $type === "timestamp")) {
          $type = "s";
        }
        $typeStr .= $type;
      }
      return $typeStr;
    }

    private function getColumnType(): Object {
      $sql = "SELECT DATA_TYPE 
        FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_NAME = '" . $this->tableName . "' 
        ORDER BY ORDINAL_POSITION";

      $result = $this->conn->query($sql);
      return $result;
    }
  }



  // $db = new Database();
  // echo $db->toTable($db->tableCreateAdmin)->insertRow([0, 2, 1, date("y-m-d h:i:s")]);
 ?>