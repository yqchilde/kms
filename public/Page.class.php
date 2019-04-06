<?php
/* 分页类
 * @Author: 于波 
 * @Date: 2019-02-18 14:37:46 
 * @Last Modified by:   于波 
 * @Last Modified time: 2019-02-18 14:37:46 
 */
class Page 
{
	private $result;
	private $pageId;
	private $pageSize;
	private $pageCount;
	private $recordCount;
	private $navigate;
	private $gotoUrl;
	private $prePage;
	private $nextPage;

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