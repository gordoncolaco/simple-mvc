<?php
class Controller
{
	protected $sessionobj;

	function __construct()
	{
		global $sessionobj;
		
		$this->sessionobj = $sessionobj;
	}

	public function getTableStatus()
	{
		$sql = "SHOW TABLE STATUS LIKE '".$this->tableName."'";
		$row = Db::getInstance()->fetchArray($sql);

		return $row;
	}
	
	public function getNewReference($table = '', $ref_field_name = 'reference')
	{
		$not_get_ref = true;
		$reference = '';
		$tableName = $this->tableName;

		if($table != '')
			$tableName = $table;

		while($not_get_ref)
		{
			$reference = Tools::getRandomId(12);

			$sql = "select count(1) as total from ".$tableName." where ".$ref_field_name." = '".$reference."'";
			$row = Db::getInstance()->fetchArray($sql);

			if($row['total'] == 0)
				$not_get_ref = false;
		}

		return $reference;
	}
}
