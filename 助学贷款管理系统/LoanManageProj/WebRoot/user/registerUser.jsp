<%@ page language="java" contentType="text/html; charset=utf-8"%>
<%
	request.setCharacterEncoding("utf-8");
	response.setCharacterEncoding("utf-8");
%>
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
		<title>注册新用户</title>
		<link rel="stylesheet" type="text/css" href="css/css.css">
		<link rel="stylesheet" type="text/css" href="css/info.css">
		<script type="text/javascript">
			function retLogin() {
				window.location = "login.jsp";
			}
			function checkUname(){
				var txtName=document.getElementById("Uname");
				var divName=document.getElementById("divName");
				if(txtName.value.length==0){
					divName.innerHTML="<img src='images/failure.jpg' />&nbsp;用户名不能为空，可由英文字符、数字或下划线构成，可用E-mail作为用户名";
				}else{
					divName.innerHTML="<img src='images/success.jpg' />&nbsp;恭喜您，该用户名可以使用";
					divName.style.border="";
				}		
			}
			function checkPwd(){
				var pwd=document.getElementById("pw");
				var divPwd=document.getElementById("divPw");
				if(pwd.value.length<6){
					divPwd.innerHTML="<img src='images/failure.jpg' />&nbsp;密码由6-30位英文字符、数字或下划线构成，严格区分大小写";
				}else{
					divPwd.innerHTML="<img src='images/success.jpg' />&nbsp;该密码正确";
					divPwd.style.border="";
				}		
			}
		</script>
	</head>
	<body>
	<div align="center">
		<form method="post" action="user_register">
			<table width="80%" border="1" align="center" cellpadding="0" cellspacing="0"
				class="tableBorder2" style="padding-left: 5px;">
				<tr align="center">
					<td height="40" colspan="3" class="TableTitle1">
						注册新用户
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						用户名:
					</td>
					<td width="231">
						<input type="text" name="register.userName" id="Uname" onblur="checkUname()" />
						<span class="Redfont">*</span>
					</td>
					<td>
						<div id="divName" align="left"></div>
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						密码:
					</td>
					<td width="231">
						<input type="password" name="register.userPwd" id="pw" onblur="checkPwd()" />
						<span class="Redfont">*</span>
					</td>
					<td><div id="divPw" align="left"></div></td>
				</tr>
				<tr>
					<td width="142" height="27">
						身份:
					</td>
					<td>
						<select size="1" name="register.status">
							<option value="学生"  selected="selected">
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
						&nbsp;&nbsp;
						<input type="button" name="button" value="返回" onclick="retLogin()" />
					</td>
				</tr>
				<tr>
					<td colspan="3" align="center"></td>
				</tr>
			</table>
		</form>
		</div>
	</body>
</html>
