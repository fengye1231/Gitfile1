<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"%>
<%
	String path = request.getContextPath();
	String basePath = request.getScheme() + "://"
			+ request.getServerName() + ":" + request.getServerPort()
			+ path + "/";
%>
<%@ taglib prefix="s" uri="/struts-tags"%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<base href="<%=basePath%>">
		<title>学生管理页面</title>

		<script src="js/prototype.lite.js" type="text/javascript">
</script>
		<script src="js/moo.fx.js" type="text/javascript">
</script>
		<script src="js/moo.fx.pack.js" type="text/javascript">
</script>
		<style type="">
body {
	font: 12px Arial, Helvetica, sans-serif;
	color: #000;
	background-color: #EEF2FB;
	margin: 0px;
}

#container {
	width: 182px;
}

H1 {
	font-size: 12px;
	margin: 0px;
	width: 182px;
	cursor: pointer;
	height: 30px;
	line-height: 20px;
}

H1 a {
	display: block;
	width: 182px;
	color: #000;
	height: 30px;
	text-decoration: none;
	moz-outline-style: none;
	background-image: url(images/menu_bgS.gif);
	background-repeat: no-repeat;
	line-height: 30px;
	text-align: center;
	margin: 0px;
	padding: 0px;
}

.content {
	width: 182px;
	height: 26px;
}

.MM ul {
	list-style-type: none;
	margin: 0px;
	padding: 0px;
	display: block;
}

.MM li {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	line-height: 26px;
	color: #333333;
	list-style-type: none;
	display: block;
	text-decoration: none;
	height: 26px;
	width: 182px;
	padding-left: 0px;
}

.MM {
	width: 182px;
	margin: 0px;
	padding: 0px;
	left: 0px;
	top: 0px;
	right: 0px;
	bottom: 0px;
	clip: rect(0px, 0px, 0px, 0px);
}

.MM a:link {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	line-height: 26px;
	color: #333333;
	background-image: url(images/menu_bg1.gif);
	background-repeat: no-repeat;
	height: 26px;
	width: 182px;
	display: block;
	text-align: center;
	margin: 0px;
	padding: 0px;
	overflow: hidden;
	text-decoration: none;
}

.MM a:visited {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	line-height: 26px;
	color: #333333;
	background-image: url(images/menu_bg1.gif);
	background-repeat: no-repeat;
	display: block;
	text-align: center;
	margin: 0px;
	padding: 0px;
	height: 26px;
	width: 182px;
	text-decoration: none;
}

.MM a:active {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	line-height: 26px;
	color: #333333;
	background-image: url(images/menu_bg1.gif);
	background-repeat: no-repeat;
	height: 26px;
	width: 182px;
	display: block;
	text-align: center;
	margin: 0px;
	padding: 0px;
	overflow: hidden;
	text-decoration: none;
}

.MM a:hover {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	line-height: 26px;
	font-weight: bold;
	color: #006600;
	background-image: url(images/menu_bg2.gif);
	background-repeat: no-repeat;
	text-align: center;
	display: block;
	margin: 0px;
	padding: 0px;
	height: 26px;
	width: 182px;
	text-decoration: none;
}
</style>
	</head>

	<body>
		<table width="100%" height="280" border="0" cellpadding="0"
			cellspacing="0" bgcolor="#EEF2FB">
			<tr>
				<td width="182" valign="top">
					<div id="container">
						<h1 class="type">
							<a href="javascript:void(0)">常规管理</a>
						</h1>
						<div class="content">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td>
										<img src="images/menu_topline.gif" width="182" height="5" />
									</td>
								</tr>
							</table>
							<ul class="MM">
								<li>
									<a href="user/loginInfo.jsp" target="main">当前用户信息</a>
								</li>
								<li>
									<a href="info/afficheManager.html" target="main">公告信息管理</a>
								</li>
								<li>
									<a href="news_listStu.action" target="main">新闻管理中心</a>
								</li>
							</ul>
						</div>
						<h1 class="type">
							<a href="javascript:void(0)">贷款管理</a>
						</h1>
						<div class="content">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td>
										<img src="images/menu_topline.gif" width="182" height="5" />
									</td>
								</tr>
							</table>
							<ul class="MM">
								<li>
									<a href="loan/applyProcess.html" target="main">贷款申请流程</a>
								</li>
								<li>
									<a href="loan/addMyLoan.jsp" target="main">贷款申请信息</a>
								</li>
								<li>
									<a href="loan_findLoanByName.action" target="main">我的贷款信息</a>
								</li>
								<li>
									<a href="loan/addApply.jsp" target="main">提前还款申请</a>
								</li>
								<li>
									<a href="apply_findApplyByName.action" target="main">提前还款记录</a>
								</li>
								<li>
									<a href="account_findAccountByName.action" target="main">我的账户信息</a>
								</li>
								<li>
									<a href="loan/addMyAccount.jsp" target="main">添加我的账户</a>
								</li>
							</ul>
						</div>
						<h1 class="type">
							<a href="javascript:void(0)">学生信息管理</a>
						</h1>
						<div class="content">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td>
										<img src="images/menu_topline.gif" width="182" height="5" />
									</td>
								</tr>
							</table>
							<ul class="MM">
								<li>
									<a href="student_findMyInfo.action" target="main">我的基本信息</a>
								</li>
								<li>
									<a href="student/addMyInfo.jsp" target="main">添加个人信息</a>
								</li>
							</ul>
						</div>
					</div>
				</td>
			</tr>
		</table>
	</body>
</html>