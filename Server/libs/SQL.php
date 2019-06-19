<?php

include "sql_config.php";

class SQL
{
	protected $select;
	protected $insert;
	protected $delete;
	protected $update;
	protected $from;
	protected $where;
	protected $join;
	protected $and;
	protected $leftJoin;
	protected $rightJoin;
	protected $crossJoin;
	protected $naturalJoin;
	protected $group;
	protected $having;
	protected $order;
	protected $limit;
	protected $query;
	protected $errors;

	function __construct ()
	{
			$this->select = "SELECT";
			$this->insert = "INSERT INTO";
			$this->delete = "DELETE FROM";
			$this->update = "UPDATE";
			$this->from = "FROM";
			$this->where = "WHERE";
			$this->join = "INNER JOIN";
			$this->and = "AND";
			$this->leftJoin = "LEFT OUTER JOIN";
			$this->rightJoin = "RIGHT OUTER JOIN";
			$this->crossJoin = "CROSS JOIN";
			$this->naturalJoin = "NATURAL JOIN";
			$this->group = "GROUP BY";
			$this->having = "HAVING";
			$this->order = "ORDER BY";
			$this->limit = "LIMIT";
			$this->query = "";
			$this->errors = [];
	}

	public function getErrors()
	{
		return $this->errors;
	}

	public function getQuery()
	{
		return $this->query;
	}

	public function newQuery()
	{
		$this->query = "";
		return $this;
	}

    public function select($columns=" *", $distinct=false)
    {
    	if ($this->query)
    		{
    			$this->query .= " " . $this->select;
    		} else {
    			$this->query .= $this->select;
    		}

    	if ($distinct === true)
    	{
    		$this->query .= " DISTINCT";
    	}

    	if (is_string($columns))
    	{
    		$this->query .= " $columns";
    		return $this;
    	}

    	if(is_array($columns))
    	{
    		foreach ($columns as $col) 
    		{
    			$this->query .= " " . trim($col) . ",";
    		}
    		$this->query = substr($this->query, 0, -1);
    		return $this;
    	}

    	array_push($this->errors, ERR_VAL_COLUMNS);
    	return $this;
    }

    public function from($tableName)
    {
    	if(is_string($tableName) and trim($tableName))
    	{
    		$this->query .= " $this->from " . trim($tableName);
    		return $this;
    	}
    	array_push($this->errors, ERR_VAL_TABLENAME);
    	return $this;
    }

    public function where ($conditions)
    {
    	if (is_string($conditions) and trim($conditions))
    	{
    		$this->query .= " $this->where ". trim($conditions);
    		return $this;
    	}
    	array_push($this->errors, ERR_VAL_CONDITIONS);
    	return $this;
    }

    public function join($tableName, $conditions)
    {
    	if ($tableName and is_string($tableName))
    	{
    		$this->query .= " $this->join " . trim($tableName);
    	} else {
    		array_push($this->errors, ERR_VAL_TABLENAME);
    	}

    	if (is_string($conditions))
    	{
    		$this->query .= " ON " . trim($conditions);
    		return $this;
    	}
    	array_push($this->errors, ERR_VAL_CONDITIONS);
    	return $this;
	}
	
	public function l_and($conditions)
	{
		if(is_string(trim($conditions)))
		{
			$this->query .= " AND " . trim($conditions);
			return $this;
		}
		array_push($this->errors, ERR_VAL_CONDITIONS);
    	return $this;
	}

    public function leftJoin($tableName, $conditions)
    {
    	if ($tableName and is_string($tableName))
    	{
    		$this->query .= " $this->leftJoin " . trim($tableName);
    	} else {
    		array_push($this->errors, ERR_VAL_TABLENAME);
    	}

    	if (is_string($conditions))
    	{
    		$this->query .= " ON " . trim($conditions);
    		return $this;
    	}
    	array_push($this->errors, ERR_VAL_CONDITIONS);
    	return $this;
    }

    public function rightJoin($tableName, $conditions)
    {
    	if ($tableName and is_string($tableName))
    	{
    		$this->query .= " $this->rightJoin " . trim($tableName);
    	} else {
    		array_push($this->errors, ERR_VAL_TABLENAME);
    	}

    	if (is_string($conditions))
    	{
    		$this->query .= " ON " . trim($conditions);
    		return $this;
    	}
    	array_push($this->errors, ERR_VAL_CONDITIONS);
    	return $this;
    }

    public function crossJoin($tableName)
    {
    	if(is_string($tableName) and trim($tableName))
    	{
    		$this->query .= " $this->crossJoin " . trim($tableName);
    		return $this;
    	}
    	array_push($this->errors, ERR_VAL_TABLENAME);
    	return $this;
    }

    public function naturalJoin($tableName)
    {
    	if(is_string($tableName) and trim($tableName))
    	{
    		$this->query .= " $this->naturalJoin " . trim($tableName);
    		return $this;
    	}
    	array_push($this->errors, ERR_VAL_TABLENAME);
    	return $this;
    }

    public function group($columns)
    {
    	$this->query .= " $this->group";

    	if (is_string($columns))
    	{
    		$this->query .= " $columns";
    		return $this;
    	}

    	if(is_array($columns))
    	{
    		foreach ($columns as $col) 
    		{
    			$this->query .= " " . trim($col) . ",";
    		}
    		$this->query = substr($this->query, 0, -1);
    		return $this;
    	}
    	array_push($this->errors, ERR_VAL_COLUMNS);
    	return $this;
    }

    public function having ($conditions)
    {
    	if (is_string($conditions) and trim($conditions))
    	{
    		$this->query .= " $this->having ". trim($conditions);
    		return $this;
    	}
    	array_push($this->errors, ERR_VAL_CONDITIONS);
    	return $this;
    }

    public function order($columns)
    {
    	$this->query .= " $this->order";

    	if (is_string($columns))
    	{
    		$this->query .= " $columns";
    		return $this;
    	}

    	if(is_array($columns))
    	{
    		foreach ($columns as $col) 
    		{
    			$this->query .= " " . trim($col) . ",";
    		}
    		$this->query = substr($this->query, 0, -1);
    		return $this;
    	}
    	array_push($this->errors, ERR_VAL_COLUMNS);
    	return $this;
    }

    public function limit($limit, $desc=false)
    {
		if(is_bool($desc) and false === $desc)
		{
			if (is_numeric($limit))
			{
				$this->query .= " $this->limit" . trim($limit);
				return $this;
			}
		} elseif (is_bool($desc) and true === $desc)
		{
			if (is_numeric($limit))
			{
				$this->query .= " DESC $this->limit " . trim($limit);
				return $this;
			}
		}
        array_push($this->errors, ERR_VAL_LIMIT);
    	return $this;
    }

    public function insert($tableName, $columns, $values)
    {
    	if(is_string($tableName) and trim($tableName))
    	{
    		$this->query .= "$this->insert " . trim($tableName);
    	} else {
    		array_push($this->errors, ERR_VAL_TABLENAME);
    		return $this;
    	}

    	if (is_string($columns))
    	{
    		$this->query .= " ($columns) ";
    	} elseif (is_array($columns)) 
    	{ 
    		$cols = implode(", ", $columns);
    		$this->query .= " ($cols) ";
    	} else {
    		array_push($this->errors, ERR_VAL_COLUMNS);
    		return $this;
    	}

    	if (is_string($values))
    	{
    		$this->query .= "VALUES ($values)";
    	} elseif (is_array($values)) 
    	{ 
    		$vals = implode(", ", $values);
    		$this->query .= "VALUES ($vals)";
    	} else {
    		array_push($this->errors, ERR_VAL_VALUES);
    		return $this;
    	}
    	return $this;
    }

    public function delete($tableName, $conditions)
    {
    	if(is_string($tableName) and trim($tableName))
    	{
    		$this->query .= " $this->delete " . trim($tableName);
    	} else {
    		array_push($this->errors, ERR_VAL_TABLENAME);
    		return $this;
    	}

    	if (is_string($conditions) and trim($conditions))
    	{
    		$this->query .= " $this->where ". trim($conditions);
    		return $this;
    	}
    	array_push($this->errors, ERR_VAL_CONDITIONS);
    	return $this;
    }

    public function update($tableName, $fields, $values, $conditions)
    {
    	if(is_string($tableName) and trim($tableName))
    	{
    		$this->query .= " $this->update " . trim($tableName);
    	} else {
    		array_push($this->errors, ERR_VAL_TABLENAME);
    		return $this;
    	}

    	if (is_array($fields) and is_array($values))
        {
            $this->query .= " SET ";
            $count = count($fields);
            foreach ($fields as $key => $field) {
                if($key != $count-1)
                {
                    $this->query .= "$field={$values[$key]}, ";
                } else {
                    $this->query .= "$field={$values[$key]}";
                }
            }
        } else {
        	array_push($this->errors, ERR_VAL_UPDATE);
    		return $this;
        }

        if (is_string($conditions) and trim($conditions))
    	{
    		$this->query .= " $this->where ". trim($conditions);
    		return $this;
    	}
    	array_push($this->errors, ERR_VAL_CONDITIONS);
    	return $this;
    }
}