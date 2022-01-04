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
		<base href="<%=basePath%>">
		<title>查询用户信息</title>
		<link rel="stylesheet" type="text/css" href="css/css.css">
		<link rel="stylesheet" type="text/css" href="css/info.css">
	</head>
	<body>
		<div class="map">
			<label class="curr">
				&nbsp;当前位置：
			</label>
			<label class="curr1">
				常规管理 &gt; 查询用户信息
			</label>
		</div>
		<form method="post" action="user_searchUser.action">
			<table border="1" align="center" cellpadding="0" cellspacing="0"
				class="tableBorder2">
				<tr align="center">
					<td height="20" colspan="4" class="TableTitle1">
						用户查询
					</td>
				</tr>
				<tr>
					<td width="100">
						用户ID
					</td>
					<td>
						<input type="text" name="user.userId">
					</td>
					<td width="100">
						用户名
					</td>
					<td>
						<input type="text" name="user.userName">
					</td>
				</tr>
				<tr>
					<td colspan="4" align="center">
						<input type="radio" name="user.status" value="管理员">
						管理员
						<input type="radio" name="user.status" value="学生">
						学生
						<input type="radio" name="user.status" value="院领导">
						院领导
						<input type="radio" name="user.status" value="助贷小组">
						助贷小组
					</td>
				</tr>
				<tr>
					<td height="27" colspan="4" align="center">
						&nbsp;
					</td>
				</tr>
			</table>
			<p>
				<input type="image" src="images/search.gif"
					onclick="javascript:submit();">
				<input type="hidden" value="submit" name="submit">
			</p>
		</form>
		<div>
			<table border="1" align="center" cellpadding="0" cellspacing="0"
				width="80%">
				<tr>
					<th>
						用户编号
					</th>
					<th>
						用户名称
					</th>
					<th>
						用户身份
					</th>
					<th>
						备注
					</th>
				</tr>
				<s:iterator value="userList">
					<tr>
						<td>
							<s:property value="userId" />
						</td>
						<td>
							<s:property value="userName" />
						</td>
						<td>
							<s:property value="status" />
						</td>
						<td>
							<s:property value="remark" />
						</td>
					</tr>
				</s:iterator>
			</table>
		</div>
	</body>
</html>