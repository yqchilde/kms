<?php
/* 管理业务类
 * @Author: 于波 
 * @Date: 2019-02-16 17:20:23 
 * @Last Modified by: 于波
 * @Last Modified time: 2019-03-07 22:46:28
 */

header("Content-type: text/html; charset=UTF-8");
require_once(__DIR__ ."/../../public/Db.class.php");
class AdminModel
{
    /**
     * 登录
     * @param  object $admin  账号密码
     * @return booleam       预处理执行成功与否
     */
    public function login($admin)
    {
        $username = $admin->username;
        $password = md5($admin->password);
        $sql = "SELECT username,password FROM t_user WHERE username = ? AND password = ?";
        $db = Db::getInstance();
        $stmt = $db->mysqli->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $stmt->store_result();
        $result = $stmt->num_rows;// 取回全部查询结果
        $stmt->free_result();
        $stmt->close();
        return $result;
    }

    /**
     * 注册
     * @param object $admin   账号密码
     * @return boolean       预处理执行成功与否
     */
    public function register($admin)
    {
        $username = $admin->username;
        $password = md5($admin->password);
        $role_id = 2;//默认普通用户
        $sql = "INSERT INTO t_user (username, password, role_id) VALUES (?,?,?)";
        $db = Db::getInstance();
        $stmt = $db->mysqli->prepare($sql);
        $stmt->bind_param("ssi", $username, $password, $role_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * 获取用户名用于ajax查询
     * @param  string $username 账号密码
     * @return boolean          预处理执行成功与否
     */
    public function getUserByUsername($username)
    {
        $sql = "SELECT * FROM t_user WHERE username = ?";
        $db = Db::getInstance();
        $stmt = $db->mysqli->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        $result = $stmt->num_rows;
        $stmt->free_result();
        $stmt->close();
        return $result;

    }

    /**
     * 账号密码获取权限标识
     * @param  object $admin  获取用户账号密码
     * @return int           返回权限标识
     */
    public function getRoleByUser($admin)
    {
        $username = $admin->username;
        $password = md5($admin->password);
        $sql = "SELECT role_id FROM t_user WHERE username = ? AND password = ?";
        $db = Db::getInstance();
        $stmt = $db->mysqli->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        //获取到role
        $stmt->bind_result($role_id);
        $stmt->fetch();
        return $role_id;
        $stmt->close(); 
        echo $role_id;
    }

    /**
	 * 通过登录获取的账号密码获取ID
	 * @param  object $admin 用户登录账号密码
	 * @return int          在t_user中的ID
	 */
    public function getIdByUser($admin)
    {
        $username = $admin->username;
        $password = md5($admin->password);
        $sql = "SELECT user_id FROM t_user WHERE username = ? AND password = ?";
        $db = Db::getInstance();
        $stmt = $db->mysqli->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        //获取到id
        $stmt->bind_result($user_id);
        $stmt->fetch();
        return $user_id;
        $stmt->close();       
    }

    /**
     * 通过分页显示用户信息
     * @param object $page   分页的信息
     * @return object 
     */
    public function getUserByPage($page)
	{
        $start = ($page->pageId - 1) * $page->pageSize;
        $sql1 = "SELECT * FROM t_user WHERE state = 1 LIMIT $start, $page->pageSize";
        $sql2 = "SELECT COUNT(*) AS recordCount FROM t_user WHERE state = 1";
        $db = Db::getInstance();
        $db->dqlByPage($sql1, $sql2, $page);
    }
    
    /**
     * 搜索用户
     * @param object $admin  用户账号,用户权限
     * @return array        用户信息 
     */
    public function getUserBySearch($admin)
    {
        $username = $admin->username;
        $role_id = $admin->role_id;
        if ($role_id == '-1') {
            $sql = "SELECT user_id,username,user_realname,user_email,role_id FROM t_user WHERE username = ? AND state = 1";
        } elseif ($role_id == '1') {
            $sql = "SELECT user_id,username,user_realname,user_email,role_id FROM t_user WHERE username = ? AND role_id = 1 AND state = 1";
        } elseif ($role_id == '2') {
            $sql = "SELECT user_id,username,user_realname,user_email,role_id FROM t_user WHERE username = ? AND role_id = 2 AND state = 1";
        }
        $db = Db::getInstance();
        $stmt = $db->mysqli->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($user_id, $username, $user_realname, $user_email, $role_id);
        $stmt->fetch();
        return array ([
            'user_id' => $user_id,
            'username' => $username,
            'user_realname' => $user_realname,
            'user_email' => $user_email,
            'role_id' => $role_id
        ]);
        $stmt->close();  
    }

    /**
     * 通过ID删除用户
     * @param  object $admin  获取用户ID
     * @return booleam       预处理执行成功与否
     */
    public function setDelUserById($admin)
    {
        $user_id = $admin->user_id;
        $sql = "UPDATE t_user SET state = 0 WHERE user_id = ? ";
        $db = Db::getInstance();
        $stmt = $db->mysqli->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * 添加用户
     * @param  object $admin 获取账号密码
     * @return booleam      预处理执行成功与否
     */
    public function addUserInfo($admin)
    {
        $username = $admin->username;
        $password = $admin->password;
        $role_id = $admin->role_id;
        $sql = "INSERT INTO t_user (username, password, role_id) VALUES (?, ?, ?)";
        $db = Db::getInstance();
        $stmt = $db->mysqli->prepare($sql);
        $stmt->bind_param("sss", $username, $password, $role_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * 编辑用户信息
     * @param  object $admin  获取用户信息
     * @return booleam        预处理执行成功与否
     */
    public function editUserInfo($admin)
    {
        $user_id = $admin->user_id;
        $user_realname = $admin->user_realname;
        $user_email = $admin->user_email;
        $role_id = $admin->role_id;
        $sql = "UPDATE t_user SET user_realname = ?, user_email = ?, role_id = ? WHERE user_id = ?";
        $db = Db::getInstance();
        $stmt = $db->mysqli->prepare($sql);
        $stmt->bind_param("ssis", $user_realname, $user_email, $role_id, $user_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * 重置密码
     * @param  object $admin  获取用户id
     * @return boolean        执行预处理结果是否成功
     */
    public function resetPassword($admin)
    {
        $user_id = $admin->user_id;
        $password = md5(123456);
        $sql = "UPDATE t_user SET password = ? WHERE user_id = ?";
        $db = Db::getInstance();
        $stmt = $db->mysqli->prepare($sql);
        $stmt->bind_param("si", $password, $user_id);
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
        $start = ($page->pageId - 1) * $page->pageSize;
        $sql1 = "SELECT * FROM t_knowledge WHERE state != 0 ORDER BY knowledge_date DESC LIMIT $start, $page->pageSize";
        $sql2 = "SELECT COUNT(*) AS recordCount FROM t_knowledge WHERE state != 0";
        $db = Db::getInstance();
        $db->dqlByPage($sql1, $sql2, $page);
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
     * 审核知识不通过
     * @param  object $admin 知识的信息
     * @return boolean        执行预处理结果是否成功
     */
    public function setDelMsgById($admin)
    {
        $knowledge_id = $admin->knowledge_id;
        $knowledge_censor = $admin->knowledge_censor;
        $sql = "UPDATE t_knowledge SET knowledge_censor = ? , state = 0 WHERE knowledge_id = ?";
        $db = Db::getInstance();
        $stmt = $db->mysqli->prepare($sql);
        $stmt->bind_param("si",$knowledge_censor, $knowledge_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * 通过知识ID来发布知识
     * @param  object $msgId 知识的id
     * @return boolean        执行预处理结果是否成功
     */
    public function setPassMsgById($msgId)
    {
        $sql = "UPDATE t_knowledge SET state = 1 WHERE knowledge_id = ?";
        $db = Db::getInstance();
        $stmt = $db->mysqli->prepare($sql);
        $stmt->bind_param("i", $msgId);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * 通过ID获取知识内容
     * @param  object $msgId 知识的id
     * @return array        执行预处理结果取到的具体信息
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
     * 发布知识内容
     * @param  object $admin   发布知识的信息
     * @return boolean        执行预处理结果是否成功
     */
    public function setMsg($admin)
    {
        $user_id = $admin->user_id;
        $type_id = $admin->type_id;
        $knowledge_title = $admin->knowledge_title;
        $knowledge_msg = $admin->knowledge_msg;
        $knowledge_date = $admin->knowledge_date;
        $state = 1;
        $sql = "INSERT INTO t_knowledge (type_id, knowledge_title, knowledge_msg, knowledge_date, user_id, state) VALUES (?, ?, ?, ?, ?, ?)";
        $db = Db::getInstance();
        $stmt = $db->mysqli->prepare($sql);
        $stmt->bind_param("issssi", $type_id, $knowledge_title, $knowledge_msg, $knowledge_date, $user_id, $state);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * 更新知识内容
     * @param  object $admin   更新知识的信息
     * @return boolean        执行预处理结果是否成功
     */
    public function updateMsg($admin)
    {
        $knowledge_id = $admin->knowledge_id;
        $type_id = $admin->type_id;
        $knowledge_title = $admin->knowledge_title;
        $knowledge_msg = $admin->knowledge_msg;
        $knowledge_date = $admin->knowledge_date;
        $sql = "UPDATE t_knowledge SET type_id = ?, knowledge_title = ?, knowledge_msg = ?, knowledge_date = ?, state = 1 WHERE knowledge_id = ?";
        $db = Db::getInstance();
        $stmt = $db->mysqli->prepare($sql);
        $stmt->bind_param("isssi", $type_id, $knowledge_title, $knowledge_msg, $knowledge_date, $knowledge_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * 获取首页信息
     * @return boolean 预处理的执行成功与否
     */
    public function getHomeInfo()
    {
        $sql1 = "SELECT COUNT(*) AS userCount FROM t_user WHERE state = 1";
        $sql2 = "SELECT COUNT(*) AS knowledgeCount FROM t_knowledge WHERE state = 1";
        $db = Db::getInstance();
        $result = $db->dqlKmsInfo($sql1, $sql2);
        return $result;
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