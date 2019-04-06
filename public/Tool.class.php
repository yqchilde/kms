<?php
/* 常用工具类
 * @Author: 于波 
 * @Date: 2019-02-16 20:36:12 
 * @Last Modified by: 于波
 * @Last Modified time: 2019-02-22 13:53:58
 */
class Tool
{
	public static function alert($info)
	{
		echo "<script>alert('$info');</script>";
		exit();
	}

	public static function alertGo($info, $url)
	{
		echo "<script>alert('$info');location.href='$url'</script>";
		exit();
	}

	public static function alertBack($info)
	{
		echo "<script>alert('$info');history.back();</script>";
		exit();
	}
}