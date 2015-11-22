<?php

class Db {
	private $iniFile = "db.ini.php";
	private $pdo;
	private $sQuery;
	private $settings;
	private $bConnected = false;
	private $parameters;
	
	public function __construct(){
		$this->Connect();
		$this->parameters = array();	
	}
	
	private function Connect(){
		$this->settings = parse_ini_file($this->iniFile);
		$dsn = 'mysql:dbname='.$this->settings["dbname"].';host='.$this->settings["host"].'';
		try{
			$this->pdo = new PDO($dsn, $this->settings["user"], $this->settings["password"]);
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			$this->bConnected = true;
		}catch(PDOException $e){
			echo $e->getMessage();
			die();		
		}
	}
	
	public function CloseConnection(){
		$this->pdo = null;	
	}
	
	private function Init($query,$parameters = ""){
		if(!$this->bConnected) { 
			$this->Connect(); 
		}
		
		try {
			$this->sQuery = $this->pdo->prepare($query);
			$this->bindMore($parameters);
			
			if(!empty($this->parameters)) {
				
				foreach($this->parameters as $param){
					$parameters = explode("\x7F",$param);
					
					$this->sQuery->bindParam($parameters[0],$parameters[1]);				
				}
			}
			
			$this->succes 	= $this->sQuery->execute();	
		}catch(PDOException $e){
			echo $e->getMessage();		
			die();
		}	
		
		$this->parameters = array();
	}
	
	public function bind($param, $value){
		$this->parameters[sizeof($this->parameters)] = ":" . $param . "\x7F" . utf8_encode($value);	
	}
	
	public function bindMore($parArray){
		if(empty($this->parameters) && is_array($parArray)) {
			$columns = array_keys($parArray);
			foreach($columns as $i => &$column)	{
				$this->bind($column, $parArray[$column]);			
			}			
		}	
	}
	
	public function query($query,$params = null, $fetchmode = PDO::FETCH_ASSOC){
		$query = trim($query);
		$this->Init($query,$params);
		
		$rawStatement = explode(" ", $query);
		$statement = strtolower($rawStatement[0]);
		if ($statement === 'select' || $statement === 'show') {
			return $this->sQuery->fetchAll($fetchmode);		
		}elseif( $statement === 'insert' ||  $statement === 'update' || $statement === 'delete' ) {
						
			return $this->sQuery->rowCount();		
		}else {
			return NULL;		
		}	
	}
	
	public function lastInsertId() {
		return $this->pdo->lastInsertId();	
	}
	
	public function column($query,$params = null){
		$this->Init($query,$params);
		$Columns = $this->sQuery->fetchAll(PDO::FETCH_NUM);
		$column = null;
		foreach($Columns as $cells) {
			$column[] = $cells[0];
		}
		return $column;
	}
	
	public function row($query,$params = null,$fetchmode = PDO::FETCH_ASSOC){
		$this->Init($query,$params);
		return $this->sQuery->fetch($fetchmode);	
	}
	
	public function single($query,$params = null){
		$this->Init($query,$params);
		return $this->sQuery->fetchColumn();
	}
}
?>