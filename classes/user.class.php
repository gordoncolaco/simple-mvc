<?php
class User extends Controller
{
	protected $tableName;

	function __construct()
	{
		$this->tableName = "user";
		parent::__construct();
	}

	public function login($email, $password)
	{
		$sql = "select a.id_user, a.name, a.email, a.passwd, a.status
				from user a
				where a.email = '".Db::getInstance()->escape($email)."' ";

		$row = Db::getInstance()->fetchArray($sql);

		if(count($row) > 0)
		{
			$md5_password = md5($password);

			if($row['passwd'] != $md5_password)
				return "passwordmismatch";
			else if($row['status'] == 0)
				return "inactive";

			$this->sessionobj['user_id'] = $row['id_user'];
			$this->sessionobj['user_name'] = $row['name'];
			$this->sessionobj['user_email'] = $row['email'];
			return "success";
		}
		return "usernotfound";
	}
}

?>
