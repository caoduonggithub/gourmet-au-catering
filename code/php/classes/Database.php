<?php 
  class Database {
    use upercaseString;

  	private $serverName = "localhost";
  	private $userName = "root";
  	private $password = "";
  	private $dbName = "gourmet_catering";
  	private $tableName = "";
  	private $conn = null;

  	public $tableAdmin = TAB_ADMIN;
  	public $tableCreateAdmin = TAB_CREATE_ADMIN;
  	public $tableDeleteAdmin = TAB_DELETE_ADMIN;
  	public $tableCustomer = TAB_CUSTOMER;
  	public $tableOrder = TAB_ORDER;
  	public $tableUpdateOrder = TAB_UPDATE_ORDER;
  	public $tableMenu = TAB_MENU;
  	public $tableFood = TAB_FOOD;
  	public $tableMenuFood = TAB_MENU_FOOD;

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

    // get data
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

    // update data
    // if $values contains string value, that value must be endclose "" or '' 
    public function updateRows(array $columns, array $values, string $condition): bool {
      $len = count($columns);

      if ($len == count($values)) {
        $sql = "";
        for ($i=0; $i < $len; $i++) { 
          $sql .= $columns[$i] . " = " . $values[$i] . ", ";
        }
        $sql = chop($sql, ", ");
        $sql = "UPDATE " . $this->tableName . 
        " SET " . $sql . 
        " WHERE " . $condition;
        $result = $this->conn->query($sql);
        return $result;
      }
      else {
        return false;
      }
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
          ($type === "datetime" || $type === "timestamp")) {
          $type = "s";
        }
        else if ($type === "float") {
          $type = "d";
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

 ?>