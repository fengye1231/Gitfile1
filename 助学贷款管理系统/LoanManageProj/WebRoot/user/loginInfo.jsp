<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"%>
<%
	String path = request.getContextPath();
	String basePath = request.getScheme() + "://"
			+ request.getServerName() + ":" + request.getServerPort()
			+ path + "/";
%>
<%@ taglib prefix="s" uri="/struts-tags"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<base href="<%=basePath%>">
		<title>显示当前登录的用户信息</title>
		<link rel="stylesheet" type="text/css" href="css/info.css">
		<link rel="stylesheet" type="text/css" href="css/css.css">
	</head>
	<body>
		<div class="map">
			<label class="curr">
				&nbsp;当前位置：
			</label>
			<label class="curr1">
				常规信息管理 &gt; 显示当前登录的用户信息
			</label>
		</div>
		<div>
			<form method="post" action="#">
				<table width="80%" border="1" align="center" cellpadding="0"
					cellspacing="0" class="tableBorder2" style="padding-left: 5px;">
					<tr align="center">
						<td height="40" colspan="5" class="TableTitle1">
							当前登录用户信息
						</td>
					</tr>
					<tr align="center">
						<th width="120">
							用户ID号
						</th>
						<th width="120">
							用户名
						</th>
						<th width="120">
							登录时间
						</th>
						<th width="120">
							用户身份
						</th>
						<th width="120">
							操作
						</th>
					</tr>
					<tr align="center">
						<td>
							${session.userId}
						</td>
						<td>
							${session.userName}
						</td>
						<td>
							<%=(new java.util.Date()).toLocaleString()%>
						</td>
						<td>
							${session.status}
						</td>
						<td>
							<a	href="user_updateInput?updateUser.userId=${session.userId}">修改密码</a>
						</td>
					</tr>
					<tr>
						<td colspan="5" align="center"></td>
					</tr>
				</table>
			</form>
		</div>
	</body>
</html>