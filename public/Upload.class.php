<?php
/* 文件上传类
 * @Author: 于波 
 * @Date: 2019-03-07 15:24:43 
 * @Last Modified by: 于波
 * @Last Modified time: 2019-03-07 15:56:53
 */

class Upload {
    private $allow_types = array('application/zip');
    private $max_size = 8388608; //8M大小
    private $upload_path = '';
    private $error = './';
    
    public function __construct($params = array())
    {
        if (isset($params['types'])) {
            $this->allow_types = $params['types'];
        }
        if (isset($params['size'])) {
            $this->max_size = $params['size'];
        }
        if (isset($params['path'])) {
            $this->upload_path = $params['path'];
        }
    }

    /**
     * 上传文件
     * @param array $file 包含文件的5个数据
     * @param string $prefix 前缀
     * @return string 目标文件名
     */
    public function up($file, $prefix = '')
    {
        if ($file['error'] != 0) {
            $upload_errors = array(
                1 => '文件过大，请上传小于8M的附件', 
                2 => '文件过大，请上传小于8M的附件', 
                3 => '文件没有上传完毕', 
                4 => '文件没有上传', 
                6 => '没有找到临时上传目录', 
                7 => '临时文件写入失败', 
            );
            $this->error = isset($upload_errors[$file['error']]) ? $upload_errors[$file['error']] :'未知错误';
            return false;
        }
        if (!in_array($file['type'], $this->allow_types)) {
            $this->error = '该类型不能上传，允许上传的类型为：' . implode('|',$this->allow_types);
            return false;
        }
        if ($file['size'] > $this->max_size) {
            $this->error = '文件不能超过' . $this->max_size . '字节';
            return false;
        }
        $new_file = uniqid($prefix) . strrchr($file['name'], '.');
        $sub_path = date("Ymd");
        $upload_path = $this->upload_path . $sub_path . '/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path);
        }
        if (move_uploaded_file($file['tmp_name'], $upload_path . $new_file)) {
            return $sub_path . '/' . $new_file;
        } else {
            $this->error = '移动失败';
            return false;
        }
    }

    /**
     * 获取错误值
     * @return string 错误原因
     */
    public function getError()
    {
        return $this->error;
    }
}