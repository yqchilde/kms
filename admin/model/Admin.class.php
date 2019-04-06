<?php
/* 管理实体类
 * @Author: 于波 
 * @Date: 2019-02-16 17:00:12 
 * @Last Modified by: 于波
 * @Last Modified time: 2019-02-22 21:47:02
 */

header("Content-type: text/html; charset=UTF-8");
class Admin
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
	private $knowledge_censor;
	private $knowledge_filename;
	private $type_id;
    
    public function  __set($property, $value)
    {
        $this->$property = $value;
    }

    public function __get($property)
    {
        return isset($this->$property) ? $this->$property : null;
    }
}