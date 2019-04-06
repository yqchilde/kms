<?php
/* 用户控制器
 * @Author: 于波 
 * @Date: 2019-02-18 14:26:35 
 * @Last Modified by: 于波
 * @Last Modified time: 2019-02-23 16:09:41
 */
if(!isset($_SESSION)){
    session_start();
}
require_once __DIR__ .'/../model/UserModel.class.php';
require_once __DIR__ .'/../model/User.class.php';
require_once __DIR__ .'/../../public/Tool.class.php';
require_once __DIR__ .'/../../public/Page.class.php';
require_once __DIR__ .'/../../public/Upload.class.php';
$userModel = new UserModel();
if (isset($_REQUEST["flag"])) {
    $flag = $_REQUEST["flag"];
    switch ($flag) {
        case 'user':
            if (isset($_GET["src"])) {
                $src = $_GET["src"];
                switch ($src) {
                    //k1表示知识管理首页
                    case 'k1':
                        //判断是否打开编辑页面
                        if (isset($_GET["edit"])) {
                            $msgId = $_GET["edit"];
                            $msgInfo = $userModel->getMsgById($msgId);
                            require("../view/userContentEdit.php");
                        //判断是否是进行删除操作
                        } elseif (isset($_GET["delete"])) {
                            $msgId = $_GET["delete"];
                            $result = $userModel->setDelMsgById($msgId);
                            if ($result == 1) {
                                $page = new Page();
                                $page->pageSize = 6;
                                $page->pageId = empty($_GET['pageId']) ? 1 : $_GET['pageId'];
                                $page->gotoUrl = 'userController.php?flag=user&src=k1';
                                $userModel->getMsgByPage($page);
                                $msgInfo = $page->result;
                                if ($msgInfo != null) {
                                    foreach ($msgInfo as $key => $value) {
                                        $msgInfo[$key]['user_id'] = $userModel->getUserByUserId($msgInfo[$key]['user_id']);
                                    }
                                }
                                require("../view/userContentList.php");
                            } else {
                                Tool::alertBack("删除失败");
                            }
                        //判断是否是进行知识搜索操作
                        } elseif (isset($_REQUEST["wd"])) {
                            $user = new User();
                            $user->knowledge_title = $_REQUEST["wd"];
                            $user->knowledge_msg = $_REQUEST["wd"];
                            if ($_REQUEST["id"] == 0) {
                                $user->type_id = 0;
                            } else {
                                $user->type_id = $_REQUEST["id"];
                            }
                            $page = new Page();
                            $page->pageSize = 6;
                            $page->pageId = empty($_GET["pageId"]) ? 1 : $_GET["pageId"];
                            $page->gotoUrl = "userController.php?flag=user&src=k1&wd=" . $_REQUEST['wd'] . "&id=" . $_REQUEST['id'];
                            $userModel->getMsgBySearchPage($user, $page);
                            $msgInfo = $page->result;
                            if ($msgInfo != null) {
                                foreach ($msgInfo as $key => $value) {
                                    $msgInfo[$key]['user_id'] = $userModel->getUserByUserId($msgInfo[$key]['user_id']);
                                }
                            }
                            require("../view/userContentSearch.php");
                        } else {
                            //以分页的形式展示知识内容
                            $page = new Page();
                            $page->pageSize = 6;
                            $page->pageId = empty($_GET['pageId']) ? 1 : $_GET['pageId'];
                            $page->gotoUrl = 'userController.php?flag=user&src=k1';
                            $userModel->getMsgByPage($page);
                            $msgInfo = $page->result;
                            // print_r($msgInfo);
                            // if ($msgInfo != null) {
                            //     foreach ($msgInfo as $key => $value) {
                            //         $msgInfo[$key]['user_id'] = $userModel->getUserByUserId($msgInfo[$key]['user_id']);
                            //     }
                            // }
                            require("../view/userContentList.php");
                        }
                        break;
                    //k2表示添加知识页面
                    case 'k2':
                        //发布知识
                        if (isset($_GET["post"])) {
                            $user = new User();
                            if (isset($_FILES['file'])) {
                                $params = array(
                                    'types' => array('application/zip'),
                                    'size' => 8388608,
                                    'path' => '../../public/file/file', 
                                );
                                $upload = new Upload($params);
                                // if (!($pic_path = $upload->up($_FILES['file'],'user_' . $_SESSION['user_id']))) {
                                //     echo $upload->getError();
                                //     die;
                                // }
                                $user->knowledge_filename = 'file' . $upload->up($_FILES['file'],'user_' . $_SESSION['user_id']);
                            }
                            $user->type_id = $_POST["type"];
                            $user->knowledge_title = $_POST["title"];
                            $user->knowledge_msg = $_POST["msg"];
                            $user->knowledge_date = time();
                            $user->user_id = $_SESSION["user_id"];
                            $result = $userModel->setMsg($user);
                            if ($result == 1) {
                                header("location:userController.php?flag=user&src=k1");
                            } else {
                                Tool::alertBack("发布失败");
                            }
                        //判断是否进行编辑提交操作
                        } elseif (isset($_GET["edit"])) {
                            $user = new User();
                            $user->knowledge_id = $_GET["edit"];
                            $user->type_id = $_POST["type"];
                            $user->knowledge_title = $_POST["title"];
                            $user->knowledge_msg = $_POST["msg"];
                            $user->knowledge_date = time();
                            $result = $userModel->updateMsg($user);
                            if ($result == 1) {
                                header("location:userController.php?flag=user&src=k1");
                            } else {
                                Tool::alertBack("编辑失败");
                            }
                        } else {
                            require("../view/userContentPost.php");
                        }
                        break;
                    //k3是预览知识内容
                    case 'k3':
                        if (isset($_GET["view"])) {
                            $msgId = $_GET["view"];
                            $msgInfo = $userModel->getMsgById($msgId);
                            if ($msgInfo != null) {
                                foreach ($msgInfo as $key => $value) {
                                    $msgInfo[$key]['user_id'] = $userModel->getUserByUserId($msgInfo[$key]['user_id']);
                                }
                            }
                            require("../view/userContentView.php");
                        } elseif (isset($_GET["filename"])) {
                            $user = new User();
                            $user->knowledge_filename = $_GET["filename"];
                            $userModel->downloadFile($user);
                        }
                        break;
                    //u1表示个人中心
                    case 'u1':
                        //用户自己编辑自己信息
                        if (isset($_GET["uuid"])) {
                            $user = new User();
                            $user->user_id = $_GET["uuid"];
                            $user->user_realname = $_POST["editRealname"];
                            $user->user_email = $_POST["editEamil"];
                            $result = $userModel->editUserInfo($user);
                            if ($result == 1) {
                                $user = new User();
                                $user->username = $_SESSION["username"];
                                $userInfo = $userModel->getUserBySession($user);
                                require("../view/userZone.php");
                            } else {
                                Tool::alertBack("修改失败");
                            }
                        //用户修改密码
                        } elseif (isset($_GET["pwd"])) {
                            $user = new User();
                            $user->password = $_POST["pwd3"];
                            $user->username = $_SESSION["username"];
                            $user->user_id = $_SESSION["user_id"];
                            $Info = $userModel->getUserBySession($user);
                            //判断是否是原密码
                            if ($Info[0]['password'] != md5($_POST["pwd1"])) {
                                Tool::alertBack("原密码错误");
                            } else {
                                $result = $userModel->setPassword($user);
                                if ($result == 1) {
                                    $user = new User();
                                    $user->username = $_SESSION["username"];
                                    $userInfo = $userModel->getUserBySession($user);
                                    require("../view/userZone.php");
                                    Tool::alert("修改成功");
                                } else {
                                    Tool::alertBack("修改失败");
                                }
                            }
                        //获取登录者信息
                        } else {
                            $user = new User();
                            $user->username = $_SESSION["username"];
                            $userInfo = $userModel->getUserBySession($user);
                            require("../view/userZone.php");
                        }
                        break;
                    default:
                        # code...
                        break;
                }
            } else {
                //加载后台首页面的相关信息
                $newInfo = $userModel->getNewInfo();
                $codeInfo = $userModel->getCodeInfo();
                $webInfo = $userModel->getWebInfo();
                $imgInfo = $userModel->getImgInfo();
                $templateInfo = $userModel->getTemplateInfo();
                require("../view/user.php");
            }
            break;

        case 'logout':
            unset($_SESSION['username']);
            header("location:../../admin/controller/adminController.php?flag=login");
			// require("../../admin/view/login.php");
        break;
        
        default:
            # code...
            break;
    }
}