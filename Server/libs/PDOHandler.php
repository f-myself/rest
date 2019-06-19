<?php

require_once "SQL.php";

class PDOHandler extends SQL
{

	private $pdoDriver;

	function __construct($drv=null)
	{
		parent::__construct();
		if ($drv == "pg" || $drv == "pgsql")
		{
			$this->pdoDriver = DB_DRV_PGSQL;
		} else {
			$this->pdoDriver = DB_DRV_MYSQL;
		}
	}

	public function doQuery()
	{
		$dbh = new PDO($this->pdoDriver . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
		$selectResult = [];
		if ($this->query)
		{
			$stmt = $dbh->prepare($this->query);
			$queryResult = $stmt->execute();
			//var_dump($result);
			$i = 0;
	        while ($row = $stmt->fetch(PDO::FETCH_OBJ)) 
	        {
	            $selectResult[$i] = $row;
	            $i++;
	        }
	        if($queryResult)
	        {
	        	if($selectResult)
	        	{
	        		$dbh = null;
	        		$stmt = null;
	        		return $selectResult;
	        	}
	        	$dbh = null;
	        	$stmt = null;
	        	return true;
	        }
	        $dbh = null;
	        $stmt = null;
	        return false;
		}
	}
}