<?php
/* 用户业务类
 * @Author: 于波 
 * @Date: 2019-02-18 14:10:00 
 * @Last Modified by: 于波
 * @Last Modified time: 2019-02-23 16:09:04
 */
header("Content-type: text/html; charset=UTF-8");
require_once(__DIR__ . '/../../public/Db.class.php');
class UserModel
{
	 /**
     * 通过session获取用户真实姓名和邮箱
     * @param  object $user  获取用户真实姓名和邮箱
     * @return boolean        执行预处理结果是否成功
     */
    public function getUserBySession($user)
    {
        $username = $user->username;
        $sql = "SELECT user_realname, user_email, password FROM t_user WHERE username = ? AND state = 1";
        $db = Db::getInstance();
        $stmt = $db->mysqli->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($user_realname, $user_email, $password);
        $stmt->fetch();
        return array([
            'user_realname' => $user_realname,
            'user_email' => $user_email,
            'password' => $password,
        ]);
        $stmt->close();
    }

    /**
     * 编辑用户信息
     * @param  object $user  获取用户信息
     * @return booleam        预处理执行成功与否
     */
    public function editUserInfo($user)
    {
        $user_id = $user->user_id;
        $user_realname = $user->user_realname;
        $user_email = $user->user_email;
        $role_id = $user->role_id;
        $sql = "UPDATE t_user SET user_realname = ?, user_email = ?, role_id = ? WHERE user_id = ?";
        $db = Db::getInstance();
        $stmt = $db->mysqli->prepare($sql);
        $stmt->bind_param("ssis", $user_realname, $user_email, $role_id, $user_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * 用户设置密码
     * @param  object $user  获取用户id
     * @return boolean        执行预处理结果是否成功
     */
    public function setPassword($user)
    {
        $user_id = $user->user_id;
        $password = md5($user->password);
        $sql = "UPDATE t_user SET password = ? WHERE user_id = ?";
        $db = Db::getInstance();
        $stmt = $db->mysqli->prepare($sql);
        $stmt->bind_param("si", $password, $user_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * 发布知识内容
     * @param  object $user   发布知识的信息
     * @return boolean        执行预处理结果是否成功
     */
    public function setMsg($user)
    {
        $user_id = $user->user_id;
        $type_id = $user->type_id;
        $knowledge_title = $user->knowledge_title;
        $knowledge_msg = $user->knowledge_msg;
        $knowledge_date = $user->knowledge_date;
        $knowledge_filename = $user->knowledge_filename;
        $sql = "INSERT INTO t_knowledge (type_id, knowledge_title, knowledge_msg, knowledge_date, user_id, knowledge_filename) VALUES (?, ?, ?, ?, ?, ?)";
        $db = Db::getInstance();
        $stmt = $db->mysqli->prepare($sql);
        $stmt->bind_param("isssss", $type_id, $knowledge_title, $knowledge_msg, $knowledge_date, $user_id, $knowledge_filename);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * 更新知识内容
     * @param  object $user   更新知识的信息
     * @return boolean        执行预处理结果是否成功
     */
    public function updateMsg($user)
    {
        $knowledge_id = $user->knowledge_id;
        $type_id = $user->type_id;
        $knowledge_title = $user->knowledge_title;
        $knowledge_msg = $user->knowledge_msg;
        $knowledge_date = $user->knowledge_date;
        $sql = "UPDATE t_knowledge SET type_id = ?, knowledge_title = ?, knowledge_msg = ?, knowledge_date = ?, state = 2 WHERE knowledge_id = ?";
        $db = Db::getInstance();
        $stmt = $db->mysqli->prepare($sql);
        $stmt->bind_param("isssi", $type_id, $knowledge_title, $knowledge_msg, $knowledge_date, $knowledge_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * 分页显示知识内容
     * @param  object $page 分页信息
     * @return void
     */
    public function getMsgByPage($page)
    {
        $user_id = $_SESSION['user_id'];
        $start = ($page->pageId - 1) * $page->pageSize;
        $sql1 = "SELECT * FROM t_knowledge WHERE user_id = $user_id ORDER BY knowledge_date DESC LIMIT $start, $page->pageSize";
        $sql2 = "SELECT COUNT(*) AS recordCount FROM t_knowledge WHERE user_id = $user_id";
        $db = Db::getInstance();
        $db->dqlByPage($sql1, $sql2, $page);
    }

    /**
     * 通过ID获取知识内容
     * @param  object $msgId 知识的id
     * @return array         执行预处理结果取到的具体信息
     */
    public function getMsgById($msgId)
    {
        $sql = "SELECT type_id,knowledge_title,knowledge_msg,knowledge_date,user_id,knowledge_censor,knowledge_filename FROM t_knowledge WHERE knowledge_id = ?";
        $db = Db::getInstance();
        $stmt = $db->mysqli->prepare($sql);
        $stmt->bind_param("i", $msgId);
        $result = $stmt->execute();
        $stmt->bind_result($type_id, $knowledge_title, $knowledge_msg, $knowledge_date, $user_id, $knowledge_censor, $knowledge_filename);
        $stmt->fetch();
        return array([
            'type_id' => $type_id,
            'knowledge_title' => $knowledge_title,
            'knowledge_msg' => $knowledge_msg,
            'user_id' => $user_id,
            'knowledge_date' => $knowledge_date,
            'knowledge_censor' => $knowledge_censor,
            'knowledge_filename' => $knowledge_filename,
        ]);
        $stmt->close();
    }

    /**
     * 通过知识ID来删除知识
     * @param  object $msgId 知识的id
     * @return boolean        执行预处理结果是否成功
     */
    public function setDelMsgById($msgId)
    {
        $sql = "DELETE FROM t_knowledge WHERE knowledge_id = ?";
        $db = Db::getInstance();
        $stmt = $db->mysqli->prepare($sql);
        $stmt->bind_param("i", $msgId);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * 通过user_id来获取用户名
     * @param  int $user_id   用户的id
     * @return array          执行预处理结果取到的具体信息
     */
    public function getUserByUserId($user_id)
    {
        $sql = "SELECT username FROM t_user WHERE user_id = ?";
        $db = Db::getInstance();
        $stmt = $db->mysqli->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $result = $stmt->execute();
        $stmt->bind_result($username);
        $stmt->fetch();
        return $username;
        $stmt->close();
    }

    /**
     * 通过搜索获取知识并以分页形式展开
     * @param  object $user   要搜素的关键词
     * @param  object $page   分页信息
     * @return boolean        执行预处理结果是否成功
     */
    public function getMsgBySearchPage($user, $page)
    {
        $knowledge_title = $user->knowledge_title;
        $knowledge_msg = $user->knowledge_msg;
        $type_id = $user->type_id;
        $start = ($page->pageId - 1) * $page->pageSize;
        if ($user->type_id == 0) {
            $sql1 = "SELECT type_id, knowledge_id, knowledge_title, knowledge_msg, knowledge_date, knowledge_censor, user_id FROM t_knowledge WHERE state = 1 AND (knowledge_title LIKE '%$knowledge_title%' OR knowledge_msg LIKE '%$knowledge_msg%') ORDER BY knowledge_date DESC LIMIT $start, $page->pageSize";
            $sql2 = "SELECT COUNT(*) AS recordCount FROM t_knowledge WHERE state = 1 AND (knowledge_title LIKE '%$knowledge_title%' OR knowledge_msg LIKE '%$knowledge_msg%')";
        } else {
            $sql1 = "SELECT type_id, knowledge_id, knowledge_title, knowledge_msg, knowledge_date, knowledge_censor, user_id FROM t_knowledge WHERE state = 1 AND type_id = $type_id AND (knowledge_title LIKE '%$knowledge_title%' OR knowledge_msg LIKE '%$knowledge_msg%') ORDER BY knowledge_date DESC LIMIT $start, $page->pageSize";
            $sql2 = "SELECT COUNT(*) AS recordCount FROM t_knowledge WHERE state = 1 AND type_id = $type_id AND (knowledge_title LIKE '%$knowledge_title%' OR knowledge_msg LIKE '%$knowledge_msg%')";
        }
        $db = Db::getInstance();
        $db->dqlByPage($sql1, $sql2, $page);

        // $db = Db::getInstance();
        // $stmt = $db->mysqli->prepare($sql);
        // $stmt->execute();
        // $stmt->store_result();
        // $stmt->bind_result($type_id, $knowledge_title, $knowledge_msg, $knowledge_date, $user_id); 
        // if ($stmt->num_rows == 0) {
        //     $data = [];
        // } else {
        //     for ($i=0; $i < $stmt->num_rows ; $i++) { 
        //         $stmt->fetch();
        //         $data[$i]=[
        //         'type_id' => $type_id,
        //         'knowledge_title' => $knowledge_title,
        //         'knowledge_msg' => $knowledge_msg,
        //         'knowledge_date' => $knowledge_date,
        //         'user_id' => $user_id,             
        //         ];
        //     }
        // }
        // return $data;
        // $stmt->close();
    }

    /**
     * 获取首页信息
     * @return boolean 预处理的执行成功与否
     */
    public function getNewInfo()
    {
        $sql = "SELECT knowledge_id, knowledge_title, knowledge_date FROM t_knowledge WHERE state != 0 ORDER BY knowledge_date DESC LIMIT 0,6";
        $db = Db::getInstance();
        $stmt = $db->mysqli->prepare($sql);
        $result = $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($knowledge_id, $knowledge_title, $knowledge_date);
        if ($stmt->num_rows == 0) {
            $data = [];
        } else {
            for ($i=0; $i < $stmt->num_rows ; $i++) { 
                $stmt->fetch();
                $data[$i]=[
                    'knowledge_id' => $knowledge_id,
                    'knowledge_title' => $knowledge_title,
                    'knowledge_date' => $knowledge_date,
                ];
            }
        }
        return $data;
        $stmt->close();
    }

    /**
     * 获取首页信息
     * @return boolean 预处理的执行成功与否
     */
    public function getCodeInfo()
    {
        $sql = "SELECT knowledge_id, knowledge_title, knowledge_date FROM t_knowledge WHERE state != 0 AND type_id = 2 ORDER BY knowledge_date DESC LIMIT 0,6";
        $db = Db::getInstance();
        $stmt = $db->mysqli->prepare($sql);
        $result = $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($knowledge_id, $knowledge_title, $knowledge_date);
        if ($stmt->num_rows == 0) {
            $data = [];
        } else {
            for ($i=0; $i < $stmt->num_rows ; $i++) { 
                $stmt->fetch();
                $data[$i]=[
                    'knowledge_id' => $knowledge_id,
                    'knowledge_title' => $knowledge_title,
                    'knowledge_date' => $knowledge_date,
                ];
            }
        }
        return $data;
        $stmt->close();
    }

     /**
     * 获取首页信息
     * @return boolean 预处理的执行成功与否
     */
    public function getWebInfo()
    {
        $sql = "SELECT knowledge_id, knowledge_title, knowledge_date FROM t_knowledge WHERE state != 0 AND type_id = 3 ORDER BY knowledge_date DESC LIMIT 0,6";
        $db = Db::getInstance();
        $stmt = $db->mysqli->prepare($sql);
        $result = $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($knowledge_id, $knowledge_title, $knowledge_date);
        if ($stmt->num_rows == 0) {
            $data = [];
        } else {
            for ($i=0; $i < $stmt->num_rows ; $i++) { 
                $stmt->fetch();
                $data[$i]=[
                    'knowledge_id' => $knowledge_id,
                    'knowledge_title' => $knowledge_title,
                    'knowledge_date' => $knowledge_date,
                ];
            }
        }
        return $data;
        $stmt->close();
    }

     /**
     * 获取首页信息
     * @return boolean 预处理的执行成功与否
     */
    public function getImgInfo()
    {
        $sql = "SELECT knowledge_id, knowledge_title, knowledge_date FROM t_knowledge WHERE state != 0 AND type_id = 4 ORDER BY knowledge_date DESC LIMIT 0,6";
        $db = Db::getInstance();
        $stmt = $db->mysqli->prepare($sql);
        $result = $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($knowledge_id, $knowledge_title, $knowledge_date);
        if ($stmt->num_rows == 0) {
            $data = [];
        } else {
            for ($i=0; $i < $stmt->num_rows ; $i++) { 
                $stmt->fetch();
                $data[$i]=[
                    'knowledge_id' => $knowledge_id,
                    'knowledge_title' => $knowledge_title,
                    'knowledge_date' => $knowledge_date,
                ];
            }
        }
        return $data;
        $stmt->close();
    }

     /**
     * 获取首页信息
     * @return boolean 预处理的执行成功与否
     */
    public function getTemplateInfo()
    {
        $sql = "SELECT knowledge_id, knowledge_title, knowledge_date FROM t_knowledge WHERE state != 0 AND type_id = 5 ORDER BY knowledge_date DESC LIMIT 0,6";
        $db = Db::getInstance();
        $stmt = $db->mysqli->prepare($sql);
        $result = $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($knowledge_id, $knowledge_title, $knowledge_date);
        if ($stmt->num_rows == 0) {
            $data = [];
        } else {
            for ($i=0; $i < $stmt->num_rows ; $i++) { 
                $stmt->fetch();
                $data[$i]=[
                    'knowledge_id' => $knowledge_id,
                    'knowledge_title' => $knowledge_title,
                    'knowledge_date' => $knowledge_date,
                ];
            }
        }
        return $data;
        $stmt->close();
    }

    /**
     * 文件下载
     * @param object $user 
     * @return void
     */
    public function downloadFile($user)
    {
        $knowledge_filename = $user->knowledge_filename;
        $fileurl = '../../public/file/' . $_GET['filename'];
        if(!file_exists($fileurl)){
            exit("无法找到文件"); //即使创建，仍有可能失败。。。。
        }
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header('Content-disposition: attachment; filename='.basename($fileurl)); //文件名
        header("Content-Type: application/zip"); //zip格式的
        header("Content-Transfer-Encoding: binary"); //告诉浏览器，这是二进制文件
        header('Content-Length: '. filesize($fileurl)); //告诉浏览器，文件大小
        ob_clean();   //*******************修改部分*******************************
        flush();     //*******************修改部分*******************************
        @readfile($fileurl);
    }
}
?>