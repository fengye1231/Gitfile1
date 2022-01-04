<%@ page language="java" contentType="text/html; charset=utf-8"%>
<%request.setCharacterEncoding("utf-8");
response.setCharacterEncoding("utf-8"); %>
<%
	String path = request.getContextPath();
	String basePath = request.getScheme() + "://" + request.getServerName() + ":" + 
		request.getServerPort() + path + "/";
 %>
<%@ taglib  prefix="s" uri="/struts-tags" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<base href="<%=basePath%>">
		<title>增加用户</title>
		<link rel="stylesheet" type="text/css" href="css/css.css">
		<link rel="stylesheet" type="text/css" href="css/info.css">
	</head>
	<body onload="clockon(bgclock)">
		<div class="map">
			<label class="curr">
				&nbsp;当前位置：
			</label>
			<label class="curr1">
				常规信息管理 &gt; 增加用户信息
			</label>
		</div>
		<form  method="post" action="user_addUser">
			<table width="80%" border="1" align="center" cellpadding="0" cellspacing="0"
				class="tableBorder2" style="padding-left: 5px;">
				<tr align="center">
					<td height="40" colspan="3" class="TableTitle1">
						增加用户
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						用户名:
					</td>
					<td width="231">
						<input type="text" name="addUser.userName" /> 
						<span class="Redfont">*</span>
					</td>
					<td rowspan="3" width="227" valign="top" class="Redfont">
						注意:
						<ul>
							一:带*号项是必填项!
						</ul>
						<ul>
							二:密码长度最长为16位
						</ul>
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						密码:
					</td>
					<td width="231">
						<input type="text" name="addUser.userPwd" />
						<span class="Redfont">*</span>
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						身份:
					</td>
					<td>
						<select size="1" name="addUser.status">
							<option value="学生" selcted="selected">
								学生
							</option>
							<option value="管理员">
								管理员
							</option>
							<option value="院领导">
								院领导
							</option>
							<option value="助贷小组">
								助贷小组
							</option>
						</select>
					</td>
				</tr>
				<tr align="center">
					<td height="22" colspan="3">
						<input type="submit" name="Submit" value="提交">
						&nbsp;&nbsp;
						<input type="reset" name="Submit2" value="重置">
					</td>
				</tr>
				<tr>
					<td colspan="3" align="center"></td>
				</tr>
			</table>
		</form>
	</body>
</html>
