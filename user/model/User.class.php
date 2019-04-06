<?php
/* 用户实体类
 * @Author: 于波 
 * @Date: 2019-02-18 13:52:14 
 * @Last Modified by: 于波
 * @Last Modified time: 2019-02-23 15:59:17
 */

header("Content-Type: text/html; charset=UTF-8");

class User
{
	private $user_id;
	private $username;
	private $password;
	private $user_realname;
	private $user_email;
	private $state;
	private $role_id;
	private $knowledge_id;
	private $knowledge_title;
	private $knowledge_msg;
	private $knowledge_date;
	private $type_id;
	private $knowledge_filename;


	public function __set($property, $value) 
	{
		$this->$property = $value;
	}

	public function __get($property) 
	{
		return isset($this->$property) ? $this->$property : null;
	}
}
?>