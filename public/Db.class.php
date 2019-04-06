<?php
/* 数据库操作类
 * @Author: 于波 
 * @Date: 2019-02-16 15:01:59 
 * @Last Modified by: 于波
 * @Last Modified time: 2019-02-23 15:04:57
 */

header("Content-type: text/html; charset=UTF-8");
require_once(__DIR__. '/config.php');

class Db 
{
	public $mysqli;
	private $hostname = HOSTNAME;
	private $username = USERNAME;
	private $password = PASSWORD;
	private $database = DATABASE;
	private static $instance;

	private function __construct()
	{
		$this->mysqli = new mysqli($this->hostname, $this->username, $this->password, $this->database);
		if ($this->mysqli->connect_errno) {
			die("数据库链接失败");
			exit();
		}
		$this->mysqli->set_charset('utf-8');
	}

	public function __destruct()
	{
		if ($this->mysqli) {
			$this->mysqli->close();
		}
	}
	
	/**
	 * 获得单例对象的公共接口方法
	 * @return [object]  [单例的对象]
	 */
	public static function getInstance()
	{
		if (!self::$instance instanceof self) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __clone() {}

	/**
	 * 分页查询
	 * @param  [string] $sql1  sql语句取出所有数据
	 * @param  [string] $sql2  sql语句取出总记录数
	 * @param  [string] $page  page是为了取出实体类中的成员
	 * @return [int]  
	 */
	public function dqlByPage($sql1, $sql2, $page)
	{
		//获取存放结果集的数组
		$result = $this->mysqli->query($sql1) or die("数据库操作失败");
		$arrUser = [];
		while ($row = $result->fetch_assoc()) {
			$arrUser[] = $row;
		}
		$result->free();
		$page->result = $arrUser;
		//获取总记录数,总页数
		$result = $this->mysqli->query($sql2) or die("数据库操作失败");
		//从结果集中取得一行，并作为枚举数组返回
		if ($row = $result->fetch_row()) {
			$page->recordCount = $row[0];
			$page->pageCount = ceil($page->recordCount / $page->pageSize);
		}
		$result->free();
		//计算分页
		$prePage = $page->pageId <= 1 ? 1 : $page->pageId - 1;
		$page->prePage = $prePage;

		$nextPage = $page->pageId >= $page->pageCount ? $page->pageCount : $page->pageId + 1;
		$page->nextPage = $nextPage;	
	}

	public function dqlKmsInfo($sql1, $sql2)
	{
		$result = $this->mysqli->query($sql1) or die("数据库操作失败");
		$arrUser = [];
		while ($row = $result->fetch_assoc()) {
			$arrUser = $row;
		}
		$result->free();
		$result = $this->mysqli->query($sql2) or die("数据库操作失败");
		$arrKnowledge = [];
		while ($row = $result->fetch_assoc()) {
			$arrKnowledge = $row;
		}
		$result->free();
		return([
			'userCount' => $arrUser['userCount'],
			'knowledgeCount' => $arrKnowledge['knowledgeCount'],
		]);
	}
}