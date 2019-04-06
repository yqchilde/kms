<?php require("../../public/verifyLogin.php");?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>网站后台管理</title>
	<link rel="stylesheet" href="../../public/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../public/css/main.css"/>
	<link rel="stylesheet" href="https://cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.css">
	<style>
		.table th, .table td { 
			vertical-align: middle !important;
		}
	</style>
</head>
<body>
	  <!-- 顶部导航部分开始 -->
    <nav class="navbar navbar-default">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="adminController.php?flag=admin" class="navbar-brand">YQAdmin</a>
			</div>	
			<div class="navbar-collapse collapse" id="menu">
				<ul class="nav navbar-nav">
                    <li><a href="adminController.php?flag=admin"><span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;后台首页</a></li>
                    <li><a href="adminController.php?flag=admin&src=k1"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;&nbsp;知识管理</a></li>
                    <li class="active"><a href="adminController.php?flag=admin&src=u1"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;用户管理</a></li>
                </ul>
				<ul class="nav navbar-nav navbar-right">
    				<li class="dropdown">
    					<a id="dLabel" type="button" data-toggle="dropdown">
    						<?php echo $_SESSION["username"];?>
    						<span class="caret"></span>
    					</a>
                        <ul class="dropdown-menu">
							<li><a href=""><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;<?php echo $_SESSION["user_id"] ?></a></li>
							<li role="separator" class="divider"></li>
    						<li><a href=""><span class="glyphicon glyphicon-screenshot"></span>&nbsp;&nbsp;前台首页</a></li>
    						<li><a href="adminController.php?flag=admin&src=u1"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;用户管理</a></li>
    					</ul>
    				</li>
    				<li><a href="adminController.php?flag=logout"><i class="fa fa-power-off" aria-hidden="true"></i>&nbsp;&nbsp;退出</a></li>
    			</ul>
			</div>
		</div>
	</nav>
	<!-- 顶部导航部分结束 -->
	<!-- 主页面开始 -->
	<div class="container">
		<div class="row">
			<div class="col-md-2">
				<div class="list-group">
					<a href="adminController.php?flag=admin&src=u1" class="list-group-item active">用户管理</a>
					<a href="" class="list-group-item" data-toggle="modal" data-target="#userSearch">用户搜索</a>
					<a href="" class="list-group-item" data-toggle="modal" data-target="#userAdd">添加用户</a>
				</div>
			</div>
			<div class="col-md-10">
				<div class="page-header"><h1>用户管理</h1></div>
				<ul class="nav nav-tabs">
					<li class="active"><a href="adminController.php?flag=admin&src=u1">用户列表</a></li>
					<li><a href="" data-toggle="modal" data-target="#userSearch">用户搜索</a></li>
					<li><a href="" data-toggle="modal" data-target="#userAdd">添加用户</a></li>
				</ul>
				<div class="tablebox">
					<table class="table table-hover page-main">
						<thead>
							<tr>
								<th>UUID</th>
								<th>用户名</th>
								<th>真实姓名</th>
								<th>邮箱</th>
								<th>权限级别</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($userInfo as $user):?>
							<tr>
								<th><?php echo $user['user_id'] ?></th>
								<td><?php echo $user['username'] ?></td>
								<td><?php echo $user['user_realname'] ?></td>
								<td><?php echo $user['user_email'] ?></td>
								<td>
									<?php
									if ($user['role_id'] == '1') {
										echo "超级管理员";
									} elseif ($user['role_id'] == '2') {
										echo "普通用户";
									}
									?>
								</td>
								<td>
									<a href="" class="btn btn-info btn-operate" data-toggle="modal" data-target="#userEdit"  data-id="edit"><i class="fa fa-pencil"></i>&nbsp;编辑</a>
									<a href="adminController.php?flag=admin&src=u1&delete=<?php echo $user['user_id'] ?>" class="btn btn-danger btn-operate" onclick="return confirm('确定要删除吗');"><i class="fa fa-trash-o"></i>&nbsp;刪除</a>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<!-- 分页开始 -->
				<nav aria-label="Page navigation" class="pull-right";">
					<ul class="pagination">
						<li>
							<a href="<?php echo $page->gotoUrl . '&pageId=1' ?>" aria-label="Previous">
								<span>首页</span>
							</a>
						</li>
						<li><a href="<?php echo $page->gotoUrl . '&pageId=' . $page->prePage; ?>">上一页</a></li>
						<?php for ($pageid=1; $pageid <= $page->pageCount ; $pageid++) { 
							echo "<li><a href=\"{$page->gotoUrl}&pageId={$pageid}\">$pageid</a></li>";
						}?>
						<li><a href="<?php echo $page->gotoUrl . '&pageId=' . $page->nextPage ?>">下一页</a></li>
						<li>
						<a href="<?php echo $page->gotoUrl . '&pageId=' . $page->pageCount ?>" aria-label="Next">
							<span>尾页</span>
						</a>
						</li>
					</ul>
				</nav>
				<!-- 分页结束 -->
			</div>
		</div>
	</div>
	<!-- 搜索用户模态框开始 -->
	<form action="adminController.php?flag=admin&src=u1&search" method="post">
		<div class="modal fade" id="userSearch" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">搜索用户</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="searchName">用户名</label>
							<input type="text" id="searchName" name="searchName" class="form-control" placeholder="请输入用户名"/>
						</div>
						<div class="form-group">
							<label for="searchGroup">用户组</label>
							<select id="searchGroup" name="searchGroup" class="form-control">
								<option value="-1">所有用户</option>
								<option value="2">普通用户</option>
								<option value="1">超级管理员</option>	
							</select>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
						<button type="submit" class="btn btn-primary">搜索</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	<!-- 搜索用户模态框结束 -->
	<!-- 添加用户模态框开始 -->
	<form action="adminController.php?flag=admin&src=u1&add" method="post">
		<div class="modal fade" id="userAdd" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">添加用户</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="addname">用户名</label>
							<input type="text" id="addname" name="addname" class="form-control" placeholder="请输入用户名"/>
						</div>
						<div class="form-group">
							<label for="addpwd">用户密码</label>
							<input type="password" id="addpwd" name="addpwd" class="form-control" placeholder="请输入密码"/>
						</div>
						<div class="form-group">
							<label for="addGroup">用户组</label>
							<select id="addGroup" name="addGroup" class="form-control">
								<option value="2">普通用户</option>
								<option value="1">超级管理员</option>	
							</select>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
						<button type="submit" class="btn btn-primary">添加</button>
					</div>
				</div>
			</div>
		</div>
	</form>	
	<!-- 添加用户模态框结束 -->
	<!-- 编辑用户模态框开始 -->
	<form action="" id="formEdit">
		<div class="modal fade" id="userEdit" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">编辑用户</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="editUser">用户名</label>
							<input type="text" id="editUser" class="form-control" disabled/>
						</div>
						<div class="form-group">
							<label for="editRealname">真实姓名</label>
							<input type="text" id="editRealname" name="editRealname" class="form-control"/>
						</div>
						<div class="form-group">
							<label for="editEamil">邮箱</label>
							<input type="email" id="editEamil" name="editEamil" class="form-control"/>
						</div>
						<div class="form-group">
							<label for="editGroup">用户组</label>
							<select id="editGroup" name="editGroup" class="form-control">
								<option value="2">普通用户</option>
								<option value="1">超级管理员</option>	
							</select>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger pull-left" id="reset">重置密码</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
						<button type="submit" class="btn btn-primary" id="submit">确认</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	<!-- 编辑用户模态框结束 -->
	<!-- 主页面结束 -->
	<!-- footer开始 -->
	<?php
    include("../../public/footer.php");
    ?>
	<!-- footer结束 -->
	
	<script src="../../public/js/jquery-3.3.1.min.js"></script>
	<script src="../../public/js/bootstrap.min.js"></script>
	<script>
		$(function(){
			$('#userEdit').on('show.bs.modal', function (event) {
				var btnThis = $(event.relatedTarget); //触发事件的按钮
				var modal = $(this);  //当前模态框
				var modalId = btnThis.data('id');   //解析出data-id的内容
				var userId = btnThis.closest('tr').find('th').eq(0).text();
				//点击提交表单
				$("#submit").click(function(){
					var newUrl = 'adminController.php?flag=admin&src=u1&uuid=' + userId;    //设置新提交地址
					$("#formEdit").attr('action',newUrl);    //通过jquery为action属性赋值
					$("#formEdit").attr('method',"post");    //通过jquery为action属性赋值
					$("#formEdit").submit();    //提交ID为myform的表单
				});
				//点击重置密码
				$("#reset").click(function(){
					var newUrl = 'adminController.php?flag=admin&src=u1&reset=' + userId;    //设置新提交地址
					$(location).attr('href',newUrl);    //通过jquery为action属性赋值
				});

				var userName = btnThis.closest('tr').find('td').eq(0).text();
				modal.find('#editUser').val(userName);

				var realName = btnThis.closest('tr').find('td').eq(1).text();
				modal.find('#editRealname').val(realName);

				var userEmail = btnThis.closest('tr').find('td').eq(2).text();
				modal.find('#editEamil').val(userEmail);

				//常回来看看
				var userGroup = btnThis.closest('tr').find('td').eq(3).text();
				if (userGroup.trim() == "超级管理员") {
					userGroup = "1";
					modal.find('#editGroup').val(userGroup);
				} else if (userGroup.trim() == "普通用户") {
					userGroup = "2";
					modal.find('#editGroup').val(userGroup);
				}
			});
		});
	</script>
  </body>
</html>