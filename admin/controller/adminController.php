<?php
/*
 * @Author: 于波 
 * @Date: 2019-02-16 20:32:23 
 * @Last Modified by: 于波
 * @Last Modified time: 2019-02-22 22:18:56
 */
if(!isset($_SESSION)){
    session_start();
}
require_once __DIR__ .'/../model/AdminModel.class.php';
require_once __DIR__ .'/../model/Admin.class.php';
require_once __DIR__ .'/../../public/Tool.class.php';
require_once __DIR__ .'/../../public/Page.class.php';
$adminModel = new AdminModel();
if (isset($_REQUEST["flag"])) {
    $flag = $_REQUEST["flag"];
    switch ($flag) {
        case 'checkUsername':
            $username = $_POST["username"];
            $isExist = $adminModel->getUserByUsername($username);
            if ($isExist == 0) {
                echo "<script>
                $(function(){
                    $('#tips').html('该账号可以注册');
                    $('#tips').removeClass('error').addClass('success');
                });
                </script>";
            } else {
                echo "<script>
                $(function(){
                    $('#tips').html('该账号已被注册,请换个用户名');
                    $('#tips').removeClass('success').addClass('error');
                });
                </script>";
            }
            break;

        case 'register':
            if ($_POST) {
                $admin = new Admin();
                $admin->username = $_POST["username"];
                $admin->password = $_POST["password"];
                $result = $adminModel->register($admin);
                if ($result == 1) {
                    Tool::alertGo("注册成功","adminController.php?flag=login");
                } else {
                    Tool::alertBack("注册失败");
                }
            } else {
                require("../view/register.php");
            }
            break;
        
        case 'login':
            //先判断前台验证码验证
            if ($_POST) {
                if ($_SESSION["captcha"] != $_POST["captcha"]) {
                    header("location:adminController.php?flag=login&errno=2");
                    exit();
                }
                $admin = new Admin();
                $admin->username = $_POST['username'];
                $admin->password = $_POST['password'];
                $result = $adminModel->login($admin);
                if ($result == 1) {
                    $_SESSION["username"] = $_POST["username"];
                    $_SESSION["user_id"] = $adminModel->getIdByUser($admin);
                    $role_id = $adminModel->getRoleByUser($admin);
                    if ($role_id == 1) {
                        //如果是管理员进入admin.php
                        header("location:adminController.php?flag=admin");
                        exit();
                        //如果是普通用户进入user.php
                    } elseif ($role_id == 2) {
                        header("location:../../user/controller/userController.php?flag=user");
                        exit();
                    }
                } else {
                    header("location:adminController.php?flag=login&errno=1");
                }
            }
            require("../view/login.php");
            break;

        case 'admin':
            if (isset($_GET["src"])) {
                $src = $_GET["src"];
                switch ($src) {
                    //k1表示知识管理首页
                    case 'k1':
                        //判断是否打开编辑页面
                        if (isset($_GET["edit"])) {
                            $msgId = $_GET["edit"];
                            $msgInfo = $adminModel->getMsgById($msgId);
                            require("../view/adminContentEdit.php");
                        //判断是否是进行文章不通过操作
                        } elseif (isset($_GET["delete"])) {
                            $admin = new Admin();
                            $admin->knowledge_id = $_GET["delete"];
                            $admin->knowledge_censor = $_POST["censor"];
                            $result = $adminModel->setDelMsgById($admin);
                            if ($result == 1) {
                                $page = new Page();
                                $page->pageSize = 6;
                                $page->pageId = empty($_GET['pageId']) ? 1 : $_GET['pageId'];
                                $page->gotoUrl = 'adminController.php?flag=admin&src=k1';
                                $adminModel->getMsgByPage($page);
                                $msgInfo = $page->result;
                                if ($msgInfo != null) {
                                    foreach ($msgInfo as $key => $value) {
                                        $msgInfo[$key]['user_id'] = $adminModel->getUserByUserId($msgInfo[$key]['user_id']);
                                    }
                                }
                                require("../view/adminContentList.php");
                            } else {
                                Tool::alertBack("删除失败");
                            }
                        //判断是否是进行通过文章操作
                        }elseif (isset($_GET["view"])) {
                            $msgId = $_GET["view"];
                            $result = $adminModel->setPassMsgById($msgId);
                            if ($result == 1) {
                                $page = new Page();
                                $page->pageSize = 6;
                                $page->pageId = empty($_GET['pageId']) ? 1 : $_GET['pageId'];
                                $page->gotoUrl = 'adminController.php?flag=admin&src=k1';
                                $adminModel->getMsgByPage($page);
                                $msgInfo = $page->result;
                                if ($msgInfo != null) {
                                    foreach ($msgInfo as $key => $value) {
                                        $msgInfo[$key]['user_id'] = $adminModel->getUserByUserId($msgInfo[$key]['user_id']);
                                    }
                                }
                                require("../view/adminContentList.php");
                            } else {
                                Tool::alertBack("请重新尝试审核文章!");
                            }
                        } else {
                            //以分页的形式展示知识内容
                            $page = new Page();
                            $page->pageSize = 6;
                            $page->pageId = empty($_GET['pageId']) ? 1 : $_GET['pageId'];
                            $page->gotoUrl = 'adminController.php?flag=admin&src=k1';
                            $adminModel->getMsgByPage($page);
                            $msgInfo = $page->result;
                            if ($msgInfo != null) {
                                foreach ($msgInfo as $key => $value) {
                                    $msgInfo[$key]['user_id'] = $adminModel->getUserByUserId($msgInfo[$key]['user_id']);
                                }
                            }
                            require("../view/adminContentList.php");
                        }
                        break;
                    //k2表示添加知识页面
                    case 'k2':
                        //发布知识
                        if (isset($_GET["post"])) {
                            if (isset($_FILES['file'])) {
                                $params = array(
                                    'types' => array('application/octet-stream'),
                                    'size' => 8388608,
                                    'path' => '../../public/file/file', 
                                );
                                $upload = new Upload($params);
                                if (!($pic_path = $upload->up($_FILES['file'],'user_' . $_SESSION['user_id']))) {
                                    echo $upload->getError();
                                    die;
                                }
                            }
                            $admin = new Admin();
                            $admin->type_id = $_POST["type"];
                            $admin->knowledge_title = $_POST["title"];
                            $admin->knowledge_msg = $_POST["msg"];
                            $admin->knowledge_date = time();
                            $admin->user_id = $_SESSION["user_id"];
                            $result = $adminModel->setMsg($admin);
                            if ($result == 1) {
                                header("location:adminController.php?flag=admin&src=k1");
                            } else {
                                Tool::alertBack("发布失败");
                            }
                        //判断是否进行编辑提交操作
                        } elseif (isset($_GET["edit"])) {
                            $admin = new Admin();
                            $admin->knowledge_id = $_GET["edit"];
                            $admin->type_id = $_POST["type"];
                            $admin->knowledge_title = $_POST["title"];
                            $admin->knowledge_msg = $_POST["msg"];
                            $admin->knowledge_date = time();
                            $result = $adminModel->updateMsg($admin);
                            if ($result == 1) {
                                header("location:adminController.php?flag=admin&src=k1");
                            } else {
                                Tool::alertBack("编辑失败");
                            }
                        } else {
                            require("../view/adminContentPost.php");
                        }
                        break;
                    //k3是预览知识内容
                    case 'k3':
                        if (isset($_GET["view"])) {
                            $msgId = $_GET["view"];
                            $msgInfo = $adminModel->getMsgById($msgId);
                            if ($msgInfo != null) {
                                foreach ($msgInfo as $key => $value) {
                                    $msgInfo[$key]['user_id'] = $adminModel->getUserByUserId($msgInfo[$key]['user_id']);
                                }
                            }
                            require("../view/adminContentView.php");
                        } elseif (isset($_GET["filename"])) {
                            $admin = new Admin();
                            $admin->knowledge_filename = $_GET["filename"];
                            $adminModel->downloadFile($admin);
                        }
                        break;
                    //u1表示用户管理
                    case 'u1':
                        //判断是否搜索
                        if (isset($_GET["search"])) {
                            $admin = new Admin();
                            $admin->username = $_POST["searchName"];
                            $admin->role_id = $_POST["searchGroup"];
                            $userInfo = $adminModel->getUserBySearch($admin);
                            require("../view/adminUserSearch.php");
                        //判断是否删除
                        }  elseif (isset($_GET["delete"])) {
                            $admin = new Admin;
                            $admin->user_id = $_GET["delete"];
                            $result = $adminModel->setDelUserById($admin);
                            if ($result == 1) {
                                $page = new Page();
                                $page->pageSize = 5;
                                $page->pageId = empty($_GET['pageId']) ? 1 : $_GET['pageId'];
                                $page->gotoUrl = 'adminController.php?flag=admin&src=u1';
                                $adminModel->getUserByPage($page);
                                $userInfo = $page->result;
                                require("../view/adminUserList.php");
                            } else {
                                Tool::alertBack("删除失败");
                            }
                        //判断是否添加
                        }  elseif (isset($_GET["add"])) {
                            $admin = new Admin();
                            $admin->username = $_POST["addname"];
                            $admin->password = $_POST["addpwd"];
                            $admin->role_id = $_POST["addGroup"];
                            $result = $adminModel->addUserInfo($admin);
                            if ($result == 1) {
                                $page = new Page();
                                $page->pageSize = 5;
                                $page->pageId = empty($_GET['pageId']) ? 1 : $_GET['pageId'];
                                $page->gotoUrl = 'adminController.php?flag=admin&src=u1';
                                $adminModel->getUserByPage($page);
                                $userInfo = $page->result;
                                require("../view/adminUserList.php");
                            } else {
                                Tool::alertBack("添加失败");
                            }
                        //编辑信息
                        } elseif (isset($_GET["uuid"])) {
                            $admin = new Admin();
                            $admin->user_id = $_GET["uuid"];
                            $admin->user_realname = $_POST["editRealname"];
                            $admin->user_email = $_POST["editEamil"];
                            $admin->role_id = $_POST["editGroup"];
                            $result = $adminModel->editUserInfo($admin);
                            if ($result == 1) {
                                $page = new Page();
                                $page->pageSize = 5;
                                $page->pageId = empty($_GET['pageId']) ? 1 : $_GET['pageId'];
                                $page->gotoUrl = 'adminController.php?flag=admin&src=u1';
                                $adminModel->getUserByPage($page);
                                $userInfo = $page->result;
                                require("../view/adminUserList.php");
                            } else {
                                Tool::alertBack("编辑失败");
                            }
                        //进行重置密码操作
                        } elseif (isset($_GET["reset"])) {
                            $admin = new Admin();
                            $admin->user_id = $_GET["reset"];
                            $result = $adminModel->resetPassword($admin);
                            if ($result == 1) {
                                $page = new Page();
                                $page->pageSize = 5;
                                $page->pageId = empty($_GET['pageId']) ? 1 : $_GET['pageId'];
                                $page->gotoUrl = 'adminController.php?flag=admin&src=u1';
                                $adminModel->getUserByPage($page);
                                $userInfo = $page->result;
                                require("../view/adminUserList.php");
                                Tool::alert("重置密码成功");
                            } else {
                                Tool::alertBack("重置密码失败");
                            }
                        // 正常不进行任何操作时以分页显示页面
                        } else{
                            $page = new Page();
                            $page->pageSize = 6;
                            $page->pageId = empty($_GET['pageId']) ? 1 : $_GET['pageId'];
                            $page->gotoUrl = 'adminController.php?flag=admin&src=u1';
                            $adminModel->getUserByPage($page);
                            $userInfo = $page->result;
                            require("../view/adminUserList.php");
                        }
                        break;
                    default:
                        # code...
                        break;
                }
            } else {
                //加载后台首页面的相关信息
                $kmsInfo = $adminModel->getHomeInfo();
                $page = new Page();
                $page->pageSize = 5;
                $page->pageId = empty($_GET['pageId']) ? 1 : $_GET['pageId'];
                $page->gotoUrl = 'adminController.php?flag=admin&src=k1';
                $knowledge = $adminModel->getMsgByPage($page);
                $msgInfo = $page->result;
                require("../view/Admin.php");
            }
            break;

        case 'logout':
			unset($_SESSION['username']);
			require("../view/login.php");
        break;
        
        default:
            # code...
            break;
    }
}

//
//                       _oo0oo_
//                      o8888888o
//                      88" . "88
//                      (| -_- |)
//                      0\  =  /0
//                    ___/`---'\___
//                  .' \\|     |// '.
//                 / \\|||  :  |||// \
//                / _||||| -:- |||||- \
//               |   | \\\  -  /// |   |
//               | \_|  ''\---/''  |_/ |
//               \  .-\__  '-'  ___/-. /
//             ___'. .'  /--.--\  `. .'___
//          ."" '<  `.___\_<|>_/___.' >' "".
//         | | :  `- \`.;`\ _ /`;.`/ - ` : | |
//         \  \ `_.   \_ __\ /__ _/   .-` /  /
//     =====`-.____`.___ \_____/___.-`___.-'=====
//                       `=---='
//
//
//     ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//
//               佛祖保佑         永无BUG
