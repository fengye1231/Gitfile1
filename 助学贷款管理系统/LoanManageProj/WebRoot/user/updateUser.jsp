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
		<title>用户修改密码</title>
		<link rel="stylesheet" type="text/css" href="css/css.css">
		<link rel="stylesheet" type="text/css" href="css/info.css">
	</head>
	<script type="text/javascript">
function checkPwd() {
	var pwdOld = document.getElementById("pwdOld");
	var pwdNew = document.getElementById("pwdNew");
	var pwdAgain = document.getElementById("pwdAgain");

	if (pwdOld.value == "") {
		alert("请填写旧密码");
		return false;
	}
	if (pwdNew.value == "") {
		alert("请填写新密码");
		return false;
	}
	if (pwdNew.value != pwdAgain.value) {
		alert("新密码与确认密码不符");
		return false;
	}
}
function Rback(){
	window.location = "user/loginInfo.jsp";
}
</script>
	<body>
		<div class="map">
			<label class="curr">
				&nbsp;当前位置：
			</label>
			<label class="curr1">
				常规信息管理 &gt; 修改当前用户密码
			</label>
		</div>
		<form method="post" action="user_updateUser"
			onsubmit="return checkPwd()">
			<table width="80%" border="1" align="center" cellpadding="0"
				cellspacing="0" class="tableBorder2" style="padding-left: 5px;">
				<tr align="center">
					<td height="40" colspan="3" class="TableTitle1">
						修改用户密码
					</td>
				</tr>
				<tr style="">
					<td width="142" height="27">
						用户ID号:
					</td>
					<td width="231">
						<input type="text" name="updateUser.userId"
							value="<%=request.getParameter("updateUser.userId")%>" />
						<span class="Redfont">*</span>
					</td>
					<td rowspan="6" width="227" valign="top" class="Redfont">
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
						用户名:
					</td>
					<td width="231">
						<input type="text" name="updateUser.userName"
							value="${updateUser.userName}" />
						<span class="Redfont">*</span>
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						用户身份:
					</td>
					<td width="231">
						<input type="text" name="updateUser.status"
							value="${updateUser.status}" )" />
						<span class="Redfont">*</span>
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						旧密码:
					</td>
					<td width="231">
						<input type="password" name="oldUserPwd" id="pwdOld" />
						<span class="Redfont">*</span>
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						新密码:
					</td>
					<td width="231">
						<input type="password" name="updateUser.userPwd" id="pwdNew" />
						<span class="Redfont">*</span>
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						确认新密码:
					</td>
					<td width="231">
						<input type="password" name="againUserPwd" id="pwdAgain" />
						<span class="Redfont">*</span>
					</td>
				</tr>
				<tr align="center">
					<td height="22" colspan="3">
						<input type="submit" value="提交" />
						&nbsp;&nbsp;
						<input type="reset" value="重置" />
						&nbsp;&nbsp;
						<input type="button" value="返回" onclick="Rback()" />
					</td>
				</tr>
				<tr>
					<td colspan="3" align="center"></td>
				</tr>
			</table>
		</form>
	</body>
</html>
